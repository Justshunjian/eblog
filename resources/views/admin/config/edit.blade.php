@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">网站配置</a> &raquo; 编辑配置
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
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
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config/'.$data->conf_id)}}" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" class="lg" name="conf_title" value="{{$data->conf_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text"  class="lg" name="conf_name" value="{{$data->conf_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" @if($data->field_type == 'input') checked="checked" @endif/>input　
                            <input type="radio" name="field_type" value="textarea" @if($data->field_type == 'textarea') checked="checked" @endif/>textarea　
                            <input type="radio" name="field_type" value="radio" @if($data->field_type == 'radio') checked="checked" @endif/>radio
                        </td>
                    </tr>
                    <tr id="fd_val">
                        <th>类型值：</th>
                        <td>
                            <input type="text" name="field_value" value="{{$data->field_value}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型只在radio类型下有效,0|关闭,1|开启</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="conf_order" value="{{$data->conf_order}}">
                        </td>
                    </tr>
                    <tr>
                    <th>说明：</th>
                    <td>
                        <textarea name="conf_tips" cols="10" rows="30">{{$data->conf_tips}}</textarea>
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
    <script type="text/javascript">
        $(function () {
            $("input[type='radio']").click(function () {
                var val = this.value;
                if(val == 'radio'){
                    $('#fd_val').show();
                }else{
                    $('#fd_val').hide();
                }
            });
        });

        if($("input[type='radio']:checked").val() == 'radio'){
            $('#fd_val').show();
        }else{
            $('#fd_val').hide();
        }
    </script>
@endsection