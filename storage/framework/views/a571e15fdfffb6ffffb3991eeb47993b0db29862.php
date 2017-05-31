
<?php $__env->startSection('info'); ?>
  <title><?php echo e($article->art_title); ?> - <?php echo e(Config::get('web.web_title')); ?></title>
  <meta name="keywords" content="<?php echo e($article->art_tag); ?>" />
  <meta name="description" content="<?php echo e($article->art_description); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <article class="blogs">
    <h1 class="t_nav"><span>您当前的位置：<a href="<?php echo e(url('/')); ?>">首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo e(url("cate/".$article->cate_id)); ?>"><?php echo e($article->cate_name); ?></a></span><a href="<?php echo e(url('/')); ?>" class="n1">网站首页</a><a href="<?php echo e(url("cate/".$article->cate_id)); ?>" class="n2"><?php echo e($article->cate_name); ?></a></h1>
    <div class="index_about">
      <h2 class="c_titile"><?php echo e($article->art_title); ?></h2>
      <p class="box_c"><span class="d_time">发布时间：<?php echo e(date('Y-m-d',strtotime($article->updated_at))); ?></span><span>编辑：<?php echo e($article->art_editor); ?></span><span>查看次数：<?php echo e($article->art_view); ?></span></p>
      <ul class="infos">
        <?php echo $article->art_content; ?>

      </ul>
      <div class="keybq">
      <p><span>关键字词</span>：<?php echo e($article->art_tag); ?></p>

      </div>
      <div class="ad"> </div>
      <div class="nextinfo">
        <?php if($field['pre']): ?>
          <p>上一篇：<a href="<?php echo e(url('article/'.$field['pre']->art_id)); ?>"><?php echo e($field['pre']->art_title); ?></a>
        <?php else: ?>
          <p>上一篇：没有上一篇</p>
        <?php endif; ?>
        <?php if($field['next']): ?>
          <p>下一篇：<a href="<?php echo e(url('article/'.$field['next']->art_id)); ?>"><?php echo e($field['next']->art_title); ?></a></p>
        <?php else: ?>
          <p>下一篇：没有下一篇</p>
        <?php endif; ?>
      </div>
      <div class="otherlink">
        <h2>相关文章</h2>
        <ul>
          <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a href="<?php echo e(url('article/'.$item->art_id)); ?>" title="<?php echo e($item->art_title); ?>"><?php echo e($item->art_title); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
    <aside class="right">
      <!-- Baidu Button BEGIN -->
      <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
      <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
      <script type="text/javascript" id="bdshell_js"></script>
      <script type="text/javascript">
  document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
  </script>
      <!-- Baidu Button END -->
      <div class="blank"></div>
      <div class="news">
        ##parent-placeholder-040f06fd774092478d450774f5ba30c5da78acc8##
      </div>
      <div class="visitors">
        <h3>
          <p>最近访客</p>
        </h3>
        <ul>
        </ul>
      </div>
    </aside>
  </article>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>