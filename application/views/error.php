<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Metronic | Admin Dashboard Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="media/css/my-style.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="shortcut icon" href="media/image/favicon.ico" />


    <!--page css-->
    <link href="media/css/error.css" rel="stylesheet" type="text/css"/>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="index.html">
                <img src="media/image/logo.png" alt="logo"/>
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <img src="media/image/menu-toggler.png" alt="" />
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown user">
                    <a href="javascript:void(0)" style="background:none!important" class="dropdown-toggle my_nobg">
                        <span class="username my_header_span">华东地区</span>
                    </a>
                </li>
                <li class="dropdown user">
                    <a href="#" style="background:none!important" class="dropdown-toggle my_nobg">
                        <span class="username my_header_span my_underline">退出</span>
                    </a>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar nav-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li style="margin-bottom:15px">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start active ">
                <a href="index.html">
                    <i class="icon-home"></i>
                    <span class="title">PG管理</span>
                    <span class="selected"></span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="active"><a href="index.html">新建</a></li>
                    <li><a href="index.html">PG列表</a></li>
                </ul>
            </li>
            <li class="">
                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title">查看订单</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
                    <li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
                    <li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
                </ul>
            </li>
            <li class="">
                <a href="index.html">
                    <i class="icon-home"></i>
                    <span class="title">PG管理</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="">
                <a href="index.html">
                    <i class="icon-home"></i>
                    <span class="title">PG管理</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
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
                                <h3>槽糕，出错了！</h3>
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
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2015 &copy; 互赢网络
    </div>
    <div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
    </div>
</div>
<!--common js-->
<script src="media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="media/js/bootstrap.min.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="media/js/excanvas.min.js"></script>
<script src="media/js/respond.min.js"></script>
<![endif]-->
<script src="media/js/jquery.uniform.min.js" type="text/javascript" ></script>
<script src="media/js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="media/js/app.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        App.init(); // initlayout and core plugins
    });
</script>
</body>
<!-- END BODY -->
</html>