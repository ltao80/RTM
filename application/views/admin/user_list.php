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
	<!-- BEGIN HEADER -->
    <?php include 'top.php';?>
	<!-- END HEADER -->
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
							PG管理<small>PG列表</small>
							<span class="pull-right" style="font-size:30px"><a class="my_back" href="#">返回</a></span>
						</h3>
						<form action="/admin/user_manage/list_user" method="get" novalidate="novalidate"
						style="margin-bottom:0">
						<ul class="breadcrumb my_select_list" style="margin-bottom:0px">

							<li>
								<select class="small m-wrap my_form_item" tabindex="1" name="province">
									<option value="">请选择省</option>
                                    <?php foreach($provinces as $province){?>
                                        <option value="<?php echo $province ?>"><?php echo $province ?></option>
                                    <?php }?>
								</select>
							</li>
							<li>
								<select class="small m-wrap my_form_item" tabindex="2" name="city">
									<option value="">请选择市</option>
								</select>
							</li>
							<li>
								<select class="small m-wrap my_form_item" tabindex="3" name="region">
									<option value="">请选择区</option>
								</select>
							</li>
							<li>
								<select class="small m-wrap my_form_item" tabindex="4" name="store">
									<option value="">请选择门店</option>
								</select>
								<input type="hidden" name="store_name" class="my_form_item" />
							</li>
							<li>
								<input type="text" data-required="1" placeholder="* 请输入PG姓名" class="m-wrap small
								required my_form_item"
									   name="name">
							</li>
							<li><button type="submit" class="btn blue" style="margin-left:10px">搜 索</button></li>
							<a class="btn red pull-right" href="/admin/user_manage/new_user" style="color:#fff; margin-right:10px">新 建</a>
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
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
								<thead>
								<tr>
									<th width="15%">姓名</th>
									<th width="15%">手机号码</th>
									<th width="15%">电子邮箱</th>
									<th width="30%">省/市-门店</th>
									<th width="10%" class="my_align_center">状态</th>
									<th width="15%" class="my_align_center">操作</th>
                                    </tr>
								</thead>
								<tbody>
                                <?php foreach($user_info_list as $user_info) { ?>
								<tr >
									<td><?php echo $user_info['name'] ?></td>
									<td><?php echo $user_info['phone'] ?></td>
									<td><?php echo $user_info['email'] ?></td>
									<td><?php echo $user_info['province'] ?>/<?php echo $user_info['city'] ?>-<?php echo $user_info['store_name'] ?></td>
                                    <?php if($user_info['province'] == 0 ) { ?>
									<td class="my_align_center">正常</td>
                                    <?php } else { ?>
                                        <td class="my_align_center">冻结</td>
                                    <?php } ?>
									<td class="my_align_center">
                                        <?php if($user_info['province'] == 0 ) { ?>
                                            <a class="edit my_edit operate_status" href="#confirm" extra-data="1">冻结</a>
                                        <?php } else { ?>
                                            <a class="edit my_edit operate_status" href="#confirm" extra-data="1">解冻</a>
                                        <?php } ?>
										<a class="edit my_edit" href="/admin/user_manage/edit_user/<?php echo$user_info['id'] ?>">修改</a>
                                        <a class="edit my_edit operate_delete" href="#confirm2" extra-data="1">删除</a>
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

    <!-- BEGIN BOTTOM -->
    <?php include 'bottom.php'?>
    <!-- END BOTTOM -->

	<!--page js-->
	<script>
		jQuery(document).ready(function() {
			//change status
			$('.operate_status').click(function(){
				var sId=$(this).attr('extra-data');
				var self=this;
				$('#confirm').find('button.red').unbind().bind('click',function(){

					if($(self).hasClass('grey')){return}
					$(self).addClass('grey');
					if($.trim($(self).text())=='冻结'){
						$.ajax({
							type:'post',
							url:'/admin/product_manage/update_exchange_status',
							data:{
								sId:sId,
								status:1
							},
							success:function(data){
								if(!data.error){
									$(self).text('解冻').removeClass('grey');
									$(self).parent().prev().text('冻结')
								}else{
									$(self).removeClass('grey')
								}
							},
							error:function(){
								$(self).removeClass('grey')
							}
						})
					}else{
						$.ajax({
							type:'post',
							url:'/admin/product_manage/update_exchange_status',
							data:{
								sId:sId,
								status:0
							},
							success:function(data){
								if(data){
									$(self).text('冻结').removeClass('grey');
									$(self).parent().prev().text('正常')
								}else{
									$(self).removeClass('grey')
								}
							},
							error:function(){
								$(self).removeClass('grey')
							}
						})
					}

				})

			});

			//delete
			$('.operate_delete').click(function(){
				var sId=$(this).attr('extra-data');
				var self=this;
				$('#confirm2').find('button.red').unbind().bind('click',function(){

					if($(self).hasClass('grey')){return}
					$(self).addClass('grey');
					$.ajax({
						type:'post',
						url:'/admin/product_manage/delete_product',
						data:{
							sId:sId
						},
						success:function(data){
							if(!data.error){
								$(self).parents('tr').remove()
							}else{
								$(self).removeClass('grey')
							}
						},
						error:function(){
							$(self).removeClass('grey')
						}
					})

				})

			})

		});
	</script>
</body>
<!-- END BODY -->
</html>