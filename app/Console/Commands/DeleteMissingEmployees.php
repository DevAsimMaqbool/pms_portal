<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class DeleteMissingEmployees extends Command
{
    protected $signature = 'app:delete-missing-employees';

    protected $description = 'Delete users whose barcode does not exist in employee API';

    public function handle()
    {
        $this->info('Fetching employee records from API...');

        $response = Http::withToken('YOUR_API_TOKEN')
            ->get('http://103.177.240.229/pms/get-employee-list');

        if ($response->failed()) {
            $this->error('Failed to fetch employee data.');
            $this->error('Status: ' . $response->status());

            return self::FAILURE;
        }

        $employees = $response->json();

        if (!is_array($employees) || empty($employees)) {
            $this->error('API returned no employee records. Nothing deleted.');

            return self::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | Get API Barcodes
        |--------------------------------------------------------------------------
        */

        $apiBarcodes = collect($employees)
            ->pluck('barcode')
            ->filter()
            ->map(function ($barcode) {
                return trim((string) $barcode);
            })
            ->unique()
            ->values()
            ->toArray();

        $this->info('API barcodes found: ' . count($apiBarcodes));

        /*
        |--------------------------------------------------------------------------
        | Get Users
        |--------------------------------------------------------------------------
        */

        $users = User::whereNotNull('barcode')->get();

        $deleted = 0;
        $deletedUserIds = [];

        /*
        |--------------------------------------------------------------------------
        | Delete Users Missing From API
        |--------------------------------------------------------------------------
        */

        foreach ($users as $user) {

            $dbBarcode = trim((string) $user->barcode);

            if (!in_array($dbBarcode, $apiBarcodes, true)) {

                $deletedUserIds[] = $user->id;

                $this->warn(
                    "Deleting User ID: {$user->id} | " .
                    "Name: {$user->name} | " .
                    "Barcode: {$user->barcode}"
                );

                $user->delete();

                $deleted++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('================================');
        $this->info('Deletion Completed');
        $this->info('API Barcodes : ' . count($apiBarcodes));
        $this->info('Deleted      : ' . $deleted);

        if (!empty($deletedUserIds)) {
            $this->info(
                'Deleted IDs  : ' . implode(', ', $deletedUserIds)
            );
        } else {
            $this->info('Deleted IDs  : None');
        }

        $this->info('================================');

        return self::SUCCESS;
    }
}