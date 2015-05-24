<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>Metronic | Admin Dashboard Template</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="media/css/my-style.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="shortcut icon" href="media/image/favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.html">
				<img src="media/image/logo.png" alt="logo"/>
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="media/image/menu-toggler.png" alt="" />
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<ul class="nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="javascript:void(0)" style="background:none!important" class="dropdown-toggle my_nobg">
							<span class="username my_header_span">华东地区</span>
						</a>
					</li>
					<li class="dropdown user">
						<a href="#" style="background:none!important" class="dropdown-toggle my_nobg">
						<span class="username my_header_span my_underline">退出</span>
						</a>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu">
				<li style="margin-bottom:15px">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start active ">
					<a href="index.html">
					<i class="icon-home"></i>
					<span class="title">PG管理</span>
					<span class="selected"></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class="active"><a href="index.html">新建</a></li>
						<li><a href="index.html">PG列表</a></li>
					</ul>
				</li>
				<li class="">
					<a href="javascript:;">
					<i class="icon-cogs"></i>
					<span class="title">查看订单</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
						<li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
						<li ><a href="layout_horizontal_sidebar_menu.html">子菜单</a></li>
					</ul>
				</li>
				<li class="">
					<a href="index.html">
						<i class="icon-home"></i>
						<span class="title">PG管理</span>
						<span class="selected"></span>
					</a>
				</li>
				<li class="">
					<a href="index.html">
						<i class="icon-home"></i>
						<span class="title">PG管理</span>
						<span class="selected"></span>
					</a>
				</li>
			</ul>
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
											<option value="Category 1">Category 1</option>
											<option value="Category 2">Category 2</option>
											<option value="Category 3">Category 5</option>
											<option value="Category 4">Category 4</option>
										</select>
										<select class="small m-wrap" tabindex="2" name="city">
											<option value="">请选择市</option>
											<option value="Category 1">Category 1</option>
											<option value="Category 2">Category 2</option>
											<option value="Category 3">Category 5</option>
											<option value="Category 4">Category 4</option>
										</select>
										<select class="small m-wrap" tabindex="3" name="region">
											<option value="">请选择区</option>
											<option value="Category 1">Category 1</option>
											<option value="Category 2">Category 2</option>
											<option value="Category 3">Category 5</option>
											<option value="Category 4">Category 4</option>
										</select>
										<select class="small m-wrap" tabindex="4" name="store">
											<option value="">请选择门店</option>
											<option value="Category 1">Category 1</option>
											<option value="Category 2">Category 2</option>
											<option value="Category 3">Category 5</option>
											<option value="Category 4">Category 4</option>
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
	<script src="media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="media/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="media/js/excanvas.min.js"></script>
	<script src="media/js/respond.min.js"></script>
	<![endif]-->
	<script src="media/js/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="media/js/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="media/js/app.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {
			App.init(); // initlayout and core plugins
		});
	</script>




	<!--page js-->
	<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
	<script src="media/js/form-validation.js"></script>
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
					email: {
						required: true,
						email: true
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
					email:{
						required: "邮箱不能为空",
						email:"请输入合法的邮箱地址"
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
					$(element).next().text('')
				}
			});
		});
	</script>
</body>
<!-- END BODY -->
</html>