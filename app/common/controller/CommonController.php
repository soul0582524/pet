<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\common\controller;


use think\Controller;
use app\common\model\ClassificationModel;
use think\Db;
use think\Route;
use think\Request;

class CommonController extends Controller{

	/**
	* 偶去下级分类
	* @param pid  父分类Id
	*/
	public function getNextClass(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$model   = new ClassificationModel();
		$where['pid']   = $param['pid'];
		$where['level'] = 2;
		$where['status']= 1;

		$field   = 'id ,name';
		$result  = $model ->selectClass($where, $field);


		if ($result ->isEmpty()) {
			$data['status'] = 2;
		}else{
			$data['status'] = 1;
			$data['data']   = $result;
		}
		echo json_encode($data);
	}



}
?>