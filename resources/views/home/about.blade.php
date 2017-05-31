@extends('layouts.home')

@section('info')
<title>Eblog博客系统—免费个人博客网站</title>
<meta name="keywords" content="个人博客,Eblog,lvfk,免费博客" />
<meta name="description" content="Eblog博客系统—免费个人博客网站，开发测试版本。" />
@endsection

@section('content')
    <link href='http://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
    <article class="aboutcon">
    <h1 class="t_nav"><span>勇敢的坚持下去，未来才有希望。</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('about')}}" class="n2">关于我</a></h1>
    <div class="about left">
      <h2>Just about me</h2>
        <ul>
         <p>lvfk，一个80后90初的重庆人，一个爱好编程的屌丝</p>
    <p>
        在技术道路上从未停止，从一开始工作的C、后来接触ASP.NET、Winform、JAVAEE、PHP、Python、MySQL
    </p>
    <p>目前在闲暇之余，学习大数据技术。。。</p>
    <p>
        未来也会在最新技术的道路上前行
    </p>
        </ul>
        {{--<h2>About Me</h2>--}}
        {{--<p>域  名：www.test.com 创建于2011年01月12日 <a href="/" class="blog_link" target="_blank">注册域名</a></p>--}}
        {{--<p>服务器：阿里云服务器<a href="/" class="blog_link" target="_blank">购买空间</a></p>--}}
        {{--<p>备案号：无</p>--}}
        {{--<p>程  序：无</p>--}}
    </div>
    <aside class="right">
        <div class="about_c">
        <p>网名：<span>Ebolg</span></p>
        <p>姓名：lvfk </p>
        <p>生日：1989-9-5</p>
        <p>籍贯：重庆市</p>
        <p>现居：深圳市</p>
        <p>职业：网站开发及运维</p>
            <iframe src="https://ghbtns.com/github-btn.html?user=Justshunjian&repo=eblog&type=star&count=true&size=large" frameborder="0" scrolling="0" width="160px" height="30px"></iframe>
            <iframe src="https://ghbtns.com/github-btn.html?user=Justshunjian&repo=eblog&type=watch&count=true&size=large&v=2" frameborder="0" scrolling="0" width="160px" height="30px"></iframe>
            <iframe src="https://ghbtns.com/github-btn.html?user=Justshunjian&repo=eblog&type=fork&count=true&size=large" frameborder="0" scrolling="0" width="158px" height="30px"></iframe>
    </div>
    </aside>
    </article>
@endsection