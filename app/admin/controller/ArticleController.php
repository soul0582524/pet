<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\ArticleModel;
use app\common\model\ClassificationModel;
use app\common\model\NavArticleModel;
use think\Db;
use think\Route;
use think\Request;

class ArticleController extends AdminBaseController{


	public function index(){
		
	}

	/**
	* 文章列表
	*
	*/
	public function lists(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where   = 'a.classi = c.id';
		$where  .= ' AND a.is_status = 1';

		if (!empty($param['classi']) && $param['classi'] != 0) {
			$where .= ' AND a.classi = '.$param['classi'];
		}

		if (!empty($param['class2']) && $param['class2'] != 0) {
			$where .= ' AND a.classii = '.$param['class2'];
		}
		if (!empty($param['title'])) {
			$title = trim($param['title']);
			if (!empty($title)) {
				$where .= " AND a.title like '%".$title."%' ";
			}
		}
		

		$list = Db::table(['pet_article' => 'a', 'pet_classification' => 'c']) 
				 
				    ->where($where)
				    ->field('a.id, a.title, a.source, a.abstract, FROM_UNIXTIME(a.add_time) AS add_time, FROM_UNIXTIME(a.release_time) AS release_time, c.name, a.is_release')
				    ->order('a.id DESC')
				    ->paginate('10');
		$this ->assign('list', $list);
		// 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);


        $classification = new ClassificationModel();
        unset($where);
		//查询所有一级分类
		$where['level']  = 1;
		$where['status'] = 1;
		$field = 'id, name';

		$classi = $classification ->selectClass($where, $field);
		
		$this ->assign('classi', $classi);

		return $this ->fetch();
	}

	/**
	* 文章添加页面

	*/
	public function add(){

		$classification = new ClassificationModel();
		//查询所有一级分类
		$where['level']  = 1;
		$where['status'] = 1;
		$field = 'id, name';

		$classi = $classification ->selectClass($where, $field);
		
		$this ->assign('classi', $classi);
		return $this ->fetch();
	}


	/**
	* 文章添加
	*/
	public function addArticle(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$title   = trim($param['title']);//去除空格
		$content = html_entity_decode($param['content']);//html字符转义
		
		$article = new ArticleModel();


		//设置添加内容
		$add['classi'] = $param['classi']; //一级分类id
		if (!empty($param['class2'])) {
			$add['classii'] = $param['class2']; //二级分类id
		}

		$add['title']  = $title; //标题
		if (!empty($param['source'])) { //判断来源是否为空
			$add['source']   = $param['source'];
		}
		if (!empty($param['abstract'])) { //判断是否有摘要
			$add['abstract'] = $param['abstract'];
		}
		$add['content']= $content; //内容
		$add['is_release']   = 2; //未发布
		$add['is_status']    = 1; //存在
		$add['add_time']     = time(); //添加时间


		$result = $article ->insertArticle($add);

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '添加文章失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '添加文章成功';
		}
		echo json_encode($data);
	}

	/**
	* 详情
	* @param id 文章id
	*/
	public function detail(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$model   = new ArticleModel();

		//查询文章详情
		$where['id'] = $param['id'];
		$field   = 'id, classi, classii, title, source, abstract, content';
		$result  = $model ->findArticle($where, $field);
		//查询一级分类

		$model1  = new ClassificationModel();

		$where1  = '(level = 1  AND status = 1)  OR (pid = '.$result['classi'].' AND status = 1)';
		$field1  = 'id, name, level';

		$result1 = $model1 ->selectClass($where1, $field1);
		
		$classi  = array();
		$classii = array();
		$i  = 0;
		$ii = 0; 
		foreach ($result1 as $key => $value) {
			if ($value['level'] == 1) {
				//一级分类
				$classi[$i] = $value;
				$i++;
			}else if ($value['level'] == 2) {
				//二级分类
				$classii[$ii] = $value;
				$ii++;
			}
		}

		$this ->assign('detail', $result);
		$this ->assign('classi', $classi);
		$this ->assign('classii', $classii);
		return $this ->fetch();
	}


	/**
	* 修改文章
	* 
	*/
	public function changeDetail(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where['id'] = $param['id'];

		if (!empty($param['classi'])) {
			$save['classi']  = $param['classi'];
		}
		if (!empty($param['class2'])) {
			$save['classii'] = $param['class2'];
		}

		$save['title']   = trim($param['title']);//去除空格
		$save['content'] = html_entity_decode($param['content']);//html字符转义
		$save['source']  = $param['source'];//文章来源
		$save['abstract']= $param['abstract'];//摘要

		$article = new ArticleModel();

		$result  = $article ->setFieldArticle($where, $save);  

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '修改失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '修改成功';
		}
		echo json_encode($data);
	}

	/**
    * 发布和取消发布
    * @param id   文章id
    * @param type type 1发布  2取消
    */
	public function release(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where['id']        = $param['id'];
		$save['is_release'] = $param['type'];
		if ($param['type'] == 1) {
			$save['release_time'] = time();
		}

		$article = new ArticleModel();

		$result  = $article ->setFieldArticle($where, $save);  

		if ($result === false) {
			$data['code'] = 2;
			if ($param['type'] == 1) {
				$data['msg']  = '发布失败';
			}else{
				$data['msg']  = '取消发布失败';
			}
			
		}else{
			$data['code'] = 1;
			if ($param['type'] == 1) {
				$data['msg']  = '发布成功';
			}else{
				$data['msg']  = '取消发布成功';
			}
		}
		echo json_encode($data);
	}


	/**
	* 删除文章
	* @param id 文章Id
	*/
	public function del(){
		//获取参数
		$request = Request::instance();
		$param   = $request ->param();

		$where['id']       = $param['id'];
		$save['is_status'] = 2;

		$article = new ArticleModel();

		$result  = $article ->setFieldArticle($where, $save);  

		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '删除失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '删除成功';
		}
		echo json_encode($data);
	}


	public function nav(){
		//获取参数
		$request    = Request::instance();
		$param      = $request ->param();

		$add['article_id']    = $param['id'];
		$add['article_title'] = $param['title'];
		$add['add_time']      = time();

		$nav_article = new NavArticleModel();

		$result      = $nav_article ->insertArticle($add);


		if ($result === false) {
			$data['code'] = 2;
			$data['msg']  = '设置失败';
		}else{
			$data['code'] = 1;
			$data['msg']  = '设置成功';
		}
		echo json_encode($data);
	}
}
?>