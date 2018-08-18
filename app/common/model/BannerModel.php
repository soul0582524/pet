<?php
// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;
use think\Db;

class BannerModel extends Model
{

	/**
	* find查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function findBanner($where = '', $field = '')
	{
		return $result = Db::table('pet_banner') ->where($where) ->field($field) ->find();
	}

	/**
	* 查询某一字段值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function selectBanner($where = '', $field = '')
	{
		return $result = Db::table('pet_banner') ->where($where) ->field($field) ->select();
	}

	/**
	* 查询某一列值
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function cloumnBanner($where = '', $field = '')
	{
		return $result = Db::table('pet_banner') ->where($where) ->column($field); 
	}

	/**
	* 分页查询
	* @param where 查询条件
	* @param field 查询内容
	*/
	public function paginateBanner($where = '', $field = '', $order = '', $limit = '')
	{
		return $result = Db::table('pet_banner') ->where($where) ->field($field) ->order($order) ->paginate($limit);
	}

	/**
	* 更新
	* @param where 更新条件
	* @param field 更新内容
	*/
	public function setFieldBanner($where = '', $data = '')
	{
		return $result = Db::table('pet_banner') ->where($where) ->setField($data);
	}

	/**
	* 添加
	* @param add 添加内容
	*/
	public function insertBanner($add){
		return $result = Db::table('pet_banner') ->insert($add);
	}


	/**
	* 删除
	* @param where 删除条件
	*/
	public function delBanner($where){
		return $result = Db::table('pet_banner') ->where($where)->delete();
	}

}

?>