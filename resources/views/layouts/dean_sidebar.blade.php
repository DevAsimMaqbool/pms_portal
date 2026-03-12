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

        <li class="menu-item {{ request()->routeIs('my_performance') ? 'active' : '' }}">
            <a href="{{ route('my_performance') . '/' . '45433' }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                <div data-i18n="My Performances">My Performances</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('teacher_dashboard') ? 'active' : '' }}">
            <a href="{{ route('teacher_dashboard') }}"" class=" menu-link">
                <i class="menu-icon icon-base ti tabler-users-group"></i>
                <div data-i18n="Faculty Performance">Faculty Performance</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Team Performance">Team Performance</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ request()->routeIs('survey.report') ? 'active' : '' }}">
            <a href="{{ route('survey.report') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Report">Report</div>
            </a>
        </li> --}}
        
        @if(in_array(getRoleName(activeRole()), ['Dean']))
           

            @php
            $userRole = activeRole();
            $displayRole = match (strtolower($userRole)) {
                'dean' => 'Dean',
                default => ucfirst($userRole),
            };
            //$result = getRoleAssignments($displayRole, null, 1);
            $result = getSidbarRoleAssignments($displayRole, null, 1);
            $icons = icons();
            @endphp

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ti tabler-text-recognition"></i>
                    <div data-i18n="Forms">Forms</div>
                </a>

                <ul class="menu-sub">

                    @foreach($result as $kpakey => $kpa)
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{ $kpa['performance_area'] }}">
                                <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
                                <div data-i18n="{{ $kpa['performance_area'] }}">{{ $kpa['performance_area'] }}</div> {{-- keep
                                same
                                label as
                                your original --}}
                            </a>

                            <ul class="menu-sub">
                                @foreach($kpa['category'] as $category)
                                    <li class="menu-item" title="{{ $category['indicator_category'] }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{ $category['indicator_category'] }}">
                                            <div data-i18n="{{ $category['indicator_category'] }}">
                                                {{ $category['indicator_category'] }}
                                            </div>
                                        </a>

                                        @if(!empty($category['indicator']))
                                            <ul
                                                class="menu-sub {{ request()->routeIs('indicator.form') && request()->route('category') == $category['id'] ? 'active open' : '' }}">
                                                @foreach($category['indicator'] as $indicator)
                                                                    <li class="menu-item" title="{{ $indicator['indicator'] }}">
                                                                        <a href="{{ route('indicator.form', [
                                                        'area' => $kpa['id'],
                                                        'category' => $category['id'],
                                                        'indicator' => $indicator['id']
                                                    ]) }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{ $indicator['indicator'] }}">
                                                                            <div data-i18n="{{ $indicator['short_code'] ?? $indicator['indicator'] }}">
                                                                                {{ $indicator['short_code'] ?? $indicator['indicator'] }}
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
                    
                    
                    <li class="menu-item {{ request()->routeIs('dean.target') ? 'active' : '' }} data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Target"">
                        <a href="{{ route('dean.target') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-contract"></i>
                            <div data-i18n="Target">Target</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>

</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ti tabler-menu icon-base"></i>
        <i class="ti tabler-chevron-right icon-base"></i>
    </a>
</div>
<!-- Menu -->