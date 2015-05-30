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
							用户管理<small>积分详细信息</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/customer_manage/score_info?customer_id=<?php if(isset($customer_info['id'])){echo $customer_info['id']; }?>">返回</a></span>
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
								<h3 class="portlet-title">商品信息</h3>
								<div class="form-horizontal">
                                    <?php if(isset($product_info) && !empty($product_info)) {?>
                                    <?php foreach($product_info as $product){?>
									<div class="control-group">
										<div class="controls">
											<span class="help-inline"><?php if(isset($product['name'])){echo $product['name'];}?> <?php if(isset($product['spec_name'])){echo $product['spec_name'];}?> x<?php if(isset($product['product_num'])){echo $product['product_num'];}?></span>
										</div>
									</div>
                                    <?php }?><?php } ?>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">消费店面</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey"></span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($order_info['store_name'])){echo $order_info['store_name'];}?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">产生积分</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<span class="control-label my_color_grey"></span>
										<div class="controls">
											<span class="help-inline"><?php if(isset($order_info['order_type'])){if($order_info['order_type'] == "1"){echo "消耗积分";}else{echo "获取积分";}}?>：<span><?php if(isset($order_info['order_type'])){if($order_info['order_type'] == "1"){echo "-";}else{echo "+";}}?><?php if(isset($order_info['total_score'])){echo $order_info['total_score'];}?> </i>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body row-fluid my_product_p">
								<h3 class="portlet-title">订单时间</h3>
								<div class="form-horizontal">
									<div class="control-group">
										<div class="controls">
											<span class="help-inline"><i class="my_color_red"> <?php if(isset($order_info['order_datetime'])){echo date('Y-m-d H:i:s',strtotime($order_info['order_datetime']));}?> </i>
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