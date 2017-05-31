

<?php $__env->startSection('info'); ?>
<title>Eblog博客系统—免费个人博客网站</title>
<meta name="keywords" content="个人博客,Eblog,lvfk,免费博客" />
<meta name="description" content="Eblog博客系统—免费个人博客网站，开发测试版本。" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link href='http://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
    <article class="aboutcon">
    <h1 class="t_nav"><span>勇敢的坚持下去，未来才有希望。</span><a href="<?php echo e(url('/')); ?>" class="n1">网站首页</a><a href="<?php echo e(url('about')); ?>" class="n2">关于我</a></h1>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>