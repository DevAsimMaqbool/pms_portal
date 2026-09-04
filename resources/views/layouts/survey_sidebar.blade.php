<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
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

        <!-- <li class="menu-item {{ request()->routeIs('survey_dashboard.report') ? 'active' : '' }}">
            <a href="{{ route('survey_dashboard.report') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li> -->

        <!-- <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Home">Home</div>
            </a>
            <ul class="menu-sub">
        <li class="menu-item active">
          <a href="" class="menu-link">
            <div data-i18n="Analytics">Analytics</div>
          </a>
        </li>
      </ul> 
        </li> -->
        <!-- <li class="menu-item {{ request()->routeIs('survey.index') ? 'active' : '' }}">
            <a href="{{ route('survey.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Survey Data">Survey Data</div>
            </a>
        </li> -->
        <!-- <li class="menu-item {{ request()->routeIs('survey.report') ? 'active' : '' }}">
            <a href="{{ route('survey.report') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Over All Teacher Report">Over All Teacher Report</div>
            </a>
        </li> -->
        <!-- <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-chart-pie"></i>
                <div data-i18n="Survey Report">Survey Report</div>
            </a>
        </li> -->

        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon icon-base ti tabler-home"></i>
                <div data-i18n="Home">Home</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('newgoals.index') ? 'active' : '' }}">
            <a href="{{ route('newgoals.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-target"></i>
                <div data-i18n="Goal Setting">Goal Setting</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('goal-self-reports.index') ? 'active' : '' }}">
            <a href="{{ route('goal-self-reports.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-target"></i>
                <div data-i18n="Self Performance Reporting">Self Performance Reporting</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-star"></i>
                <div data-i18n="Virtue Mirror">Virtue Mirror</div>
            </a>
        </li>

        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-download"></i>
                <div data-i18n="Downloads">Downloads</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs([
  'employee-tasks.index',
  'employee-tasks.create',
  'employee-tasks.edit',
  'employee-tasks.show',
  'tasks.dashboard'
]) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon icon-base ti tabler-calendar-check"></i>
        <div data-i18n="Daily Productivity">Daily Productivity</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item  {{ request()->routeIs([
  'employee-tasks.index',
  'employee-tasks.create',
  'employee-tasks.edit',
  'employee-tasks.show'
]) ? 'active' : '' }}">
          <a href="{{ route('employee-tasks.index') }}" class="menu-link" data-bs-toggle="tooltip"
            data-bs-placement="right" data-bs-original-title="Assign To Me">
            <div data-i18n="Task Management">Task Management</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('tasks.dashboard') ? 'active' : '' }}">
          <a href="{{ route('tasks.dashboard') }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-original-title="Assign To Me Report">
            <div data-i18n="Task dashboard">Task dashboard</div>
          </a>
        </li>
      </ul>

    </li>

        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-message"></i>
                <div data-i18n="Feedback / Surveys">Feedback / Surveys</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-alert-triangle"></i>
                <div data-i18n="PIPs">PIPs</div>
            </a>
        </li>

        @php
            $hasManagedUsers = \App\Models\User::where('manager_id', auth()->id())->exists();
        @endphp

        @if ($hasManagedUsers)
            <li class="menu-item {{ request()->routeIs('goal-manager.index') ? 'active' : '' }}">
                <a href="{{ route('goal-manager.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-target"></i>
                    <div data-i18n="Manager Validation & Rating">
                        Manager Validation & Rating
                    </div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('manager.employees') ? 'active' : '' }}">
                    <a href="{{ route('manager.employees') }}"" class=" menu-link" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title="Team Performance">
                        <i class="menu-icon icon-base ti tabler-users-group"></i>
                        <div data-i18n="Team Performance">Team Performance</div>
                    </a>
                </li>
            <li class="menu-item {{ request()->routeIs('employee.goalfeedback.index') ? 'active' : '' }}">
                    <a href="{{ route('employee.goalfeedback.index') }}"" class=" menu-link" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title="Line Manager Feedback">
                        <i class="menu-icon icon-base ti tabler-building-skyscraper"></i>
                        <div data-i18n="Line Manager Feedback">Line Manager Feedback</div>
                    </a>
            </li>
            <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-report"></i>
                <div data-i18n="Daily Productivity">Daily Productivity</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ route('manage-employee-tasks.index') }}">
                    <a href="{{ route('manage-employee-tasks.index') }}" class="menu-link">
                        <div data-i18n="View Tasks">View Tasks</div>
                    </a>
                </li>

                <li class="menu-item {{ route('manager-view-tasks.index') }}">
                    <a href="{{ route('manager-view-tasks.index') }}" class="menu-link">
                        <div data-i18n="Daily Tasks Review">Daily Tasks Review</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('manager-verification-summary') ? 'active' : '' }}">
                    <a href="{{ route('manager-verification-summary') }}" class="menu-link">
                        <div data-i18n="Manager Verification Summary">
                            Manager Verification Summary
                        </div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('productivity.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('productivity.dashboard') }}" class="menu-link">
                        <div data-i18n="Monthly Dashboard">
                            Monthly Dashboard
                        </div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('main.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('main.dashboard') }}" class="menu-link">
                        <div data-i18n="Visual Dashboard">
                            Visual Dashboard
                        </div>
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