<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base ti tabler-menu-2 icon-md"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
    <h5 class="card-title mb-0 justify-content-center">Performance Management Solution</h5>
    <ul class="navbar-nav flex-row align-items-center ms-md-auto">

      <!--/ Language -->


      <!-- Style Switcher -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" id="nav-theme"
          href="javascript:void(0);" data-bs-toggle="dropdown">
          <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
          <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
          <li>
            <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light"
              aria-pressed="false">
              <span><i class="icon-base ti tabler-sun icon-22px me-3" data-icon="sun"></i>Light</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
              aria-pressed="true">
              <span><i class="icon-base ti tabler-moon-stars icon-22px me-3" data-icon="moon-stars"></i>Dark</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
              aria-pressed="false">
              <span><i class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                  data-icon="device-desktop-analytics"></i>System</span>
            </button>
          </li>
        </ul>
      </li>
      <!-- / Style Switcher-->
      <!-- Quick links  -->
      
      <!-- Quick links -->

      <!-- Notification -->
      
      <!--/ Notification -->

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="<?php echo e(asset('admin/assets/img/avatars/1.png')); ?>" alt class="rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item mt-0" href="<?php echo e(route('profile.index')); ?>">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-2">
                  <div class="avatar avatar-online">
                    <img src="<?php echo e(asset('admin/assets/img/avatars/1.png')); ?>" alt class="rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0"><?php echo e(session('username')); ?></h6>
                  <small class="text-body-secondary"><?php echo e(session('user_type')); ?></small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider my-1 mx-n2"></div>
          </li>
          <li>
            <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>"> <i
                class="icon-base ti tabler-user me-3 icon-md"></i><span class="align-middle">My Profile</span> </a>
          </li>
          

          <li>
            <div class="dropdown-divider my-1 mx-n2"></div>
          </li>

          
          <li>
            <div class="d-grid px-2 pt-2 pb-1">
              <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <a class="btn btn-sm btn-danger d-flex text-white" :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                  <small class="align-middle">Logout</small>
                  <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                </a>
              </form>
            </div>
          </li>
        </ul>
      </li>
      <!--/ User -->

    </ul>
  </div>
</nav>

<!-- / Navbar --><?php /**PATH C:\wamp64\www\pms\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>