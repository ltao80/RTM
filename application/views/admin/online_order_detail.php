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
                    兑换订单详情<small></small>
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

                    <div class="form-wizard">
                        <div class="navbar steps">
                            <div class="navbar-inner">
                                <ul class="row-fluid nav nav-pills">
                                    <li class="span4 active">
                                        <a href="javascript:void(0)" class="step active">
                                            <span class="number">1</span>
													<span class="desc"><i class="icon-ok"></i>买家下单<br><strong>2029-04-12
                                                            10:30</strong></span>
                                        </a>
                                    </li>
                                    <li class="span4">
                                        <a href="javascript:void(0)" class="step">
                                            <span class="number">2</span>
													<span class="desc"><i class="icon-ok"></i>卖家出货<br><strong>2029-04-12
                                                            10:31</strong></span>
                                        </a>
                                    </li>
                                    <li class="span4">
                                        <a href="javascript:void(0)" class="step">
                                            <span class="number">3</span>
													<span class="desc"><i class="icon-ok"></i>订单完成<br><strong>3129-04-12
                                                            10:32</strong></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="bar" class="progress progress-success progress-striped">
                            <div class="bar" style="width: 33.33%;"></div>
                        </div>
                    </div>
                    <div class="portlet-body row-fluid my_product_p">
                        <h3 class="portlet-title">订单信息</h3>
                        <div class="form-horizontal">
                            <div class="control-group">
                                <span class="control-label my_color_grey">订单日期：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['order_datetime']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">微商城订单号：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['order_code']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">产品信息：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['detail']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">总积分：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['total_score']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">买家留言：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['message']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body row-fluid my_product_p">
                        <h3 class="portlet-title">买家信息</h3>
                        <div class="form-horizontal">
                            <div class="control-group">
                                <span class="control-label my_color_grey">openID：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['wechat_id']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">收货人：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['receiver_name']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">联系方式：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['receiver_phone']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">地址：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['receiver_province']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body row-fluid my_product_p">
                        <h3 class="portlet-title">物流信息</h3>
                        <div class="form-horizontal">
                            <div class="control-group">
                                <span class="control-label my_color_grey">物流公司：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['company_name']?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <span class="control-label my_color_grey">运单号：</span>
                                <div class="controls">
                                    <span class="help-inline"><?php echo $data['delivery_order_code']?></span>
                                </div>
                            </div>
                            <div class="control-group" style="display: none">
                                <span class="control-label my_color_grey">发货时间：</span>
                                <div class="controls">
                                    <span class="help-inline">1988-04-12 10:30</span>
                                </div>
                            </div>
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
<?php include "bottom.php"?>




<!--page js-->
</body>
<!-- END BODY -->
</html>