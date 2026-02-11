<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Campus;

class ImportCampuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-campuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import campuses from remote API and save into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching campuses...');

        // HTTP call
        $response = Http::get('http://10.25.25.108:8000/pms/get-campus-list');

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
            Campus::updateOrCreate(
                ['id' => $dept['id']],
                [
                    'name' => $dept['name'],
                    'code' => $dept['code'],
                    'city' => $dept['city'],
                    'effective_date' => $dept['effective_date'],
                    'status' => !empty($dept['status']) ? 1 : 0,
                ]
            );
        }

        $this->info('Campuses imported successfully!');
    }
}
