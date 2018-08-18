<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"themes/admin_simpleboot3/admin\article\lists.html";i:1530068330;s:71:"D:\phpStudy\WWW\pets\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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
        <li class="active"><a>文章列表</a></li>
        <li><a href="<?php echo url('admin/Article/add'); ?>">添加文章</a></li>
        <li><a href="<?php echo url('admin/Article/navArticle'); ?>">引导页展示文章</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('Admin/Article/lists'); ?>">
        一级分类：
        <select name="classi" class="select" id="classi" onchange="getNextClass()">
            <option value="0">请选择分类</option>
            <?php if(is_array($classi) || $classi instanceof \think\Collection || $classi instanceof \think\Paginator): if( count($classi)==0 ) : echo "" ;else: foreach($classi as $key=>$vo): ?>
                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
       </select>
       &nbsp;&nbsp;&nbsp;
        二级分类：
        <select name="class2" class="select" id="class2">
            <option value="0">请选择二级分类</option>
        </select>
        标题：
        <input class="form-control" type="text" name="title" style="width: 200px;" value="<?php echo input('request.title'); ?>" placeholder="标题">
        &nbsp;

        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('Admin/Article/lists'); ?>">清空</a>

        <input type="button" class="btn btn-primary" value="添加" onclick="add()">
    </form>
    <form method="post" class="js-ajax-form">
        <table class="table table-hover table-bordered tablecenter">
            <thead style="font-size: 24px;">
                <tr>
                    <th class="tablecenter">ID</th>
                    <th class="tablecenter">分类</th>
                    <th class="tablecenter">标题</th>
                    <th class="tablecenter">来源</th>
                    <th class="tablecenter" width="500px;">摘要</th>
                    <th class="tablecenter">添加时间</th>
                    <th class="tablecenter">发布时间</th>
                    <th class="tablecenter"><?php echo lang('ACTIONS'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                    <tr>
                        <th class="tablecenter"><?php echo $vo['id']; ?></th>
                        <th class="tablecenter"><?php echo $vo['name']; ?></th>
                        <th class="tablecenter"><?php echo $vo['title']; ?></th>
                        <th class="tablecenter"><?php echo $vo['source']; ?></th>
                        <th class="tablecenter"><?php echo $vo['abstract']; ?></th>
                        <th class="tablecenter"><?php echo $vo['add_time']; ?></th>
                        <th class="tablecenter"><?php echo $vo['release_time']; ?></th>
                        <th class="tablecenter">
                            <a href="<?php echo url('Admin/Article/detail',array('id' => $vo['id'])); ?>">详情</a>
                            &nbsp;|&nbsp;
                            <?php if($vo['is_release'] == 2): ?>
                                <a href="javascript:release(<?php echo $vo['id']; ?>, 1)">发布</a>
                            <?php else: ?>
                                <a href="javascript:release(<?php echo $vo['id']; ?>, 2)">撤销</a>
                            <?php endif; ?>
                            &nbsp;|&nbsp;
                            <a href="javascript:del(<?php echo $vo['id']; ?>)">删除</a>
                            &nbsp;|&nbsp;
                            <a href="javascript:nav('<?php echo $vo['id']; ?>', '<?php echo $vo['title']; ?>')">引导页推荐</a>
                        </th>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php echo $page; ?>
        </div>
    </form>
</div>
<script src="/pets/public/static/js/admin.js"></script>
<script type="text/javascript" src="/pets/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript" src="/pets/public/static/admin/js/admin.js"></script>
<script type="text/javascript">

    var getNextClassUrl = '<?php echo url("common/Common/getNextClass"); ?>';

    function add(){
        window.location.href = "<?php echo url('admin/Article/add'); ?>";
    }

    /**
    * 发布和取消发布
    * @param id   文章id
    * @param type type 1发布  2取消
    */
    function release(id, type){
        $.ajax({
            url: '<?php echo url("Article/release"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {"id":id, "type":type},
            success:function(res){
                layer.msg(res.msg);
                setTimeout(function(){
                    window.location.reload(); 
                },2000);
            }
        })
        
    }

    /**
    * 删除文章
    * @param id 文章id
    */
    function del(id){
        layer.confirm('确定要删除该文章吗？',function(){
            $.ajax({
                url: '<?php echo url("Article/del"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {"id":id},
                success:function(res){
                    layer.msg(res.msg);
                    setTimeout(function(){
                        window.location.reload(); 
                    },2000);
                }
            })
        });
    }


    /**
    * 引导推荐
    * @param id 文章id
    */
    function nav(id, title){
        layer.confirm('确定要设置该文件为引导页展示吗',function(){
            $.ajax({
                url: '<?php echo url("Article/nav"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {"id":id, "title":title},
                success:function(res){
                    layer.msg(res.msg);
                    setTimeout(function(){
                        window.location.reload(); 
                    },2000);
                }
            })
        });

    }


</script>
</body>
</html>