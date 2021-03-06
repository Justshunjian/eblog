

<?php $__env->startSection('content'); ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
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

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <thead>
                <tr>
                    <th>分类</th>
                    <th>ID</th>
                    <th width="30%">标题</th>
                    <th width="15%">关键词</th>
                    <th>缩略图</th>
                    <th>编辑者</th>
                    <th>点击量</th>
                    <th>更新时间</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="tc"><?php echo e($item->cate_id); ?></td>
                        <td class="tc"><?php echo e($item->art_id); ?></td>
                        <td class="tc"><?php echo e($item->art_title); ?></td>
                        <td class="tc"><?php echo e($item->art_tag); ?></td>
                        <td>
                            <img src="<?php echo e($item->art_thumb); ?>" width="100px" height="100px" align="center">
                        </td>
                        <td><?php echo e($item->art_editor); ?></td>
                        <td><?php echo e($item->art_view); ?></td>
                        <td><?php echo e($item->updated_at); ?></td>
                        <td><?php echo e($item->created_at); ?></td>
                        <td>
                            <a href="<?php echo e(url('admin/article/'.$item->art_id.'/edit')); ?>">修改</a>
                            <a href="javascript:void(0)" name="delArticle" id="<?php echo e($item->art_id); ?>">删除</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page_nav" style="margin:20px auto; width:600px;">
        <?php echo e($data->links()); ?>

    </div>

    <script>
        //注册事件
        var bindlistener = function () {
            $("a[name='delArticle']").click(function () {
                var obj = $(this);
                var art_id = this.id;
                layer.confirm('您确定删除文章？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.post('<?php echo e(url('admin/article/')); ?>/'+art_id,{'_token':'<?php echo e(csrf_token()); ?>','_method':'delete'},function (data) {
                        layer.closeAll('loading');
                        if(data.state){
                            //删除表格数据
                            obj.parents("tr").remove();
                            layer.msg('文章删除成功', {
                                icon: 6,
                                time: 3000,//3s自动执行
//                            btn: [''] //按钮
                            }, function(){

                            });

                        }else{
                            layer.msg('文章删除失败', {
                                icon: 2,
                                time: 3000,//3s自动执行
                            }, function(){
                                
                            });
                        }
                    });
                }, function(){

                });

            });
        }

        $(function () {

            //绑定事件
            bindlistener();


        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>