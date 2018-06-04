<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\common\model\ArticleModel;
use app\common\model\ClassificationModel;
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
		$list = Db::table(['pet_article' => 'a', 'pet_classification' => 'c']) 
				    ->where('a.classi = c.id')
				    ->where('a.is_status = 1')
				    ->field('a.id, a.title, a.source, a.abstract, FROM_UNIXTIME(a.add_time) AS add_time, a.release_time, c.name')
				    ->order('a.id DESC')
				    ->paginate('10');
		foreach ($list as $key => $value) {
			if (!empty($list[$key]['release_time'])) {
				$list[$key]['release_time'] = date('Y-m-d H:i:s', $value['release_time']);
			}

			if (mb_strlen($value['abstract']) > 10) {
				$abstract = mb_substr($value['abstract'], 0,10);
				$list[$key]['abstract'] = $abstract.'……';
			}
			
		}
		$this ->assign('list', $list);
		// 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);
		return $this ->fetch();
	}

	/**
	* 文章添加页面

	*/
	public function add(){

		$classification = new ClassificationModel();
		//查询所有一级分类
		$where['pid']    = 0;
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
		$add['classi'] = $param['classi']; //分类id
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
}
?>