
<?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/css/pages/page-profile.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
   <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-6">
        <div class="user-profile-header-banner">
          <img src="<?php echo e(asset('admin/assets/img/pages/profile-banner.png')); ?>" alt="Banner image" class="rounded-top" />
        </div>
        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="<?php echo e(asset('admin/assets/img/avatars/1.png')); ?>" alt="user image" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
          </div>
          <div class="flex-grow-1 mt-3 mt-lg-5">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4 class="mb-2 mt-lg-6"><?php echo e($employee['name']); ?></h4>
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                  <li class="list-inline-item d-flex gap-2 align-items-center"><i class="icon-base ti tabler-palette icon-lg"></i><span class="fw-medium"><?php echo e($employee['job_title']); ?></span></li>
                  <li class="list-inline-item d-flex gap-2 align-items-center"><i class="icon-base ti tabler-map-pin  icon-lg"></i><span class="fw-medium">Vatican City</span></li>
                  <li class="list-inline-item d-flex gap-2 align-items-center"><i class="icon-base ti tabler-calendar  icon-lg"></i><span class="fw-medium"> <?php echo e($employee['birthday']); ?> </span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->

  <!-- User Profile Content -->
  <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
      <!-- About User -->
      <div class="card mb-6">
        <div class="card-body">
          <p class="card-text text-uppercase text-body-secondary small mb-0">About</p>
          <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-4"><i class="icon-base ti tabler-user icon-lg"></i><span class="fw-medium mx-2">Full Name:</span> <span><?php echo e($employee['name']); ?></span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ti tabler-check icon-lg"></i><span class="fw-medium mx-2">Status:</span> <span>Active</span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ti tabler-crown icon-lg"></i><span class="fw-medium mx-2">Role:</span> <span><?php echo e($employee['job_title']); ?></span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ti tabler-flag icon-lg"></i><span class="fw-medium mx-2">Country:</span> <span>USA</span></li>
            <li class="d-flex align-items-center mb-2"><i class="icon-base ti tabler-language icon-lg"></i><span class="fw-medium mx-2">Languages:</span> <span>English</span></li>
          </ul>
          <p class="card-text text-uppercase text-body-secondary small mb-0">Contacts</p>
          <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ti tabler-phone-call icon-lg"></i><span class="fw-medium mx-2">Contact:</span>
              <span><?php echo e($employee['emergency_phone']); ?></span>
            </li>

            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ti tabler-mail icon-lg"></i><span class="fw-medium mx-2">Email:</span>
              <span><?php echo e($employee['work_email']); ?></span>
            </li>
             <li class="d-flex align-items-center mb-4"><i class="icon-base ti tabler-map-pin icon-lg"></i><span class="fw-medium mx-2">location:</span> <span><?php echo e($employee['work_location']); ?></span></li>
          </ul>
          <p class="card-text text-uppercase text-body-secondary small mb-0">Teams</p>
          <ul class="list-unstyled mb-0 mt-3 pt-1">
            <li class="d-flex flex-wrap mb-4"><span class="fw-medium me-2">Backend Developer</span><span>(126 Members)</span></li>
            <li class="d-flex flex-wrap"><span class="fw-medium me-2">React Developer</span><span>(98 Members)</span></li>
          </ul>
        </div>
      </div>
      <!--/ About User -->
    </div>

  </div>
  <!--/ User Profile Content -->
</div>
          <!-- / Content -->
    
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/pms/resources/views/profile/index.blade.php ENDPATH**/ ?>