<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php include "header.php"?>
    <link href="/static/admin/css/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="/static/admin/image/favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed <?php if($user_info['menu_status'] == "0") { ?> page-sidebar-closed <?php } ?>">
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
                        <span class="pull-right" style="font-size:30px"><a class="my_back" href="/admin/product_manage/list_products">返回</a></span>
                    </h3>

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <div class="portlet-body">
                        <form action="/admin/product_manage/add_product" class="form-horizontal" id="add_goods" method="post" enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label my_form_label">
                                    <select class="small m-wrap" tabindex="1" name="type">
                                        <option value="">请选择分类</option>
                                        <?php foreach($category as $category){?>
                                            <option value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
                                        <?php }?>
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
                                    <input type="text" name="title" class="span6 m-wrap" placeholder="商品简介（限20字）" name="title"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请选择图片：</label>
                                <div class="controls">
                                    <div class="fileupload fileupload-new span6" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <i class="icon-file fileupload-exists"></i>
                                                <span class="fileupload-preview" name="image_url"></span>
                                            </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择图片</span>
													<span class="fileupload-exists">更改</span>
													<input type="file" class="default" id="img_file"/>
													</span>
                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="image"/>
                                    <input type="hidden" name="thumb">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <!--progress-->
                            <div class="control-group" style="display:none" id="progress">
                                <label class="control-label my_color_grey"></label>
                                <div class="controls">
                                    <div class="progress progress-striped progress-success active span6"
                                         style="min-height:20px; margin-top:-15px">
                                        <div style="width: 0%;" class="bar" id="progress_bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">请选择规格：</label>
                                <div class="controls">
                                    <div class="my_product_line">
                                        <select class="small m-wrap" tabindex="1">
                                            <option value="">请选择规格</option>
                                            <?php foreach($specification as $spec){?>
                                            <option value="<?php echo $spec['spec_id']?>"><?php echo $spec['spec_name']?></option>
                                            <?php }?>
                                        </select>
                                        &nbsp;&nbsp;&nbsp;&nbsp;尊享价：<input type="text" class="span1 m-wrap my_align_center"/>积分
                                        &nbsp;&nbsp;&nbsp;&nbsp;库存：<input type="text" class="span1 m-wrap my_align_center"/>件
                                        <span class="help-inline"></span>
                                    </div>
                                    <a class="edit my_edit" href="javascript:void(0)" id="add_size_line">+添加规格</a>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red"></label>
                                <div class="controls">
                                    <input type="hidden" name="total" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_red">是否为线下商品：</label>
                                <div class="controls" style="line-height:30px; margin-bottom:10px">
                                    <label class="checkbox">
                                        <input type="checkbox" id="is_store" value="1"
                                        name="is_exchange"/><span>（点击显示门店列表）</span>
                                    </label>
                                </div>
                                <div class="controls" id="store_show" style="display:none">
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
                            <div class="control-group">
                                <label class="control-label my_color_grey">请输入详细描述：</label>
                                <div class="controls">
                                    <textarea class="span6 m-wrap" rows="3" placeholder="详细描述" name="description"></textarea>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label my_color_grey">上架：</label>
                                <div class="controls" style="line-height:30px">
                                    <label class="checkbox">
                                        <input type="checkbox" value="1"
                                        name="status" /><span>（此为选填项，勾选后商品同步上架）</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn black" id="submit">确 定</button>
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
            totalSize=totalSize.join('-');
            console.log(totalSize);
            if(totalSize.indexOf('null')>=0){
                totalSize=''
            }
            $('[name=total]').val(totalSize);
            $('#add_goods').submit()
        });
        $('#add_goods').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                type:{
                    required: true
                },
                name: {
                    required: true
                },
                image: {
                    required: true
                },
                total:{
                    required: true
                }
            },
            messages: {
                type:{
                    required: '请选择分类'
                },
                name:{
                    required: "名称不能为空"
                },
                image: {
                    required: ''
                },
                total:{
                    required: '规格填写不完整'
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
        });

        //upload
        $('#img_file').change(function(e){
            if($(this).val()){
                var xhr = new XMLHttpRequest();
                var upload = xhr.upload;
                var file= this.files[0];
                upload.addEventListener("progress", function(e){
                    if (e.lengthComputable) {
                        $('#progress').fadeIn(500);
                        var percentage = Math.round((e.loaded * 100) / e.total);
                        $('#progress_bar').width(percentage+'%');
                        if(percentage>=100){
                            $('#progress').fadeOut(500);
                        }
                    }
                }, false);
                xhr.onreadystatechange=function(){
                    if(xhr.readyState==4&&xhr.status==200){
                        var json=eval('('+xhr.response+')');
                        $('[name=image]').val(json.image);
                        $('[name=image]').after('<img class="show_pic" style=" display:block; max-width:120px;max-height:120px"src='+json.image+'/>');
                        $('[name=thumb]').val(json.thumb);
                        if($('[name=image]').attr('extra-data')&&$('[name=thumb]').attr('extra-data')){
                            $.ajax({
                                type:'post',
                                url:'/admin/product/unlink_product_image',
                                data:{
                                    image:$('[name=image]').attr('extra-data'),
                                    thumb:$('[name=thumb]').attr('extra-data')
                                },
                                dataType:'json',
                                success:function(data){
                                    if(!data.error){
                                        $('[name=image]').attr('extra-data',json.image);
                                        $('[name=thumb]').attr('extra-data',json.thumb)
                                    }
                                }
                            })
                        }else{
                            $('[name=image]').attr('extra-data',json.image);
                            $('[name=thumb]').attr('extra-data',json.thumb)
                        }
                    }
                }
                xhr.open("POST", '/admin/product_manage/upload_product_image', true);
                xhr.sendAsBinary(file)
            }else{
                $('.show_pic').remove();
                if($('[name=image]').attr('extra-data')&&$('[name=thumb]').attr('extra-data')){
                    $.ajax({
                        type:'post',
                        url:'/admin/product/unlink_product_image',
                        data:{
                            image:$('[name=image]').attr('extra-data'),
                            thumb:$('[name=thumb]').attr('extra-data')
                        },
                        dataType:'json',
                        success:function(data){
                            if(!data.error){
                                $('[name=image]').attr('extra-data','');
                                $('[name=thumb]').attr('extra-data','')
                            }
                        }
                    })
                }else{
                    $('[name=image]').attr('extra-data','');
                    $('[name=thumb]').attr('extra-data','')
                }
            }
        });

        XMLHttpRequest.prototype.sendAsBinary = function(file) {
            var formData2 = new FormData();
            formData2.append('file',file);
            this.send(formData2)
        }

        $('#is_store').change(function(){
            if($(this).attr('checked')){
                $('#store_show').show()
            }else{
                $('#store_show').hide()
            }
        })
    })
</script>
</body>
<!-- END BODY -->
</html>