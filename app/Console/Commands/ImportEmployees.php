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

        $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxNTY4NzAiLCJleHAiOjE3NDg4NTc5OTJ9.MPayVRjyZ847APtQ8EPj0JByM8pdiUMw617lAyN6XuE')
            ->get('http://103.62.235.19:8000/get-employee-detail');

        if ($response->failed()) {
            $this->error("Failed to fetch employee data.");
            $this->error('Status: ' . $response->status());
            $this->error('Body: ' . $response->body());
            return;
        }

        $employees = $response->json();
        $count = 0;
        foreach ($employees as $emp) {
            $email = $emp['work_email'] ?? ('test' . (++$count) . '@example.com');
            $existingUser = User::where('employee_code', $emp['registration_number'])->first();
            if (!$existingUser && User::where('email', $email)->exists()) {
                \Log::warning("Skipped duplicate email: {$email} (employee_code: {$emp['registration_number']})");
                continue;
            }
            User::updateOrCreate(
                ['employee_code' => $emp['registration_number']], // Unique key
                [
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
                    'department' => $emp['department_name'] ?? 'null',
                    'department_id' => $emp['department_id'] ?? 'null',
                    'employee_code' => $emp['registration_number'] ?? '000',
                    'manager_id' => $emp['manager_id'],
                    'manager_name' => $emp['manager_name'] ?? 'null',
                    'position' => $emp['job_title'] ?? 'null',
                    'level' => 'Managerial',
                    'status' => $emp['status'] ? 'active' : 'in-active',
                    'password' => $emp['password'] ?? Hash::make('Admin@123'), // Assuming already hashed

                ]
            );
        }
        foreach ($employees as $emp) {
            $user = User::where('employee_code', $emp['registration_number'])->first();

            if (!empty($emp['manager_id'])) {
                $manager = User::where('employee_code', $emp['manager_id'])->first();

                if ($user && $manager) {
                    $user->manager_id = $manager->id;
                    $user->save();
                }
            }
        }

        $this->info("Imported " . count($employees) . " employee records.");
    }
}
