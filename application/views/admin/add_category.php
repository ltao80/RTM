<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <?php include "top.php"?>

</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include "navigation.php"?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title portlet-title">
                        分类管理<small>添加分类</small>
                        <span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/product_manage/list_category">返回</a></span>
                    </h3>

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <form class="form-horizontal" id="PG_form" action="/admin/product_manage/add_category" method="post" enctype="multipart/form-data">
                        <div class="portlet-body">
                            <div class="control-group">
                                <label class="control-label my_color_red">请输入类别名称：</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" placeholder="角色名称" name="category_name" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions" style="clear:both">
                            <button type="submit" class="btn black">保 存</button>
                            <button type="reset" class="btn">重 置</button>
                        </div>
                    </form>

                </div>
                <!-- END DASHBOARD STATS -->
            </div>
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include "bottom.php"?>




<!--page js-->
<script type="text/javascript" src="/static/admin/js/jquery.validate.min.js"></script>
<script src="/static/admin/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#PG_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                type: {
                    required: true,
                    minlength:2
                }
            },
            messages: {
                type:{
                    required: "类别名称不能为空",
                    minlength: $.validator.format("角色名不能少于 {0} 个字符")
                }
            },
            errorPlacement: function(error, element) {
                if(element.attr('name')=='tree_list'){
                    $('#tree_error').text(error.text())
                }else{
                    element.next().text(error.text())
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.help-inline').removeClass('ok'); // display OK icon
                $(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change dony by hightlight
                $(element).closest('.control-group').removeClass('error'); // set error class to the control group
                $(element).next('span').text('')
            }
        })
    });
</script>
</body>
<!-- END BODY -->
</html>