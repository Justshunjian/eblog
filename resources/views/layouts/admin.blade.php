<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('backend/style/css/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/style/font/css/font-awesome.min.css') }}">
    <script type="text/javascript" src="{{ asset('backend/style/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/style/js/ch-ui.admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/layer-v3.0.3/layer/layer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/laypage-v1.3/laypage/laypage.js') }}"></script>
</head>
<body>
@yield('content')

</body>
</html>