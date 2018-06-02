<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"themes/admin_simpleboot3/admin\article\add.html";i:1527601711;s:70:"D:\phpStudy\WWW\pet\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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
<style type="text/css">
    .pic-list li {
        margin-bottom: 5px;
    }
</style>

</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('Article/lists'); ?>">文章管理</a></li>
        <li class="active"><a>添加文章</a></li>
    </ul>
    <form class="form-horizontal js-ajax-form margin-top-20">
        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th width="100">分类<span class="form-required">*</span></th>
                        <td>
                           <select name="classi" id="classi">
                               <option value="0" style="height: 34px; width: 200px;">请选择分类</option>
                               <?php if(is_array($classi) || $classi instanceof \think\Collection || $classi instanceof \think\Paginator): if( count($classi)==0 ) : echo "" ;else: foreach($classi as $key=>$vo): ?>
                                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                               <?php endforeach; endif; else: echo "" ;endif; ?>
                           </select>
                        </td>
                    </tr>
                    <tr>
                        <th>标题<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" name="post[post_title]"
                                   id="title" required value="" placeholder="请输入标题"/>
                        </td>
                    </tr>

                    <tr>
                        <th>文章来源</th>
                        <td><input class="form-control" type="text" name="post[post_source]" id="source" value=""
                                   placeholder="请输入文章来源"></td>
                    </tr>
                    <tr>
                        <th>摘要</th>
                        <td>
                            <textarea class="form-control" name="post[post_excerpt]" style="height: 50px;" id="abstract" placeholder="请填写摘要"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td>
                            <script type="text/plain" id="content" name="post[post_content]" style="height: 400px;"></script>
                        </td>
                    </tr>
                   
                </table>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-primary js-ajax-submit" onclick = "add()"><?php echo lang('ADD'); ?></button >
                        <a class="btn btn-default" href="<?php echo url('Article/lists'); ?>"><?php echo lang('BACK'); ?></a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<script type="text/javascript" src="/pet/public/static/js/admin.js"></script>
<script type="text/javascript">
    //编辑器路径定义
    var editorURL = GV.WEB_ROOT;
</script>
<script type="text/javascript" src="/pet/public/static/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/pet/public/static/js/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/pet/public/static/layer/layer.js"></script>
<script type="text/javascript" src="/pet/public/static/admin/js/layerconfig.js"></script>
<script type="text/javascript">
    $(function () {

        editorcontent = new baidu.editor.ui.Editor();
        editorcontent.render('content');
        try {
            editorcontent.sync();
        } catch (err) {
        }

    });


    /**
    * 添加
    */
    function add(){
        //获得分类
        var classi = $('#classi').val();
        if (classi == 0) {
            layer.msg('请选择文章分类');
            return false;
        }
        //获得标题
        var title  = $('#title').val();
        if (title == '') {
            layer.msg('请输入文章标题');
            return false;
        } 
        //获得来源
        var source = $('#source').val();
        //摘要
        var abstract = $('#abstract').val();
        //文章内容
        var content = editorcontent.getContent();
        if (content == '') {
            layer.msg('请输入文章内容');
            return false;
        }

        var param = {"classi":classi, "title":title, "source":source, "abstract":abstract, "content":content};

        $.ajax({
            url: '<?php echo url("Article/addArticle"); ?>',
            type: 'POST',
            dataType: 'json',
            data: param,
            success:function(res){
                layer.msg(res.msg);
                setTimeout(function(){
                    if (res.code == 1) {
                        window.location.href = "<?php echo url('admin/Article/lists'); ?>"
                    }else if (res.code == 2) {
                        window.location.reload();
                    }
                },2000);
            }
        })

        
    }

</script>
</body>
</html>
