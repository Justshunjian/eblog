<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 14:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends BaseController
{
    //GET admin/navs
    /**
     * 全部导航列表
     */
    public function index(){
        $data = Navs::orderBy('nav_order','asc')->paginate(10);
        return view('admin/navs/index')->with('data', $data);
    }

    //POST admin/navs/changeOrder
    /**
     * ajax,调整导航排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOrder(Request $request){
        $state = null;
        try{
            $input = Input::all();
            $input = $request->input();
            $nav = Navs::find($input['id']);
            if(empty($nav)){
                $state = array(
                    'state'=>false
                );
            }else{
                $nav->nav_order = $input['order'];
                $result = $nav->update();
                $state = array(
                    'state'=>$result
                );
            }
        }catch (\Exception $e){
            $state = array(
                'state'=>false
            );
        }

        return response()->json($state);
    }

    //GET admin/navs/create
    /**
     * 添加导航
     */
    public function create(){
        return view('admin.navs.create');
    }

    //POST admin/navs
    /**
     * 保存添加的导航
     */
    public function store(){
        $input = Input::except(['_token']);
        $validator = Validator::make($input,[
            'nav_name'=>'required|max:64',
            'nav_alias'=>'required|max:64',
            'nav_url'=>'required|max:255',
            'nav_order'=>'required|integer',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'nav_name.max'=>':attribute 最大长度为64',
            'nav_alias.max'=>':attribute 最大长度为64',
            'nav_url.max'=>':attribute 最大长度为255',
        ],[
            'nav_name'=>'名称',
            'nav_alias'=>'别名',
            'nav_url'=>'链接',
            'nav_order'=>'排序',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $nav = Navs::create($input);
            if($nav){
                return redirect('admin/navs');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/navs/create')->withErrors(['state'=>'添加失败'])->withInput();
        }
    }

    //GET admin/navs/{navs}/edit
    /**
     * 编辑导航
     * @param int $nav_id 导航ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($nav_id){;
        //获取
        $data = Navs::find($nav_id);

        return view('admin.navs.edit',['data'=>$data]);
    }

    //PUT/PATCH   admin/navs/{navs}
    /**
     * 更新导航
     * @param int $nav_id 导航ID
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($nav_id){
        $input = Input::except(['_token','_method']);
        $validator = Validator::make($input,[
            'nav_name'=>'required|max:64',
            'nav_alias'=>'required|max:64',
            'nav_url'=>'required|max:255',
            'nav_order'=>'required|integer',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'nav_name.max'=>':attribute 最大长度为64',
            'nav_alias.max'=>':attribute 最大长度为64',
            'nav_url.max'=>':attribute 最大长度为255',
        ],[
            'nav_name'=>'名称',
            'nav_alias'=>'别名',
            'nav_url'=>'链接',
            'nav_order'=>'排序',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $nav = Navs::where('nav_id',$nav_id)->update($input);
            if($nav){
                return redirect('admin/navs');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/navs/create')->withErrors(['state'=>'更新失败'])->withInput();
        }
    }

    //DELETE admin/navs/{navs}
    /**
     * 删除导航
     * @param int $nav_id 导航ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($nav_id){
        $state = null;
        try{
            //删除
            $nav = Navs::find($nav_id);
            $state = $nav->delete();
            $state = array('state'=>$state);
        }catch (\Exception $e){
            $state = array('state'=>false);
        }

        return response()->json($state);
    }
}