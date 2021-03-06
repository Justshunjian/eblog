

<?php $__env->startSection('content'); ?>
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('plugin/ueditor1_4_3_3-utf8-php/utf8-php/ueditor.config.js')); ?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('plugin/ueditor1_4_3_3-utf8-php/utf8-php/ueditor.all.min.js')); ?>"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('plugin/ueditor1_4_3_3-utf8-php/utf8-php/lang/zh-cn/zh-cn.js')); ?>"></script>

    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('plugin/uploadify/jquery.uploadify.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('plugin/uploadify/uploadify.css')); ?>">

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; <a href="<?php echo e(url('admin/article')); ?>">文章管理</a> &raquo; 添加文章
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
                <a href="<?php echo e(url('admin/article/create')); ?>" target="main"><i class="fa fa-plus"></i>添加文章</a>
                <a href="<?php echo e(url('admin/article')); ?>" target="main"><i class="fa fa-recycle" ></i>全部文章</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="<?php echo e(url('admin/article')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">分类：</th>
                        <td>
                            <select name="cate_id">
                                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->cate_id); ?>">
                                        <?php if($item->cate_pid!=0): ?>
                                            <?php echo '|—';?>
                                        <?php endif; ?>
                                        <?php echo e($item->cate_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                        </td>
                    </tr>
                    <tr>
                        <th>编辑：</th>
                        <td>
                            <input type="text" name="art_editor">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" class="lg" name="art_thumb" readonly="readonly">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="" alt="" id="art_thumb_id" width="100px" height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th>文章标签：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;"></script>
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
    <style>
        .edui-default{line-height: 28px;}
        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
        {
            overflow: hidden;height: 20px;
        }
        div.edui-box{overflow: hidden;height: 22px}
        .uploadify{display: inline-block;}
        .uploadify-button{border: none;border-radius: 5px;margin-top: 8px;}
        table.add_tab tr td span.uploadify-button-text{
            color: #ffffff;margin: 0;}
    </style>
    <script type="text/javascript">
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');

        //上传缩略图
		$(function() {
            $('#file_upload').uploadify({
                'buttonText' : '图片上传',
                'formData'     : {
                    'timestamp' : '<?php echo time();?>',
                    '_token'     : '<?php echo e(csrf_token()); ?>'
                },
                'swf'      : "<?php echo e(asset('plugin/uploadify/uploadify.swf')); ?>",
                'uploader' : "<?php echo e(url('admin/article/upload')); ?>",
                'onUploadSuccess' : function(file, data, response) {
                    $('input[name=art_thumb]').val(data);
                    $("#art_thumb_id").attr('src',data);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>