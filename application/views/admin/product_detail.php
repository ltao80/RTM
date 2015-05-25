<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php $this->load->view("header");?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed page-sidebar-closed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <?php $this->load->view("top")?>
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php $this->load->view("navigation")?>
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
            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <div class="portlet-body row-fluid">
                        <div class="span6">
                            <div class="my_pic_show_box">
                                <div class="my_pic_show">
                                    <img src="/upload/<?php echo $data['image_url']?>">

                                </div>
                            </div>
                            <div class="my_pic_preview_box">
                                <ul>
                                    <li class="span2"><img src="/upload/<?php $data['thumbnail_url']?>"> </li>

                                </ul>
                            </div>
                        </div>
                        <div class="span6">
                            <h2><?php echo $data['name']?></h2>
                            <h4><?php echo $data['description']?></h4>
                            <h5 class="my_color_grey"><?php echo $data['title']?></h5>
                            <p style="margin-top:30px">尊享价<span class="my_number my_color_red">777</span>元</p>
                            <p class="my_product_size" spec="<?php echo $data['spec_name']?>">规格：
                                <span class="btn">70CL</span>
                                <span class="btn">1L</span>
                                <span class="btn">1.5L</span>
                                <span class="btn">3L</span>
                            </p>
                            <p>库存：<span class="my_number my_number_small my_color_red"><?php echo $data['stock_num']?></span>件</p>
                        </div>
                    </div>

                    <div class="portlet-body row-fluid my_product_p">
                        <h3 class="portlet-title">产品参数</h3>
                        <p><?php echo $data['description']?></p>
                    </div>

                    <div class="portlet-body row-fluid my_product_p">
                        <h3 class="portlet-title">产品信息</h3>
                        <img src="/upload/<?echo $data['image_url']?>" style="margin-top:30px">
                        <p><?php echo $data['description']?></p>
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
<?php $this->load->view("bottom")?>




<!--page js-->
<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="media/js/form-validation.js"></script>
<script type="text/javascript" src="media/js/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="media/js/form-components.js"></script>
<script>
    jQuery(document).ready(function() {
        $('.my_pic_preview_box li').each(function(){
            $(this).height($(this).width());
            $(this).click(function(){
                $(this).addClass('my_pic_active').siblings().removeClass('my_pic_active');
                $('.my_pic_show img').eq($(this).index()).show().siblings().hide()
            })
        }).eq(0).click();

        $('.my_product_size span').click(function(){
            $(this).addClass('black').siblings().removeClass('black')
        }).eq(0).click();
    });
</script>
</body>
<!-- END BODY -->
</html>