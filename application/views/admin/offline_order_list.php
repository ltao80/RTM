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
<?php include "navigation.php"?>
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
                <h3 class="page-title portlet-title">
                    查看订单<small></small>
                    <span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
                </h3>
                <form action="" novalidate="novalidate" style="margin-bottom:0">
                    <ul class="breadcrumb my_select_list" style="margin-bottom:0px">

                        <li>
                            <select class="small m-wrap" tabindex="1" name="province">
                                <option value="">请选择省</option>
                                <option value="Category 1">Category 1</option>
                                <option value="Category 2">Category 2</option>
                                <option value="Category 3">Category 5</option>
                                <option value="Category 4">Category 4</option>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap" tabindex="2" name="city">
                                <option value="">请选择市</option>
                                <option value="Category 1">Category 1</option>
                                <option value="Category 2">Category 2</option>
                                <option value="Category 3">Category 5</option>
                                <option value="Category 4">Category 4</option>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap" tabindex="3" name="region">
                                <option value="">请选择区</option>
                                <option value="Category 1">Category 1</option>
                                <option value="Category 2">Category 2</option>
                                <option value="Category 3">Category 5</option>
                                <option value="Category 4">Category 4</option>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap" tabindex="4" name="store">
                                <option value="">请选择门店</option>
                                <option value="Category 1">Category 1</option>
                                <option value="Category 2">Category 2</option>
                                <option value="Category 3">Category 5</option>
                                <option value="Category 4">Category 4</option>
                            </select>
                        </li>
                        <li>
                            <input type="text" data-required="1" placeholder="* 请输入PG姓名" class="m-wrap small required" name="name">
                        </li>
                        <li>
                            <input type="text" data-required="1" placeholder="* 请选择时间" class="m-wrap small required" name="time" id="datePicker">
                        </li>
                        <li>
                            <label class="checkbox" style="margin-left:5px">
                                <span>是否扫码：</span><input type="checkbox" value="" />
                            </label>
                        </li>
                        <li><button type="submit" class="btn blue" style="margin-left:10px">搜 索</button></li>
                    </ul>
                </form>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>

        <!-- END PAGE HEADER-->
        <div id="dashboard">
            <button type="button" class="btn black my_btn">导 出</button>
            <!-- BEGIN DASHBOARD STATS -->
            <div class="row-fluid">
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                        <tr>
                            <th width="20%">门店</th>
                            <th width="15%" class="my_align_center">省市</th>
                            <th width="15%" class="my_align_center">PG</th>
                            <th width="20%" class="my_align_center">用户OpenID</th>
                            <th width="15%" class="my_align_center">订单详情</th>
                            <th width="15%" class="my_align_center">扫码时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr >
                            <td>上海市徐汇区槽尼玛总店</td>
                            <td class="my_align_center">上海市上海市</td>
                            <td class="my_align_center">张三<br>123423545345</td>
                            <td class="my_align_center">fsdf545435435fdfas</td>
                            <td class="my_align_center">
                                暴力伏特加×3<br>
                                嗷嗷白兰地×4
                            </td>
                            <td class="my_align_center">2015-6-01 10:30</td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="span6 pull-right">
                        <div class="dataTables_paginate paging_bootstrap pagination" style="overflow:hidden; margin-top:0px">
                            <ul style="float:right">
                                <li class="prev disabled"><a href="#"><span class="hidden-480">上一页</span></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li class="next"><a href="#"><span class="hidden-480">下一页</span></a></li>
                            </ul>
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
<script src="media/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        $('#datePicker').datepicker({
            orientation: "right",
            autoclose: true
        });
    });
</script>
</body>
<!-- END BODY -->
</html>