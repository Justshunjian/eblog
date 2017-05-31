<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    //登录
    public function login(Request $request)
    {
        if($request->isMethod('POST')){
            $form = $request->input();
            //数据验证
            $validator = Validator::make($form,[
                'username'=> 'required|between:4,20',
                'password'=>'required|min:6|max:15',
                'code'=>'required|between:4,20'
            ],[
                'username.required'=>'账号为必填项',
                'username.between'=>'账号必须在6-20位之间',
                'password.required'=>'密码为必填项',
                'password.min'=>'密码长度太短',
                'password.max' => '密码长度过长',
                'code.required' => '验证为必填项',
                'code.between'=>'验证码必须为5位',
            ],[
                'username'=> '登录名',
                'password'=>'密码',
                'code'=>'验证码'
            ]);

            $validator->after(function ($validator)use($form) {
                if( strlen(strtoupper($form['code'])) == 5
                    && strtoupper(session()->get('verifyCode')) != strtoupper($form['code'])){
                    $validator->errors()->add('code', '验证码输入错误');
                }
            });

            //验证
            if($validator->fails()){
//                $message = $validator->messages();
//                dd($message);
                return redirect('admin/login')->withErrors($validator)->withInput();
            }
//            $this->validate($request, [
//                'username'=> 'required|min:2|max:20',
//                'password'=>'required|min:6|max:15',
//                'code'=>'required'
//            ],[
//                'required'=>':attribute 为必填项',
//                'min'=>':attribute 长度太短',
//                'max' => ':attribute 长度过长'
//            ],[
//                'username'=> '登录名',
//                'password'=>'密码',
//                'code'=>'验证码'
//            ]);

//            //校验验证码
//            if(strtoupper(session()->get('verifyCode')) != strtoupper($form['code'])){
//                return redirect('admin/login')->withErrors(['code'=>'验证码输入错误'])->withInput();
//            }

//        die(Crypt::encrypt('123456'));
//        die(Crypt::decrypt());

            //校验登录
            $admin = Admin::find($form['username']);
            if(empty($admin)){
                return redirect('admin/login')->withErrors(['username'=>'用户名或者密码错误'])->withInput();
            }

            //加密
            //Crypt::encrypt($form['password']);
            //解密
            $pwd = Crypt::decrypt($admin->password);
            if($pwd != $form['password']){
                return back()->withErrors(['username'=>'密码错误'])->withInput();
            }

            //存储到session
            session()->put('admin',$admin->username);
            session(['username'=>$admin->nickname]);
            return redirect('admin');
        }
        return view('admin.login');
    }

    /**
     * 注销
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){
//        session()->forget('username');
        session(['username'=>null]);
        session(['admin'=>null]);
        return redirect('admin/login');
    }

    public function verifyCode()
    {
        $builder = new CaptchaBuilder();
        $builder->build();
        $content = $builder->get();
        //存储到session
        session()->put('verifyCode',$builder->getPhrase());
        return response($content)->header('Content-Type', "image/jpeg");
    }
}
