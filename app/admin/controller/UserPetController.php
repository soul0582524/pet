<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 2018/9/6
 * Time: 19:33
 */

namespace app\admin\controller;
use cmf\controller\AdminBaseController;
use app\admin\model\UserPetModel;
use think\Db;
use think\Route;
use think\Request;

class UserPetController extends AdminBaseController
{
    public function index()
    {
        $db='user_pet';
        $where['status']=array('in','1,3'); //条件
        $field = 'id,petname,userid,added_time,type,sex,photo,birthday,update_time,intro'; //获取的内容
        $order = 'added_time DESC'; //排序
        $limit = '10'; //每页显示记录数

        $find=new UserPetModel();
        $res  = $find ->FindPet_Page($db,$where, $field, $order, $limit);

        $page=$res->render();//获取分页
        $res=$res->toArray();//提取数据
        $data=$res['data'];//提取数据
        $db_user='user_local';
        $field_user = 'username'; //获取的内容
        $order_user = 'added_time DESC'; //排序
        $limit_user = '1';

        foreach($data  as  $key=>$value){//设置性别返回，同时设置返回设置username
            $where_user['id']=array('in',$value['userid']); //条件,因为是二维数组
            $res_user  = $find ->FindPet_Page($db_user,$where_user, $field_user, $order_user, $limit_user);
            $userdata=$res_user->toArray();
            $userdata=$userdata['data'];
            $data[$key]["username"]=$userdata[0]['username'];//获取用户姓名
            if($value["sex"]=="1"){
                $data[$key]["sex"]="男";
            }else if($value["sex"]=="0"){
                $data[$key]["sex"]="女";
            }else{
                $data[$key]["sex"]="未设置";
            }
            if($value["type"]=="1"){
                $data[$key]["type"]="猫";
            }else if($value["type"]=="2"){
                $data[$key]["type"] = "狗";
            }
        }
        $this->assign('page',$page);
        $this ->assign('userinfo', $data);
        return $this ->fetch();

    }
    public function add(){
        $db='user_local';
        $where['status']=array('in','1,3'); //条件
        $field = 'id,username,status'; //获取的内容
        $order = 'added_time DESC'; //排序
        $limit = ''; //每页显示记录数
        $find=new UserPetModel();
        $res_user  = $find ->FindPet_Page($db,$where, $field, $order, $limit);

        return $this->fetch();
    }
    public function add_do(){
        $request=Request::instance();
        $param=$request->param();
        $user_id=$param['id'];
        $user_data=new UserPetModel();
        $where['id']=array('eq',$user_id);
        $db_user='user_local';
        $field_user = 'id,username'; //获取的内容
        $order_user = 'added_time DESC'; //排序
        $limit_user = '1';
        $data=$user_data->FindPet_Page($db_user,$where,$field_user,$order_user,$limit_user);
        $data=$data->toArray();
        $data=$data['data'][0];
        //dump($data);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function add_do_insert(){
        $request=Request::instance();
        $param=$request->param();
        $birthday=strtotime($param['birthday']);
        $data=[
            'userid'=>$param['userid'],
            'petname'=>$param['petname'],
            'type'=>$param['type'],
            'sex'=>$param['sex'],
            'intro'=>$param['intro'],
            'birthday'=>$birthday,
            'status'=>1,
            'added_time'=>time(),
            'update_time'=>time()
        ];
        $res=new UserPetModel();
        $code=$res->InsertPet($data);

        if($code==0){
            $data['code'] = 1;
            $data['msg']  = '添加宠物成功';
        }else{
            $data['code'] = 2;
            if($code==1) {
                $data['msg'] = '用户信息不正确';
            }
        }
        echo json_encode($data);
    }
    public function edit(){
        $request=Request::instance();
        $param=$request->param();
        $id=$param['id'];
        $user_data=new UserPetModel();
        $where['id']=array('eq',$id);
        $db_user='user_pet';
        $field_user = 'id,userid,petname,type,sex,intro,birthday'; //获取的内容
        $order_user = 'added_time DESC'; //排序
        $limit_user = '1';
        $data=$user_data->FindPet_Page($db_user,$where,$field_user,$order_user,$limit_user);
        $data=$data->toArray();
        $data=$data['data'][0];
        //dump($data);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function editpost(){
        $request=Request::instance();
        $param=$request->param();
        $data=$param;
        $data['birthday']=strtotime($param['birthday']);
        $data['update_time']=time();
        $db=new UserPetModel();
        $res=$db->UpdatePet($data);
        if($res==1){
            $this->success("保存成功",url('UserPet/index'));
        }elseif ($res==-1) {
            $this->error("插入失败！");
        }
    }
}