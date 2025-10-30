<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <img style="width: 175px;" src="{{ asset('admin/assets/img/avatars/superior.svg') }}">
        </a>


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->

        <li class="menu-item {{ request()->routeIs('teacher_dashboard') ? 'active' : '' }}">
            <a href="{{ route('teacher_dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Home">Home</div>
            </a>
            <!-- <ul class="menu-sub">
        <li class="menu-item active">
          <a href="" class="menu-link">
            <div data-i18n="Analytics">Analytics</div>
          </a>
        </li>
      </ul> -->
        </li>
        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="My Team">My Team</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('survey.report') ? 'active' : '' }}">
            <a href="{{ route('survey.report') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Report">Report</div>
            </a>
        </li>
        @if(auth()->user()->hasRole(['HOD']))
            @php
                $teacherRoleId = auth()->user()->roles->firstWhere('name', 'HOD')->id ?? null;

                $assignments = \App\Models\RoleKpaAssignment::with([
                'kpa',
                'category',
                'indicator.indicatorForm'
                ])
                ->where('role_id', $teacherRoleId)
                ->get();

                // Group by KPA → Category → Indicators
                $result = $assignments->groupBy('kpa.id')->map(function ($kpaGroup) {
                $kpa = $kpaGroup->first()->kpa;

                return [
                    'id' => $kpa->id,
                    'performance_area' => $kpa->performance_area,
                    'created_by' => $kpa->created_by,
                    'updated_by' => $kpa->updated_by,
                    'created_at' => $kpa->created_at,
                    'updated_at' => $kpa->updated_at,
                    'category' => $kpaGroup->groupBy('category.id')->map(function ($catGroup) {
                    $category = $catGroup->first()->category;

                    return [
                        'id' => $category->id,
                        'key_performance_area_id' => $category->key_performance_area_id,
                        'indicator_category' => $category->indicator_category,
                        'created_by' => $category->created_by,
                        'updated_by' => $category->updated_by,
                        'created_at' => $category->created_at,
                        'updated_at' => $category->updated_at,
                        'indicator' => $catGroup->map(function ($item) {
                        $indicator = $item->indicator;

                        return [
                            'id' => $indicator->id,
                            'indicator_category_id' => $indicator->indicator_category_id,
                            'indicator' => $indicator->indicator,
                            'created_by' => $indicator->created_by,
                            'updated_by' => $indicator->updated_by,
                            'created_at' => $indicator->created_at,
                            'updated_at' => $indicator->updated_at,
                            'indicator_form' => $indicator->indicatorForm ?? [],
                        ];
                        })->values()
                    ];
                    })->values()
                ];
                })->values();
                $icons = [
                    'ti tabler-star',
                    'ti tabler-heart',
                    'ti tabler-award',
                    'ti tabler-book',
                    'ti tabler-chart-bar',
                    'ti tabler-rocket',
                    'ti tabler-star',
                    'ti tabler-device-laptop'
                ];
            @endphp

            {{-- Render Menu --}}
            @foreach($result as $kpakey=>$kpa)
                <li class="menu-item active">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
                    <div data-i18n="{{ $kpa['performance_area'] }}">
                    {{ $kpa['performance_area'] }}
                    </div>
                </a>

                {{-- Level 2: Indicator Categories --}}
                <ul class="menu-sub">
                    @foreach($kpa['category'] as $category)
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="{{ $category['indicator_category'] }}">
                            {{ $category['indicator_category'] }}
                        </div>
                        </a>

                        {{-- Level 3: Indicators --}}
                        @if(!empty($category['indicator']))
                        <ul class="menu-sub">
                            @foreach($category['indicator'] as $indicator)
                                <li class="menu-item">
                                <a href="{{ route('indicator.form', [
                                'area' => $kpa['id'],
                                'category' => $category['id'],
                                'indicator' => $indicator['id']
                            ]) }}" class="menu-link">
                                    <div data-i18n="{{ $indicator['indicator'] }}">
                                    {{ $indicator['indicator'] }}
                                    </div>
                                </a>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
                </li>
            @endforeach
      @endif
      <li class="menu-item">
        <a href="{{ route('v2') }}"" class="menu-link">
          <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
          <div data-i18n="v2">v2</div>
        </a>
      </li>
    </ul>

</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ti tabler-menu icon-base"></i>
        <i class="ti tabler-chevron-right icon-base"></i>
    </a>
</div>
<!-- Menu -->