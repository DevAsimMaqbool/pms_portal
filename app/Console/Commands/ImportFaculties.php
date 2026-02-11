<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Faculty;

class ImportFaculties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-faculties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import faculties from remote API and save into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching faculties...');

        // HTTP call
        $response = Http::get('http://10.25.25.108:8000/pms/get-faculty-list');

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
            Faculty::updateOrCreate(
                ['id' => $dept['id']],
                [
                    'name' => $dept['name'],
                    'code' => $dept['code'],
                    'campus_id' => $dept['campus_id'],
                    'house' => $dept['house'],
                    'status' => !empty($dept['status']) ? 1 : 0,
                ]
            );
        }

        $this->info('Faculties imported successfully!');
    }
}
