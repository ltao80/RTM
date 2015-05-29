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
							会员信息<small></small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
						</h3>
						<form>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px; padding-bottom:0;
						padding-left:10px">
								<li style="margin-left:10px">购买日期：
									<input type="text" data-required="1" placeholder="起始日期"
										   class="m-wrap small required timePicker" name="date_start">
									<span>-</span>
									<input type="text" data-required="1" placeholder="截止日期"
										   class="m-wrap small required timePicker" name="date_end">
								</li>
							</ul>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px; padding-bottom:0;
						padding-left:10px">
								<li>所在省市：
									<select class="small m-wrap province" tabindex="1" name="province">
										<option value="">请选择省</option>
                                        <?php foreach($province as $p1){?>
                                            <option value="<?php echo $p1;?>"><?php echo $p1;?></option>
                                        <?php }?>
									</select>
									<span>-</span>
									<select class="small m-wrap city" tabindex="1" name="city">
										<option value="">请选择市</option>
										<option value="Category 1">Category 1</option>
									</select>
								</li>
								<li style="margin-left:10px">出生日期：
									<input type="text" data-required="1" placeholder="出生日期"
										   class="m-wrap small required timePicker" name="birthday">
								</li>
							</ul>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px;
						padding-left:10px">
								<li>购买门店：
                                    <select class="small m-wrap province" tabindex="1" name="province2">
                                        <option value="">请选择省</option>
                                        <?php foreach($province as $p2){?>
                                            <option value="<?php echo $p2;?>"><?php echo $p2;?></option>
                                        <?php }?>
                                    </select>
									<span>-</span>
									<select class="small m-wrap city" tabindex="1" name="city2">
										<option value="">请选择市</option>
										<option value="Category 1">Category 1</option>
									</select>
									<span>-</span>
									<select class="small m-wrap region" tabindex="1" name="region2">
										<option value="">请选择区</option>
										<option value="Category 1">Category 1</option>
									</select>
									<span>-</span>
									<select class="small m-wrap store" tabindex="1" name="store2">
										<option value="">请选择门店</option>
										<option value="Category 1">Category 1</option>
									</select>
								</li>
								<button class="btn blue my_btn pull-right" style="color:#fff; margin:0 10px">筛选</button>
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
							<h4>共计<span class="my_number my_color_red">5000</span>用户</h4>
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
								<thead>
								<tr>
									<th width="40%">微信信息</th>
									<th width="30%">个人信息</th>
									<th width="30%" class="my_align_center">更多用户信息</th>
								</tr>
								</thead>
								<tbody>
								<tr >
									<td>
										<div class="media">
											<a href="#" class="pull-left">
												<img alt="" src="media/image/5.jpg" width="80" class="media-object">
											</a>
											<div class="media-body">
												<h4 class="media-heading">白兰地少校</h4>
												<p><span class="my_color_red" style="margin-right:10px">男</span>
													天狼星区/旧太阳系/地球</p>
												<p class="my_color_grey">openID 1345453667</p>
											</div>
										</div>
									</td>
									<td>嗷嗷嗷 | 10958905842<br>生日：1999-04-12<br>邮箱：aoaoao@ao.com</td>
									<td class="my_align_center">
										<a class="edit my_edit" href="#">点击查看更多用户信息</a>
									</td>
								</tr>
								<tr >
									<td>
										<div class="media">
											<a href="#" class="pull-left">
												<img alt="" src="media/image/5.jpg" width="80" class="media-object">
											</a>
											<div class="media-body">
												<h4 class="media-heading">白兰地少校</h4>
												<p><span class="my_color_red" style="margin-right:10px">男</span> 天狼星区/旧太阳系/地球</p>
												<p class="my_color_grey">openID 1345453667</p>
											</div>
										</div>
									</td>
									<td>嗷嗷嗷 | 10958905842<br>生日：1999-04-12<br>邮箱：aoaoao@ao.com</td>
									<td class="my_align_center">
										<a class="edit my_edit" href="#">点击查看更多用户信息</a>
									</td>
								</tr>
								<tr >
									<td>
										<div class="media">
											<a href="#" class="pull-left">
												<img alt="" src="media/image/5.jpg" width="80" class="media-object">
											</a>
											<div class="media-body">
												<h4 class="media-heading">白兰地少校</h4>
												<p><span class="my_color_red" style="margin-right:10px">男</span> 天狼星区/旧太阳系/地球</p>
												<p class="my_color_grey">openID 1345453667</p>
											</div>
										</div>
									</td>
									<td>嗷嗷嗷 | 10958905842<br>生日：1999-04-12<br>邮箱：aoaoao@ao.com</td>
									<td class="my_align_center">
										<a class="edit my_edit" href="#">点击查看更多用户信息</a>
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
	<script src="/static/admin/js/bootstrap-datepicker.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {
			setTimeRange($('[name=date_start1]'),$('[name=date_end1]'));
			setTimeRange($('[name=date_start2]'),$('[name=date_end2]'));
			$('[name=birthday]').datepicker({
				orientation: "left",
				autoclose: true
			})
		});
	</script>
</body>
<!-- END BODY -->
</html>