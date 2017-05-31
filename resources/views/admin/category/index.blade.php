@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类管理
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
                <a href="{{url('admin/category/create')}}" target="main"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/category')}}" target="main"><i class="fa fa-recycle" ></i>全部分类</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <thead>
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th width="10%">分类</th>
                    <th width="50%">标题</th>
                    <th width="5%">点击</th>
                    <th width="15%">更新时间</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody id="cate_data"></tbody>
            </table>
        </div>
    </div>

    <div class="page_nav" style="margin:20px auto; width:600px;">
        <div id="page"></div>
    </div>

    <script>
        //注册事件
        var bindlistener = function () {
            $(":text").unbind("change")
            $(":text").change(function () {
                layer.load(2);
                var cate_order = this.value;
                var cate_id = $(this).parent().next(".tc").html();

                $.post('{{url('admin/category/changeOrder')}}',{'_token':'{{csrf_token()}}','id':cate_id, 'order':cate_order},function (data) {
                    layer.closeAll('loading');
                    if(data.state){
                        layer.msg('分类排序更新成功', {
                            icon: 6,
                            time: 3000,//3s自动执行
//                            btn: [''] //按钮
                        }, function(){
                            //暂不做及时刷新页面
                        });

                    }else{
                        layer.msg('分类排序更新失败', {
                            icon: 2,
                            time: 3000,//3s自动执行
                        }, function(){
                            //暂不做及时刷新页面
                        });
                    }
                });
            });

            $("a[name='del']").unbind("click")
            $("a[name='del']").click(function () {
                var obj = $(this);
                var cate_id = this.id;
                layer.confirm('您确定删除分类？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.post('{{url('admin/category/')}}/'+cate_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                        layer.closeAll('loading');
                        if(data.state){
                            //删除表格数据
                            obj.parents("tr").remove();
                            layer.msg('分类删除成功', {
                                icon: 6,
                                time: 3000,//3s自动执行
//                            btn: [''] //按钮
                            }, function(){

                            });

                        }else{
                            layer.msg('分类删除失败', {
                                icon: 2,
                                time: 3000,//3s自动执行
                            }, function(){
                                {{--window.location.href= "{{url('admin/category')}}"--}}
                            });
                        }
                    });
                }, function(){

                });

            });
        }

        /**
         * 异步获取一页分类数据
         * @param int curr  页码
         * @param int pageSize 每页数量
         */
        function pageUpDown(curr) {
            layer.load(2);
            $.post('{{url('admin/category/page')}}',{'_token':'{{csrf_token()}}','curr':curr, 'pageSize':10},function (data) {
                layer.closeAll('loading');
                if(data.state){
                    //操作表格
                    //清空所有子节点
                    $("#cate_data").empty();
                    var items = data.items;
                    for(var i = 0; i < items.length; i++){
                        var $tr = $("<tr></tr>");
                        $tr.append("<td class='tc'><input type='text' name='ord[]' value="+items[i].cate_order+"></td>");
                        $tr.append("<td class=\"tc\">"+items[i].cate_id+"</td>");
                        if(items[i].cate_pid != 0){
                            $tr.append("<td><a href=\"#\">|—"+items[i].cate_name+"</a></td>");
                        }else{
                            $tr.append("<td><a href=\"#\">"+items[i].cate_name+"</a></td>");
                        }
                        $tr.append("<td>"+items[i].cate_title+"</td>");
                        $tr.append("<td>"+items[i].cate_view+"</td>");
                        $tr.append("<td>"+items[i].updated_at+"</td>");
                        $tr.append("<td>"
                                +"<a href=\"{{url('admin/category/')}}/"
                                +items[i].cate_id+"/edit\">修改</a>"
                                +"<a href=\"javascript:void(0)\" name=\"del\" id="+items[i].cate_id+">删除</a>"
                                +"</td>");

                        $tr.appendTo($("#cate_data"));

                        //注册事件
                        bindlistener();
                    }
                    //分页
                    laypage({
                        cont: 'page' //分页容器的id
                        ,pages: data.pages //总页数
                        ,curr: curr || 1 //当前页
                        ,skin: '#5FB878' //自定义选中色值
                        //,skip: true //开启跳页
                        ,jump: function(obj, first){
                            if(!first){
                                pageUpDown(obj.curr);
                            }
                        }
                    });

                }else{
                    layer.msg('服务器未知错误', {
                        icon: 2,
                        time: 3000,//3s自动执行
                    }, function(){
                        //暂不做及时刷新页面
                    });
                }
            });
        }

        $(function () {

            //获取第一页数据
            pageUpDown(1);


        });
    </script>
@endsection