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
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
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
                    所有兑换订单<small></small>
                    <span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
                </h3>
                <ul class="breadcrumb my_select_list" style=" margin-bottom:0px; padding-bottom:0;
						padding-left:10px">
                    <li>全部订阅订单（<a href="#"><?php echo $total_count;?></a>）</li>
                    <li>未发货订单（<a href="#" class="my_color_red"><?php echo $u_count;?></a>）</li>
                    <li>已发货订单（<a href="#" class="my_color_red"><?php echo $delivery_count;?></a>）</li>
                    <li>已完成订单（<a href="#" class="my_color_red"><?php echo $complete_count;?></a>）</li>
                </ul>
                <ul class="breadcrumb my_select_list" style=" margin-bottom:0px">
                    <li>
                        <select class="small m-wrap  my_filter" tabindex="1">
                            <option value="">交易状态</option>
                            <option value="0">未发货</option>
                            <option value="1">发货中</option>
                            <option value="2">完成发货</option>
                        </select>
                    </li>
                    <form style="display:inline">
                        <a class="btn blue my_btn pull-right" href="#" style="color:#fff; margin:0 10px">搜索
                        </a>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="区间结束日期"
                                   class="m-wrap small required" id="time_end" name="endTime">
                        </li>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="区间起始日期"
                                   class="m-wrap small required" id="time_start" name="startTime">
                        </li>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="* 请输入商城的订单号"
                                   class="m-wrap small required" name="order_code">
                        </li>
                    </form>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>

        <!-- END PAGE HEADER-->
        <div id="dashboard">
            <!-- BEGIN DASHBOARD STATS -->
            <div class="row-fluid">
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                        <tr>
                            <th width="30%">兑换商品信息</th>
                            <th width="10%" class="my_align_center">兑换积分</th>
                            <th width="5%" class="my_align_center">数量</th>
                            <th width="15%" class="my_align_center">买家信息</th>
                            <th width="15%" class="my_align_center">订单号</th>
                            <th width="15%" class="my_align_center">运单号</th>
                            <th width="10%" class="my_align_center">交易状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data as $item){?>
                        <tr >
                            <td>
                                <div class="media">
                                    <div class="media-body">
                                        <?php $detail = explode(",",$item['detail'])?>
                                        <?php foreach($detail as $val){?>
                                        <p><?php echo $val;?></p><br/>
                                        <?php }?>
                                        <p class="my_color_grey">发布时间：<?php echo $item['order_datetime'];?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="my_align_center"><?php echo $item['total_score']?></td>
                            <td class="my_align_center"><?php echo $item['product_num']?></td>
                            <td class="my_align_center"><?php echo $item['username']?><br>openID:<?php echo $item['wehcat_id']?></td>
                            <td class="my_align_center"><?php echo $item['order_code']?></td>
                            <td class="my_align_center"><?php echo $item['delivery_order_code']?></td>
                            <td class="my_align_center">
                                <!--<a class="edit my_edit" href="">编辑</a>-->
                                <!--<a class="edit my_edit" href="#">删除</a><br>-->
                                <?php if($item['status'] == 0){?>
                                    <a class="btn black mini" href="/admin/order_manage/delivery?order_code=<?php echo $item['order_code']?>">发货</a>
                                <?php }elseif($item['status'] == 1){?>
                                <button>发货中</button>
                                <?php }else{?>
                                <button>完成发货</button>
                                <?php }?>
                            </td>
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
        setTimeRange($('#time_start'),$('#time_end'))
    });
</script>
</body>
<!-- END BODY -->
</html>