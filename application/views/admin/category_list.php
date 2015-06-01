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
                        分类管理<small>分类列表</small>
                        <span class="pull-right" style="font-size:30px;display: none"><a class="my_back" href="#">返回</a></span>
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
                                <th width="70%">类别名称</th>
                                <th width="30%" class="my_align_center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($category as $item){?>
                            <tr>
                                <td><?php echo $item['name']?></td>
                                <td class="my_align_center">
                                    <a class="edit my_edit" href="/admin/product_manage/new_category?category_id=<?php echo $item['id']?>">编辑</a>
                                    <a class="edit my_edit operate_delete" extra-data="<?php echo $item['id']?>" href="#confirm"
                                       data-toggle="modal">删除</a>
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
<script>
    jQuery(document).ready(function() {
        //delete
        $('.operate_delete').click(function(){
            var category_id=$(this).attr('extra-data');
            var self=this;
            $('#confirm').find('button.red').unbind().bind('click',function(){

                if($(self).hasClass('grey')){return}
                $(self).addClass('grey');
                $.ajax({
                    type:'post',
                    url:'/admin/product_manage/delete_category',
                    data:{
                        category_id:category_id
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