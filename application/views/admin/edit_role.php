<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include 'header.php';?>
    <!--page css-->
    <link href="/static/admin/css/jquery.nestable.css" rel="stylesheet" type="text/css"/>
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
						<form class="form-horizontal" id="PG_form" action="/admin/permission_manage/save_role/<?php echo $role_info['id'] ?>" method="post">
						<div class="portlet-body">
							<div class="control-group">
								<label class="control-label my_color_red">请输入角色名称：</label>
								<div class="controls">
									<input type="text" class="span6 m-wrap" placeholder="角色名称" name="name" value="<?php echo $role_info['role_name'] ?>"/>
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label my_color_grey">请输入角色描述：</label>
								<div class="controls">
									<textarea class="span6 m-wrap" rows="3" placeholder="角色描述" name="describe" alue="<?php echo $role_info['description'] ?>"></textarea>
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
                                    <?php foreach($role_info['permissions'] as $main_menu) { ?>
									<li class="dd-item" data-id="<?php echo $main_menu['id'] ?>">
										<div class="dd-handle controls">
											<label class="checkbox">
												<input type="checkbox" <?php if($main_menu['selected']){ ?> checked='checked' <?php } ?>  extra-data="<?php echo $main_menu['permission_code'] ?>" />
												<span> <?php echo $main_menu['menu_name'] ?></span>
											</label>
										</div>
										<ol class="dd-list">
                                            <?php foreach($main_menu['sub_menu'] as $sub_menu) { ?>
											<li class="dd-item" data-id="<?php echo $sub_menu['id'] ?>">
												<div class="dd-handle controls">
													<label class="checkbox">
														<input type="checkbox" <?php if($sub_menu['selected']){ ?> checked='checked' <?php } ?> extra-data="<?php echo $sub_menu['permission_code'] ?>" />
														<span> <?php echo $sub_menu['menu_name'] ?></span>
													</label>
												</div>
											</li>
                                            <?php } ?>
										</ol>
									</li>
                                    <?php } ?>
								</ol>
							</div>
							<div class="control-group">
								<label class="control-label my_color_red"></label>
								<div class="controls">
									<span class="help-inline my_color_red" id="tree_error"></span>
								</div>
							</div>
							<input type="hidden" name="permissions" id="tree_list" />
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
	<script src="/static/admin/js/app.js" type="text/javascript"></script>
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
                    permissions: {
						required: true
					}
				},
				messages: {
					name:{
						required: "角色名称不能为空",
						minlength: $.validator.format("角色名不能少于 {0} 个字符")
					},
                    permissions:{
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