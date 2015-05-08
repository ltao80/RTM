<div class="main">
    <div class="oders_detail_info">
        <h1><?php if(isset($order_info)){echo $order_info["company_name"];}?></h1>
        <p>运单编号：<?php if(isset($order_info)){echo $order_info["delivery_order_code"];}?></p>
    </div>
    <ul class="oders_list oders_detail">
        <li>
            <h1><?php if(isset($order_info)){echo $order_info["order_datetime"];}?></h1>
            <?php foreach($order_info['detail'] as $order_detail){?>
            <div class="oders_main">
                <div class="confirm_img"><img src="/static/images/<?php if(isset($order_detail['image_url'])){echo
                $order_detail['image_url'];}?>" /></div>
                <p>><?php if(isset($order_detail['name'])){echo $order_detail['name'];}?></p>
                <h2><?php if(isset($order_detail['description'])){echo $order_detail['description'];}?></h2>
                <h3>所需积分 <i><?php if(isset($order_detail['score'])){echo $order_detail['score'];}?></i> 积分</h3>
            </div>
            <?php } ?>
            <p>
                共<?php if(isset($order_info['detail'])){echo count($order_info['detail']);}?>件商品 合计：<span><?php if(isset($order_info['total_score'])){echo $order_info['total_score'];}?>积分</span>
            </p>
            <p>订单号：<?php if(isset($order_info['order_code'])){echo $order_info['order_code'];}?></p>
        </li>
    </ul>
</div>