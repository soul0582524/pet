<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\NavSetModel;
use think\Db;
use think\Route;
use think\Request;

class SetController extends AdminBaseController{


	/**
	* 图片列表
	*/
	public function imgs(){
		$model = new NavSetModel();

		$where['is_del'] = 2;
		$where['type']   = 2;
		$field = 'id, sort, url, FROM_UNIXTIME(add_time) AS add_time';
		$order = ['sort' => 'DESC','add_time'=>'DESC'];

		$limit = 3;
		$result= $model ->paginateSet($where, $field, $order, $limit);

		$this ->assign('list', $result);
		// 获取分页显示
        $page = $result->render();
        $this->assign('page', $page);
		return $this ->fetch();
	}

	/**
	* 添加图片
	* @param file
	*/
	public function addImgs(){
		$request = Request::instance();
		$file    = $request ->file('file');

		if (isset($file)) {
	
			$info = $file ->move(ROOT_PATH.'upload/nav_img');
			if ($info) {
				$name = $info ->getSaveName();

				$img  = str_replace("\\","/",$name);  

				$imgpath='upload/nav_img/'.$img;

				$add['url']      = $imgpath;
				$add['add_time'] = time();
				$add['type']     = 2;
				$add['sort']     = 0;

				$model = new NavSetModel();

				$result = $model ->insertSet($add);

				if ($result === false) {
					$data['code'] = 2;
					$data['msg']  = '上传图片失败';
					exit(json_encode($data));
				}else{
					$data['code'] = 1;
					$data['msg']  = '上传图片成功';
					exit(json_encode($data));
				}

			}else{
				$data['code'] = 2;
				$data['msg']  = '上传图片失败';
				exit(json_encode($data));
			}
		}else{
			$data['code'] = 2;
			$data['msg']  = '上传图片失败';
			exit(json_encode($data));
		}
	}

	/**
	* 删除
	*
	*/
	public function del(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();


		$where['id']   = $param['id'];
		$model   = new NavSetModel();
		$save['is_del']= 1;

		$result  = $model ->setFieldSet($where, $save);
		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '删除失败';
			exit(json_encode($data));
		}else{
			//删除文件
			unlink($param['url']);

			$data['code'] = 1;
			$data['msg']  = '删除成功';
			exit(json_encode($data));
		}

	}

	/**
	* 修改排序
	*/
	public function changeSort(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where['id']   = $param['id'];
		$model   = new NavSetModel();
		$save['sort']  = (int)$param['value'];

		$result  = $model ->setFieldSet($where, $save);
		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '修改失败';
			exit(json_encode($data));
		}else{
			$data['code'] = 1;
			$data['msg']  = '修改成功';
			exit(json_encode($data));
		}
	}

	/**
	* 视频
	*/
	public function video(){
		$model = new NavSetModel();

		$where['is_del'] = 2;
		$where['type']   = 1;
		$field = 'id,  url, FROM_UNIXTIME(add_time) AS add_time';
		$order = 'id DESC';

		$limit = 10;
		$result= $model ->paginateSet($where, $field, $order, $limit);

		$this ->assign('list', $result);
		// 获取分页显示
        $page = $result->render();
        $this->assign('page', $page);
		
		return $this ->fetch();
	}

	/**
	* 添加视频
	*/
	public function addVideo(){
		$request = Request::instance();
		$file    = $request ->file('file');

		if (isset($file)) {
	
			$info = $file ->move(ROOT_PATH.'upload/nav_video');
			if ($info) {
				$name = $info ->getSaveName();

				$img  = str_replace("\\","/",$name);  

				$imgpath='upload/nav_video/'.$img;

				$add['url']      = $imgpath;
				$add['add_time'] = time();
				$add['type']     = 1;
				$add['sort']     = 0;

				$model = new NavSetModel();

				$result = $model ->insertSet($add);

				if ($result === false) {
					$data['code'] = 2;
					$data['msg']  = '上传视频失败';
					exit(json_encode($data));
				}else{
					$data['code'] = 1;
					$data['msg']  = '上传视频成功';
					exit(json_encode($data));
				}

			}else{
				$data['code'] = 2;
				$data['msg']  = '上传视频失败';
				exit(json_encode($data));
			}
		}else{
			$data['code'] = 2;
			$data['msg']  = '上传视频失败';
			exit(json_encode($data));
		}
	}
}
?>