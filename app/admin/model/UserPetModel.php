<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 2018/9/6
 * Time: 19:35
 */

namespace app\admin\model;
use think\Model;
use think\Db;

class UserPetModel extends Model
{
    public function FindPet_Page($db='user_pet',$where = '', $field = '', $order = '', $limit = '')
    {
        return $result = Db::name($db)
            ->where($where)
            ->field($field)
            ->order($order)
            ->paginate($limit);
    }

    public function panduan($data){//判断是否有重复的内容
        if(array_key_exists('userid',$data)==false){
            $data['userid']=1;
        }
        $panduan['user']=Db::name('user_local')->where([
            'id'=>['=',$data['userid']]
        ])->count();

        if(($panduan['user']==1)){
            $code=0;
        }else{
            if($panduan['user']<1) {
                $code = 1;//用户不存在
            }
        }
        return $code;
    }
    public function InsertPet($data){
        $code=$this->panduan($data);//判断数据是否重名
        if($code==0){
            $res=Db::name('user_pet')->insert($data);
            return $code;
        }else{
            return $code;
        }
    }
    public function UpdatePet($data){
        $res=Db::name('user_pet')->where('id',$data['id'])->update($data);
        if($res!=false){
            $code=1;
        }else{
            $code=-1;
        }
        return $code;
    }
}