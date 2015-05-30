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
							用户管理<small>录入门店购买订单</small>
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
									<label class="control-label my_color_red">请选择PG门店：</label>
									<div class="controls">
										<select class="small m-wrap" tabindex="1" name="province">
											<option value="">请选择省</option>
                                            <?php foreach($province as $p2){?>
                                                <option value="<?php echo $p2;?>"><?php echo $p2;?></option>
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
								<div class="control-group">
									<label class="control-label my_color_red">购买商品：</label>
									<div class="controls">
										<div class="my_product_line">
											<select class="small m-wrap" tabindex="1">
												<option value="">请选择商品</option>
												<option value="Category 1">Category 1</option>
											</select>
											<select class="small m-wrap" tabindex="1">
												<option value="">请选择规格</option>
												<option value="Category 1">Category 1</option>
											</select>
											<input type="text" class="m-wrap small" placeholder="商品数量" />
											<span class="help-inline"></span>
										</div>
										<a href="javacript:void(0)" id="add_size_line" class="edit my_edit">+新增商品</a>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label my_color_red"></label>
									<div class="controls">
										<input type="hidden" name="total" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn black" id="submit">保 存</button>
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
    <?php include "bottom.php"?>

    <script type="text/javascript" src="/static/admin/js/jquery.validate.min.js"></script>
    <script src="/static/admin/js/form-validation.js"></script>
    <script>
        jQuery(document).ready(function() {
            $('#submit').click(function(e){
                var totalSize=[];
                $('.my_product_line').each(function(){
                    var size=[];
                    $(this).find('.m-wrap').each(function(){
                        var val=$(this).val()?$(this).val():'null';
                        size.push(val)
                    });
                    totalSize.push(size.join(','))
                });
                totalSize=totalSize.join('|');
                console.log(totalSize);
                if(totalSize.indexOf('null')>=0){
                    totalSize=''
                }
                $('[name=total]').val(totalSize);
                $('#add_PG').submit()
            });
            $('#add_PG').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    store: {
                        required: true
                    },
                    total:{
                        required: true
                    }
                },
                messages: {
                    store:{
                        required: "门店不能为空"
                    },
                    total:{
                        required: '商品填写不完整'
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

            var line=$('.my_product_line').eq(0).clone(true);
            var count=1;
            $('#add_size_line').click(function(){
                var l=line.clone(true);
                var del=$('<a href="javascript:void(0)" style="margin-left:20px">删除规格</a>');
                del.click(function(){
                    $(this).parents('.my_product_line').remove()
                });
                l.append(del);
                $(this).before(l)
            })
        });
    </script>
</body>
<!-- END BODY -->
</html>