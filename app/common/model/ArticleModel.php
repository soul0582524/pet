<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;
use think\Db;

class ArticleModel extends Model
{

	/**
	* find查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function findArticle($where = '', $field = '')
	{
		return $result = Db::table('pet_article') ->where($where) ->field($field) ->find();
	}

	/**
	* 查询某一字段值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function selectArticle($where = '', $field = '')
	{
		return $result = Db::table('pet_article') ->where($where) ->field($field) ->select();
	}

	/**
	* 查询某一列值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function cloumnArticle($where = '', $field = '')
	{
		return $result = Db::table('pet_article') ->where($where) ->column($field); 
	}

	/**
	* 分页查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function paginateArticle($where = '', $field = '', $order = '', $limit = '')
	{
		return $result = Db::table('pet_article') ->where($where) ->field($field) ->order($order) ->paginate($limit);
	}

	/**
	* 更新
	* @param where 更新条件
	* @param field 更新内容
	*/
	public function setFieldArticle($where = '', $data = '')
	{
		return $result = Db::table('pet_article') ->where($where) ->setField($data);
	}

	/**
	* 添加
	* @param add 添加内容
	*/
	public function insertArticle($add){
		return $result = Db::table('pet_article') ->insert($add);
	}


}

?>