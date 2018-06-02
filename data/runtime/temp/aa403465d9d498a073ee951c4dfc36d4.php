<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"themes/admin_simpleboot3/admin\classification\add.html";i:1527517455;s:70:"D:\phpStudy\WWW\pet\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="/pet/public/static/admin/css/layerconfig.css">
<link rel="stylesheet" type="text/css" href="/pet/public/static/admin/css/admin.css">

<style type="text/css">
    .from{
        width: 500px; 
        text-align: center;
    }

    .span{
        color: red; 
        margin-left:5px;
    }

    .select{
        width: 200px;
        height: 34px;
        margin-top: 5px;
    }
    .add{
        margin-top: 20px;
    }
</style>

<body>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('admin/Classification/index'); ?>">分类列表</a></li>
        <li class="active"><a>添加分类</a></li>
    </ul>
    <center>
        <form class="well form-inline margin-top-20 from">

            分类名称：
            <input class="form-control" type="text" id="name" style="width: 200px;" value="" placeholder="请输入分类名称">
            <span class="span">*</span>
            <br/>

            <!-- 所属分类：
            <select id="class" class="select" onchange = "getNext()">
                <option value="0">一级分类</option>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <span class="span">*</span>
            <br/> -->

         

            <input type="button" class="btn btn-primary add" value="添加分类" onclick="add()">
        </form>
    </center>
</div>
<script src="/pet/public/static/js/admin.js"></script>
<script type="text/javascript" src="/pet/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pet/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript">
    /**
    * 添加
    */
    function add(){
        var name = $('#name').val(); //分类名称
        var clas = $('#class').val(); //所属分类
        if (name == '') {
            layer.msg('请输入分类名称');
            return false;
        } 
        $.ajax({
            url: "<?php echo url('Admin/Classification/add'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {'name': name, "class":0},
            success:function(res){
                layer.msg(res.msg);
                setTimeout(function(){
                    if (res.code == 1) {
                        layer.confirm('',{
                            btn:['继续添加', '返回列表'],
       
                            btn2:function(){
                                var url = "<?php echo url('admin/Classification/index'); ?>";
                                window.location.href = url;
                            }
                        })
                    }
                },2000)
            }
        })

    }

  

</script>
</body>
</html>