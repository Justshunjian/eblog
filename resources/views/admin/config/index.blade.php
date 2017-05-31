@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置项
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color:red">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}" target="main"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}" target="main"><i class="fa fa-recycle" ></i>全部配置项</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <form action="{{url('admin/config/changeContent')}}" method="post">
                {{csrf_field()}}
                <table class="list_tab">
                    <thead>
                    <tr>
                        <th width='5%'>ID</th>
                        <th>排序</th>
                        <th width="10%">标题</th>
                        <th width="10%">名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{$item->conf_id}}</td>
                            <td class='tc'><input type='text' name='ord[]' value="{{$item->conf_order}}"></td>
                            <td>{{$item->conf_title}}</td>
                            <td>{{$item->conf_name}}</td>
                            <td>{!! $item->html !!}</td>
                            <td>
                                <input type='hidden' name='conf_id[]' value="{{$item->conf_id}}">
                                <a href="{{url('admin/config/'.$item->conf_id.'/edit')}}">修改</a>
                                <a href="javascript:void(0)" name="delConf" id="{{$item->conf_id}}">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>
            </form>
        </div>
    </div>

    <div class="page_nav" style="margin:20px auto; width:600px;">
        {{ $data->links() }}
    </div>

    <script>
        //注册事件
        var bindlistener = function () {
            //修改排序
            $(":text[name='ord[]']").unbind("change")
            $(":text[name='ord[]']").change(function () {
                layer.load(2);
                var order = this.value;
                var id = $(this).parent().parent().children().first().html();

                $.post('{{url('admin/config/changeOrder')}}',{'_token':'{{csrf_token()}}','id':id, 'order':order},function (data) {
                    layer.closeAll('loading');
                    if(data.state){
                        layer.msg('更新成功', {
                            icon: 6,
                            time: 3000,//3s自动执行
//                            btn: [''] //按钮
                        }, function(){
                            //暂不做及时刷新页面
                        });
                    }else{
                        layer.msg('更新失败', {
                            icon: 2,
                            time: 3000,//3s自动执行
                        }, function(){
                            //暂不做及时刷新页面
                        });
                    }
                });
            });

            $("a[name='delConf']").click(function () {
                var obj = $(this);
                var id = this.id;
                layer.confirm('您确定删除配置项？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.post('{{url('admin/config/')}}/'+id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                        layer.closeAll('loading');
                        if(data.state){
                            //删除表格数据
                            obj.parents("tr").remove();
                            layer.msg('删除成功', {
                                icon: 6,
                                time: 3000,//3s自动执行
//                            btn: [''] //按钮
                            }, function(){

                            });

                        }else{
                            layer.msg('删除失败', {
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