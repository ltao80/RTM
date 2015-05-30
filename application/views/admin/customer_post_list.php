<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="shortcut icon" href="media/image/favicon.ico" />
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
							用户管理<small>邮寄信息</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/user_detail_info?customer_id=<?php if(isset($customer_info['id'])){echo $customer_info['id']; }?>">返回</a></span>
						</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="portlet-body">
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">openID:<?php if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id'];}?></h3>
								<div class="form-horizontal">
                                    <?php foreach($delivery_info as $item){?>
									<div class="control-group">
										<span class="control-label my_color_grey"><?php if(isset($item['receiver_name'])){echo $item['receiver_name'];}?>：</span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($item['receiver_phone'])){echo $item['receiver_phone'];}?> <?php if(isset($item['receiver_province'])){echo $item['receiver_province'];}?>/<?php if(isset($item['receiver_city'])){echo $item['receiver_city'];}?>/<?php if(isset($item['receiver_region'])){echo $item['receiver_region'];}?> <?php if(isset($item['receiver_address'])){echo $item['receiver_address'];}?></span>
                                            <?php if($item['is_default'] == 1) {?>
											<span class="help-inline my_color_red" style="margin-left:50px">默认地址</span>
                                            <?php } ?>
										</div>
									</div>
                                    <?php } ?>
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