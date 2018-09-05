<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 2018/9/3
 * Time: 11:45
 */

namespace app\admin\model;
use think\Model;
use think\Db;

class UserLocalModel extends Model
{
    public function findUser($status=1)
    {
        $result=Db::name('user_local')
            ->where("1=1")
            ->limit(20)
            ->select()
            ->toArray();
        return $result;
    }
    /**
     * 分页查询
     * @param where 查询条件
     * @param field 查询内容
     */
    public function FindUser_Page($where = '', $field = '', $order = '', $limit = '')
    {
        return $result = Db::name('user_local')
            ->where($where)
            ->field($field)
            ->order($order)
            ->paginate($limit);
    }
    public function add($add){
        return $result=Db::name('user_local')->insert($add);
    }
    public function update_data($data,$type){//更新用户信息
        //$data 为原始数据，$type  =1更新密码  =0  不更新密码
        $code=$this->panduan($data);
        if($code==0){
            if($type==1){
                $res=Db::name('user_local')
                    ->where("id",$data['id'])
                    ->update($data);
            }elseif($type==0) {
                $res=Db::name('user_local')
                    ->where("id",$data['id'])
                    ->update($data);
            }
            if($res!=false){
                $code=1;//返回成功代码
            }else{
                $code=-1;//返回失败代码
            }
            return $code;
        }else{
            return $code;
        }
    }
    public function panduan($data){//判断是否有重复的内容
        if(array_key_exists('id',$data)==false){
            $data['id']=1;
        }
        $panduan['tel']=Db::name('user_local')->where([
            'tel'=>['=',$data['tel']],
            'id'=>['<>',$data['id']]
        ])->count();
        $panduan['username']=Db::name('user_local')->where([
            'username'=>['=',$data['username']],
            'id'=>['<>',$data['id']]
        ])->count();
        $panduan['email']=Db::name('user_local')->where([
            'email'=>['=',$data['email']],
            'id'=>['<>',$data['id']]
        ])->count();
        if(($panduan['email']<1)&($panduan['username']<1)&($panduan['tel']<1)){
                $code=0;
        }else{
            if($panduan['tel']>=1){
                $code=2;
            }
            if($panduan['username']>=1){
                $code=3;
            }
            if($panduan['email']>=1){
                $code=4;
            }
        }
        return $code;
    }
}