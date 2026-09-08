<?php

namespace App\Services;

class DemoPmsIndicatorCalculationService extends PmsIndicatorCalculationService
{
    /**
     * -------------------------------------------------------------
     * DEMO ROLE
     * -------------------------------------------------------------
     *
     * Only role_id = 33 will be processed.
     */
    protected array $roleIds = [
        33,
    ];

    /**
     * -------------------------------------------------------------
     * DEMO INDICATORS
     * -------------------------------------------------------------
     */
    protected array $indicatorIds = [
        113,
        117,
        120,
        122,
        182,
        185,
        186,
        188,
        189,
    ];

    /**
     * -------------------------------------------------------------
     * DEMO INDICATOR META
     * -------------------------------------------------------------
     */
    protected array $indicatorMeta = [

        113 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate113',
            'save'     => '90plus',
        ],

        117 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate117',
            'save'     => 'attendance',
        ],

        120 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate120',
            'save'     => '100plus',
        ],

        122 => [
            'kpa'      => 1,
            'category' => 3,
            'method'   => 'calculate122',
            'save'     => 'normal',
        ],

        182 => [
            'kpa'      => 1,
            'category' => 23,
            'method'   => 'calculate182',
            'save'     => '90plus',
        ],

        185 => [
            'kpa'      => 1,
            'category' => 25,
            'method'   => 'calculate185',
            'save'     => '90plus',
        ],

        186 => [
            'kpa'      => 1,
            'category' => 25,
            'method'   => 'calculate186',
            'save'     => 'normal',
        ],

        188 => [
            'kpa'      => 13,
            'category' => 27,
            'method'   => 'calculate188',
            'save'     => 'normal',
        ],

        189 => [
            'kpa'      => 13,
            'category' => 28,
            'method'   => 'calculate189',
            'save'     => 'normal',
        ],
    ];
}