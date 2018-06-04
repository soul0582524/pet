<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\ClassificationModel;
use think\Db;
use think\Route;
use think\Request;

class ClassificationController extends AdminBaseController{

	/**
	* 列表页
	*/
	public function index(){
		$request = Request::instance();
		$param   = $request ->param();

		if (!empty($param['name'])) {
			$where['c.name'] = array('like', '%'.$param['name'].'%');
		}

		if (!empty($param['level']) && $param['level'] != 0) {
			$where['c.level'] = array('eq', $param['level']);
		}

		$where['c.status'] = array('eq', 1);

		$list = Db::table('pet_classification')
		        ->alias('c')
				->join(['pet_classification' => 'p'], 'c.pid = p.id', 'left')
				->where($where)
				->field('c.id, c.name, c.level, p.name as pname')
				->order('c.pid ASC, c.id ASC')
				->paginate('10');

		$this ->assign('list', $list);
		// 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);

		return $this ->fetch();
	}

	/**
	* 添加分类
	* @param name 分类名称
	* @param pid  父分类
	*/
	public function add(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$model = new ClassificationModel();

		$add['name']  = $param['name']; //分类名称
		$add['pid']   = $param['pid']; //父分类

		if ($param['pid'] == 0) {
			$add['level'] = 1;
		}else{
			$add['level'] = 2;
		}

		$add['status']= 1;//状态

		$result = $model ->insertClass($add);

		$id = $model ->getLastInsID();


		if ($add['level'] == 1) {
			$where['id'] = $id;
			$save['pid'] = $id;

			$result = $model ->setFieldClass($where, $save);
		}
		
		if ($id === false) {
			$data['code'] = 2;
			$data['msg']  = '添加分类失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '添加分类成功';
		}
		echo json_encode($data);
	}


	/**
	* 添加分类页面
	*/
	public function addClass(){

		$model = new ClassificationModel();
		//查询所有一级分类
		$where['pid']    = array('eq', 0);
		$where['status'] = array('eq', 1);
		$field = 'id, name';


		$list = $model ->selectClass($where, $field);

		$this ->assign('list', $list);

		return $this ->fetch();
	}

	/**
	* 删除分类
	* @param id 产出分类bangey 
	*/
	public function cancel(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where['id'] = $param['id'];  //获取id
		$model   = new ClassificationModel(); //实例化表
		$save['status'] = 2; //更新内容

		$result  = $model ->setFieldClass($where, $save);

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '删除分类失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '删除分类成功';
		}
		echo json_encode($data);
	}
}
?>