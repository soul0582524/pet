<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"themes/admin_simpleboot3/admin\article\nav.html";i:1528604390;s:71:"D:\phpStudy\WWW\pets\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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


    <link href="/pets/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/pets/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/pets/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
            ROOT: "/pets/public/",
            WEB_ROOT: "/pets/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/pets/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/pets/public/static/js/wind.js"></script>
    <script src="/pets/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
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
<link rel="stylesheet" type="text/css" href="/pets/public/static/admin/css/layerconfig.css">
<link rel="stylesheet" type="text/css" href="/pets/public/static/admin/css/admin.css">
<link rel="stylesheet" href="/pets/public/static/layui/css/layui.css" media="all">
<body>
    <button type="button" class="layui-btn" id="uploadsImg" name="imgs">
        <i class="layui-icon">&#xe67c;</i>上传图片
    </button>
</div>
<script src="/pets/public/static/js/admin.js"></script>
<script type="text/javascript" src="/pets/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pets/public/static/layui/layui.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/admin.js"></script>
<script type="text/javascript">
    layui.use('upload', function(){
        var upload = layui.upload;
   
        //执行实例
        var uploadInst = upload.render({
            elem: '#uploadsImg' //绑定元素
            ,url: '<?php echo url("Common/Common/uploadsImg"); ?>' //上传接口
            ,done: function(res){
            //上传完毕回调
            }
            ,error: function(){
              //请求异常回调
            }
        });
    });
</script>
</body>
</html>