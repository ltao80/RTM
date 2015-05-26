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
    <!-- BEGIN TOP NAVIGATION BAR -->
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
                    积分兑换商品<small></small>
                    <span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/product_manage/list_products">返回</a></span>
                </h3>
                <ul class="breadcrumb my_select_list" style="margin-bottom:0px">

                    <li>
                        <select class="small m-wrap" tabindex="1" name="province">
                            <option value="">请选类别</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <option value="Category 3">Category 5</option>
                            <option value="Category 4">Category 4</option>
                        </select>
                    </li>
                    <li>
                        <select class="small m-wrap" tabindex="2" name="city">
                            <option value="">请选状态</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <option value="Category 3">Category 5</option>
                            <option value="Category 4">Category 4</option>
                        </select>
                    </li>
                    <a class="btn black my_btn pull-right" href="/admin/product_manage/new_product" style="color:#fff; margin-right:10px">添加兑换商品</a>
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
                            <th width="10%" class="my_align_center">类别</th>
                            <th width="10%" class="my_align_center">兑换积分</th>
                            <th width="10%" class="my_align_center">库存</th>
                            <th width="10%" class="my_align_center">兑换总量</th>
                            <th width="10%" class="my_align_center">状态</th>
                            <th width="10%" class="my_align_center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data as $item){?>
                        <tr>
                            <td>
                                <div class="media">
                                    <a href="#" class="pull-left">
                                        <img alt="" src="/upload/<?php echo $item['thumbnail_rul']?>" width="110" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $item['name']?></h4>
                                        <p><?php echo $item['title']?></p>
                                        <p class="my_color_grey">发布时间：<?php echo $item['create_at']?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="my_align_center"><?php echo $item['category_name']?></td>
                            <td class="my_align_center"><?php echo $item['score']?></td>
                            <td class="my_align_center"><?php echo $item['stock_num']?></td>
                            <td class="my_align_center"><?php echo $item['exchange_num']?></td>
                            <td class="my_align_center"><?php echo $item['status']?></td>
                            <td class="my_align_center" sId="<?php echo $item['id']?>">
                                <a class="edit my_edit" href="/admin/product_manage/get_product_by_id?sId=<?php echo $item['id']?>">编辑</a>
                                <a class="edit my_edit" href="/admin/product_manage/delete_product?sId=<?php echo $item['id']?>">删除</a><br>
                                <button class="btn black mini">复制链接</button>
                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div class="span6 pull-right">
                        <div class="dataTables_paginate paging_bootstrap pagination" style="overflow:hidden; margin-top:0px">
                            <ul style="float:right">
                                <?php echo $pager?>
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
</body>
<!-- END BODY -->
</html>