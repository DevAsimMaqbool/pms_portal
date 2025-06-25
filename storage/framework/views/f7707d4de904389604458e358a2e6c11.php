<?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/bootstrap-select/bootstrap-select.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/select2/select2.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/flatpickr/flatpickr.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/tagify/tagify.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/form-validation.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
         <div class="row g-6 mb-6">
    <!-- Browser Default -->
    <div class="col-md">
      <div class="card">
        <h5 class="card-header">Update your account's profile information and email address.</h5>
        <div class="card-body">
          <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
    </div>
    <!-- /Browser Default -->

    <!-- Bootstrap Validation -->
    <div class="col-md">
      <div class="card">
        <h5 class="card-header">Delete Account</h5>
        <p class="card-header">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
        <div class="card-body">
         <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
    </div>
    <!-- /Bootstrap Validation -->
  </div>
    </div>
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('admin/assets/vendor/libs/select2/select2.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/bootstrap-select/bootstrap-select.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/flatpickr/flatpickr.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/tagify/tagify.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/popular.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js')); ?>"></script>

<script src="<?php echo e(asset('admin/assets/js/form-validation.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\pms\resources\views\profile\edit.blade.php ENDPATH**/ ?>