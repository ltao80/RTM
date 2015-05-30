<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>

	<!--page css-->
	<link href="/static/admin/css/datepicker3.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="shortcut icon" href="/static/admin/image/favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
        <?php include "top.php"?>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
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
							用户管理<small>兑换订单</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/user_detail_info?customer_id=<?php if(isset($customer_info['id'])){echo $customer_info['id']; }?>">返回</a></span>
						</h3>
						<form>
							<ul class="breadcrumb my_select_list" style="overflow:hidden; margin-bottom:0px">
								<button class="btn black my_btn pull-right"
								   style="color:#fff; margin:0 10px 0 10px">搜 索</button>
								<li class="pull-right">
									<input type="text" data-required="1" placeholder="区间结束日期"
										   class="m-wrap small required" id="time_end" name="time_end">
								</li>
								<li class="pull-right">
									<input type="text" data-required="1" placeholder="区间起始日期"
										   class="m-wrap small required" id="time_start" name="time_start">
								</li>
								<li class="pull-right">
									<input type="text" data-required="1" placeholder="* 请输入商品名称"
										   class="m-wrap small required" name="name">
								</li>
                                <input type="hidden" name="customer_id" value="<?php if(isset($customer_id)) { echo $customer_id;}  ?>"/>
							</ul>
						</form>
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
									<th width="20%">兑换商品信息</th>
                                    <th width="15%" class="my_align_center">订单号</th>
                                    <th width="15%" class="my_align_center">运单号</th>
									<th width="15%" class="my_align_center">消耗积分</th>
									<th width="15%" class="my_align_center">兑换时间</th>
									<th width="15%" class="my_align_center">邮寄地址</th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach($data as $item){?>
								<tr >
									<td>
										<div class="media">
											<a href="#" class="pull-left">
												<img alt="" src="<?php if(isset($item['thumbnail_url'])){echo $item['thumbnail_url'];}?>" width="110" class="media-object">
											</a>
											<div class="media-body">
												<h4 class="media-heading"><?php if(isset($item['name'])){ echo $item['name']; }?></h4>
												<h4 class="my_color_grey"><?php if(isset($item['spec_name'])){ echo $item['spec_name'];}?> × <?php echo $item['product_num']?></h4>
											</div>
										</div>
									</td>
                                    <td class="my_align_center"><?php if(isset($item['order_code'])){echo $item['order_code'];}?></td>
                                    <td class="my_align_center"><?php if(isset($item['delivery_order_code'])){echo $item['delivery_order_code'];}?></td>
									<td class="my_align_center"><?php if(isset($item['total_score'])){echo $item['total_score'];}?></td>
									<td class="my_align_center"><?php if(isset($item['order_datetime'])){echo $item['order_datetime'];}?></td>
									<td class="my_align_center">
                                        <?php if(isset($item['receiver_name'])){echo $item['receiver_name'];}?> <?php if(isset($item['receiver_phone'])){echo $item['receiver_phone'];}?><br>
                                        <?php if(isset($item['receiver_province'])){echo $item['receiver_province'];}?>/<?php if(isset($item['receiver_city'])){echo $item['receiver_city'];}?>/ <?php if(isset($item['receiver_region'])){echo $item['receiver_region'];}?> <?php if(isset($item['receiver_address'])){echo $item['receiver_address'];}?>
									</td>
								</tr>
                                <?php } ?>
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