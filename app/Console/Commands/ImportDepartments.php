<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Department;

class ImportDepartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-departments';

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
        $this->info('Fetching departments...');

        // HTTP call
        $response = Http::get('http://103.62.235.19:8000/get-department-info');

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
            Department::updateOrCreate(
                ['id' => $dept['id']],
                [
                    'name' => $dept['name'],
                    'complete_name' => $dept['complete_name'],
                    'parent_id' => $dept['parent_id']
                ]
            );
        }

        $this->info('Departments imported successfully!');
    }
}
