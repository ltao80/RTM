<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>

	<!--page css-->
	<link href="media/css/datepicker3.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="shortcut icon" href="media/image/favicon.ico" />
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
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
						</h3>
						<h3>openID:12312434<span class="my_color_red pull-right">当前积分：500积分</span></h3>
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
									<input type="text" data-required="1" placeholder="请输入商品名称" class="m-wrap small required" name="name">
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
									<th width="20%">商品信息</th>
									<th width="20%" class="my_align_center">日期</th>
									<th width="15%" class="my_align_center">是否扫码</th>
									<th width="15%" class="my_align_center">获得/消耗积分</th>
									<th width="30%" class="my_align_center">备注</th>
								</tr>
								</thead>
								<tbody>
								<tr >
									<td>
										草泥马矿泉水 × 1<br>
										草泥马伏特加 × 1<br>
										矮人烈酒 × 10
									</td>
									<td class="my_align_center">2015-04-21 10:30</td>
									<td class="my_align_center">是</td>
									<td class="my_align_center"><span class="my_color_red">150</span></td>
									<td class="my_align_center">卧槽尼码是什么编码，在什么场景下使用？</td>
								</tr>
								<tr >
									<td>
										草泥马矿泉水 × 1<br>
										草泥马伏特加 × 1<br>
										矮人烈酒 × 10
									</td>
									<td class="my_align_center">2015-04-21 10:30</td>
									<td class="my_align_center">是</td>
									<td class="my_align_center"><span>-150</span></td>
									<td class="my_align_center">卧槽尼码是什么编码，在什么场景下使用？</td>
								</tr>
								<tr >
									<td>
										草泥马矿泉水 × 1<br>
										草泥马伏特加 × 1<br>
										矮人烈酒 × 10
									</td>
									<td class="my_align_center">2015-04-21 10:30</td>
									<td class="my_align_center">是</td>
									<td class="my_align_center"><span class="my_color_red">150</span></td>
									<td class="my_align_center">卧槽尼码是什么编码，在什么场景下使用？</td>
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