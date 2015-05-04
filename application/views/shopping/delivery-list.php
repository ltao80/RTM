<div class="main">
    <ul class="query_list address_list">
        <?php foreach($delivery_list as $delivery_info){?>
        <li delivery_id="<?php if(isset($delivery_info['id'])){echo $delivery_info['id'];}?>">
            <h1>收件人：<?php if(isset($delivery_info['receiver_name'])){echo $delivery_info['receiver_name'];}?>
                电话：<?php if(isset($delivery_info['receiver_phone'])){echo $delivery_info['receiver_phone'];}?><span><?php if(isset($score_info['is_default'])){if($score_info['is_default'] == "1"){echo "默认地址";}else{echo "";}}?></span></h1>
            <h1><?php if(isset($delivery_info['receiver_province'])){echo $delivery_info['receiver_province'];}?>省<?php if(isset($delivery_info['receiver_city'])){echo $delivery_info['receiver_city'];}?>市 <?php if(isset($delivery_info['receiver_region'])){echo $delivery_info['receiver_region'];}?>区</h1>
            <h1>详细地址：<?php if(isset($delivery_info['receiver_address'])){echo $delivery_info['receiver_address'];}?></h1>
        </li>
        <?php } ?>
    </ul>
    <div class="product_foot addr_foot">
        <input class="detail_btn" type="submit" id="submit" value="添加新地址">
    </div>
</div>