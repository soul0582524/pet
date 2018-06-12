<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"themes/admin_simpleboot3/admin\classification\add_class.html";i:1528296665;s:71:"D:\phpStudy\WWW\pets\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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
<body>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('admin/Classification/index'); ?>">分类列表</a></li>
        <li class="active"><a>添加分类</a></li>
 
    </ul>
    <form class="well form-inline margin-top-20" >
        <div>
            分类名称：&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="form-control" type="text" id="name" style="width: 200px;" value="" placeholder="请输入分类名称">
        </div>
        
        <br/>

        <div style="margin-top: 10px;">
            请选择分类：
            <select id="pid" >
                <option value="0" class="select">--为一级分类--</option>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>

                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>


        </div>

        <div style="margin-top: 20px; margin-left: 80px;">
            <input type="button" class="btn btn-primary" value="添加" onclick="add()" />

            <input type="button" class="btn" value="返回" style="border: 1px solid black; margin-left: 5px;" onclick="back()">
        </div>
    </form>

</div>
<script src="/pets/public/static/js/admin.js"></script>
<script type="text/javascript" src="/pets/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/admin.js"></script>
<script type="text/javascript">
    var getNextClassUrl = '<?php echo url("common/Common/getNextClass"); ?>';
    /**
    * 添加分类
    */
    function add(){
        var name = $('#name').val();
        if (name == '') {
            layer.msg('请输入分类名称');
            return false;
        }
        var pid  = $('#pid').val();

         $.ajax({
             url: "<?php echo url('admin/Classification/add'); ?>",
             type: 'POST',
             dataType: 'json',
             data: {"name": name, "pid": pid},
             success:function(res){
                layer.msg(res.msg);
                setTimeout(function(){
                    if (res.code == 1) {
                        window.location.href = "<?php echo url('admin/Classification/index'); ?>";
                    }
                },2000)
             }
         });
         
    }


    function back(){
        window.location.href = "<?php echo url('admin/Classification/index'); ?>";
    }
</script>
</body>
</html>