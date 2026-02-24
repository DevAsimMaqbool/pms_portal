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
    @php
      $result = getRoleAssignments(Auth::user()->getRoleNames()->first(), null, 1);
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
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon icon-base {{ $icons[$kpakey % count($icons)] }}"></i>
              <div data-i18n="{{ $kpa['performance_area'] }}">{{ $kpa['performance_area'] }}</div> {{-- keep same label as
              your original --}}
            </a>
            <ul class="menu-sub">
              @foreach($kpa['category'] as $category)
                <li class="menu-item" title="{{ $category['indicator_category'] }}">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
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
                        ]) }}" class="menu-link">
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