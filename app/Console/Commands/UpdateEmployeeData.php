<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UpdateEmployeeData extends Command
{
    protected $signature = 'app:update-employees-data';

    protected $description = 'Update employee category and support staff roles';

    public function handle()
    {
        $this->info('Fetching employee records...');

        $response = Http::withToken('YOUR_API_TOKEN')
            ->timeout(120)
            ->get('http://103.48.1.218/pms/get-employee-list');

        if ($response->failed()) {
            $this->error('Failed to fetch employee data.');
            $this->error('Status: ' . $response->status());
            $this->error('Body: ' . $response->body());

            return Command::FAILURE;
        }

        $employees = $response->json();

        if (!is_array($employees)) {
            $this->error('Invalid API response.');

            return Command::FAILURE;
        }

        $updated = 0;
        $notFound = 0;
        $skipped = 0;
        $failed = 0;

        $supportStaffRoleAdded = 0;

        // Store barcodes
        $notFoundBarcodes = [];
        $skippedBarcodes = [];

        foreach ($employees as $emp) {

            /*
            |--------------------------------------------------------------------------
            | BARCODE VALIDATION
            |--------------------------------------------------------------------------
            */

            if (empty($emp['barcode'])) {

                $skipped++;

                $skippedBarcodes[] = '[EMPTY BARCODE]';

                continue;
            }

            $barcode = trim($emp['barcode']);

            try {

                /*
                |--------------------------------------------------------------------------
                | FIND USER BY BARCODE
                |--------------------------------------------------------------------------
                */

                $user = User::where('barcode', $barcode)->first();

                if (!$user) {

                    $notFound++;

                    $notFoundBarcodes[] = $barcode;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | UPDATE ONLY EMPLOYEE CATEGORY
                |--------------------------------------------------------------------------
                */

                $user->update([
                    'employee_category' => $emp['employee_category'] ?? null,
                ]);

                $updated++;

                /*
                |--------------------------------------------------------------------------
                | SUPPORT STAFF ROLE
                |--------------------------------------------------------------------------
                |
                | If employee_category = support_staff:
                |
                | - Delete all existing roles
                | - Assign role_id = 24
                |
                | EXCEPTION:
                | Barcode 100735 is completely excluded from
                | role deletion/assignment.
                |
                */

                if (
                    isset($emp['employee_category']) &&
                    strtolower(trim($emp['employee_category'])) === 'support_staff' &&
                    $barcode !== '100735'
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | DELETE ALL EXISTING ROLES
                    |--------------------------------------------------------------------------
                    */

                    DB::table('model_has_roles')
                        ->where('model_type', User::class)
                        ->where('model_id', $user->id)
                        ->delete();

                    /*
                    |--------------------------------------------------------------------------
                    | ASSIGN ROLE 24
                    |--------------------------------------------------------------------------
                    */

                    DB::table('model_has_roles')->insert([
                        'role_id'    => 24,
                        'model_type' => User::class,
                        'model_id'   => $user->id,
                    ]);

                    $supportStaffRoleAdded++;

                    $this->info(
                        "✓ Role 24 assigned: {$user->name} ({$barcode})"
                    );
                }

            } catch (\Throwable $e) {

                $failed++;

                $this->error(
                    "Failed to update barcode {$barcode}: "
                    . $e->getMessage()
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info("==========================================");
        $this->info("Employee category update completed.");
        $this->info("==========================================");
        $this->info("Total API Records       : " . count($employees));
        $this->info("Updated                 : {$updated}");
        $this->info("Not Found               : {$notFound}");
        $this->info("Skipped                 : {$skipped}");
        $this->info("Failed                  : {$failed}");
        $this->info("------------------------------------------");
        $this->info("Role 24 Assigned        : {$supportStaffRoleAdded}");
        $this->info("Excluded Barcode        : 100735");
        $this->info("==========================================");

        /*
        |--------------------------------------------------------------------------
        | NOT FOUND BARCODES
        |--------------------------------------------------------------------------
        */

        if (!empty($notFoundBarcodes)) {

            $this->newLine();

            $this->warn("NOT FOUND BARCODES ({$notFound}):");

            foreach ($notFoundBarcodes as $barcode) {
                $this->line($barcode);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SKIPPED BARCODES
        |--------------------------------------------------------------------------
        */

        if (!empty($skippedBarcodes)) {

            $this->newLine();

            $this->warn("SKIPPED BARCODES ({$skipped}):");

            foreach ($skippedBarcodes as $barcode) {
                $this->line($barcode);
            }
        }

        $this->newLine();

        return Command::SUCCESS;
    }
}