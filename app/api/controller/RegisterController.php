<?php

// +----------------------------------------------------------------------
// | Author: 惊蛰 < 18311217075@163.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use cmf\controller\ApiBaseController;
use think\Request;
use think\Db;

class RegisterController extends ApiBaseController{

	/**
	* 注册
	* @param  userName  用户名
	* @param  passWord  密码
	* @return code      1成功  2失败
	*/
	public function index(){
		$request = Request::instance();
		$param   = $request ->param();
		//设置添加数据
		dump($param);
	}
}

?>