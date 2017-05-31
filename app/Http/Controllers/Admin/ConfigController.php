<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 14:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends BaseController
{
    //GET admin/config
    /**
     * 全部配置项列表
     */
    public function index(){
        $data = Config::orderBy('conf_order','asc')->paginate(10);
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'"/>';
                    break;
                case 'textarea':
                    $data[$k]->html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //0|关闭,1|开启
                    $field_value = explode(',', $v->field_value);
                    $str = '';
                    foreach ($field_value as $m=>$n){
                        $r = explode('|', $n);
                        $c = $v->conf_content == $r[0] ? ' checked ': '';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'/>'.$r[1].'　';
                    }
                    $data[$k]->html = $str;
                    break;
            }
        }
        return view('admin/config/index')->with('data', $data);
    }

    //POST admin/config/changeOrder
    /**
     * ajax,调整培训项顺序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOrder(Request $request){
        $state = null;
//      $input = Input::all();
        try{
            $input = $request->input();
            $config = Config::find($input['id']);
            if(empty($config)){
                $state = array(
                    'state'=>false
                );
            }else{
                $config->conf_order = $input['order'];
                $result = $config->update();
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

    /**
     * 修改配置内容
     */
    public function changeContent(){
        $input = Input::all();
        try{
            foreach ($input['conf_id'] as $k => $v){
                Config::where('conf_id',$v)->update(['conf_content'=> $input['conf_content'][$k]]);
            }
        }catch (\Exception $e){
            return back()->withErrors(['state'=>'更新失败'])->withInput();
        }

        $this->putFile();

        return redirect('admin/config')->withErrors(['state'=>'更新成功'])->withInput();
    }

    /**
     * 读取数据库中的配置，并写入到配置文件中
     */
    private function putFile(){
        $config = Config::pluck('conf_content', 'conf_name')->all();
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path, $str);
    }

    //GET admin/config/create
    /**
     * 添加导航
     */
    public function create(){
        return view('admin.config.create');
    }

    //POST admin/config
    /**
     * 保存添加的导航
     */
    public function store(){
        $input = Input::except(['_token']);
        $validator = Validator::make($input,[
            'conf_title'=>'required|max:64',
            'conf_name'=>'required|max:64',
            'field_type'=>'required|max:64',
            'field_value'=>'max:255',
            'conf_order'=>'required|integer',
            'conf_tips'=>'required|max:255',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'conf_title.max'=>':attribute 最大长度为64',
            'conf_name.max'=>':attribute 最大长度为64',
            'field_type.max'=>':attribute 最大长度为64',
            'field_value.max'=>':attribute 最大长度为255',
            'conf_tips.max'=>':attribute 最大长度为255',
        ],[
            'conf_title'=>'标题',
            'conf_name'=>'名称',
            'field_type'=>'类型',
            'field_value'=>'类型值',
            'conf_order'=>'排序',
            'conf_tips'=>'说明',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $nav = Config::create($input);
            if($nav){
                return redirect('admin/config');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/config/create')->withErrors(['state'=>'添加失败'])->withInput();
        }
    }

    //GET admin/config/{config}/edit
    /**
     * 编辑配置项
     * @param int $conf_id 配置项ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($conf_id){;
        //获取
        $data = Config::find($conf_id);

        return view('admin.config.edit',['data'=>$data]);
    }

    //PUT/PATCH   admin/config/{config}
    /**
     * 更新配置项
     * @param int $conf_id 配置项ID
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($conf_id){
        $input = Input::except(['_token','_method']);
        $validator = Validator::make($input,[
            'conf_title'=>'required|max:64',
            'conf_name'=>'required|max:64',
            'field_type'=>'required|max:64',
            'field_value'=>'max:255',
            'conf_order'=>'required|integer',
            'conf_tips'=>'required|max:255',
        ],[
            'required'=>':attribute 为必填项',
            'integer'=>':attribute 为整数',
            'conf_title.max'=>':attribute 最大长度为64',
            'conf_name.max'=>':attribute 最大长度为64',
            'field_type.max'=>':attribute 最大长度为64',
            'conf_tips.max'=>':attribute 最大长度为255',
        ],[
            'conf_title'=>'标题',
            'conf_name'=>'名称',
            'field_type'=>'类型',
            'field_value'=>'类型值',
            'conf_order'=>'排序',
            'conf_tips'=>'说明',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try{
            //保存
            $config = Config::where('conf_id',$conf_id)->update($input);
            if($config){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->withErrors(['state'=>'未知错误'])->withInput();
            }
        }catch (\Exception $e){
            return redirect('admin/config/create')->withErrors(['state'=>'更新失败'])->withInput();
        }
    }

    //DELETE admin/config/{config}
    /**
     * 删除配置项
     * @param int $conf_id 配置项ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($conf_id){
        $state = null;
        try{
            //删除
            $config = Config::find($conf_id);
            $s = $config->delete();
            if($s){
                $this->putFile();
            }
            $state = array('state'=>$s);
        }catch (\Exception $e){
            $state = array('state'=>false);
        }

        return response()->json($state);
    }
}