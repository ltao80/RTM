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
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/user_info">返回</a></span>
						</h3>
                        <h3>openID:<?php if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id']; }?><span class="my_color_red pull-right">当前积分：<?php if(isset($customer_info['total_score'])){echo $customer_info['total_score']; }?>积分</span></h3>
						<form>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px; padding-bottom:0;
						padding-left:10px">
								<li>购买日期：
									<input type="text" data-required="1" placeholder="起始日期"
										   class="m-wrap small required timePicker my_form_item" name="date_start2">
									<span>-</span>
									<input type="text" data-required="1" placeholder="截止日期"
										   class="m-wrap small required timePicker my_form_item" name="date_end2">
								</li>
							</ul>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px; padding-bottom:0;
						padding-left:10px">
								<li>所在省市：
									<select class="small m-wrap province my_form_item" tabindex="1" name="province">
										<option value="">请选择省</option>
                                        <?php foreach($province as $p1){?>
                                            <option value="<?php echo $p1;?>"><?php echo $p1;?></option>
                                        <?php }?>
									</select>
									<span>-</span>
									<select class="small m-wrap city my_form_item" tabindex="1" name="city">
										<option value="">请选择市</option>
									</select>
								</li>
								<li style="margin-left:10px">出生日期：
									<input type="text" data-required="1" placeholder="出生日期"
										   class="m-wrap small required timePicker my_form_item" name="birthday">
								</li>
							</ul>
							<ul class="breadcrumb my_select_list" style=" margin-bottom:0px;
						padding-left:10px">
								<li>购买门店：
                                    <select class="small m-wrap province my_form_item" tabindex="1" name="province2">
                                        <option value="">请选择省</option>
                                        <?php foreach($province as $p2){?>
                                            <option value="<?php echo $p2;?>"><?php echo $p2;?></option>
                                        <?php }?>
                                    </select>
									<span>-</span>
									<select class="small m-wrap city my_form_item" tabindex="1" name="city2">
										<option value="">请选择市</option>
									</select>
									<span>-</span>
									<select class="small m-wrap region my_form_item" tabindex="1" name="region2">
										<option value="">请选择区</option>
									</select>
									<span>-</span>
									<select class="small m-wrap store my_form_item" tabindex="1" name="store2">
										<option value="">请选择门店</option>
									</select>
									<input type="hidden" name="store_name" class="my_form_item" />
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
							<h4>共计<span class="my_number my_color_red"><?php echo $total;?></span>用户</h4>
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
								<thead>
								<tr>
									<th width="70%">个人信息</th>
									<th width="30%" class="my_align_center">更多用户信息</th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach($data as $item){?>
								<tr >
                                    <td><?php if(isset($item['name'])) { echo $item['name'];}?> | <?php if(isset($item['phone'])) { echo $item['phone'];}?><br>生日：<?php if(isset($item['birthday'])) { echo $item['birthday'];}?><br>邮箱：<?php if(isset($item['email'])) { echo $item['email'];}?></td>
									<td class="my_align_center">
										<a class="edit my_edit" href="/admin/customer_manage/user_detail_info?customer_id=1?customer_id=<?php echo $item['id']?>">点击查看更多用户信息</a>
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
			setTimeRange($('[name=date_start1]'),$('[name=date_end1]'));
			setTimeRange($('[name=date_start2]'),$('[name=date_end2]'));
			$('[name=birthday]').datepicker({
				orientation: "left",
				autoclose: true,
				format: "yyyy-mm-dd"
			})
		});
	</script>
</body>
<!-- END BODY -->
</html>