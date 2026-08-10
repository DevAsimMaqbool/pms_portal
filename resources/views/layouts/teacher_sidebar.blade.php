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

    <li class="menu-item {{ request()->routeIs('teacher_dashboard') ? 'active' : '' }}">
      <a href="{{ route('teacher_dashboard') }}" class="menu-link">
        <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon icon-base ti tabler-users"></i>
        <div data-i18n="Goal Settings">Goal Settings</div>
      </a>
    </li>
    <!-- <li class="menu-item {{ request()->routeIs([
              'view-assign-to-goal',
              'assign.goal.mapping.pdf',
          ]) ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon icon-base ti tabler-circle-letter-g"></i>
        <div data-i18n="Goal Settings">Goal Settings</div>
        </a>

        <ul class="menu-sub">
        <li class="menu-item  {{ request()->routeIs('view-assign-to-goal') ? 'active' : '' }}">
            <a href="{{ route('view-assign-to-goal') }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right"  data-bs-original-title="Assign To Me">
            <div data-i18n="Assign To Me">Assign To Me</div>
            </a>
        </li>
         <li class="menu-item {{ request()->routeIs('assign.goal.mapping.pdf') ? 'active' : '' }}">
              <a href="{{ route('assign.goal.mapping.pdf') }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right"  data-bs-original-title="Assign To Me Report">
              <div data-i18n="Assign To Me Report">Assign To Me Report</div>
              </a>
          </li>
        </ul>

    </li> -->

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

    <!-- <li class="menu-item {{ request()->routeIs('teacher_dashboard') ? 'active' : '' }}">
<a href="{{ route('teacher_dashboard') }}" class="menu-link">
<i class="menu-icon icon-base ti tabler-target-arrow"></i>
<div data-i18n="My Goals">My Goals</div>
</a>
</li> -->

    <!-- <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
