<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed <?php if($user_info['menu_status'] == "0") { ?> page-sidebar-closed <?php } ?>">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
<?php include "top.php"?>

</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php include "navigation.php"?>
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
                    积分兑换商品<small></small>
                    <span class="pull-right" style="font-size:30px;display: none"><a class="my_back" href="/admin/product_manage/list_products">返回</a></span>
                </h3>
                <ul class="breadcrumb my_select_list" style="margin-bottom:0px">

                    <li>
                        <select class="small m-wrap my_filter my_form_item" tabindex="1" name="type">
                            <option value="">请选类别</option>
                            <?php foreach($category as $category){?>
                            <option value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
                            <?php }?>
                        </select>
                    </li>
                    <li>
                        <select class="small m-wrap my_filter my_form_item" tabindex="2" name="status">
                            <option value="">请选状态</option>
                            <option value="0">下架</option>
                            <option value="1">出售中</option>
                        </select>
                    </li>
                    <a class="btn black my_btn pull-right" href="/admin/product_manage/new_product" style="color:#fff; margin-right:10px">添加兑换商品</a>
                </ul>
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
                            <th width="30%">兑换商品信息</th>
                            <th width="10%" class="my_align_center">类别</th>
                            <th width="10%" class="my_align_center">兑换积分</th>
                            <th width="10%" class="my_align_center">库存</th>
                            <th width="10%" class="my_align_center">兑换总量</th>
                            <th width="10%" class="my_align_center">状态</th>
                            <th width="10%" class="my_align_center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data as $item){?>
                        <tr>
                            <td>
                                <div class="media">
                                    <a href="/admin/product_manage/get_product_by_id?sId=<?php echo $item['id']?>" class="pull-left">
                                        <img alt="" src="/static/admin/upload/<?php echo $item['thumbnail_url']?>" width="110" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $item['name']?></h4>
                                        <p><?php echo $item['title']?></p>
                                        <p class="my_color_grey">发布时间：<?php echo $item['created_at']?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="my_align_center"><?php echo $item['category_name']?></td>
                            <td class="my_align_center"><?php echo $item['score']?></td>
                            <td class="my_align_center"><?php echo $item['stock_num']?></td>
                            <td class="my_align_center"><?php echo $item['exchange_num']?></td>
                            <td class="my_align_center">
                            <a href="#confirm" class="edit my_edit operate_status" extra-data="<?php echo $item['id']?>"
                            data-toggle="modal">
                            <?php if
                            ($item['status'] == 1){ echo '出售中';}else{ echo '已下架';} ?>
                            </a>
                            </td>
                            <td class="my_align_center">
                                <a class="edit my_edit" href="/admin/product_manage/new_product?sId=<?php echo $item['id']?>">编辑</a>
                                <a class="edit my_edit operate_delete" extra-data="<?php echo $item['id']?>"
                                href="#confirm2" data-toggle="modal">删除</a><br>
                                <div style="position: relative"><button class="btn black mini copyBtn" link="<?php echo $this->config->item('base_url')?>admin/product_manage/get_product_by_id?sId=<?php echo $item['id']?>">复制链接</button></div>

                            </td>
                        </tr>
                        <?php }?>
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
                            <p>是否改变状态？</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                            <button data-dismiss="modal" class="btn red">确认</button>
                        </div>
                    </div>

                    <div id="confirm2" class="modal hide fade" tabindex="-1" role="dialog"
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
<!-- BEGIN FOOTER -->
<?php include "bottom.php"?>

<!--page js-->
<script src="/static/admin/js/jquery.zclip.min.js"></script>
<script>
	jQuery(document).ready(function() {

		$('.copyBtn').each(function(){
			var link=$(this).attr('link');
			$(this).zclip({
				path: "/static/admin/swf/ZeroClipboard.swf",
				copy: function(){
					return link;
				}
			});
		});

        //change status
        $('.operate_status').click(function(){
            var sId=$(this).attr('extra-data');
            var self=this;
            $('#confirm').find('button.red').unbind().bind('click',function(){

                if($(self).hasClass('grey')){return}
                $(self).addClass('grey');
                if($.trim($(self).text())=='已下架'){
                    $.ajax({
                        type:'post',
                        url:'/admin/product_manage/update_exchange_status',
                        data:{
                            sId:sId,
                            status:1
                        },
                        success:function(data){
                            if(!data.error){
                                $(self).text('出售中').removeClass('grey')
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
                                $(self).text('已下架').removeClass('grey')
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