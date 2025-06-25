
<?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/jstree/jstree.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
   <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
  <div class="row gy-6">
 <!-- Basic -->
    <div class="col-md-12 col-12">
      <div class="card">
        <h5 class="card-header"><?php echo e($area->performance_area); ?></h5>
        <div class="card-body">
          <div id="jstree-basic">
            <ul>
            
                <?php $__currentLoopData = $area->indicatorCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-jstree='{"icon" : "icon-base ti tabler-graph"}'>
                        <?php echo e($category->indicator_category); ?>

                        <ul>
                            <?php $__currentLoopData = $category->indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li data-jstree='{"icon" : "icon-base ti tabler-player-record"}'><?php echo e($indicator->indicator); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <ul>
              
             
             
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /Basic -->
  </div>
</div>
          <!-- / Content -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('admin/assets/vendor/libs/jstree/jstree.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/js/extended-ui-treeview.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
    let theme = $("html").attr("data-bs-theme") === "dark" ? "default-dark" : "default";
    let contextTree = $("#jstree-context-menu");

    if (contextTree.length) {
        contextTree.jstree({
            core: {
                themes: {
                    name: theme
                },
                check_callback: true,
                data: [
                    {
                        text: "css",
                        children: [
                            { text: "app.css", type: "css" },
                            { text: "style.css", type: "css" }
                        ]
                    },
                    {
                        text: "img",
                        state: { opened: true },
                        children: [
                            { text: "bg.jpg", type: "img" },
                            { text: "logo.png", type: "img" },
                            { text: "avatar.png", type: "img" }
                        ]
                    },
                    {
                        text: "js",
                        state: { opened: true },
                        children: [
                            { text: "jquery.js", type: "js" },
                            { text: "app.js", type: "js" }
                        ]
                    },
                    { text: "index.html", type: "html" },
                    { text: "page-one.html", type: "html" },
                    { text: "page-two.html", type: "html" }
                ]
            },
            plugins: ["types", "contextmenu"],
            types: {
                default: { icon: "icon-base ti tabler-folder" },
                html: { icon: "icon-base ti tabler-brand-html5 bg-danger" },
                css: { icon: "icon-base ti tabler-brand-css3 bg-info" },
                img: { icon: "icon-base ti tabler-photo bg-success" },
                js: { icon: "icon-base ti tabler-brand-javascript bg-warning" }
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\pms\resources\views/admin/performance.blade.php ENDPATH**/ ?>