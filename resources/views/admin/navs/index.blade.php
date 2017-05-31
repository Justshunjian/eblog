@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 导航管理
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
                <a href="{{url('admin/navs/create')}}" target="main"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}" target="main"><i class="fa fa-recycle" ></i>全部导航</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <thead>
                <tr>
                    <th width='5%'>ID</th>
                    <th width="10%">名称</th>
                    <th width="10%">别名</th>
                    <th width="20%">链接</th>
                    <th>排序</th>
                    <th>更新时间</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{$item->nav_id}}</td>
                        <td>{{$item->nav_name}}</td>
                        <td>{{$item->nav_alias}}</td>
                        <td>{{$item->nav_url}}</td>
                        <td class='tc'><input type='text' name='ord[]' value="{{$item->nav_order}}"></td>
                        <td>{{$item->updated_at}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$item->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0)" name="delNav" id="{{$item->nav_id}}">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="page_nav" style="margin:20px auto; width:600px;">
        {{ $data->links() }}
    </div>

    <script>
        //注册事件
        var bindlistener = function () {
            //修改排序
            $(":text").unbind("change")
            $(":text").change(function () {
                layer.load(2);
                var order = this.value;
                var id = $(this).parent().parent().children().first().html();

                $.post('{{url('admin/navs/changeOrder')}}',{'_token':'{{csrf_token()}}','id':id, 'order':order},function (data) {
                    layer.closeAll('loading');
                    if(data.state){
                        layer.msg('排序更新成功', {
                            icon: 6,
                            time: 3000,//3s自动执行
//                            btn: [''] //按钮
                        }, function(){
                            //暂不做及时刷新页面
                        });
                    }else{
                        layer.msg('排序更新失败', {
                            icon: 2,
                            time: 3000,//3s自动执行
                        }, function(){
                            //暂不做及时刷新页面
                        });
                    }
                });
            });

            $("a[name='delNav']").click(function () {
                var obj = $(this);
                var id = this.id;
                layer.confirm('您确定删除友情链接？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.post('{{url('admin/navs/')}}/'+id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                        layer.closeAll('loading');
                        if(data.state){
                            //删除表格数据
                            obj.parents("tr").remove();
                            layer.msg('导航删除成功', {
                                icon: 6,
                                time: 3000,//3s自动执行
//                            btn: [''] //按钮
                            }, function(){

                            });

                        }else{
                            layer.msg('导航删除失败', {
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

        $(function () {

            //绑定事件
            bindlistener();


        });
    </script>
@endsection