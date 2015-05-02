<div class="detail_top">
        <div class="show_pic">
            <img src="/static/images/<?php if(isset($product_info['image_url'])){echo $product_info['image_url'];}?>" />
        </div>
        <p class="detail_titel"><?php if(isset($product_info['title'])){echo $product_info['title'];}?></p>
        <p class="detail_price">尊享价：<span><?php if(isset($product_info['score'])){echo $product_info['score'];}?></span>积分</p>
    </div>
    <div class="product_foot detail_btns">
        <a href="javascript:void(0)" class="detail_btn join_cart">加入购物车</a>
        <a href="javascript:void(0)" class="detail_btn change_now">立即兑换</a>
    </div>
    <div class="detail_main">
        <h1>产品信息</h1>
        <p><?php if(isset($product_info['description'])){echo $product_info['description'];}?></p>
        <h1>购物须知</h1>
        <p>1.快递：我们将使用顺丰快递为您寄送礼品，如果您所在的地区不在顺丰寄送范围之内，请您联系微信客服进行咨询。<br><br>
            2.发货：正常情况下，您在每日16:00前拍下的商品将会当天发送，晚于16:00将会次日发送。<br><br>
            3.签收：请您务必在收到礼品后第一时间开箱进行检查，确保礼品无任何破损后再进行签收。<br><br>
            4.退货：由于此次活动属于积分兑礼活动，故礼品如无质量问题，我们将不提供退货服务。<br><br>
            ※ 人头马对此次活动保有最终解释权
        </p>
    </div>
    <div class="product_foot detail_btns" style="margin-bottom:20px">
        <a href="javascript:void(0)" class="detail_btn join_cart">加入购物车</a>
        <a href="javascript:void(0)" class="detail_btn change_now">立即兑换</a>
    </div>