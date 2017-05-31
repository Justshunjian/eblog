<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //指定关联的表
    protected $table = 'admin';
    //指定主键
    protected $primaryKey = 'username';
    //由于主键不是整形，关闭自增长，否则出现在获取时主键会自动转换为整形
    public $incrementing = false;
    //设置时间同步
    public $timestamps = true;
}
