<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ImportEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-employees';

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

        $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxODI1OTIiLCJleHAiOjE3NjQwNTQzODV9.5ggTLuXkPzL6A_rzw-hVa9WbFmdskhuPuAryfUWC90M')
            ->get('http://10.25.25.108:8000/pms/get-employee-list');

        if ($response->failed()) {
            $this->error("Failed to fetch employee data.");
            $this->error('Status: ' . $response->status());
            $this->error('Body: ' . $response->body());
            return;
        }

        $employees = $response->json();
        $count = 0;
        // $threshold = 40030;
        foreach ($employees as $emp) {
            //if (!is_null($emp['faculty_id'])) {

            // if ((int) $emp['employee_id'] <= $threshold) {
            //     continue;
            // }

            $invalidEmails = ['N/A', 'N/A ', 'NA', 'Pending', '-', 'NBMN', 'None'];

            if (!isset($emp['work_email']) || $emp['work_email'] === null) {
                $email = 'dummy' . (++$count) . '@example.com';
            } elseif (in_array($emp['work_email'], $invalidEmails, true)) {
                $email = 'dummy' . (++$count) . '@example.com';
            } else {
                $email = $emp['work_email'];
            }
            $existingUser = User::where('employee_id', $emp['employee_id'])->first();

            if (!$existingUser && User::where('email', $email)->exists()) {
                \Log::warning("Skipped duplicate email: {$email} (employee_id: {$emp['employee_id']})");
                continue;
            }
            $user = User::updateOrCreate(
                ['id' => $emp['employee_id']], // Unique key
                [
                    'employee_id' => $emp['employee_id'],
                    'faculty_id' => $emp['faculty_id'],
                    'name' => $emp['name'],
                    'gender' => $emp['gender'] ?? 'null',
                    'marital' => $emp['marital'] ?? 'null',
                    'birthday' => $emp['birthday'] ?? 'null',
                    'cnic' => $emp['cnic'] ?? 'null',
                    'emergency_phone' => trim($emp['emergency_phone'] ?? '00'),
                    'barcode' => $emp['barcode'] ?? 'null',
                    'job_title' => $emp['job_title'] ?? 'null',
                    'work_phone' => trim($emp['work_phone'] ?? '00'),
                    'mobile_phone' => trim($emp['mobile_phone'] ?? '00'),
                    'work_location' => $emp['work_location'] ?? 'null',
                    'blood_group' => $emp['blood_group'] ?? 'null',
                    'email' => $email,
                    'parent_department_id' => $emp['parent_department_id'] ?? 'null',
                    'parent_department_name' => $emp['parent_department_name'] ?? 'null',
                    'department' => $emp['department_name'] ?? 'null',
                    'department_id' => $emp['department_id'] ?? 'null',
                    'employee_code' => $emp['registration_number'] ?? '000',
                    'manager_id' => $emp['manager_id'],
                    'manager_name' => $emp['manager_name'] ?? 'null',
                    'position' => $emp['job_title'] ?? 'null',
                    'level' => 'Managerial',
                    'status' => $emp['status'] ? 'active' : 'in-active',
                    'password' => Hash::make('Admin@123'), // Assuming already hashed

                ]
            );
            $user->assignRole('user');
            // }
        }

        $this->info("Imported " . count($employees) . " employee records.");
    }
}
