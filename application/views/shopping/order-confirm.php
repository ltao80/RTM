<form id="addr_form">
    <div class="main">

        <div id="oders_main2_list">
        </div>
        <p class="oder_title">再次确认订单信息</p>
        <input type="text" name="message" class="info_input" placeholder="买家留言" />
        <p class="oder_title">共<i id="count"></i> 件商品<span>合计：<i id="score"></i> 积分</span></p>
    </div>
    <div class="address">


<?php if(isset($default_delivery_info) && count($default_delivery_info) > 0){?>
    <div class="addr_left">
        收货人：<?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_name"];}?>
        电话： <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_phone"];}?>
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_province"];}?>省
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_city"];}?>市
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_region"];}?>区
        <?php if(isset($default_delivery_info)){echo $default_delivery_info["receiver_address"];}?>
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
        <p><span>*</span>请填写完整的地址信息</p>
    </div>
<?php } ?>
      <input type="text" style="visibility: hidden; height:0" class="required" id="address" value="" name="address" />
     </div>
    </div>
    <div class="product_foot addr_foot">
        <input class="detail_btn" type="submit" id="submit" value="确认提交"/>
    </div>
</form>