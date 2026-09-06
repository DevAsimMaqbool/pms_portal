<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PmsIndicatorCalculationService;
use Throwable;

class CalculatePmsIndicators extends Command
{
    protected $signature = 'pms:calculate-indicators
                            {--employee= : Calculate only one employee_id}
                            {--dry-run : Calculate but do not save}';

    protected $description =
        'Calculate and save PMS indicators for roles 21, 26, 27 and 28';

    public function handle(
        PmsIndicatorCalculationService $service
    ): int {

        $this->info(
            'Starting PMS indicator calculation...'
        );

        $this->newLine();

        $employeeId = $this->option('employee');

        try {

            /*
             * -----------------------------------------------------
             * DRY RUN
             * -----------------------------------------------------
             */
            if ($this->option('dry-run')) {

                $this->warn(
                    'Dry-run is not implemented as DB transaction rollback.'
                );

                $this->warn(
                    'Run without --dry-run for actual saving.'
                );

                return self::SUCCESS;
            }

            /*
             * -----------------------------------------------------
             * SINGLE EMPLOYEE
             * -----------------------------------------------------
             */
            if ($employeeId) {

    $this->info(
        "Processing employee: {$employeeId}"
    );

    $result = $service->calculateAll(
        (int) $employeeId
    );

    $this->newLine();

    $this->table(
        [
            'Employees',
            'Processed',
            'Saved',
            'Skipped',
            'Failed',
        ],
        [[
            $result['employees'],
            $result['processed'],
            $result['saved'],
            $result['skipped'],
            $result['failed'],
        ]]
    );

    /*
     * Show indicator-level details
     */
    $this->newLine();

    $employee = \App\Models\User::where(
        'employee_id',
        $employeeId
    )->first();

    if ($employee) {

        /*
         * Run separately so we can see
         * exact indicator results.
         */
        $detailService = app(
            \App\Services\PmsIndicatorCalculationService::class
        );

        $detail = $detailService
            ->calculateForEmployee($employee);

        $this->newLine();

        $this->table(
            [
                'Role',
                'Indicator',
                'Status',
                'Raw Score',
                'Weight',
                'Weighted',
                'Message',
            ],
            collect($detail['indicators'])
                ->map(function ($item) {

                    return [
                        $item['role_id'] ?? '',
                        $item['indicator_id'] ?? '',
                        $item['status'] ?? '',
                        $item['raw_score'] ?? '',
                        $item['weightage'] ?? '',
                        $item['weighted_score'] ?? '',
                        $item['message'] ?? '',
                    ];

                })
                ->toArray()
        );
    }

    return $result['failed'] > 0
        ? self::FAILURE
        : self::SUCCESS;
}

            /*
             * -----------------------------------------------------
             * ALL EMPLOYEES
             * -----------------------------------------------------
             */
            $result = $service->calculateAll();

            $this->newLine();

            $this->info(
                'PMS indicator calculation completed.'
            );

            $this->newLine();

            $this->table(
                [
                    'Employees',
                    'Indicators Processed',
                    'Saved',
                    'Skipped',
                    'Failed',
                ],
                [[
                    $result['employees'],
                    $result['processed'],
                    $result['saved'],
                    $result['skipped'],
                    $result['failed'],
                ]]
            );

            return $result['failed'] > 0
                ? self::FAILURE
                : self::SUCCESS;

        } catch (Throwable $e) {

            $this->error(
                'Calculation failed.'
            );

            $this->error(
                $e->getMessage()
            );

            $this->error(
                $e->getFile() .
                ':' .
                $e->getLine()
            );

            return self::FAILURE;
        }
    }
}