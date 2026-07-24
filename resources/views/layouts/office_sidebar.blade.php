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
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-report"></i>
                <div data-i18n="Goal Statement">Goal Statement</div>
                </a>

                <ul class="menu-sub">
                 <li class="menu-item {{ route('s2r-drivers.index') }}">
                  <a href="{{ route('s2r-drivers.index') }}" class="menu-link">
                    <div data-i18n="S2R">S2R</div>
                  </a>
                </li>
                <li class="menu-item {{ route('goals.index') }}">
                  <a href="{{ route('goals.index') }}" class="menu-link">
                    <div data-i18n="GOAL">GOAL</div>
                  </a>
                </li>
                <li class="menu-item {{ route('goals-assign.index') }}">
                    <a href="{{ route('goals-assign.index') }}" class="menu-link">
                    <div data-i18n="Assign GOAL">Assign GOAL</div>
                    </a>
                </li>
                 <li class="menu-item {{ route('view-assign-to-goal') }}">
                    <a href="{{ route('view-assign-to-goal') }}" class="menu-link">
                    <div data-i18n="View From Assign Goal">View From Assign Goal</div>
                    </a>
                </li>
                <li class="menu-item {{ route('view-assign-goal') }}">
                    <a href="{{ route('view-assign-goal') }}" class="menu-link">
                    <div data-i18n="View To Assign Goal">View To Assign Goal</div>
                    </a>
                </li>
                <li class="menu-item {{ route('goal.mapping.pdf') }}">
                    <a href="{{ route('goal.mapping.pdf') }}" class="menu-link">
                    <div data-i18n="View Assign Report">View Assign Report</div>
                    </a>
                </li>
                </ul>

            </li>
    @php
      // $result = getRoleAssignments(Auth::user()->getRoleNames()->first(), null, 1); 
      $result = getSidbarRoleAssignments(Auth::user()->getRoleNames()->first(), null, 1);
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
            <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip" data-bs-placement="right"
              data-bs-original-title="{{ $kpa['performance_area'] }}">
              <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
              <div data-i18n="{{ $kpa['performance_area'] }}">{{ $kpa['performance_area'] }}</div> {{-- keep same label as
              your original --}}
            </a>
            <ul class="menu-sub">
              @foreach($kpa['category'] as $category)
                <li class="menu-item" title="{{ $category['indicator_category'] }}">
                  <a href="javascript:void(0);" class="menu-link menu-toggle" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="{{ $category['indicator_category'] }}">
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
                        ]) }}" class="menu-link" data-bs-toggle="tooltip" data-bs-placement="right"
                                    data-bs-original-title="{{ $indicator['indicator'] }}">
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

      </ul>
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