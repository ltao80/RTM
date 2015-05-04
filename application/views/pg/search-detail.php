<div class="product_head"><img src="/static/images/logo.png" /></div>
<div class="main">
    <ul class="oders_list oders_detail">
        <li style=" margin-bottom:0">
            <h1 style=" margin-top:10px">订单号：<?php echo $order->order_code ?><span style="float:right"><?php 
            echo $order->order_datetime
            ?></span></h1>
            <div class="oders_main" style=" height:300px; padding:0">
                <h2 style=" color:#fff4cf">购买产品：</h2>
                <?php
                 $totalScore = 0;
                 foreach($order->details as $detail) {
                	$totalScore += ($detail['product_num'] * $detail['score']);
                	?>
                <h2 style=" color:#fff4cf"><?php echo $detail['name'] ?>       <?php echo $detail['spec_name'] ?> x <?php echo $detail['product_num'] ?></h2>
                <?php }?>
                
                <h2 style=" color:#fff4cf">积分总计:<span style="font-size:2.4rem; margin:0 5px"><?php echo $totalScore ?></span>积分</h2>
                <a href="javascript:void(0)" class="detail_btn generate-qrcode" style=" right:0">生成二维码</a>
            </div>
        </li>
    </ul>
</div>