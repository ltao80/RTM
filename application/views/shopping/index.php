<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="target-densitydpi=353,width=800,user-scalable=no">
    <meta name="apple-touch-fullscreen" content="no">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="no">

    <meta name="renderer" content="webkit">

    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>积分商城</title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>static/css/main.css?v=<?php echo $version ?>" />
    <script src="<?php echo base_url()?>static/js/jquery-1.8.3.min.js?v=<?php echo $version ?>"></script>
    <script src="<?php echo base_url()?>static/js/jquery.validVal.min.js?v=<?php echo $version ?>"></script>
    <script src="<?php echo base_url()?>static/js/underscore.js?v=<?php echo $version ?>"></script>
</head>
<body>
    <div class="wrapper" id="wrapper">
        <div id="background"></div>
        <div class="nav_box">
            <div class="nav_li" id="nav_menu_close">
                <span></span>
                <p>我的专区</p>
            </div>
            <a class="nav_li" id="link_to_cart">
                <span></span>
                <p>购物车</p>
            </a>
            <a class="nav_li" id="link_to_query">
                <span></span>
                <p>积分查询</p>
            </a>
            <a class="nav_li" id="link_to_oder">
                <span></span>
                <p>兑换记录</p>
            </a>
            <a class="nav_li" id="link_to_info">
                <span></span>
                <p>个人信息</p>
            </a>
        </div>
        <div id="header">

        </div>
        <div id="main"></div>
    </div>
    <script src="<?php echo base_url()?>static/js/router.js?v=<?php echo $version ?>"></script>
    <script src="<?php echo base_url()?>static/js/main.js?v=<?php echo $version ?>"></script>
</body>
</html>
