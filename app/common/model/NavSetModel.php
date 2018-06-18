<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;
use think\Db;

class NavSetModel extends Model
{

	/**
	* find查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function findSet($where = '', $field = '')
	{
		return $result = Db::table('pet_nav_set') ->where($where) ->field($field) ->find();
	}

	/**
	* 查询某一字段值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function selectSet($where = '', $field = '')
	{
		return $result = Db::table('pet_nav_set') ->where($where) ->field($field) ->select();
	}

	/**
	* 查询某一列值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function cloumnSet($where = '', $field = '')
	{
		return $result = Db::table('pet_nav_set') ->where($where) ->column($field); 
	}

	/**
	* 分页查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function paginateSet($where = '', $field = '', $order = '', $limit = '')
	{
		return $result = Db::table('pet_nav_set') ->where($where) ->field($field) ->order($order) ->paginate($limit);
	}

	/**
	* 更新
	* @param where 更新条件
	* @param field 更新内容
	*/
	public function setFieldSet($where = '', $data = '')
	{
		return $result = Db::table('pet_nav_set') ->where($where) ->setField($data);
	}

	/**
	* 添加
	* @param add 添加内容
	*/
	public function insertSet($add){
		return $result = Db::table('pet_nav_set') ->insert($add);
	}


}

?>