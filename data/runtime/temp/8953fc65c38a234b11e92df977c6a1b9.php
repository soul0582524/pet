<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:53:"themes/admin_simpleboot3/admin\black_words\index.html";i:1527324368;s:70:"D:\phpStudy\WWW\pet\public\themes\admin_simpleboot3\public\header.html";i:1525682252;}*/ ?>
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
        <li class="active"><a>黑词列表</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('Admin/BlackWords/index'); ?>">

        黑词：
        <input class="form-control" type="text" name="words" style="width: 200px;" value="<?php echo input('request.words'); ?>" placeholder="黑词">
        &nbsp;

        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('Admin/BlackWords/index'); ?>">清空</a>

        <input type="button" class="btn btn-primary" value="添加" onclick="add()">
    </form>
    <form method="post" class="js-ajax-form">
        <table class="table table-hover table-bordered tablecenter">
            <thead style="font-size: 24px;">
                <tr>
                    <th class="tablecenter">ID</th>
                    <th class="tablecenter"><?php echo lang('WORD'); ?></th>
                    <th class="tablecenter"><?php echo lang('ACTIONS'); ?></th>
                </tr>
            </thead>
            <tbody>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $vo['word']; ?>
                    </td>
                    <td>
                        <a href="javascript:cancel(<?php echo $vo['id']; ?>)" class="abutton">取消黑词</a>
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

    //取消黑词
    function cancel(id){
        layer.confirm('确定要取消该黑词设定吗？',function(){
            var url = "<?php echo url('Admin/BlackWords/cancel'); ?>";

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'id': id},
                success:function(res){
                    layer.msg(res.msg);
                    if (res.code == 1) {
                        setTimeout(function(){
                            window.location.reload();
                        },2000)
                    }
                    
                }
            })
            
            
        })
    }

    function add(){
        layer.prompt({
            formType: 2,
            title: '请输入黑词',
            area: ['400px', '50px'] //自定义文本域宽高
        }, function(value, index, elem){
            $.ajax({
                url: "<?php echo url('Admin/BlackWords/addWords'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {'value': value},
                success:function(res){
                    layer.msg(res.msg);
                    if (res.code == 1) {
                        setTimeout(function(){
                            window.location.reload();
                        },2000)
                    }
                    
                }
            })
        });
    }
</script>
</body>
</html>