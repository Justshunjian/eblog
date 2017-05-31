<?php
/**
 * Article.php.
 * User: Administrator
 * Date: 2017/5/26 0026
 * Time: 14:14
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //关联数据表
    protected $table = 'article';
    //设置主键
    protected $primaryKey = 'art_id';
    //设置同步更新时间
    public $timestamps = true;
    //批量操作字段
//    protected $fillable = [];
    //排除不能操作字段
    protected $guarded = [];

    /**
     * 获取文章分类信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(){
        return $this->belongsTo('App\Http\Model\Category', 'cate_id', 'cate_id');
    }
}