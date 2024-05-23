<?php $__env->startSection('content'); ?>
<div class="row">
    <?php if($title): ?>
    <h1><strong><?php echo ($title !== 'Home') ? $title : '';; ?></strong></h1>
    <?php endif; ?>
    <hr style="margin-top: 0;">
</div>

<?php echo $content;; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row" style="margin: 15px 35px 0;">
            <div class="col-lg-5">
                <p class="text-muted">Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.Twoframework.fr/" target="_blank"><b>Two Framework <?php echo VERSION; ?> / Kernel <?php echo App::version(); ?></b></a></p>
            </div>
            <div class="col-lg-7">
                <p class="text-muted pull-right">
                    <small><!-- DO NOT DELETE! - Statistics --></small>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<!-- DO NOT DELETE! - Profiler -->

<?php echo $__env->make('Layouts/Default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>