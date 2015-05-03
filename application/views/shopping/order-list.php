<div class="main">
    <ul class="oders_list">
        <?php foreach($order_list as $order_info){?>
        <li>
            <h1><?php if(isset($order_info['order_datetime'])){echo $order_info['order_datetime'];}?></h1>
            <?php foreach($order_info['detail'] as $product_info){?>
            <div class="oders_main">
                <img src="/static/images/<?php if(isset($product_info['image_url'])){echo $product_info['image_url'];}?>" />
                <p><?php if(isset($product_info['description'])){echo $product_info['description'];}?></p>
                <h2>规格：<?php if(isset($product_info['spec_name'])){echo $product_info['spec_name'];}?></h2>
                <h3><?php if(isset($product_info['score'])){echo $product_info['score'];}?>积分</h3>
            </div>
            <?php } ?>
            <p>
                共<?php if(isset($order_info['detail'])){echo count($order_info['detail']);}?>件商品 <?php if(isset($order_info['total_score'])){echo $order_info['total_score'];}?>积分
                <a href="javascript:void(0)" class="detail_btn" extra-data="1">查看物流</a>
            </p>
        </li>
        <?php } ?>
    </ul>
</div>