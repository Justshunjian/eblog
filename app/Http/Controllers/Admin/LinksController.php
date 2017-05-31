<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 14:40
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends BaseController
{
    //GET admin/links
    /**
     * 全部友情链接列表
     */
    public function index(){
        $data = Links::paginate(10);
        return view('admin/links/index')->with('data', $data);
    }

    //POST admin/links/changeOrder
    /**
     * ajax,调整分类排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOrder(Request $request){
        $state = null;
        try{
    //      $input = Input::all();
            $input = $request->input();
            $link = Links::find($input['id']);
            if(empty($link)){
                $state = array(
                    'state'=>false
                );
            }else{
                $link->link_order = $input['order'];
                $result = $link->update();
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

    //GET admin/links/create
    /**
     * 添加友情链接
     */
    public function create(){
        return view('admin.links.create');
    }

    //POST admin/links
    /**
     * 保存添加的友情链接
     */
    public function store(){
        $input = Input::except(['_token']);
        $validator = Validator::make($input,[
            'link_name'=>'required|max:50',
            'link_title'=>'required|max:255',
            'link_url'=>'required|max:255',
            'link_order'=>'required|integer',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'link_name.max'=>':attribute 最大长度为50',
            'link_title.max'=>':attribute 最大长度为255',
            'link_url.max'=>':attribute 最大长度为255',
        ],[
            'link_name'=>'名称',
            'link_title'=>'标题',
            'link_url'=>'链接',
            'link_order'=>'排序',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $article = Links::create($input);
            if($article){
                return redirect('admin/links');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/links/create')->withErrors(['state'=>'添加失败'])->withInput();
        }
    }

    //GET admin/links/{links}/edit
    /**
     * 编辑友情链接
     * @param int $link_id 友情链接ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($link_id){;
        //获取
        $data = Links::find($link_id);

        return view('admin.links.edit',['data'=>$data]);
    }

    //PUT/PATCH   admin/links/{links}
    /**
     * 更新友情链接
     * @param int $link_id 友情链接ID
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($link_id){
        $input = Input::except(['_token','_method']);
        $validator = Validator::make($input,[
            'link_name'=>'required|max:50',
            'link_title'=>'required|max:255',
            'link_url'=>'required|max:255',
            'link_order'=>'required|integer',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'link_name.max'=>':attribute 最大长度为50',
            'link_title.max'=>':attribute 最大长度为255',
            'link_url.max'=>':attribute 最大长度为255',
        ],[
            'link_name'=>'名称',
            'link_title'=>'标题',
            'link_url'=>'链接',
            'link_order'=>'排序',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $link = Links::where('link_id',$link_id)->update($input);
            if($link){
                return redirect('admin/links');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/links/create')->withErrors(['state'=>'更新失败'])->withInput();
        }
    }

    //DELETE admin/links/{links}
    /**
     * 删除友情链接
     * @param int $link_id 友情链接ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($link_id){
        $state = null;
        try{
            //删除
            $link = Links::find($link_id);
            $state = $link->delete();
            $state = array('state'=>$state);
        }catch (\Exception $e){
            $state = array('state'=>false);
        }

        return response()->json($state);
    }
}