<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\ArticleModel;
use app\common\model\BannerModel;
use think\Db;
use think\Route;
use think\Request;

class BannerController extends AdminBaseController{
	/**
	* 首页
	*/
	public function index(){
		$model  = new BannerModel();
		$where['status']   = array('eq', 1);

		$time   = time(); //当前时间
		$where['start_time'] = array('elt', $time);
		$where['end_time']   = array('egt', $time);

		$field  = 'id, position, title, image, url, FROM_UNIXTIME(start_time) AS start_time, FROM_UNIXTIME(end_time) AS end_time, sort';

		$order  = 'sort DESC, id DESC';
		$limit  = 10;

		$result = $model ->paginateBanner($where, $field, $order, $limit);
		// 获取分页显示
        $page = $result->render();
        $this->assign('page', $page);
		$this ->assign('list', $result);

		return $this ->fetch();
	}


	/**
	* 修改排序
	*/
	public function SetSort(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$model   = new BannerModel();
		$where['id'] = $param['id'];
		$save['sort']= intval($param['sort']);

		$result  = $model ->setFieldBanner($where, $save);
		if ($result === false) {
			$this ->error('更新排序失败');
		}else{
			$this ->success('更新排序成功');
		}
	}

	/***
	* s删除
	*/
	public function del(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$model   = new BannerModel();
		$where['id'] = $param['id'];

		$result  = $model ->delBanner($where);
		if ($result === false) {
			$this ->error('删除广告失败');
		}else{
			$this ->success('删除广告成功');
		}

	}

	/**
	* 添加广告
	*/
	public function add(){
		//查询所有发布的文章
		return $this ->fetch();
	}

	/**
	* 搜索文章
	*/
	public function searchArticle(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$title   = $param['title'];

		$new_array = array();
		preg_match_all("/./u", $title, $new_array); //分割字符串
		
		$title   = implode('%', $new_array[0]);
		
		//查询文章
		$article = new ArticleModel();
		$where['title']      = array('like', '%'.$title.'%');
		$where['is_release'] = array('eq', 1);
		$where['is_status']  = array('eq', 1);
		$field   = 'id, title';
		$result  = $article ->selectArticle($where, $field);
		
		$ress    = $result ->toArray(); 
		if (empty($ress)) {
			$this ->error('查询结果为空');
		}else{
			$this ->success('查询成功','', $ress);
		}
	}


	/**
	* 上传图片
	*/
	public function setImage(){
		$request = Request::instance();
		$file    = $request ->file('file');

		if (isset($file)) {
			$info = $file ->move(ROOT_PATH.'upload/banner');

			$name = $info ->getSaveName();//图片名称

			$img  = str_replace("\\","/",$name);  

			$data['imgpath']='upload/banner/'.$img;//组成路径

			$this ->success('上传图片成功','', $data);
		}else{
			$this ->error('上传图片失败');
		}
	}

	/**
	* 删除图片
	* @param url 图片地址
	*/
	public function checkoutImg(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		//删除文件
		unlink($param['url']);
		$this ->success('删除成功');
	}

	/**
	* 添加广告
	* @param title 标题
	* @param type  类型 1广告 2文章
	* @param url   地址
	* @param images 图片
	* @param time  投放时间范围
	* @param sort  排序
	*/
	public function addBanner(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$add['position'] = $param['position'];
		$add['title'] = $param['title'];
		$add['image'] = $param['images'];
		$add['url']   = $param['url'];
		$add['status']= 1;
		$time = explode('~', $param['time']);

		$add['start_time'] = strtotime(substr($time[0], 0,-1));
		$add['end_time']   = strtotime($time[1]);
		$add['sort']       = $param['sort'];


		$model  = new BannerModel();

		$result = $model ->insertBanner($add);
		if ($result === false) {
			$this ->error('添加失败');
		}else{
			$this ->success('添加成功');
		} 
	}
}

?>