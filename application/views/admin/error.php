<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <!-- BEGIN HEADER-->
    <?php include 'header.php';?>
    <!-- END HEADER -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP -->
    <?php include 'top.php';?>
    <!-- END TOP -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN NAVIGATION -->
    <?php include 'navigation.php';?>
    <!-- END NAVIGATION -->
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

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <div class="portlet-body">

                        <div class="span12 page-404" style="margin-top:80px">
                            <div class="number">
                                <span class="icon-warning-sign"></span>
                            </div>
                            <div class="details" style="position:relative; top:-20px">
                                <h3>槽糕，出错了<?php if(!empty($error)) echo "，".$error?></php></h3>
                                <p style="font-size:14px">
                                    请联系管理员或
                                    <a href="index.html" style="text-decoration:underline">返回首页</a>。
                                </p>
                            </div>
                        </div>

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
<!-- BEGIN BOTTOM -->
<?php include 'bottom.php'?>
<!-- END BOTTOM -->
</body>
<!-- END BODY -->
</html>