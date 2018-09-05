<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 2018/9/3
 * Time: 11:11
 */

namespace app\admin\controller;
use cmf\controller\AdminBaseController;
use app\admin\model\UserLocalModel;
use think\Db;
use think\Route;
use think\Request;
class UserLocalController extends AdminBaseController
{
    public function index()
    {
        $where['status']=array('in','1,3'); //条件
        $field = 'id, username,added_time,sex,tel,email,update_time'; //获取的内容
        $order = 'added_time DESC'; //排序
        $limit = '10'; //每页显示记录数

        $find=new UserLocalModel();
        $res  = $find ->FindUser_Page($where, $field, $order, $limit);
        $page=$res->render();//获取分页
        $res=$res->toArray();

        $data=$res['data'];//提取数据
        foreach($data  as  $key=>$value){//设置性别返回
            if($value["sex"]=="1"){
                $data[$key]["sex"]="男";
            }else if($value["sex"]=="0"){
                $data[$key]["sex"]="女";
            }else{
                $data[$key]["sex"]="未设置";
            }

        }
        $this->assign('page',$page);
        $this ->assign('userinfo', $data);
        return $this ->fetch();
    }
    public function add(){
        return $this->fetch();
    }
    public function add_do(){
        $request=Request::instance();
        $param=$request->param();
        $add['email']=$param['email'];
        $add['tel']=$param['tel'];
        $add['passwd']=md5($param['passwd']);
        $add['username']=$param['username'];

        $add['added_time']=time();
        $add['update_time']=time();
        $add['status']=1;
        $in=new UserLocalModel();
        $code=$in->panduan($add);
        if($code==0){//如果返回的是没有重复  则再增加

            $result=$in->add($add);
            if ($result === false) {
                $data['code'] = 2;
                $data['msg']  = '添加用户失败';
            }else{
                $data['code'] = 1;
                $data['msg']  = '添加用户成功';
            }
            echo json_encode($data);
        }else{
            $data['code'] = 2;
            if($code==-1){
                $data['msg']  = '插入失败';
            }elseif ($code==2){
                $data['msg']  = '手机号重复';
            }elseif ($code==3){
                $data['msg']  = '用户名称重复';
            }elseif ($code==4){
                $data['msg']  = '邮箱重复';
            }else{
                $data['msg']  = '未知原因';
            }
            echo json_encode($data);
        }
    }
    public function edit(){
        if($data_get=$this->request->param())
        {
            $data['id']=$data_get['id'];
            $data_select=Db::name('user_local')->where('id',$data['id'])->find();
            $data['username']=$data_select['username'];
            $data['tel']=$data_select['tel'];
            $data['email']=$data_select['email'];
            $this->assign("data", $data);
            return $this->fetch();
        }

    }
    public function editpost(){
        if($data=$this->request->post())
        {
            $updata=new UserLocalModel();
            $data['update_time']=time();
            if($data['passwd']!=''){
                $data['passwd']=md5($data['passwd']);
                $res=$updata->update_data($data,1);
            }else{
                unset($data['passwd']);
                $res=$updata->update_data($data,0);
            }
            if($res==1){
                $this->success("保存成功",url('UserLocal/index'));
            }elseif ($res==-1){
                $this->error("插入失败！");
            }elseif ($res==2){
                $this->error("手机号重复");
            }elseif ($res==3){
                $this->error("用户名称重复");
            }elseif ($res==4){
                $this->error("邮箱重复");
            }else{
                $this->error("未知原因");
            }

        }
    }

}