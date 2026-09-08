<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\DemoPmsIndicatorCalculationService;
use Illuminate\Console\Command;
use Throwable;

class CalculateDemoPmsIndicators extends Command
{
    /**
     * -------------------------------------------------------------
     * COMMAND SIGNATURE
     * -------------------------------------------------------------
     */
    protected $signature = 'pms:calculate-demo-indicators
                            {--employee= : Calculate only one employee_id}
                            {--dry-run : Calculate but do not save}';

    /**
     * -------------------------------------------------------------
     * DESCRIPTION
     * -------------------------------------------------------------
     */
    protected $description =
        'Calculate and save Demo PMS indicators for role 33';

    /**
     * -------------------------------------------------------------
     * HANDLE
     * -------------------------------------------------------------
     */
    public function handle(
        DemoPmsIndicatorCalculationService $service
    ): int {

        $this->info(
            'Starting Demo PMS indicator calculation...'
        );

        $this->info(
            'Role: 33'
        );

        $this->info(
            'Indicators: 113, 117, 120, 122, 182, 185, 186, 188, 189'
        );

        $this->newLine();

        $employeeId = $this->option('employee');

        try {

            /**
             * -----------------------------------------------------
             * DRY RUN
             * -----------------------------------------------------
             *
             * Same behavior as your existing PMS command.
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

            /**
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

                /**
                 * Summary
                 */
                $this->table(
                    [
                        'Role',
                        'Employees',
                        'Indicators Processed',
                        'Saved',
                        'Skipped',
                        'Failed',
                    ],
                    [[
                        33,
                        $result['employees'],
                        $result['processed'],
                        $result['saved'],
                        $result['skipped'],
                        $result['failed'],
                    ]]
                );

                /**
                 * -------------------------------------------------
                 * DETAIL
                 * -------------------------------------------------
                 */
                $employee = User::where(
                    'employee_id',
                    $employeeId
                )->first();

                if ($employee) {

                    /**
                     * IMPORTANT:
                     *
                     * Use the DEMO service here as well.
                     *
                     * Do NOT use:
                     *
                     * PmsIndicatorCalculationService
                     *
                     * otherwise all roles/indicators may be processed.
                     */
                    $detail = $service
                        ->calculateForEmployee($employee);

                    $this->newLine();

                    $this->info(
                        "Indicator details for employee {$employeeId}:"
                    );

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

            /**
             * -----------------------------------------------------
             * ALL ROLE 33 EMPLOYEES
             * -----------------------------------------------------
             */
            $result = $service->calculateAll();

            $this->newLine();

            $this->info(
                'Demo PMS indicator calculation completed.'
            );

            $this->newLine();

            $this->table(
                [
                    'Role',
                    'Employees',
                    'Indicators Processed',
                    'Saved',
                    'Skipped',
                    'Failed',
                ],
                [[
                    33,
                    $result['employees'],
                    $result['processed'],
                    $result['saved'],
                    $result['skipped'],
                    $result['failed'],
                ]]
            );

            $this->newLine();

            /**
             * -----------------------------------------------------
             * FINAL STATUS
             * -----------------------------------------------------
             */
            if ($result['failed'] > 0) {

                $this->error(
                    'Some Demo PMS indicator calculations failed.'
                );

                return self::FAILURE;
            }

            $this->info(
                'All Demo PMS indicator calculations completed successfully.'
            );

            return self::SUCCESS;

        } catch (Throwable $e) {

            $this->error(
                'Demo PMS calculation failed.'
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