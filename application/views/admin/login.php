<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

    <meta charset="utf-8" />

    <title>Metronic | Login Page</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <meta content="" name="description" />

    <meta content="" name="author" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/style-metro.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/style.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/style-responsive.css" rel="stylesheet" type="text/css"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/uniform.default.css" rel="stylesheet" type="text/css"/>

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->

    <link href="<?php $this->config->item('base_url') ?>/static/admin/css/login.css" rel="stylesheet" type="text/css"/>

    <!-- END PAGE LEVEL STYLES -->

    <link rel="shortcut icon" href="<?php $this->config->item('base_url') ?>/static/admin/image/favicon.ico" />

</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

<!-- BEGIN LOGO -->

<div class="logo">

    <img src="<?php $this->config->item('base_url') ?>/static/admin/image/logo-big.png" alt="" />

</div>

<!-- END LOGO -->

<!-- BEGIN LOGIN -->

<div class="content">

    <!-- BEGIN LOGIN FORM -->

    <form class="form-vertical login-form" method="post" action="<?php $this->config->item('base_url') ?>/admin/user_manage/login">

        <h3 class="form-title">登录</h3>

        <div class="alert alert-error hide">

            <button class="close" data-dismiss="alert"></button>

            <span><?php $error ?></span>

        </div>

        <div class="control-group">

            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

            <label class="control-label visible-ie8 visible-ie9">账号</label>

            <div class="controls">

                <div class="input-icon left">

                    <i class="icon-user"></i>

                    <input class="m-wrap placeholder-no-fix" type="text" placeholder="账号" name="username"/>

                </div>

            </div>

        </div>

        <div class="control-group">

            <label class="control-label visible-ie8 visible-ie9">密码</label>

            <div class="controls">

                <div class="input-icon left">

                    <i class="icon-lock"></i>

                    <input class="m-wrap placeholder-no-fix" type="password" placeholder="密码" name="password"/>

                </div>

            </div>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn green pull-right">

                登录 <i class="m-icon-swapright m-icon-white" style="margin-left:3px; margin-top:2px"></i>

            </button>

        </div>

    </form>

    <!-- END LOGIN FORM -->

</div>

<!-- END LOGIN -->

<!-- BEGIN COPYRIGHT -->

<div class="copyright">

    2015 &copy; 互赢网络.

</div>

<!-- END COPYRIGHT -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery-1.10.1.min.js" type="text/javascript"></script>

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/bootstrap.min.js" type="text/javascript"></script>

<!--[if lt IE 9]>

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/excanvas.min.js"></script>

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/respond.min.js"></script>

<![endif]-->
<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery.uniform.min.js" type="text/javascript" ></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/jquery.validate.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/app.js" type="text/javascript"></script>

<script src="<?php $this->config->item('base_url') ?>/static/admin/js/login.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

<script>

    jQuery(document).ready(function() {

        App.init();

        Login.init();

    });

</script>

<!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->

</html>