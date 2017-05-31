<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 13:31
 */
class BaseController extends Controller
{
    public function __construct(){
        //读取导航
        $navs = Navs::orderBy('nav_order','asc')->get();
        //点击量最高的5篇文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布文章，8篇
        $new = Article::orderBy('updated_at','desc')->take(8)->get();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}