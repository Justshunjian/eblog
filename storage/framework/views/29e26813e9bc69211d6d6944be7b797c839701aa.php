<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('backend/style/css/ch-ui.admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('backend/style/font/css/font-awesome.min.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('backend/style/js/jquery.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/style/js/ch-ui.admin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugin/layer-v3.0.3/layer/layer.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugin/laypage-v1.3/laypage/laypage.js')); ?>"></script>
</head>
<body>
<?php echo $__env->yieldContent('content'); ?>

</body>
</html>