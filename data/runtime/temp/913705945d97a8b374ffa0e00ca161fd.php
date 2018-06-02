<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:52:"themes/admin_simpleboot3/admin\menu\get_actions.html";i:1525682252;s:70:"D:\phpStudy\WWW\pet\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/pet/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/pet/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/pet/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/pet/public/",
            WEB_ROOT: "/pet/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/pet/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/pet/public/static/js/wind.js"></script>
    <script src="/pet/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
</head>
<body>
	<div class="wrap">
		<div id="error_tips">
			<h2>应用<?php echo $app; ?>菜单导入成功！</h2>
			<div class="error_cont">
				<ul>
					<?php if(!empty($new_menus)): if(is_array($new_menus) || $new_menus instanceof \think\Collection || $new_menus instanceof \think\Paginator): if( count($new_menus)==0 ) : echo "" ;else: foreach($new_menus as $key=>$vo): ?>
						<li><?php echo $vo; ?></li>
						<?php endforeach; endif; else: echo "" ;endif; else: ?>
						<li>应用<?php echo $app; ?>没有新菜单导入！</li>
					<?php endif; ?>
				</ul>
				<?php if(!empty($next_app)): ?>
					<script>
						setTimeout(function() {
							location.href = "<?php echo url('admin/menu/getactions',array('app'=>$next_app)); ?>";
						}, 1000);
					</script>
					<div class="error_return">
						<a href="<?php echo url('admin/menu/getActions',array('app'=>$next_app)); ?>" class="btn btn-primary">下一个应用</a>
						<a href="<?php echo url('admin/menu/index'); ?>" class="btn btn-default" style="margin-left: 10px;">返回</a>
					</div>
				<?php else: ?>
					<div>全部导入成功！</div>
					<div class="error_return">
						<a href="<?php echo url('menu/index'); ?>" class="btn btn-default">返回</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<script src="/pet/public/static/js/admin.js"></script>
</body>
</html>