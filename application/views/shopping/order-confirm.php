<form id="addr_form" style="padding:0 20px">
    <div class="main">

        <div id="oders_main2_list">
        </div>
        <p class="oder_title">备注：</p>
        <input type="text" name="message" class="info_input" placeholder="买家留言" />
        <p class="oder_title">共<i id="count"></i> 件商品<span>合计：<i id="score"></i> 积分</span></p>
    </div>
    <div class="address">


<?php if(isset($default_delivery_info) && count($default_delivery_info) > 0){?>
    <div class="addr_left">
        收货人：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_name"];}?><br>
        电话： <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_phone"];}?><br>
        省市区：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_province"];
        }?>&nbsp;&nbsp;
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_city"];}?>&nbsp;&nbsp;
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_region"];}?><br>
        详细地址：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_address"];}?>
    </div>
    <div class="addr_right">
        <a href="javascript:void(0)" class="detail_btn" id="select_address">管理地址</a>
    </div>
<?php } else { ?>
    <div class="addr_left">
        暂无收货地址
    </div>
    <div class="addr_right">
        <a href="javascript:void(0)" class="detail_btn" id="new_address">新建地址</a>
        <p><span>*</span>没有默认地址，请填写完整的默认地址信息</p>
    </div>
<?php } ?>
      <input type="text" style="visibility: hidden; height:0" class="required" id="address" value="<?php if(isset($default_delivery_info)){echo isset($default_delivery_info["id"]) ? $default_delivery_info["id"] : "";}?>" name="address" />
     </div>
    </div>
    <div class="product_foot addr_foot">
        <input class="detail_btn" type="submit" id="submit" value="确认提交"/>
    </div>
</form>

<div id="size_box">
    <div id="confirm" class="confirm_box" style="overflow-y:auto; padding:20px 0">
        <div class="confirm" style="position:relative; margin:0 auto">
            <p class="confirm_title">再次确认订单信息<span id="close">×</span></p>
            <div class="confirm_main">
                <div id="oders_main2_list2"></div>
            </div>
            <p class="confirm_title" style="background-position: center top; padding: 24px 85px 10px
            85px">剩余积分：<i><?php if(isset($customer_current_score)){echo $customer_current_score;}?>积分</i></p>
            <div class="confirm_main" style="padding:0">

                <div class="address" style="padding:40px 85px">
                <?php if(isset($default_delivery_info) && count($default_delivery_info) > 0){?>
                    <div class="addr_left">
                        收货人：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_name"];}?><br>
                        电话： <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_phone"];}?><br>
                        省市区：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_province"];
                        }?>&nbsp;&nbsp;
                        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_city"];}?>&nbsp;&nbsp;
                        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_region"];}?><br>
                        详细地址：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_address"];}?>
                    </div>
                <?php } else { ?>
                    <div class="addr_left">
                        暂无收货地址
                    </div>
                <?php } ?>
                </div>
                <div class="address" style="color:#ff0000; padding:40px 85px; line-height:1.3em">
                尊敬的顾客，您好！<br>
                1. 请确认兑换信息，一旦提交将不能退换！<br>
                2. 由于礼品价值高昂，请签收时务必打开包裹检查后再行签收。如存在酒品缺失，请切勿签收，并发送信息至“人头马Remy Martin”官方微信账号。我们的客服人员会第一时间和您取得联系，谢谢！
                </div>


                <div class="product_foot detail_btns"  style="padding:0 85px">
                    <a href="javascript:void(0)" class="detail_btn" id="submit2" style="width:275px">确认提交</a>
                    <a href="javascript:void(0)" class="detail_btn" id="back" style="width:275px">返回修改</a>
                </div>
            </div>
        </div>
    </div>
</div>