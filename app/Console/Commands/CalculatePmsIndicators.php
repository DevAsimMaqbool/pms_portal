<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PmsIndicatorCalculationService;
use App\Models\User;
use Throwable;

class CalculatePmsIndicators extends Command
{
    protected $signature = 'pms:calculate-indicators
                            {--employee= : Calculate only one employee_id}
                            {--faculty= : Calculate users against faculty column}
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
        $facultyId = $this->option('faculty');

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
             * FACULTY USERS
             * -----------------------------------------------------
             */
            if ($facultyId !== null) {

                $employees = User::where(
                    'faculty',
                    $facultyId
                )->get();

                if ($employees->isEmpty()) {
                    $this->error(
                        "No users found for faculty: {$facultyId}"
                    );

                    return self::FAILURE;
                }

                $this->info(
                    "Processing faculty: {$facultyId}"
                );

                $this->info(
                    "Users found: {$employees->count()}"
                );

                $total = [
                    'employees' => 0,
                    'processed' => 0,
                    'saved' => 0,
                    'skipped' => 0,
                    'failed' => 0,
                ];

                foreach ($employees as $employee) {

                    $this->newLine();

                    $this->info(
                        "Processing employee ID: {$employee->employee_id}"
                    );

                    $result = $service->calculateAll(
                        (int) $employee->employee_id
                    );

                    foreach ($total as $key => $value) {
                        $total[$key] += $result[$key] ?? 0;
                    }
                }

                $this->newLine();

                $this->info(
                    'Faculty indicator calculation completed.'
                );

                $this->table(
                    [
                        'Employees',
                        'Processed',
                        'Saved',
                        'Skipped',
                        'Failed',
                    ],
                    [[
                        $total['employees'],
                        $total['processed'],
                        $total['saved'],
                        $total['skipped'],
                        $total['failed'],
                    ]]
                );

                return $total['failed'] > 0
                    ? self::FAILURE
                    : self::SUCCESS;
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

                $employee = User::where(
                    'employee_id',
                    $employeeId
                )->first();

                if ($employee) {

                    /*
                     * Run separately so we can see
                     * exact indicator results.
                     */
                    $detailService = app(
                        PmsIndicatorCalculationService::class
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