<a href="{{ route('dashboard') }}" class="menu-link">
<i class="menu-icon icon-base ti tabler-smart-home"></i>
<div data-i18n="Home">Home</div>
</a>
</li> -->

    @if(in_array(getRoleName(activeRole()), ['Teacher', 'Assistant Professor', 'Professor', 'Associate Professor', 'Program Leader UG', 'Program Leader PG']))

        <!-- <li class="menu-item" {{ request()->routeIs('pip.index') ? 'active' : '' }}>
                                                                                                                                                                                                                              <a href="{{ route('pip.index') }}" class="menu-link">
                                                                                                                                                                                                                              <i class="menu-icon icon-base ti tabler-report-analytics"></i>
                                                                                                                                                                                                                              <div data-i18n="PIP">PIP</div>
                                                                                                                                                                                                                              </a>
                                                                                                                                                                                                                              </li> -->

        {{-- <li class="menu-item {{ request()->routeIs('pms.awards') ? 'active' : '' }}">
          <a href="{{ route('pms.awards') }}" class="menu-link">
            <i class="menu-icon icon-base ti tabler-award"></i>
            <div data-i18n="Awards">Awards</div>
          </a>
        </li> --}}
        <li class="menu-item {{ request()->routeIs('nomination.create') ? 'active' : '' }}">
          <a href="{{ route('nomination.create') }}" class="menu-link">
            <i class="menu-icon icon-base ti tabler-award"></i>
            <div data-i18n="Awards & Nomination">Awards & Nomination</div>
          </a>
        </li>

        <!-- <li class="menu-item">
                                                                                                                                                                                                                                                            <a href="{{ route('dashboard_v1') }}"" class=" menu-link">
                                                                                                                                                                                                                                                              <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                                                                                                                                                                                                                                                              <div data-i18n="v1">v1</div>
                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                          </li>
                                                                                                                                                                                                                                                          <li class="menu-item">
                                                                                                                                                                                                                                                            <a href="{{ route('teacher_dashboard') }}"" class=" menu-link">
                                                                                                                                                                                                                                                              <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                                                                                                                                                                                                                                                              <div data-i18n="v2">v2</div>
                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                          </li> -->
        @php
          // $result = getRoleAssignments(Auth::user()->getRoleNames()->first(), null, 1);
          $result = getSidbarRoleAssignments(getRoleName(activeRole()), null, 1);
          $icons = icons();
          $isPerformanceActive = request()->routeIs('indicator.form') || request()->routeIs('employee.rating.index') || request()->routeIs('self-assessment.index');
        @endphp

        <li class="menu-item {{ $isPerformanceActive ? 'active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right"
            data-bs-original-title="Performance Submissions">
            <i class="menu-icon icon-base ti tabler-brand-speedtest"></i>
            <div data-i18n="Performance Submissions">Performance Submissions</div>
          </a>

          <ul class="menu-sub">

            @foreach($result as $kpakey => $kpa)
              @php
                $kpaActive = request()->routeIs('indicator.form')
                  && request()->route('area') == $kpa['id'];
              @endphp
              <li class="menu-item {{ $kpaActive ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right"
                  data-bs-original-title=" {{ $kpa['performance_area'] }}">
                  <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
                  <div data-i18n="{{ $kpa['performance_area'] }}">{{ $kpa['performance_area'] }}</div> {{-- keep same label as
                  your original --}}
                </a>
                <ul class="menu-sub">
                  @foreach($kpa['category'] as $category)
                    @php
                      $categoryActive = request()->routeIs('indicator.form')
                        && request()->route('category') == $category['id'];
                    @endphp
                    <li class="menu-item {{ $categoryActive ? 'active open' : '' }}"
                      title="{{ $category['indicator_category'] }}">
                      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title=" {{ $category['indicator_category'] }}">
                        <div data-i18n="{{ $category['indicator_category'] }}">
                          {{ $category['indicator_category'] }}
                        </div>
                      </a>

                      @if(!empty($category['indicator']))
                        <ul
                          class="menu-sub {{ request()->routeIs('indicator.form') && request()->route('category') == $category['id'] ? 'active open' : '' }}">
                          @foreach($category['indicator'] as $indicator)
                                  @php
                                    $indicatorActive = request()->routeIs('indicator.form')
                                      && request()->route('indicator') == $indicator['id'];
                                  @endphp
                                  <li class="menu-item {{ $indicatorActive ? 'active' : '' }}" title="{{ $indicator['indicator'] }}">
                                    <a href="{{ route('indicator.form', [
                              'area' => $kpa['id'],
                              'category' => $category['id'],
                              'indicator' => $indicator['id']
                            ]) }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right"
                                      data-bs-original-title=" {{ $indicator['indicator'] }}">
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
            <li class="menu-item {{ request()->routeIs('employee.rating.index') ? 'active' : '' }}">
              <a href="{{ route('employee.rating.index') }}"" class=" menu-link" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Line Manager Feedback">
                <i class="menu-icon icon-base ti tabler-building-skyscraper"></i>
                <div data-i18n="Line Manager Feedback">Line Manager Feedback</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('self-assessment.index') ? 'active' : '' }}">
              <a href="{{ route('self-assessment.index') }}" class="menu-link" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Self Assessment">
                <i class="menu-icon icon-base ti tabler-clipboard-check"></i>
                <div data-i18n="Self Assessment">Self Assessment</div>
              </a>
            </li>
          </ul>
        </li>
        <li class="menu-item {{ request()->routeIs([
        'comparitive.analysis',
        'teacher.area_of_improvements',
        'teacher.noteable_performance',
      ]) ? 'active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ti tabler-eye-search"></i>
            <div data-i18n="Insights">Insights</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item  {{ request()->routeIs('comparitive.analysis') ? 'active' : '' }}">
              <a href="{{ route('comparitive.analysis') }}" class="menu-link" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Comparative Analysis">
                <i class="menu-icon icon-base ti tabler-analyze"></i>
                <div data-i18n="Comparative Analysis">Comparative Analysis</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('teacher.area_of_improvements') ? 'active' : '' }}">
              <a href="{{ route('teacher.area_of_improvements') }}" class="menu-link" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Area's of Improvement">
                <i class="menu-icon icon-base ti tabler-chart-line"></i>
                <div data-i18n="Area's of Improvement">Area's of Improvement</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('teacher.noteable_performance') ? 'active' : '' }}">
              <a href="{{ route('teacher.noteable_performance') }}" class="menu-link" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Acheivements">
                <i class="menu-icon icon-base ti tabler-trophy"></i>
                <div data-i18n="Acheivements">Acheivements</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right"
                data-bs-original-title="Reports">
                <i class="menu-icon icon-base ti tabler-report"></i>
                <div data-i18n="Reports">Reports</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('/user_report/' . Auth::user()->id) ? 'active' : '' }}">
                  <a href="{{ url('/user_report/' . Auth::user()->id) }}" target="_blank" class="menu-link"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Performance Insight Report">
                    <div data-i18n="Performance Insight Report">Performance Insight Report</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('/user_virtue_report/' . Auth::user()->id) ? 'active' : '' }}">
                  <a href="{{ url('/user_virtue_report/' . Auth::user()->id) }}" target="_blank" class="menu-link"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Virtue Report">
                    <div data-i18n="Virtue Report">Virtue Report</div>
                  </a>
                </li>

              </ul>

            </li>

          </ul>

        </li>

        <li class="menu-item">
          <a href="#" class="menu-link">
            <i class="menu-icon icon-base ti tabler-bell"></i>
            <div data-i18n="Notifications" id="swalCongrats">Notifications</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('pms.downloads') ? 'active' : '' }}">
          <a href="{{ route('pms.downloads') }}"" class=" menu-link">
            <i class="menu-icon icon-base ti tabler-download"></i>
            <div data-i18n="Downloads">Downloads</div>
          </a>
        </li>

    @else
      <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-users"></i>
          <div data-i18n="Users">Users</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('key-performance-area.index') ? 'active' : '' }}">
        <a href="{{ route('key-performance-area.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-message-star"></i>
          <div data-i18n="Key Performance Area">Key Performance Area</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('indicator-category.index') ? 'active' : '' }}">
        <a href="{{ route('indicator-category.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-users-group"></i>
          <div data-i18n="Indicator Category">Indicator Category</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('indicator.index') ? 'active' : '' }}">
        <a href="{{ route('indicator.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-message-heart"></i>
          <div data-i18n="Indicator">Indicator</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('teaching_learning') ? 'active' : '' }}">
        <a href="teaching_learning" class="menu-link">
          <i class="menu-icon icon-base ti tabler-settings"></i>
          <div data-i18n="Assign Indicators">Assign Indicators</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('user.kpa') ? 'active' : '' }}">
        <a href="{{ route('user.kpa') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-eye"></i>
          <div data-i18n="View Assigned Indicators">View Assigned Indicators</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">
        <a href="{{ route('departments.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-list-details"></i>
          <div data-i18n="View Departents">View Departents</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('user-role.index') ? 'active' : '' }}">
        <a href="{{ route('user-role.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-list-details"></i>
          <div data-i18n="Roles">Roles</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('role-permission.index') ? 'active' : '' }}">
        <a href="{{ route('role-permission.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-list-details"></i>
          <div data-i18n="Permission">Permission</div>
        </a>
      </li>
      <!-- <li class="menu-item {{ request()->routeIs('assigndepartment.index') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                    <a href="{{ route('assigndepartment.index') }}" class="menu-link">
                                                                                                                                                                                                                                                                                                                                    <i class="menu-icon icon-base ti tabler-message-heart"></i>
                                                                                                                                                                                                                                                                                                                                    <div data-i18n="Assign Department">Assign Department</div>
                                                                                                                                                                                                                                                                                                                                    </a>
                                                                                                                                                                                                                                                                                                                                    </li> -->
      <li class="menu-item {{ request()->routeIs('students.index') ? 'active' : '' }}">
        <a href="{{ route('students.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-message-heart"></i>
          <div data-i18n="Students">Students</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('assign-form.index') ? 'active' : '' }}">
        <a href="{{ route('assign-form.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-message-heart"></i>
          <div data-i18n="Assign Form To User">Assign Form To User</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('forms.assigned') ? 'active' : '' }}">
        <a href="{{ route('forms.assigned') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-message-heart"></i>
          <div data-i18n="Go To Forms">Go To Forms</div>
        </a>
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