<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use app\common\model\NavSetModel;
use app\common\model\ArticleModel;
use app\common\model\ClassificationModel;
use app\common\model\NavArticleModel;
use think\Db;
use think\Route;
use think\Request;
use think\Cache;

class IndexController extends HomeBaseController
{
	/**
	* 引导页
	*/
    public function index(){
    	//查询背景视频
    	$where['type']   = 1;
    	$where['is_del'] = 2;
    	$field  = 'url';
    	$order  = 'id DESC';

    	$video  =  Db::table('pet_nav_set') ->where($where) ->field($field) ->order($order) ->find(); 
    	$this ->assign('video', $video['url']);

    	//获得所有首页展示分类
    	$classi = new ClassificationModel(); //实例化表
		$where1['nav']    = 1;
		$where1['status'] = 1;

		$field1 = 'id, name';

		$result1= $classi ->selectClass($where1, $field1);
		$sum    = count($result1);
		//计算展示宽度
		$number = round(100/$sum);

		$this ->assign('number', $number);
		$this ->assign('classi', $result1);

		//获得第一个分类下的三篇推荐文章
		$where2 = 'n.article_id = a.id &&';
		$where2.= 'a.classi     = '.$result1[0]['id']. ' &&';
		$where2.= 'a.is_release = 1 &&';
		$where2.= 'a.is_status  = 1';
		$list = Db::table(['pet_nav_article' => 'n', 'pet_article' => 'a']) 
				->where($where2)
				->field('a.id, a.title, a.abstract')
				->order('n.sort DESC, a.id DESC')
				->limit(0,3)
				->select();
		$this ->assign('list', $list);

		//获得该分类下的图片
		$where3['cid']  = $result1[0]['id'];
		$where3['type'] = 2;
		$where3['is_del'] = 2;
		$field3  = 'url';
		$order3  = 'sort DESC, id DESC';
		$limit3  = '0,3';
		$result3 = Db::table('pet_nav_set')
				   ->where($where3)
				   ->field($field3)
				   ->order($order3)
				   ->limit($limit3)
				   ->select();
		$this ->assign('image', $result3);

		//查询叫猫窝的
		$where4['name'] = '猫窝';
		$field4         = 'id';
		$result4 = $classi ->findClass($where4, $field4);

		$url = url('Index/indexs', array('id' => $result4['id'], 'name' => '猫窝'));

		$this ->assign('caturl', $url);

		//查询叫猫窝的
		$where5['name'] = '狗窝';
		$field5         = 'id';
		$result4 = $classi ->findClass($where5, $field5);
		$url = url('Index/indexs', array('id' => $result4['id'], 'name' => '狗窝'));
		$this ->assign('dogurl', $url);

        return $this->fetch();
    }


    /**
    * 查询推荐文章
    * @param id  分类id
    */
    public function getNavArticle(){
    	//获取参数
		$request = Request::instance();
		$param   = $request ->param();
		//分类id
		$id      = $param['id'];

		$lists   = Cache::get($id);
		if (!$lists) {
		 	//获得第一个分类下的三篇推荐文章
			$where2 = 'n.article_id = a.id &&';
			$where2.= 'a.classi     = '.$id. ' &&';
			$where2.= 'a.is_release = 1 &&';
			$where2.= 'a.is_status  = 1';
			$list = Db::table(['pet_nav_article' => 'n', 'pet_article' => 'a']) 
					->where($where2)
					->field('a.id, a.title, a.abstract')
					->order('n.sort DESC, a.id DESC')
					->limit(0,3)
					->select();
			$lists  =  $list ->toArray();

			//获得该分类下的图片
			$where3['cid']  = $id;
			$where3['type'] = 2;
			$where3['is_del'] = 2;
			$field3  = 'url';
			$order3  = 'sort DESC, id DESC';
			$limit3  = '0,3';
			$result3 = Db::table('pet_nav_set')
					   ->where($where3)
					   ->field($field3)
					   ->order($order3)
					   ->limit($limit3)
					   ->select();
			$ress    =  $result3 ->toArray();


			$img = '';
			foreach ($lists as $key => $value) {
				$img   = $ress[$key]['url'];
				$lists[$key]['url'] = $img; 
			}
			
			$res = Cache::set($id, $lists, 3600);

		}
		$data['code'] = 1;
		$data['data'] = $lists; 
		echo json_encode($data);
    }

    /**
    * 分类首页
    */
    public function indexs(){
    	$request = Request::instance();
		$param   = $request ->param();
		


		if ($param['name'] == '猫窝') {
			$data['name'] = '狗窝';
			$data['id']   = 2;
			$this ->assign('go' , $data);
		}else{
			$data['name'] = '猫窝';
			$data['id']   = 1;
			$this ->assign('go' , $data);
		}

		$this ->assign('current', $param);

		return $this ->fetch();
    }



    /**
    * 登陆
    */
    public function land(){
    	return $this ->fetch();
    }
}
