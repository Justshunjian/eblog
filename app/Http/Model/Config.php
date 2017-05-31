<?php
/**
 * Config.php.
 * User: Administrator
 * Date: 2017/5/29 0026
 * Time: 14:14
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //关联数据表
    protected $table = 'config';
    //设置主键
    protected $primaryKey = 'conf_id';
    //设置同步更新时间
    public $timestamps = true;
    //批量操作字段
//    protected $fillable = [];
    //排除不能操作字段
    protected $guarded = [];
}