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

    @if(auth()->user()->hasRole(['Teacher', 'Assistant Professor', 'Professor', 'Associate Professor']))

      <li class="menu-item {{ request()->routeIs('comparitive.analysis') ? 'active' : '' }}">
        <a href="{{ route('comparitive.analysis') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-analyze"></i>
          <div data-i18n="Comparitive Analysis">Comparitive Analysis</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('teacher.noteable_performance') ? 'active' : '' }}">
        <a href="{{ route('teacher.noteable_performance') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-trophy"></i>
          <div data-i18n="Acheivements">Acheivements</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('teacher.area_of_improvements') ? 'active' : '' }}">
        <a href="{{ route('teacher.area_of_improvements') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-chart-line"></i>
          <div data-i18n="Area's of Improvement">Area's of Improvement</div>
        </a>
      </li>
      <!-- <li class="menu-item" {{ request()->routeIs('pip.index') ? 'active' : '' }}>
                          <a href="{{ route('pip.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-report-analytics"></i>
                            <div data-i18n="PIP">PIP</div>
                          </a>
                        </li> -->
      <li class="menu-item {{ request()->routeIs('self-assessment.index') ? 'active' : '' }}">
        <a href="{{ route('self-assessment.index') }}" class="menu-link">
          <i class="menu-icon icon-base ti tabler-clipboard-check"></i>
          <div data-i18n="Self Assessment">Self Assessment</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('/user_report/' . Auth::user()->id) ? 'active' : '' }}">
        <a href="{{ url('/user_report/' . Auth::user()->id) }}" target="_blank" class="menu-link">
          <i class="menu-icon icon-base ti tabler-report"></i>
          <div data-i18n="Reports">Reports</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="#" class="menu-link">
          <i class="menu-icon icon-base ti tabler-award"></i>
          <div data-i18n="Awards">Awards</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="{{ route('dashboard_v1') }}"" class=" menu-link">
          <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
          <div data-i18n="v1">v1</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ route('v2') }}"" class=" menu-link">
          <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
          <div data-i18n="v2">v2</div>
        </a>
      </li>
      @php
        $result = getRoleAssignments(Auth::user()->getRoleNames()->first(), 2);
        $icons = icons();
      @endphp

      @foreach($result as $kpakey => $kpa)
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
            <div data-i18n="Forms">
              Forms
            </div>
          </a>


          <ul class="menu-sub">
            @foreach($kpa['category'] as $category)
              <li class="menu-item" title="{{ $category['indicator_category'] }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <div
                    data-i18n="{{ !empty($category['cat_short_code']) ? $category['cat_short_code'] : $category['indicator_category'] }}">
                    {{ !empty($category['cat_short_code']) ? $category['cat_short_code'] : $category['indicator_category'] }}
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
                      ]) }}" class="menu-link">
                            <div
                              data-i18n="{{ !empty($indicator['short_code']) ? $indicator['short_code'] : $indicator['indicator'] }}">
                              {{ !empty($indicator['short_code']) ? $indicator['short_code'] : $indicator['indicator'] }}
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
      <li class="menu-item {{ request()->routeIs('pms.downloads') ? 'active' : '' }}">
        <a href="{{ route('pms.downloads') }}"" class=" menu-link">
          <i class="menu-icon icon-base ti tabler-download"></i>
          <div data-i18n="Downloads">Downloads</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="#" class="menu-link">
          <i class="menu-icon icon-base ti tabler-bell"></i>
          <div data-i18n="Notifications" id="swalCongrats">Notifications</div>
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