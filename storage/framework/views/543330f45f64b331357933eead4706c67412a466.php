

<?php $__env->startSection('content'); ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; <a href="<?php echo e(url('admin/navs')); ?>">导航管理</a> &raquo; 编辑导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            <?php if(count($errors)>0): ?>
                <div class="mark">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li style="color:red"><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="<?php echo e(url('admin/navs/create')); ?>" target="main"><i class="fa fa-plus"></i>添加导航</a>
                <a href="<?php echo e(url('admin/navs')); ?>" target="main"><i class="fa fa-recycle" ></i>全部导航</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="<?php echo e(url('admin/navs/'.$data->nav_id)); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('put')); ?>

            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" class="lg" name="nav_name" value="<?php echo e($data->nav_name); ?>">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>别名：</th>
                    <td>
                        <input type="text" class="lg" name="nav_alias" value="<?php echo e($data->nav_alias); ?>">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>链接：</th>
                    <td>
                        <input type="text" name="nav_url" value="<?php echo e($data->nav_url); ?>">
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="nav_order" value="<?php echo e($data->nav_order); ?>">
                    </td>
                </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>