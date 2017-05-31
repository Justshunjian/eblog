<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo e(asset('backend/style/css/ch-ui.admin.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('backend/style/font/css/font-awesome.min.css')); ?>">
	<script type="text/javascript">
		//解决登录失效，登录页面被嵌套
		if(window.top.location.href!=location.href)
		{
			window.top.location.href=location.href;
		}
	</script>
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			<?php if(count($errors) > 0): ?>
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<p style="color:red"><?php echo e($error); ?></p>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			<form action="<?php echo e(url('admin/login')); ?>" method="post">
				<?php echo e(csrf_field()); ?>

				<ul>
					<li>
					<input type="text" name="username" class="text" value="<?php echo e(old('username')); ?>"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="<?php echo e(route('verifyCode')); ?>" alt="看不清，换一张" title="看不清，换一张"onclick="this.src='<?php echo e(route('verifyCode')); ?>?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; <?php echo e(date('Y')); ?> Powered by <a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a></p>
		</div>
	</div>
</body>
</html>