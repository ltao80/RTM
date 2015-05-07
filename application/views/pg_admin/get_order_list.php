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
    <title>Demo</title>
    <link type="text/css" rel="stylesheet" href="/static/css/main.css" />
    <link type="text/css" rel="stylesheet" href="/static/css/admin.css" />
    <link type="text/css" rel="stylesheet" href="/static/css/font-awesome.min.css" />
    <script src="/static/js/jquery-1.8.3.min.js"></script>
    <script src="/static/js/jquery.validVal.min.js"></script>
</head>
<body>
<style>
    #pagelist ul li { float:left;border:1px solid #e0691a; height:40px; font-weight:bold; line-height:20px; margin:0px 2px; list-style:none;}
    #pagelist ul li a,
    .current { background:#ff0000; display:block; padding:0px 6px; font-weight:bold;}
</style>
<div class="wrapper wrapper_admin" id="wrapper">
    <div id="background" class="background3"></div>
    <div class="product_head">
        <p><a href="登陆页" >退出</a></p>
        <img src="/static/images/logo.png" />
    </div>
    <div class="main">
        <div class="management_box">
            <div class="management_head">
                <label><input type="checkbox" id="select_all" />全选</label>
                <div class="manage_btn export" id="export">导 出</div>
            </div>
            <div class="management_main" id="management">
                <table>
                    <thead>
                    <tr>
                        <th width="50"></th>
                        <th>门店</th>
                        <th>省市</th>
                        <th>PG</th>
                        <th>用户OpenID</th>
                        <th>订单详情</th>
                        <th>扫码时间</th>
                        <th>订单时间</th>
                        <th>订单号</th>
                        <th>物流单号</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $val){?>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td><?php echo $val['wechat_id']?></td>
                        <td><?php echo $val['name']?></td>
                        <td><?php echo $val['phone']?></td>
                        <td><?php echo $val['spec_name']?></td>
                        <td><?php echo $val['product_num']?></td>
                        <td><?php echo $val['receiver_province']?></td>
                        <td><?php echo $val['receiver_city']?></td>
                        <td><?php echo $val['receiver_region']?></td>
                        <td class="order_code" order_code="<?php echo $val['order_code']?>"><div><input type="text" value="<?php echo $val['delivery_order_code']?>" /><i extra-data="1" class="fa fa-save"></i></div></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="management_head management_foot">

                    <div id="pagelist">
                        <ul><?php echo $this->pagination->create_links();?>
                        </ul>
                    </div>

            </div>
        </div>
    </div>
</div>
<script src="/static/js/main.js"></script>
<script>
    $('#select_all').change(function(){
        if($(this).attr('checked')){
            $('input[type=checkbox]').attr('checked',true)
        }else{
            $('input[type=checkbox]').attr('checked',false)
        }
    });

    $('#management tr').not(':first').each(function(){
        $(this).find('.fa-save').click(function(){
            var id=$(this).attr('extra-data');
            console.log(id);
            $.ajax({
                type:'post',
                url:'修改订单号',
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