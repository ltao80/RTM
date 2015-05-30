<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include 'header.php';?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
<!-- BEGIN TOP -->
<?php include 'top.php';?>
<!-- END TOP -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
        <!-- BEGIN NAVIGATION -->
        <?php include 'navigation.php';?>
        <!-- END NAVIGATION -->
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
							PG管理<small>修改密码</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
						</h3>

						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="portlet-body">
							<form action="/admin/user_manage/update_password" method="post" class="form-horizontal" id="add_PG">
								<div class="control-group">
									<label class="control-label my_color_grey">PG姓名：</label>
									<div class="controls">
										<span class="help-inline"><?php echo $user_name ?></span>
									</div>
								</div>
                                <div class="control-group">
                                    <label class="control-label my_color_grey">PG邮箱：</label>
                                    <div class="controls">
                                        <span class="help-inline"><?php echo $email ?></span>
                                    </div>
                                </div>
								<div class="control-group">
									<label class="control-label my_color_red">请输入PG登录密码：</label>
									<div class="controls">
										<input type="password" name="password" class="span6 m-wrap" placeholder="登录密码" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label my_color_red">请再次输入PG登录密码：</label>
									<div class="controls">
										<input type="password" name="password_again" class="span6 m-wrap"
											   placeholder="重复密码" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="form-actions">
                                    <input type="hidden"  name="user_id" value="<?php $user_id ?>">
									<button type="submit" class="btn black">确 定</button>
									<button type="reset" class="btn">重 置</button>
								</div>
							</form>
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
	<div class="footer">
		<div class="footer-inner">
			2015 &copy; 互赢网络
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<!--common js-->
	<script src="/static/admin/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="/static/admin/js/excanvas.min.js"></script>
	<script src="/static/admin/js/respond.min.js"></script>
	<![endif]-->
	<script src="/static/admin/js/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="/static/admin/js/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/app.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {
			App.init(); // initlayout and core plugins
		});
	</script>




	<!--page js-->
	<script type="text/javascript" src="/static/admin/js/jquery.validate.min.js"></script>
	<script src="/static/admin/js/form-validation.js"></script>
	<script>
		jQuery(document).ready(function() {
			$('#add_PG').validate({
				errorElement: 'span', //default input error message container
				errorClass: 'error', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "",
				rules: {
					password:{
						minlength: 6,
						required: true
					},
					password_again:{
						minlength: 6,
						required: true,
						equalTo:'[name=password]'
					}
				},
				messages: {
					password:{
						minlength: $.validator.format("不能少于 {0} 个字符"),
						required: "密码不能为空"
					},
					password_again:{
						minlength: $.validator.format("不能少于 {0} 个字符"),
						required: "密码不能为空",
						equalTo:"两次输入密码不一致"
					}
				},
				errorPlacement: function(error, element) {
					element.next().text(error.text())
				},
				highlight: function (element) { // hightlight error inputs
					$(element).closest('.help-inline').removeClass('ok'); // display OK icon
					$(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
				},
				unhighlight: function (element) { // revert the change dony by hightlight
					$(element).closest('.control-group').removeClass('error'); // set error class to the control group
					$(element).next('span').text('')
				},
			});



		});
	</script>
</body>
<!-- END BODY -->
</html>