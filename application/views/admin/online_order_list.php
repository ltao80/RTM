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
                    <li>全部订阅订单（<a href="#">93</a>）</li>
                    <li>未发货订单（<a href="#" class="my_color_red">52</a>）</li>
                    <li>已发货订单（<a href="#" class="my_color_red">23</a>）</li>
                    <li>已完成订单（<a href="#" class="my_color_red">18</a>）</li>
                </ul>
                <ul class="breadcrumb my_select_list" style=" margin-bottom:0px">
                    <li>
                        <select class="small m-wrap  my_filter" tabindex="1">
                            <option value="">交易状态</option>
                            <option value="http://www.baidu.com">Category 1</option>
                            <option value="http://www.baga.com">Category 2</option>
                        </select>
                    </li>
                    <form style="display:inline">
                        <a class="btn blue my_btn pull-right" href="#" style="color:#fff; margin:0 10px">搜索
                        </a>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="区间结束日期"
                                   class="m-wrap small required" id="time_end" name="time_end">
                        </li>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="区间起始日期"
                                   class="m-wrap small required" id="time_start" name="time_start">
                        </li>
                        <li class="pull-right">
                            <input type="text" data-required="1" placeholder="* 请输入PG姓名"
                                   class="m-wrap small required" name="name">
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
                        <tr >
                            <td>
                                <div class="media">
                                    <a href="#" class="pull-left">
                                        <img alt="" src="media/image/5.jpg" width="110" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">人头马VSOP</h4>
                                        <p>人头马特优飞扬跋扈超豪华蒙塔机铁蛋签名全球限量版,人头马特优飞扬跋扈超豪华蒙塔机铁蛋签名全球限量版。</p>
                                        <p class="my_color_grey">发布时间：2015-04-12 10:30</p>
                                    </div>
                                </div>
                            </td>
                            <td class="my_align_center">500K积分</td>
                            <td class="my_align_center">100</td>
                            <td class="my_align_center">嗷嗷嗷小姐<br>openID:64564564564</td>
                            <td class="my_align_center">1413423432424</td>
                            <td class="my_align_center">1413423432424</td>
                            <td class="my_align_center">
                                <a class="edit my_edit" href="/admin/order_manage/get_delivery_detail?order_code=<?php echo '1'?>">编辑</a>
                                <!--<a class="edit my_edit" href="#">删除</a><br>-->
                                <button class="btn black mini">发货</button>
                            </td>
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
        setTimeRange($('#time_start'),$('#time_end'))
    });
</script>
</body>
<!-- END BODY -->
</html>