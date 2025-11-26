<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Fetching employee records...");

        $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxODI1OTIiLCJleHAiOjE3NjQwNTI2Nzh9.koAPkPsvBxYjpOHLNHNh7zPLRMLaAExGkwfMvzTeHVs')
            ->get('http://103.62.235.19:8000/get-employee-detail');

        if ($response->failed()) {
            $this->error("Failed to fetch employee data.");
            $this->error('Status: ' . $response->status());
            $this->error('Body: ' . $response->body());
            return;
        }

        $employees = $response->json();
        $updatedCount = 0;
        foreach ($employees as $emp) {
            if (!is_null($emp['faculty_id'])) {
                $updated = User::where('employee_id', $emp['employee_id'])
                    ->update([
                        'faculty_id' => $emp['faculty_id'],
                    ]);

                if ($updated) {
                    $updatedCount++;
                }
            }
        }
        $this->info("Updated " . $updatedCount . " employee records.");
    }
}
