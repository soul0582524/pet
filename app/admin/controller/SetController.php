<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\NavSetModel;
use app\common\model\ClassificationModel;
use think\Db;
use think\Route;
use think\Request;
use think\Cache;

class SetController extends AdminBaseController{


	/**
	* 图片列表
	*/
	public function imgs(){
		$request = Request::instance();
		$param   = $request ->param();


		if (!empty($param['cid']) && $param['cid'] != 0) {
			$where['cid']  = $param['cid'];
		}


		$model = new NavSetModel();

		$where['is_del'] = 2;
		$where['type']   = 2;
		$field = 's.id, s.sort, s.url, FROM_UNIXTIME(add_time) AS add_time, c.name';
		$order = ['sort' => 'DESC','add_time'=>'DESC'];

		$limit = 10;
		

		$result= Db::table('pet_nav_set')
				 ->alias('s')
				 ->join(['pet_classification' => 'c'], 'c.id = s.cid')
				 ->where($where)
				 ->field($field)
				 ->order($order)
				 ->paginate($limit);


		$this ->assign('list', $result);
		// 获取分页显示
        $page = $result->render();
        $this->assign('page', $page);


        $model1 = new ClassificationModel(); //实例化表
		$where1['nav']    = 1;
		$where1['status'] = 1;

		$field1 = 'id, name';

		$res    = $model1 ->selectClass($where1, $field1);

		$this ->assign('res', $res);


		return $this ->fetch();
	}

	/**
	* 添加图片
	* @param file
	*/
	public function addImgs(){
		$request = Request::instance();
		$file    = $request ->file('file');
		$param   = $request ->param();

		if ($param['classi'] == 0) {
			$data['code'] = 2;
			$data['msg']  = '请选择图片所在位置后再上传图片';
			exit(json_encode($data));
		}

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
				$add['cid']      = $param['classi'];
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