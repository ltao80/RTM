<div class="main">
    <ul class="detail_list">
        <?php foreach($score_list as $score_info){?>
        <li><?php if(isset($score_info['order_datetime'])){echo $score_info['order_datetime'];}?><span><?php if(isset($score_info['store_name'])){echo $score_info['store_name'];}?>/span></li>
        <?php foreach($score_info['order_list'] as $order_info){?>
        <li><?php if(isset($order_info['name'])){echo $order_info['name'];}?> <?php if(isset($order_info['spec_name'])){echo $order_info['spec_name'];}?> x<?php if(isset($order_info['product_num'])){echo $order_info['product_num'];}?><span><?php if(isset($order_info['score'])){echo $order_info['score'];}?></span></li>
        <?php } ?>
        <?php } ?>
    </ul>
    <div class="detail_info"><span><?php if(isset($order_info['total_score'])){echo $order_info['total_score'];}?>分</span></div>
</div>