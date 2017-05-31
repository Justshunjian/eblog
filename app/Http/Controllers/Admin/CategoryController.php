<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    //GET admin/category
    /**
     * 全部分类列表
     */
    public function index(){
        return view('admin.category.index');
    }

    //POST admin/category/page
    public function page(){
        $jsonObj = null;
        try{
            $input = Input::all();
            $curr = $input['curr']-1>0 ? $input['curr']-1 : 0;
            $pageSize = $input['pageSize'] > 10 ? 10 : $input['pageSize'];
            //查询数据
            $data = (new Category())->tree();
            $pages = ceil(count($data)/$pageSize);
            //切割
            $data1 = array_slice($data, $curr*$pageSize, $pageSize);
            //封装JSON
            $jsonObj = array(
                'state'=>true,
                'pages'=>$pages,
                'items'=>$data1
            );
        }catch (\Exception $e){
            $jsonObj = array(
                'state'=>false
            );
        }
        return response()->json($jsonObj);
    }

    //POST admin/category/changeOrder
    /**
     *ajax,调整分类排序
     */
    public function changeOrder(Request $request){
        $state = null;
        try{
            $input = Input::all();
            $input = $request->input();
            $cate = Category::find($input['id']);
            if(empty($cate)){
                $state = array(
                    'state'=>false
                );
            }else{
                $cate->cate_order = $input['order'];
                $result = $cate->update();
                $state = array(
                    'state'=>$result
                );
            }
        } catch (\Exception $e){
            $state = array(
                'state'=>false
            );
        }

        return response()->json($state);
    }

    //GET admin/category/create
    /**
     * 添加分类
     */
    public function create(){
        //读取顶级分类
        $data = Category::where('cate_pid',0)->get();
        //控制器传参给视图的几种方式
//        return view('admin.category.create',['data'=>$data]);
//        return view('admin.category.create',compact('data'));
        return view('admin.category.create')->with('data',$data);
    }

    /**
     * 新增分类
     */
    //POST admin/category
    public function store(){
        $input = Input::except(['_token']);
        //验证
        $validator = Validator::make($input, [
            'cate_pid'=>'required',
            'cate_name'=>'required|between:2,50',
            'cate_title'=>'required|between:2,255',
            'cate_keywords'=>'required',
            'cate_description'=>'required',
            'cate_order'=>'required|integer',
        ],[
            'required'=>' :attribute 为必填项',
            'integer'=>' :attribute 为整数',
            'cate_name.between'=>'分类名长度必须在2-50之间',
            'cate_title.between'=>'分类标题长度必须在2-255之间',
        ],[
            'cate_pid'=>'父级分类',
            'cate_name'=>'分类名',
            'cate_title'=>'分类标题',
            'cate_keywords'=>'关键词',
            'cate_description'=>'描述',
            'cate_order'=>'排序',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $cate = Category::create($input);
            if($cate){
                return redirect('admin/category');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return back()->withErrors(['state'=>'分类添加失败'])->withInput();
        }
    }

    //GET admin/category/{category}/edit
    /**
     * 编辑分类
     * @param int $cate_id  分类ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($cate_id){
        //读取顶级分类
        $category = Category::where('cate_pid',0)->get();
        //获取分类信息
        $data = Category::find($cate_id);

        return view('admin.category.edit',['category'=>$category,'data'=>$data]);
    }

    //PUT/PATCH admin/category/{category}
    /**
     * 更新分类
     * @param int $cate_id  分类ID
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($cate_id){
        $input = Input::except(['_token','_method']);
        //验证
        $validator = Validator::make($input, [
            'cate_pid'=>'required',
            'cate_name'=>'required|between:2,50',
            'cate_title'=>'required|between:2,255',
            'cate_keywords'=>'required',
            'cate_description'=>'required',
            'cate_order'=>'required|integer',
        ],[
            'required'=>' :attribute 为必填项',
            'integer'=>' :attribute 为整数',
            'cate_name.between'=>'分类名长度必须在2-50之间',
            'cate_title.between'=>'分类标题长度必须在2-255之间',
        ],[
            'cate_pid'=>'父级分类',
            'cate_name'=>'分类名',
            'cate_title'=>'分类标题',
            'cate_keywords'=>'关键词',
            'cate_description'=>'描述',
            'cate_order'=>'排序',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //更新
            $cate = Category::where('cate_id',$cate_id)->update($input);
            if($cate){
                return redirect('admin/category');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return back()->withErrors(['state'=>'分类添加失败'])->withInput();
        }
    }

    //GET admin/category/{category}
    /**
     * 显示单个分类信息
     */
    public function show(){

    }

    //DELETE admin/category/{category}
    /**
     * 删除单个分类
     * @param int $cate_id  分类ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($cate_id){
        $state = null;
        try{
            //更新
            $cate = Category::find($cate_id);
            $state = $cate->delete();
            $state = array('state'=>$state);
        }catch (\Exception $e){
            $state = array('state'=>false);
        }

        return response()->json($state);
    }


}
