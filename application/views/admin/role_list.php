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
	<div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP -->
        <?php include 'top.php';?>
        <!-- END TOP -->
	</div>
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
							PG管理<small>角色列表</small>
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
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
								<thead>
								<tr>
									<th width="30%">角色名称</th>
									<th width="50%" class="my_align_center">角色描述</th>
									<th width="20%" class="my_align_center">操作</th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach($role_list as $role) { ?>
								<tr >
									<td><?php echo $role['role_name']?></td>
									<td class="my_align_center"><?php echo $role['description']?></td>
									<td class="my_align_center">
										<a class="edit my_edit" href="/admin/permission_manage/edit_role/<?php echo $role['id']?>">编辑</a>
										<a class="edit my_edit operate_delete" extra-data="1" data-toggle="modal"
										href="#confirm">删除</a>
										<!--/admin/permission_manage/delete_role/<?php echo $role['id']?>-->
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


                            <div id="confirm" class="modal hide fade" tabindex="-1" role="dialog"
							aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h3 id="myModalLabel">确认</h3>
								</div>
								<div class="modal-body">
									<p>是否删除？</p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
									<button data-dismiss="modal" class="btn red">确认</button>
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
    			//delete
    			$('.operate_delete').click(function(){
    				var sId=$(this).attr('extra-data');
    				var self=this;
    				$('#confirm').find('button.red').unbind().bind('click',function(){

    					if($(self).hasClass('grey')){return}
    					$(self).addClass('grey');
    					$.ajax({
    						type:'post',
    						url:'/admin/product_manage/delete_product',
    						data:{
    							sId:sId
    						},
    						dataType:'json',
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