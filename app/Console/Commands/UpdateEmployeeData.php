<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UpdateEmployeeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-employees-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing employees (job title, faculty, department and manager details)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching employee records...');

        $response = Http::withToken('YOUR_API_TOKEN')
            ->get('http://103.177.240.229/pms/get-employee-list');

        if ($response->failed()) {
            $this->error('Failed to fetch employee data.');
            $this->error('Status: ' . $response->status());
            $this->error('Body: ' . $response->body());
            return Command::FAILURE;
        }

        $employees = $response->json();

        $updated = 0;
        $skipped = 0;

        foreach ($employees as $emp) {

            if (empty($emp['barcode'])) {
                $this->warn('Skipping employee with empty barcode.');
                $skipped++;
                continue;
            }

            $existingUser = User::where('barcode', $emp['barcode'])->first();

            if (!$existingUser) {
                $this->warn("Employee not found. Barcode: {$emp['barcode']}");
                $skipped++;
                continue;
            }

            $existingUser->update([
                'job_title' => $emp['job_title'] ?? null,
                'faculty_id' => $emp['faculty_id'] ?? null, // Change to 'faculty' if your column name is faculty
                'department_id' => $emp['department_id'] ?? null,
                'manager_id' => $emp['manager_id'] ?? null,
                'manager_name' => $emp['manager_name'] ?? null,
            ]);

            $updated++;

            $this->line("✓ Updated: {$existingUser->name} ({$existingUser->barcode})");
        }

        $this->newLine();
        $this->info("==================================");
        $this->info("Employee update completed.");
        $this->info("Total API Records : " . count($employees));
        $this->info("Updated           : {$updated}");
        $this->info("Skipped           : {$skipped}");
        $this->info("==================================");

        return Command::SUCCESS;
    }
}