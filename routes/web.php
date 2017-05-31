<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function (){

    //前台
    Route::group(['namespace'=>'Home'], function (){
        //首页
        Route::get('/', 'IndexController@index');
        //分类
        Route::get('cate/{cate_id}', 'IndexController@cate');
        //文章
        Route::get('article/{art_id}', 'IndexController@article');
        //关于我
        Route::get('about', 'IndexController@about');
    });

    //后台分组中设置前缀和命名空间
    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        //后台登录路由
        //Route::any('login','Admin\LoginController@login');
        Route::match(['get','post'],'login','LoginController@login');
        //后台登录验证码
        //Route::get('verifyCode',['as'=>'verifyCode','uses'=>'Admin\LoginController@verifyCode']);
        Route::get('verifyCode','LoginController@verifyCode')->name('verifyCode');

        //登录之后的路由
        Route::group(['middleware' => 'admin.login'],function (){
            //注销
            Route::get('logout','LoginController@logout');
            //后台主页
            Route::get('/','IndexController@index');
            Route::get('info','IndexController@info');
            //修改密码
            Route::any('pass','IndexController@pass');

            //资源路由
            Route::resource('category', 'CategoryController');
            //分类列表ajax路由
            Route::post('category/page', 'CategoryController@page');
            //分类ajax路由
            Route::post('category/changeOrder', 'CategoryController@changeOrder');

            //文章资源路由
            Route::resource('article', 'ArticleController');
            //文章缩略图上传
            Route::any('article/upload','ArticleController@upload');

            //友情链接资源路由
            Route::resource('links', 'LinksController');
            //友情链接ajax路由
            Route::post('links/changeOrder', 'LinksController@changeOrder');

            //导航资源路由
            Route::resource('navs', 'NavsController');
            //友情链接ajax路由
            Route::post('navs/changeOrder', 'NavsController@changeOrder');

            //网站配置项资源路由
            Route::resource('config', 'ConfigController');
            //网站配置ajax路由
            Route::post('config/changeOrder', 'ConfigController@changeOrder');
            //配置项写入到配置文件
            Route::post('config/changeContent', 'ConfigController@changeContent');
        });
    });
});
