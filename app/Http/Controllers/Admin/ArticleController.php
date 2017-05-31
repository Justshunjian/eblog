<?php
/**
 * ArticleController.php.
 * User: Administrator
 * Date: 2017/5/26 0026
 * Time: 14:14
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends BaseController
{
    //GET admin/article
    /**
     * 文章列表
     */
    public function index(){
        $data = Article::orderBy('art_view','desc')->paginate(10);
        return view('admin.article.index',['data'=>$data]);
    }

    //GET admin/article/create
    /**
     * 添加文章
     */
    public function create(){
        $category = (new Category)->tree();
        return view('admin.article.create',['category'=>$category]);
    }

    /**
     * 文章缩略图上传
     */
    public function upload(){
        $file = Input::file('Filedata');
        if($file->isValid()){
//            $realPath = $file->getRealPath();//临时文件绝对路径
            $ext = $file->getClientOriginalExtension();//上传文件后缀
            //移动
            $newName = date('YmdHis').mt_rand(10,999).'.'.$ext;
            $path = $file->move(base_path().'/public/uploads', $newName);
            return '/uploads/'.$newName;
        }
    }

    //POST admin/article
    /**
     * 保存添加的文章
     */
    public function store(){
        $input = Input::except(['_token']);
        $input['art_view'] = 0;
        $validator = Validator::make($input,[
            'cate_id'=>'required',
            'art_title'=>'required|max:128',
            'art_editor'=>'required|max:64',
            'art_thumb'=>'required|max:255',
            'art_tag'=>'required|max:128',
            'art_description'=>'required|max:255',
            'art_content'=>'required',
        ],[
            'required'=>':attribute 为必填项',
            'art_title.max'=>':attribute 最大长度为128',
            'art_editor.max'=>':attribute 最大长度为64',
            'art_thumb.max'=>':attribute 最大长度为255',
            'art_tag.max'=>':attribute 最大长度为128',
            'art_description.max'=>':attribute 最大长度为255',
        ],[
            'cate_id'=>'分类ID',
            'art_title'=>'文章标题',
            'art_editor'=>'文章编辑者',
            'art_thumb'=>'缩略图',
            'art_tag'=>'关键词',
            'art_description'=>'描述',
            'art_content'=>'文章内容',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $article = Article::create($input);
            if($article){
                return redirect('admin/article');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/article/create')->withErrors(['state'=>'分类添加失败'])->withInput();
        }
    }

    //GET admin/article/{article}/edit
    /**
     * 编辑文章
     * @param int $art_id 文章ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($art_id){
        //读取分类
        $category = (new Category)->tree();
        //获取文章信息
        $data = Article::find($art_id);

        return view('admin.article.edit',['category'=>$category,'data'=>$data]);
    }

    //PUT/PATCH   admin/article/{article}
    /**
     * 更新文章
     * @param int $art_id 文章ID
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($art_id){
        $input = Input::except(['_token','_method']);
        $validator = Validator::make($input,[
            'cate_id'=>'required',
            'art_title'=>'required|max:128',
            'art_editor'=>'required|max:64',
            'art_thumb'=>'required|max:255',
            'art_tag'=>'required|max:128',
            'art_description'=>'required|max:255',
            'art_content'=>'required',
        ],[
            'required'=>':attribute 为必填项',
            'art_title.max'=>':attribute 最大长度为128',
            'art_editor.max'=>':attribute 最大长度为64',
            'art_thumb.max'=>':attribute 最大长度为255',
            'art_tag.max'=>':attribute 最大长度为128',
            'art_description.max'=>':attribute 最大长度为255',
        ],[
            'cate_id'=>'分类ID',
            'art_title'=>'文章标题',
            'art_editor'=>'文章编辑者',
            'art_thumb'=>'缩略图',
            'art_tag'=>'关键词',
            'art_description'=>'描述',
            'art_content'=>'文章内容',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $article = Article::where('art_id',$art_id)->update($input);
            if($article){
                return redirect('admin/article');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/article/create')->withErrors(['state'=>'文章更新失败'])->withInput();
        }
    }

    //DELETE admin/article/{article}
    /**
     * 删除单个文章
     * @param int $art_id  文章ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($art_id){
        $state = null;
        try{
            //删除
            $cate = Article::find($art_id);
            $state = $cate->delete();
            $state = array('state'=>$state);
        }catch (\Exception $e){
            $state = array('state'=>false);
        }

        return response()->json($state);
    }
}