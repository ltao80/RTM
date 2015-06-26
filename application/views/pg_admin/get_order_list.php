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
    <title>订单列表</title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>static/css/main.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>static/css/admin.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>static/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>static/css/pickmeup.min.css" />
    <script src="<?php echo base_url()?>static/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url()?>static/js/jquery.validVal.min.js"></script>
    <script src="<?php echo base_url()?>static/js/jquery.pickmeup.js"></script>
</head>
<body>
<style>
    /*#pagelist ul li { float:left;border:1px solid #e0691a; height:40px; font-weight:bold; line-height:20px;
    margin:0px 2px; list-style:none;}
    #pagelist ul li a,
    .current { background:#ff0000; display:block; padding:0px 6px; font-weight:bold;}*/
</style>
<div class="wrapper wrapper_admin" id="wrapper">
    <div id="background" class="background3"></div>
    <div class="product_head">
        <p><a href="<?php echo base_url()?>pg_admin/loginout" >退出</a></p>
        <img src="<?php echo base_url()?>static/images/logo.png" />
    </div>
    <div class="main">
        <div class="management_box">
            <div class="management_head">
                <div class="manage_btn export" id="export">导 出</div>
                <div class="search_time">
                    <form action="<?php echo base_url()?>pg_admin/get_order_list" id="time_form">
                        <input class="timepicker" id="time_start" name="startTime" type="text"
                               placeholder="请选择起始时间" />
                        <input class="timepicker" id="time_end" name="endTime" type="text" placeholder="请选择结束时间" />
                        <button class="manage_btn">搜索</button>
                    </form>
                </div>
            </div>
            <div class="management_main" id="management">
                <table>
                    <thead>
                    <tr>
                        <th>省市</th>
                        <th>用户名</th>
                        <th>用户OpenID</th>
                        <th>订单详情</th>
                        <th>订单时间</th>
                        <th>订单号</th>
                        <th>物流单号</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $val){?>
                    <tr>
                        <td><?php echo $val['receiver_province']?></td>
                        <td><?php echo $val['username']?></td>
                        <td><?php echo $val['wechat_id']?></td>
                        <td><?php echo $val['detail']?></td>
                        <td><?php echo $val['order_datetime']?></td>
                        <td><?php echo $val['order_code']?></td>
                        <td class="order_code" order_code="<?php echo $val['order_code']?>"><div><input type="text" value="<?php echo $val['delivery_order_code']?>" /><i extra-data="1" class="fa fa-save"></i></div></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="management_head management_foot">

                    <div id="pagelist">
                        <ul class="page_bar"><?php echo $this->pagination->create_links();?>
                        </ul>
                    </div>

            </div>
            <form id="export_form" method="post" action="<?php echo base_url()?>pg_admin/export" target="_blank">
                <input type="hidden" name="startTime" value="" />
                <input type="hidden" name="endTime" value="" />
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>static/js/main.js"></script>
<script>
    $('form').die('submit');
    $('#time_form').submit(function(){
        if(!$('#time_form [name=startTime]').val()){
            myAlert({
                mode:1,
                title:'请输入起始时间',
                btn1:' 确 定',
                close:function(ele){
                    ele.remove()
                },
                btnClick:function(ele){
                    ele.remove()
                }
            })
            return false
        }
        if(!$('#time_form [name=endTime]').val()){
            myAlert({
                mode:1,
                title:'请输入结束时间',
                btn1:' 确 定',
                close:function(ele){
                    ele.remove()
                },
                btnClick:function(ele){
                    ele.remove()
                }
            })
            return false
        }
    });

    function parseData(params) {
        var data = {};
        var items = params.split('&');
        for(var i = 0; i < items.length; i++) {
            var parts = items[i].split('=');
            data[parts[0]] = (parts[1] ? parts[1] : true);
        }

        return data;
    };
    var search = location.search;
    var params = search.substr(1);
    var data = parseData(params);
    $('#export_form [name=startTime]').val(data.startTime?data.startTime:'');
    $('#export_form [name=endTime]').val(data.endTime?data.endTime:'');


    $('#time_start').pickmeup({
        format  : 'Y-m-d',
        hide_on_select:true,
        max:new Date(),
        change:function(data){
            startTime(data);
            console.log(data);
        }
    });

    $('#time_end').pickmeup({
        format  : 'Y-m-d',
        hide_on_select:true,
        max:new Date(),
        change:function(data){
            endTime(data);
            console.log(data);
        }
    });

    function startTime(data){
        $('#time_end').pickmeup('destroy').pickmeup({
            default_date:(new Date(data)),
            format  : 'Y-m-d',
            hide_on_select:true,
            min:(new Date(data)),
            max:new Date(),
            change:function(data){
                endTime(data)
            }
        });
        //$('#time_end').pickmeup('set_date',(new Date(data)));
    }

    function endTime(data){
        $('#time_start').pickmeup('destroy').pickmeup({
            default_date:(new Date(data)),
            format  : 'Y-m-d',
            hide_on_select:true,
            max:(new Date(data)),
            change:function(data){
                startTime(data)
            }
        });
        //$('#time_start').pickmeup('set_date',(new Date(data)));
    }

    $('#export').click(function(){
        $('#export_form').submit()
    });

    $('#management tr').not(':first').each(function(){
        $(this).find('.fa-save').click(function(){
            var order_code=$(this).parents('.order_code').attr('order_code');
            var delivery_code=$(this).siblings('input').val();
            $.ajax({
                type:'post',
                url:'<?php echo base_url()?>pg_admin/update_delivery_order_code',
                data:{
                    order_code:order_code,
                    delivery_code:delivery_code
                },
                success:function(data){
                    if(data){
                        myAlert({
                            mode:1,
                            title:'修改成功',
                            btn1:' 确 定',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        })
                    }else{
                        myAlert({
                            mode:1,
                            title:'修改失败',
                            btn1:' 确 定',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        })
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
        })
    });

    $('#page_to').click(function(){
        window.location.href=window.location.pathname+'?page='+$('#page_num').val()
    })
</script>
</body>
</html>