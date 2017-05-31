<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class IndexController extends BaseController
{
    //
    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    /**
     * 修改超级管理员密码
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass(Request $request){

        if($request->isMethod('POST')){
            $form = $request->input();
            //验证数据
            //密码在匹配时，通过默认的匹配格式
            //即，密码为passowrd,匹配到的是password_confirmation
            $validator = Validator::make($form,[
                'password_o'=>'required|between:6,15',
                'password'=>'required|between:6,15|confirmed',
                'password_confirmation'=>'required|between:6,15',
            ],[
                'password_o.required'=>'原始密码为必填项',
                'password.required'=>'新密码为必填项',
                'password_confirmation.required'=>'确认密码为必填项',
                'between'=>':attribute 密码必须为6到15位',
                'password.confirmed'=>'新密码和确认密码不一致',
            ],[
                'password_o'=>'原始密码',
                'password'=>'新密码',
                'password_confirmation'=>'确认密码',
            ]);

            if($validator->fails()){
                 return back()->withErrors($validator);
            }
            //判断新密码和原密码是否一致
            if($form['password_o'] == $form['password']){
                return back()->withErrors(['state'=>'新密码不能和原密码一样']);
            }

            //从session中获取账号
            $key = session()->get('admin');
            //从数据库读取数据
            $admin = Admin::find($key);
            if(empty($admin)){
                return back()->withErrors(['password_o'=>'原密码错误']);
            }
            //原密码是否正确
            $password = Crypt::decrypt($admin->password);
            if($password != $form['password_o']){
                return back()->withErrors(['password'=>'原密码错误']);
            }
            //加密
            $pwd = Crypt::encrypt($form['password']);
            //更新
            $admin->password = $pwd;
            $admin->save();
            return back()->withErrors(['state'=>'修改密码成功']);
        }
        return view('admin.pass');
    }
}
