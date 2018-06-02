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
			$where['name'] = array('like', '%'.$param['name'].'%');
		}

		$model = new ClassificationModel();
		//查询所有一级分类
		$where['pid']    = array('eq', 0);
		$where['status'] = array('eq', 1);
		$field = 'id, name';
		$order = 'id DESC';
		$limit = '10';

		$list = $model ->paginateClass($where, $field, $order, $limit);

		$this ->assign('list', $list);
		// 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);

		return $this ->fetch();
	}

	/**
	* 添加
	*
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

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '添加分类失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '添加分类成功';
		}
		echo json_encode($data);
	}

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

}
?>