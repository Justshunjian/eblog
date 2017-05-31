@extends('layouts.home')
@section('info')
  <title>{{$article->art_title}} - {{Config::get('web.web_title')}}</title>
  <meta name="keywords" content="{{$article->art_tag}}" />
  <meta name="description" content="{{$article->art_description}}" />
@endsection
@section('content')
  <article class="blogs">
    <h1 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="{{url("cate/".$article->cate_id)}}">{{$article->cate_name}}</a></span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url("cate/".$article->cate_id)}}" class="n2">{{$article->cate_name}}</a></h1>
    <div class="index_about">
      <h2 class="c_titile">{{$article->art_title}}</h2>
      <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',strtotime($article->updated_at))}}</span><span>编辑：{{$article->art_editor}}</span><span>查看次数：{{$article->art_view}}</span></p>
      <ul class="infos">
        {!! $article->art_content !!}
      </ul>
      <div class="keybq">
      <p><span>关键字词</span>：{{$article->art_tag}}</p>

      </div>
      <div class="ad"> </div>
      <div class="nextinfo">
        @if($field['pre'])
          <p>上一篇：<a href="{{url('article/'.$field['pre']->art_id)}}">{{$field['pre']->art_title}}</a>
        @else
          <p>上一篇：没有上一篇</p>
        @endif
        @if($field['next'])
          <p>下一篇：<a href="{{url('article/'.$field['next']->art_id)}}">{{$field['next']->art_title}}</a></p>
        @else
          <p>下一篇：没有下一篇</p>
        @endif
      </div>
      <div class="otherlink">
        <h2>相关文章</h2>
        <ul>
          @foreach($data as $item)
          <li><a href="{{url('article/'.$item->art_id)}}" title="{{$item->art_title}}">{{$item->art_title}}</a></li>
          @endforeach
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
        @parent
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
@endsection