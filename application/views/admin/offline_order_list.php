<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
    <link href="/static/admin/css/datepicker3.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="shortcut icon" href="/static/admin/image/favicon.ico" />
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
                <form action="/admin/order_manage/get_offline_order_list" novalidate="novalidate"
                style="margin-bottom:0" method="get" enctype="multipart/form-data">
                    <ul class="breadcrumb my_select_list" style="margin-bottom:0px">

                        <li>
                            <select class="small m-wrap my_form_item" tabindex="1" name="province">
                                <option value="">请选择省</option>
                                <?php foreach($province as $province){?>
                                <option value="<?php echo $province?>"><?php echo $province?></option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap my_form_item" tabindex="2" name="city">
                                <option value="">请选择市</option>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap my_form_item" tabindex="3" name="region">
                                <option value="">请选择区</option>
                            </select>
                        </li>
                        <li>
                            <select class="small m-wrap my_form_item" tabindex="4" name="store">
                                <option value="">请选择门店</option>
                            </select>
                        </li>
                        <li>
                            <input type="text" data-required="1" placeholder="* 请输入PG姓名" class="m-wrap small required
                             my_form_item" name="name">
                        </li>
                        <li>
                            <input type="text" data-required="1" placeholder="* 请选择时间" class="m-wrap small required my_form_item"
                             name="time" id="datePicker">
                        </li>
                        <li>
                            <label class="checkbox" style="margin-left:5px">
                                <span>是否扫码：</span><input class='my_form_item' type="checkbox" value="1" name="is_scan"/>
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
            <form action="/admin/order_manage/export_offline_order" method="post" enctype="multipart/form-data">
                <input type="hidden" name="province" value="<?php echo $condition[0]?>">
                <input type="hidden" name="city" value="<?php echo $condition[1]?>">
                <input type="hidden" name="region" value="<?php echo $condition[2]?>">
                <input type="hidden" name="store" value="<?php echo $condition[3]?>">
                <input type="hidden" name="name" value="<?php echo $condition[4]?>">
                <input type="hidden" name="time" value="<?php echo $condition[5]?>">
                <input type="hidden" name="is_scan" value="<?php echo $condition[6]?>">
            <button type="submit" class="btn black my_btn">导 出</button>
            </form>
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
                        <?php foreach($data as $item){?>
                        <tr>
                            <td><?php echo $item['store']?></td>
                            <td class="my_align_center"><?php echo $item['address']?></td>
                            <td class="my_align_center"><?php echo $item['username']?><br><?php echo $item['phone']?></td>
                            <td class="my_align_center"><?php echo $item['wechat_id']?></td>
                            <td class="my_align_center">
                                <?php echo $item['detail']?>
                            </td>
                            <td class="my_align_center"><?php echo $item['scan_datetime']?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div class="span6 pull-right">
                        <div class="dataTables_paginate paging_bootstrap pagination" style="overflow:hidden; margin-top:0px">
                            <ul style="float:right">
                                <?php echo $pager;?>
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
<script src="/static/admin/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        $('#datePicker').datepicker({
            orientation: "right",
            autoclose: true,
            format:'yyyy-mm-dd'
        });
    });
</script>
</body>
<!-- END BODY -->
</html>