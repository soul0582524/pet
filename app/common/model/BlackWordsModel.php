<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;
use think\Db;

class BlackWordsModel extends Model
{

	/**
	* find查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function findWords($where = '', $field = '')
	{
		return $result = Db::table('pet_black_words') ->where($where) ->field($field) ->find();
	}

	/**
	* 查询某一字段值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function valueWords($where = '', $field = '')
	{
		return $result = Db::table('pet_black_words') ->where($where) ->value($field);
	}

	/**
	* 查询某一列值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function cloumnWords($where = '', $field = '')
	{
		return $result = Db::table('pet_black_words') ->where($where) ->column($field); 
	}

	/**
	* 分页查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function paginateWords($where = '', $field = '', $order = '', $limit = '')
	{
		return $result = Db::table('pet_black_words') ->where($where)
		                                              ->field($field)
		                                              ->order($order)
		                                              ->paginate($limit);
	}

	/**
	* 更新
	* @param where 更新条件
	* @param field 更新内容
	*/
	public function setFieldWords($where = '', $data = '')
	{
		return $result = Db::table('pet_black_words') ->where($where) ->setField($data);
	}

	/**
	* 添加
	* @param add 添加内容
	*/
	public function insertWords($add){
		return $result = Db::table('pet_black_words') ->insert($add);
	}
}

?>