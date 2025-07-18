<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">

  <div class="app-brand demo">
    <a href="<?php echo e(route('dashboard')); ?>" class="app-brand-link">
      <img style="width: 175px;" src="<?php echo e(asset('admin/assets/img/avatars/superior.svg')); ?>">
    </a>
    

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
      <i class="icon-base ti tabler-x d-block d-xl-none"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboards -->

    <li class="menu-item active open">
      <a href="<?php echo e(route('dashboard')); ?>" class="menu-link">
      <i class="menu-icon icon-base ti tabler-smart-home"></i>
      <div data-i18n="Dashboard">Dashboard</div>
      </a>
      <!-- <ul class="menu-sub">
        <li class="menu-item active">
          <a href="" class="menu-link">
            <div data-i18n="Analytics">Analytics</div>
          </a>
        </li>
      </ul> -->
    </li>


    <li class="menu-item">
      <a href="<?php echo e(route('key-performance-area.index')); ?>" class="menu-link">
        <i class="menu-icon icon-base ti tabler-message-star"></i>
        <div data-i18n="Key Performance Area">Key Performance Area</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="<?php echo e(route('indicator-category.index')); ?>" class="menu-link">
        <i class="menu-icon icon-base ti tabler-users-group"></i>
        <div data-i18n="Indicator Category">Indicator Category</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="<?php echo e(route('indicator.index')); ?>" class="menu-link">
        <i class="menu-icon icon-base ti tabler-message-heart"></i>
        <div data-i18n="Indicator">Indicator</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon icon-base ti tabler-message-circle-question"></i>
        <div data-i18n="Complaints">Complaints</div>
      </a>
    </li>
    <!-- <li class="menu-item">
      <a href="/charts" class="menu-link">
        <i class="menu-icon icon-base ti tabler-list-details"></i>
        <div data-i18n="View Details">View Details</div>
      </a>
    </li> -->
    <!-- <li class="menu-item active">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon icon-base ti tabler-settings"></i>
        <div data-i18n="Roles & Permissions">Roles & Permissions</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="" class="menu-link">
            <div data-i18n="Roles">Roles</div>
          </a>
        </li>
        <li class="menu-item active">
          <a href="#" class="menu-link">
            <div data-i18n="Permission">Permission</div>
          </a>
        </li>
      </ul>
    </li> -->
    <!-- Charts & Maps -->
    <!-- <li class="menu-header small">
      <span class="menu-header-text" data-i18n="Charts & Maps">Charts &amp; Maps</span>
    </li>
    <li class="menu-item active">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon icon-base ti tabler-chart-pie"></i>
        <div data-i18n="Reports">Reports</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item active">
          <a href="/chart" class="menu-link">
            <div data-i18n="Reports">Reports</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/chart" class="menu-link">
            <div data-i18n="View Details">View Details</div>
          </a>
        </li>
      </ul>
    </li> -->

  </ul>

</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
    <i class="ti tabler-menu icon-base"></i>
    <i class="ti tabler-chevron-right icon-base"></i>
  </a>
</div>
<!-- / Menu --><?php /**PATH C:\wamp64\www\pms\resources\views\layouts\sidebar.blade.php ENDPATH**/ ?>