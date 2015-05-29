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
							PG管理<small>新建PG</small>
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
							<form action="#" class="form-horizontal" id="add_PG">
								<div class="control-group">
									<label class="control-label my_color_red">请输入PG姓名：</label>
									<div class="controls">
										<input type="text" name="name" class="span6 m-wrap" placeholder="PG姓名" />
										<span class="help-inline"></span>
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
								<div class="control-group">
									<label class="control-label my_color_red">请输入PG手机号：</label>
									<div class="controls">
										<input type="text" name="tel" class="span6 m-wrap" placeholder="PG手机号" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label my_color_red">请输入PG邮箱地址：</label>
									<div class="controls">
										<input type="text" name="email" class="span6 m-wrap" placeholder="PG邮箱地址" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label my_color_red">请选择PG门店：</label>
									<div class="controls">
										<select class="small m-wrap" tabindex="1" name="province">
											<option value="">请选择省</option>
                                            <?php foreach($provinces as $province){?>
											<option value="<?php echo $province ?>"><?php echo $province ?></option>
                                            <?php }?>
										</select>
										<select class="small m-wrap" tabindex="2" name="city">
											<option value="">请选择市</option>
										</select>
										<select class="small m-wrap" tabindex="3" name="region">
											<option value="">请选择区</option>
										</select>
										<select class="small m-wrap" tabindex="4" name="store">
											<option value="">请选择门店</option>
										</select>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="form-actions">
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

	<!-- BEGIN BOTTOM -->
    <?php include 'bottom.php'?>
    <!-- END BOTTOM -->

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
					name: {
						minlength: 2,
						required: true
					},
					password:{
						minlength: 6,
						required: true
					},
					password_again:{
						minlength: 6,
						required: true,
						equalTo:'[name=password]'
					},
					email: {
						required: true,
						email: true,
						remote:'/admin/user_manage/validate_email'
					},
					tel: {
						required: true,
						number: true,
						maxlength:11,
						minlength:11
					},
					store: {
						required: true
					}
				},
				messages: {
					name:{
						required: "姓名不能为空",
						minlength: $.validator.format("不能少于 {0} 个字符")
					},
					password:{
						minlength: $.validator.format("不能少于 {0} 个字符"),
						required: "密码不能为空"
					},
					password_again:{
						minlength: $.validator.format("不能少于 {0} 个字符"),
						required: "密码不能为空",
						equalTo:"两次输入密码不一致"
					},
					email:{
						required: "邮箱不能为空",
						email:"请输入合法的邮箱地址",
						remote:"该邮箱已被注册"
					},
					tel:{
						required: "电话不能为空",
						number:"请输入合法的电话号码",
						maxlength: $.validator.format("不能多于 {0} 位"),
						minlength: $.validator.format("不能少于 {0} 位")
					},
					store:{
						required: "门店不能为空"
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
				}
			});
		});
	</script>
</body>
<!-- END BODY -->
</html>