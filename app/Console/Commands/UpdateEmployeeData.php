<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UpdateEmployeeData extends Command
{
    protected $signature = 'app:update-employees-data';

    protected $description = 'Update HR department details for existing employees';

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

        // Store barcodes
        $notFoundBarcodes = [];
        $skippedBarcodes = [];

        foreach ($employees as $emp) {

            // Barcode is required
            if (empty($emp['barcode'])) {
                $skipped++;

                $skippedBarcodes[] = '[EMPTY BARCODE]';

                continue;
            }

            $barcode = $emp['barcode'];

            try {

                $user = User::where('barcode', $barcode)->first();

                if (!$user) {
                    $notFound++;

                    $notFoundBarcodes[] = $barcode;

                    continue;
                }

                // Update ONLY these two columns
                $user->update([
                    'hr_department_id'   => $emp['hr_department_id'] ?? null,
                    'hr_department_name' => $emp['hr_department_name'] ?? null,
                ]);

                $updated++;

            } catch (\Throwable $e) {

                $failed++;

                $this->error(
                    "Failed to update barcode {$barcode}: "
                    . $e->getMessage()
                );
            }
        }

        $this->newLine();

        $this->info("==================================");
        $this->info("HR Department update completed.");
        $this->info("Total API Records : " . count($employees));
        $this->info("Updated           : {$updated}");
        $this->info("Not Found         : {$notFound}");
        $this->info("Skipped           : {$skipped}");
        $this->info("Failed            : {$failed}");
        $this->info("==================================");

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