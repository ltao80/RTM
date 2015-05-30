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
<body class="page-header-fixed page-sidebar-fixed <?php if($user_info['menu_status'] == "0") { ?> page-sidebar-closed <?php } ?>">
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
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
            <?php include "navigation.php"?>
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
						<h3 class="page-title portlet-title">
							用户管理<small>积分信息</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/user_detail_info?customer_id=<?php if(isset($customer_info['id'])){echo $customer_info['id']; }?>">返回</a></span>
						</h3>
						<h3>openID:<?php if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id']; }?><span class="my_color_red pull-right">当前积分：<?php if(isset($customer_info['total_score'])){echo $customer_info['total_score']; }?>积分</span></h3>
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
									<th width="40%" class="my_align_center">日期</th>
									<th width="30%" class="my_align_center">积分</th>
									<th width="30%" class="my_align_center">操作</th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach($data as $item){?>
								<tr >
									<td class="my_align_center"><?php if(isset($item['order_datetime'])) {echo date('Y-m-d H:i:s',strtotime($item['order_datetime'])); }?></td>
									<td class="my_align_center"><span class="my_color_red"><?php if(isset($item['total_score'])){echo $item['total_score'];}?></span></td>
									<td class="my_align_center"><a href="/admin/customer_manage/score_detail_info?order_code=<?php if(isset($item['order_code'])) {echo $item['order_code'];}?>&customer_id=<?php if(isset($customer_id)){echo $customer_id;}?>&order_type=<?php if(isset($item['order_type'])){echo $item['order_type'];}?>">查看记录</a></td>
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