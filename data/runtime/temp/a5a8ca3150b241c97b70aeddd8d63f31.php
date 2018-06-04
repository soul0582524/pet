<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:56:"themes/admin_simpleboot3/admin\classification\index.html";i:1528096777;s:70:"D:\phpStudy\WWW\pet\public\themes\admin_simpleboot3\public\header.html";i:1528084984;}*/ ?>
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
<body>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a>分类列表</a></li>
       <li><a href="<?php echo url('admin/Classification/addClass'); ?>">添加分类</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('Admin/Classification/index'); ?>">

        分类名称：
        <input class="form-control" type="text" name="name" style="width: 200px;" value="<?php echo input('request.name'); ?>" placeholder="请输入分类名称">
        &nbsp;
        分类等级：
        <select style="width: 200px; height: 34px;" name="level">
            <option value="0" >请选择</option>
            <option value="1" >selected</if>" >一级分类</option>
            <option value="2" >二级分类</option>
        </select>
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('Admin/Classification/index'); ?>">清空</a>

        <input type="button" class="btn btn-primary" value="添加分类" onclick="add()">
    </form>
    <form method="post" class="js-ajax-form">
        <table class="table table-hover table-bordered tablecenter">
            <thead style="font-size: 24px;">
                <tr>
                    <th class="tablecenter">ID</th>
                    <th class="tablecenter">分类等级</th>
                    <th class="tablecenter">分类名称</th>
                    <th class="tablecenter">父分类名称</th>
                    <th class="tablecenter"><?php echo lang('ACTIONS'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td>
                            <?php if($vo['level'] == 1): ?>
                                一级分类
                            <?php elseif($vo['level'] == 2): ?>    
                                二级分类
                            <?php endif; ?>
                        </td>
                        <td><?php echo $vo['name']; ?></td>
                        <td>
                            <?php if($vo['level'] != 1): ?>
                                <?php echo $vo['pname']; endif; ?>
                        </td>
                        <td>
                            <a href="javascript:cancel(<?php echo $vo['id']; ?>)" class="abutton">删除分类</a>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
           
            </tbody>
        </table>
        <div class="pagination"><?php echo $page; ?></div>
    </form>
</div>
<script src="/pet/public/static/js/admin.js"></script>
<script type="text/javascript" src="/pet/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pet/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript">

    /**
    * 添加分类
    */
    function add(){
        window.location.href = "<?php echo url('admin/Classification/addClass'); ?>";
    }

    /**
    * 删除分类
    * @param id 分类id
    */
    function cancel(id){
        layer.confirm('确定要删除该分类吗？',function(){
            $.ajax({
                url: "<?php echo url('admin/Classification/cancel'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {"id": id},
                success:function(res){
                    layer.msg(res.msg);
                    setTimeout(function(){
                        window.location.reload();
                    }, 2000);
                }
            });
        })
    }
</script>
</body>
</html>