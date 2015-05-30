<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
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
							用户管理<small>更多用户信息</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/user_info">返回</a></span>
						</h3>
                        <h3>openID:<?php if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id']; }?><span class="my_color_red pull-right">当前积分：<?php if(isset($customer_info['total_score'])){echo $customer_info['total_score']; }?>积分</span></h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="portlet-body">
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">会员信息</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey">姓名：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset( $customer_info['name'])) {echo $customer_info['name'] ;}?></span>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">生日：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset( $customer_info['birthday'])) { echo $customer_info['birthday'];} ?></span>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">手机号：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset( $customer_info['phone'])) { echo $customer_info['phone'] ;}?></span>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">邮箱：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset( $customer_info['email'])) { echo $customer_info['email'] ;}?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">邮寄信息</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey">姓名：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($delivery_info['receiver_name'])) {echo $delivery_info['receiver_name'];} ?></span>
											<a href="/admin/customer_manage/post_info?customer_id=<?php echo $customer_info['id'];?>" class="help-inline my_color_red pull-right">点击查看更多地址信息</a>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">手机号：</span>
										<div class="controls">
											<span class="help-inline"><?php  if(isset($delivery_info['receiver_name'])) { echo $delivery_info['receiver_phone'];} ?></span>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">地址：</span>
										<div class="controls">
											<span class="help-inline"><?php  if(isset($delivery_info['receiver_province'])) { echo $delivery_info['receiver_province'] ;}?> <?php  if(isset($delivery_info['receiver_city'])) { echo $delivery_info['receiver_city'];} ?> <?php  if(isset($delivery_info['receiver_region'])) { echo $delivery_info['receiver_region'];} ?><br><?php  if(isset($delivery_info['receiver_address'])) { echo $delivery_info['receiver_address'];} ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">兑换订单</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey">最近一次兑换：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($exchange_info['last_time'])) {echo $exchange_info['last_time'];}?> 消耗<i class="my_color_red"> <?php if(isset($exchange_info['last_score'])) { echo $exchange_info['last_score'];}?> </i>分
											</span>
											<a href="/admin/customer_manage/exchange_info?customer_id=<?php if(isset($customer_info['id'])) {  echo $customer_info['id']; }?>" class="help-inline my_color_red pull-right">点击查看兑换订单详情</a>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">积分兑换次数：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($exchange_info['times'])) {echo $exchange_info['times'];}?> 次 共消耗积分<i class="my_color_red"> <?php if(isset($exchange_info['total_score'])) {echo $exchange_info['total_score']; }?> </i>分
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">积分信息</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey">当前积分：</span>
										<div class="controls">
											<span class="help-inline"><i class="my_color_red"> <?php if(isset($customer_info['total_score'])) { echo $customer_info['total_score']; } ?> </i>分
											</span>
											<a href="/admin/customer_manage/score_info?customer_id=<?php if(isset($customer_info['id'])) {echo $customer_info['id']; }?>" class="help-inline my_color_red pull-right">点击查看积分信息详情</a>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">获取积分次数：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($score_info['times'])) {echo $score_info['times'];}?>  次 获取总积分<i class="my_color_red"> <?php if(isset($score_info['total_score'])) {echo $score_info['total_score'];}?>  </i>分
											</span>
										</div>
									</div>
									<div class="control-group">
										<span class="control-label my_color_grey">消耗积分次数：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($exchange_info['times'])) {echo $exchange_info['times'];}?> 次 消耗总积分<i class="my_color_red"> <?php if(isset($exchange_info['total_score'])) {echo $exchange_info['total_score']; }?></i>分
											</span>
										</div>
									</div>
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
</body>
<!-- END BODY -->
</html>