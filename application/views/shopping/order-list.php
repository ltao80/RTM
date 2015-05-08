<div class="main">
    <ul class="oders_list">
        <?php foreach($order_list as $order_info){?>
        <li>
            <h1><?php if(isset($order_info['order_datetime'])){echo $order_info['order_datetime'];}?></h1>
            <?php foreach($order_info['detail'] as $order_detail){?>
            <div class="oders_main">
                <div class="confirm_img"><img src="/static/images/<?php if(isset($order_detail['image_url'])){echo
                    $order_detail['image_url'];}?>" /></div>
                <p><?php if(isset($order_detail['name'])){echo $order_detail['name'];}?> x<?php if(isset($order_detail['product_num'])){echo $order_detail['product_num'];}?></p>
                <h2>规格：<?php if(isset($order_detail['spec_name'])){echo $order_detail['spec_name'];}?></h2>
                <h3><?php if(isset($order_detail['score'])){echo $order_detail['score'];}?>积分</h3>
            </div>
            <?php } ?>
            <p>
                共<?php if(isset($order_info['detail'])){echo count($order_info['detail']);}?>件商品 <?php if(isset($order_info['total_score'])){echo $order_info['total_score'];}?>积分
                <a href="javascript:void(0)" class="detail_btn" extra-data="<?php if(isset($order_info['order_code'])){echo $order_info['order_code'];}?>">查看物流</a>
            </p>
        </li>
        <?php } ?>
    </ul>
</div>