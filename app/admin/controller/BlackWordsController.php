<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\BlackWordsModel;
use think\Db;
use think\Route;
use think\Request;

class BlackWordsController extends AdminBaseController{

	/**
	* 列表页
	*/
	public function index(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();
		
		if (!empty($param)) {
			$words   = $param['words'];
			$where['word']   = array('eq', $words);
		}
		
		//查询所有正在使用的黑词
		$where['status'] = array('eq',1); //条件
	
		$field = 'id, word'; //内容
		$order = 'id DESC'; //排序
		$limit = '10'; //每页显示记录数
		$model = new BlackWordsModel();

		$list  = $model ->paginateWords($where, $field, $order, $limit);

		$this ->assign('list', $list);
		// 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);

		return $this ->fetch();

	}

	/**
	* 黑词屏蔽
	* @param id 黑词id
	*/
	public function cancel(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();
		$id      = $param['id'];

		$model   = new BlackWordsModel(); 
		//设置更新你条件
		$where['id']    = $id;
		$save['status'] = 2;
		//更新
		$result  = $model ->setFieldWords($where, $save);

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '取消黑词失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '取消黑词成功';
		}
		echo json_encode($data);
	}

	/**
	* 添加黑词
	* @param value 黑词
	*/

	public function addWords(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();
		$value   = $param['value'];

		$model   = new BlackWordsModel();

		$add['word'] = $value;
		$result  = $model ->insertWords($add);
		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '添加黑词失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '添加黑词成功';
		}
		echo json_encode($data);

	}
}



?>