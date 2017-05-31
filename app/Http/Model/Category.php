<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //指定关联表
    protected $table = 'category';
    //指定主键
    protected $primaryKey = 'cate_id';
    //指定时间同步更新
    public $timestamps = true;
    //批量操作字段
//    protected $fillable = [];
    //排除不能操作字段
    protected $guarded = [];

    /**
     * 获取文章分类
     * @return array
     */
    public function tree(){
        $categories = $this->orderBy('cate_order', 'asc')->get();
        //查找子分类
        $data = $this->getTree($categories);

        return $data;
    }

    /**
     * 子分类
     * @param array $data   分类集合
     * @return array
     */
    private function getTree($data){
        $arr = array();
        foreach($data as $k=>$v){
            if($v->cate_pid == 0){
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if($n->cate_pid == $v->cate_id){
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

}
