<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 13:32
 */

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends BaseController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //点击量最高的6篇文章
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //图文列表，5篇
        $data = Article::orderBy('updated_at','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',[
            'pics'=>$pics,
            'data'=>$data,
            'links'=>$links,
        ]);
    }

    /**
     * 分类信息列表
     * @param $cate_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cate($cate_id){
        //获取分类信息
        $category = Category::find($cate_id);
        //获取子分类信息
        $submenu = Category::where('cate_pid', $cate_id)->get();
        //图文列表，4篇
        $data = Article::where('cate_id',$cate_id)->orderBy('updated_at','desc')->paginate(2);
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');
        return view('home.list',[
            'category'=>$category,
            'data'=>$data,
            'submenu'=>$submenu
        ]);
    }

    /**
     * 显示文章
     * @param int $art_id   文章ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article($art_id){
        $article = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

        $field['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $field['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','desc')->first();

        $data = Article::where('cate_id',$article->cate_id)->orderBy('art_id','desc')->take(6)->get();

        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');

        return view('home.new',[
            'article'=>$article,
            'field'=>$field,
            'data'=>$data
        ]);
    }

    /**
     * 关于我页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about(){
        return view('home.about');
    }
}