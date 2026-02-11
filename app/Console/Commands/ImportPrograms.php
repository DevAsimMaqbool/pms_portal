<?php

namespace App\Console\Commands;

use App\Models\Program;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportPrograms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-programs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import departments from remote API and save into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching programs...');

        // HTTP call
        $response = Http::get('http://10.25.25.108:8000/pms/get-program-list');

        if (!$response->ok()) {
            $this->error('Failed to fetch data. HTTP Status: ' . $response->status());
            return;
        }

        $departments = $response->json();

        if (!is_array($departments)) {
            $this->error('Invalid data format received');
            return;
        }

        foreach ($departments as $dept) {
            Program::updateOrCreate(
                ['id' => $dept['id']],
                [
                    'program_name' => $dept['name'],
                    'code' => $dept['code'],
                    'short_code' => $dept['short_code'],
                    'department_id' => $dept['department_id'],
                    'faculty_id' => $dept['faculty_id'],
                    'status' => !empty($dept['status']) ? 1 : 0,
                ]
            );
        }

        $this->info('Program imported successfully!');
    }
}
