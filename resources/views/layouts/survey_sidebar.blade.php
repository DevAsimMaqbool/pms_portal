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

        <li class="menu-item">
            <a href="#" class="menu-link">
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
        <li class="menu-item {{ request()->routeIs('survey.index') ? 'active' : '' }}">
            <a href="{{ route('survey.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Survey Data">Survey Data</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('survey.report') ? 'active' : '' }}">
            <a href="{{ route('survey.report') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-contract"></i>
                <div data-i18n="Over All Teacher Report">Over All Teacher Report</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-chart-pie"></i>
                <div data-i18n="Survey Report">Survey Report</div>
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