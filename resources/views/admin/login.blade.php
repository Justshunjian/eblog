<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{ asset('backend/style/css/ch-ui.admin.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/style/font/css/font-awesome.min.css') }}">
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
			@if (count($errors) > 0)
				@foreach($errors->all() as $error)
				<p style="color:red">{{ $error }}</p>
				@endforeach
			@endif
			<form action="{{ url('admin/login') }}" method="post">
				{{ csrf_field() }}
				<ul>
					<li>
					<input type="text" name="username" class="text" value="{{old('username')}}"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{ route('verifyCode') }}" alt="看不清，换一张" title="看不清，换一张"onclick="this.src='{{ route('verifyCode') }}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; {{date('Y')}} Powered by <a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a></p>
		</div>
	</div>
</body>
</html>