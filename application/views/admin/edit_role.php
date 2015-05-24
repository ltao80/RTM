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

	<!--page css-->
	<link href="media/css/jquery.nestable.css" rel="stylesheet" type="text/css"/>

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
					<span class="title">角色管理</span>
					<span class="selected"></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class="active"><a href="index.html">新建</a></li>
						<li><a href="index.html">角色列表</a></li>
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
							PG管理<small>权限控制</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
						</h3>

						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<form class="form-horizontal" id="PG_form" action="" method="post">
						<div class="portlet-body">
							<div class="control-group">
								<label class="control-label my_color_red">请输入角色名称：</label>
								<div class="controls">
									<input type="text" class="span6 m-wrap" placeholder="角色名称" name="name" />
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label my_color_grey">请输入角色描述：</label>
								<div class="controls">
									<textarea class="span6 m-wrap" rows="3" placeholder="角色描述" name="describe"></textarea>
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label my_color_red">请选择菜单项：</label>
								<div class="controls">
									<span class="help-inline"></span>
								</div>
							</div>
						</div>
						<div class="portlet-body" style=" margin-top:-49px; margin-left:0; padding-right:20px">

							<div class="dd" id="nestable_list_1">
								<ol class="dd-list">

									<li class="dd-item" data-id="1">
										<div class="dd-handle controls">
											<label class="checkbox">
												<input type="checkbox" extra-data="1" />
												<span> PG管理</span>
											</label>
										</div>
										<ol class="dd-list">
											<li class="dd-item" data-id="2">
												<div class="dd-handle controls">
													<label class="checkbox">
														<input type="checkbox" extra-data="2" />
														<span> 子菜单一</span>
													</label>
												</div>
											</li>
											<li class="dd-item" data-id="3">
												<div class="dd-handle controls">
													<label class="checkbox">
														<input type="checkbox" extra-data="3" />
														<span> 子菜单二</span>
													</label>
												</div>
											</li>
										</ol>
									</li>
									<li class="dd-item" data-id="1">
										<div class="dd-handle controls">
											<label class="checkbox">
												<input type="checkbox" extra-data="4" />
												<span> 卧槽尼玛</span>
											</label>
										</div>
										<ol class="dd-list">
											<li class="dd-item" data-id="2">
												<div class="dd-handle controls">
													<label class="checkbox">
														<input type="checkbox" extra-data="5" />
														<span> 子菜单一</span>
													</label>
												</div>
											</li>
											<li class="dd-item" data-id="3">
												<div class="dd-handle controls">
													<label class="checkbox">
														<input type="checkbox" extra-data="6" />
														<span> 子菜单二</span>
													</label>
												</div>
											</li>
										</ol>
									</li>
									<li class="dd-item" data-id="11">
										<div class="dd-handle controls">
											<label class="checkbox">
												<input type="checkbox" extra-data="7" />
												<span> 哦嗷嗷</span>
											</label>
										</div>
									</li>
									<li class="dd-item" data-id="12">
										<div class="dd-handle controls">
											<label class="checkbox">
												<input type="checkbox" extra-data="8" />
												<span> 嗷嗷</span>
											</label>
										</div>
									</li>
								</ol>
							</div>
							<div class="control-group">
								<label class="control-label my_color_red"></label>
								<div class="controls">
									<span class="help-inline my_color_red" id="tree_error"></span>
								</div>
							</div>
							<input type="hidden" name="tree_list" id="tree_list" />
						</div>

						<div class="form-actions" style="clear:both">
							<button type="submit" class="btn black">保 存</button>
							<button type="reset" class="btn">重 置</button>
						</div>
						</form>

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
			$('#PG_form').validate({
				errorElement: 'span', //default input error message container
				errorClass: 'error', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "",
				rules: {
					name: {
						required: true,
						minlength:2
					},
					tree_list: {
						required: true
					}
				},
				messages: {
					name:{
						required: "角色名称不能为空",
						minlength: $.validator.format("角色名不能少于 {0} 个字符")
					},
					tree_list:{
						required: "请至少选择一个菜单"
					}

				},
				errorPlacement: function(error, element) {
					if(element.attr('name')=='tree_list'){
						$('#tree_error').text(error.text())
					}else{
						element.next().text(error.text())
					}
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

			$('button[type=reset]').click(function(){
				$('input[type=checkbox]').each(function(){
					if($(this).attr('checked')){
						$(this).click()
					}
				})
			});

			$('input[type=checkbox]').change(function(){
				var data=[];
				$('input[type=checkbox]:checked').each(function(){
					data.push($(this).attr('extra-data'))
				})
				if(data.length==0){
					$('#tree_list').val('')
				}else{
					$('#tree_list').val(data)
				}

			})
		});
	</script>
</body>
<!-- END BODY -->
</html>