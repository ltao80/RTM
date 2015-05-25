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
    <?php include "top.php"?>
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php include "navigation.php"?>
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
                        添加/编辑兑换商品<small></small>
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
                        <form action="/admin/product_manage/add_product" class="form-horizontal" id="add_PG">
                            <div class="control-group">
                                <label class="control-label my_form_label">
                                    <select class="small m-wrap" tabindex="1" name="province">
                                        <option value="">请选择分类</option>
                                        <option value="1">Category 1</option>
                                        <option value="2">Category 2</option>
                                        <option value="3">Category 5</option>
                                        <option value="4">Category 4</option>
                                    </select>
                                </label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" placeholder="商品名称" name="name"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_grey">请输入商品简介：</label>
                                <div class="controls">
                                    <input type="text" name="tel" class="span6 m-wrap" placeholder="商品简介（限20字）" name="title"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请选择图片：</label>
                                <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <i class="icon-file fileupload-exists"></i>
                                                <span class="fileupload-preview"></span>
                                            </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择图片</span>
													<span class="fileupload-exists">更改</span>
													<input type="file" class="default" />
													</span>
                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
                                        </div>
                                    </div>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请选择规格：</label>
                                <div class="controls">
                                    <div class="my_product_line">
                                        <select class="small m-wrap" tabindex="1" name="size">
                                            <option value="">请选择分类</option>
                                            <option value="Category 1">Category 1</option>
                                            <option value="Category 2">Category 2</option>
                                            <option value="Category 3">Category 5</option>
                                            <option value="Category 4">Category 4</option>
                                        </select>
                                        &nbsp;&nbsp;&nbsp;&nbsp;尊享价：<input type="text" class="span1 m-wrap my_align_center" name="score"/>积分
                                        &nbsp;&nbsp;&nbsp;&nbsp;库存：<input type="text" class="span1 m-wrap my_align_center" name="num"/>件
                                        <span class="help-inline"></span>
                                    </div>
                                    <a class="edit my_edit" href="javascript:void(0)" id="add_size_line">+添加规格</a>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请输入详细描述：</label>
                                <div class="controls">
                                    <textarea class="span6 m-wrap" rows="3" placeholder="详细描述" name="description"></textarea>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_grey">上架：</label>
                                <div class="controls" style="line-height:30px">
                                    <label class="checkbox">
                                        <input type="checkbox" value="" /><span>（此为选填项，勾选后商品同步上架）</span>
                                    </label>
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
<?php include "bottom.php"?>



<!--page js-->
<script type="text/javascript" src="/static/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/static/admin/js/form-validation.js"></script>
<script type="text/javascript" src="/static/admin/js/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="/static/admin/js/form-components.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#add_PG').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
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

        var line=$('.my_product_line').eq(0).clone(true);
        var count=1;
        $('#add_size_line').click(function(){
            var l=line.clone(true);
            l.find('.m-wrap').each(function(){
                $(this).attr('name',$(this).attr('name')+'_'+count)
            });
            count++;
            var del=$('<a href="javascript:void(0)" style="margin-left:20px">删除规格</a>');
            del.click(function(){
                $(this).parents('.my_product_line').nextAll('.my_product_line').each(function(){
                    $(this).find('.m-wrap').each(function(){
                        var name=$(this).attr('name');
                        $(this).attr('name',name.split('_')[0]+'_'+(name.split('_')[1]-1))
                    })
                });
                $(this).parents('.my_product_line').remove();
                count--
            });
            l.append(del);
            $(this).before(l)
        })
    });
</script>
</body>
<!-- END BODY -->
</html>