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
    <title>登录界面</title>
    <link type="text/css" rel="stylesheet" href="/static/css/main.css" />
    <link type="text/css" rel="stylesheet" href="/static/css/admin.css" />
    <script src="/static/js/jquery-1.8.3.min.js"></script>
    <script src="/static/js/jquery.validVal.min.js"></script>
</head>
<body>
<div class="wrapper" id="wrapper">
    <div id="background" class="background3"></div>
    <div class="product_head">
        <p></p>
        <img src="/static/images/logo.png" />
    </div>
    <div class="main">
        <div class="user-signin-form signin_form signin_form_admin">
            <p>管理员登录</p>
            <form id="admin_form">
                <input type="text" name="account" class="required user-account info_input" placeholder="*请输入用户名">
                <input type="password" name="password" class="required user-password info_input"
                       placeholder="*请输入登录密码">
                <button class="user-signin detail_btn">确认</button>
            </form>
        </div>
    </div>
</div>
<script src="/static/js/main.js"></script>
<script>
    $('#admin_form').validVal({
        form:{
            onInvalid: function( $fields, language ) {
                console.log($fields);
                console.log(language);
                myAlert({
                    mode:1,
                    title:'部分信息不完整',
                    btn1:' 确 定',
                    close:function(ele){
                        ele.remove()
                    },
                    btnClick:function(ele){
                        ele.remove()
                    }
                });
            },
            onValid:function(){
                var params = {
                    "name":$('input[name=account]').val(),
                    "password":$('input[name=password]').val()
                };
                $.ajax({
                    type:'post',
                    url:'/pg_admin/signin',
                    data: params,
                    dataType:'json',
                    success:function(data){
                        if(data){
                            window.location.href="/pg_admin/get_order_list"
                        }else{
                            myAlert({
                                mode:1,
                                title:'验证失败',
                                content:'账号或密码不正确',
                                btn1:' 确 定',
                                close:function(ele){
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    ele.remove()
                                }
                            });
                        }
                    },
                    error:function(){
                        myAlert({
                            mode:1,
                            title:'内部错误',
                            content:'请稍后再试',
                            btn1:' 确 定',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        })
                    }
                })
                return false
            }
        }
    });

    $('#admin_form').submit(function(){
        return false
    });
</script>
</body>
</html>