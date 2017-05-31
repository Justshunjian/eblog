@extends('layouts.home')
@section('info')
    <title>{{$category->cate_name}} - {{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$category->cate_keywords}}" />
    <meta name="description" content="{{$category->cate_description	}}" />
@endsection
@section('content')
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <article class="blogs">
    <h1 class="t_nav"><span>{{$category->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$category->cate_id)}}" class="n2">{{$category->cate_name}}</a></h1>
    <div class="newblog left">
        @foreach($data as $item)
           <h2>{{$item->art_title}}</h2>
           <p class="dateview"><span>发布时间：{{date('Y-m-d',strtotime($item->updated_at))}}</span><span>作者：{{$item->art_editor}}</span><span>分类：[<a href="{{url('cate/'.$category->cate_id)}}">{{$category->cate_name}}</a>]</span></p>
            <figure><img src="{{url("$item->art_thumb")}}"></figure>
            <ul class="nlist">
              <p>{{$item->art_description}}</p>
              <a title="{{$item->art_title}}" href="{{url('article/'.$item->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
         @endforeach
        <div class="blank"></div>
        <div class="page_nav" style="margin:20px auto; width:600px;">
            {{ $data->links() }}
        </div>
    </div>
    <aside class="right">
        @if($submenu)
       <div class="rnav">
          <ul>
              @foreach($submenu as $k=>$sub)
                <li class="rnav{{$k%4+1}}"><a href="{{url('cate/'.$sub->cate_id)}}" target="_blank">{{$sub->cate_name}}</a></li>
              @endforeach
         </ul>
        </div>
        @endif
        <div class="news">
            @parent
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
@endsection