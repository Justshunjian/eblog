
<?php $__env->startSection('info'); ?>
    <title><?php echo e($category->cate_name); ?> - <?php echo e(Config::get('web.web_title')); ?></title>
    <meta name="keywords" content="<?php echo e($category->cate_keywords); ?>" />
    <meta name="description" content="<?php echo e($category->cate_description); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <article class="blogs">
    <h1 class="t_nav"><span><?php echo e($category->cate_title); ?></span><a href="<?php echo e(url('/')); ?>" class="n1">网站首页</a><a href="<?php echo e(url('cate/'.$category->cate_id)); ?>" class="n2"><?php echo e($category->cate_name); ?></a></h1>
    <div class="newblog left">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <h2><?php echo e($item->art_title); ?></h2>
           <p class="dateview"><span>发布时间：<?php echo e(date('Y-m-d',strtotime($item->updated_at))); ?></span><span>作者：<?php echo e($item->art_editor); ?></span><span>分类：[<a href="<?php echo e(url('cate/'.$category->cate_id)); ?>"><?php echo e($category->cate_name); ?></a>]</span></p>
            <figure><img src="<?php echo e(url("$item->art_thumb")); ?>"></figure>
            <ul class="nlist">
              <p><?php echo e($item->art_description); ?></p>
              <a title="<?php echo e($item->art_title); ?>" href="<?php echo e(url('article/'.$item->art_id)); ?>" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="blank"></div>
        <div class="page_nav" style="margin:20px auto; width:600px;">
            <?php echo e($data->links()); ?>

        </div>
    </div>
    <aside class="right">
        <?php if($submenu): ?>
       <div class="rnav">
          <ul>
              <?php $__currentLoopData = $submenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="rnav<?php echo e($k%4+1); ?>"><a href="<?php echo e(url('cate/'.$sub->cate_id)); ?>" target="_blank"><?php echo e($sub->cate_name); ?></a></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
        </div>
        <?php endif; ?>
        <div class="news">
            ##parent-placeholder-040f06fd774092478d450774f5ba30c5da78acc8##
        </div>
        <div class="visitors">
          <h3><p>最近访客</p></h3>
          <ul>

          </ul>
        </div>
         <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script>
        <!-- Baidu Button END -->
    </aside>
    </article>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>