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
<body class="page-header-fixed page-sidebar-fixed <?php if($user_info['menu_status'] == "0") { ?> page-sidebar-closed <?php } ?>">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <?php include "top.php"?>
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php include "navigation.php"?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body">
                Widget settings form goes here
            </div>
        </div>
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title portlet-title">
                        发货<small></small>
                        <span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/order_manage/get_online_order_list">返回</a></span>
                    </h3>

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <div class="portlet-body">
                        <form action="/admin/order_manage/update_delivery_order_code" class="form-horizontal" id="add_PG">
                            <input type="hidden" name="order_code" value="<?php echo $order_code?>">
                            <div class="control-group">
                                <label class="control-label">物流公司：</label>
                                <div class="controls" style="line-height:22px; font-size:14px">
                                    <span class="help-inline"><?php echo $company?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请输入运单号：</label>
                                <div class="controls">
                                    <input type="text" name="delivery_code" class="span6 m-wrap" placeholder="运单号" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn black">确 定</button>
                            </div>
                        </form>
                    </div>
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
<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script src="media/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#add_PG').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                number: {
                    required: true,
                    number: true
                }
            },
            messages: {
                number:{
                    required: "运单号不能为空",
                    number:"请输入合法的运单号"
                }
            },
            errorPlacement: function(error, element) {
                element.next().text(error.text())
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.help-inline').removeClass('ok'); // display OK icon
                $(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change dony by hightlight
                $(element).closest('.control-group').removeClass('error'); // set error class to the control group
                $(element).next().text('')
            }
        });
    });
</script>
</body>
<!-- END BODY -->
</html>