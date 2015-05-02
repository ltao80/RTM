<div class="main">
    <ul class="query_list address_list">
        <?php foreach($delivery_list as $delivery_info){?>
        <li>
            <h1><?php if(isset($delivery_info['receiver_name'])){echo $delivery_info['receiver_name'];}?> <?php if(isset($delivery_info['receiver_phone'])){echo $delivery_info['receiver_phone'];}?><span><?php if(isset($delivery_info['is_default'])){echo $delivery_info['is_default'];}?></span></h1>
            <h1><?php if(isset($delivery_info['receiver_province'])){echo $delivery_info['receiver_province'];}?> <?php if(isset($delivery_info['receiver_city'])){echo $delivery_info['receiver_city'];}?> <?php if(isset($delivery_info['receiver_region'])){echo $delivery_info['receiver_region'];}?></h1>
            <h1><?php if(isset($delivery_info['receiver_address'])){echo $delivery_info['receiver_address'];}?></h1>
        </li>
        <?php } ?>
    </ul>
    <div class="product_foot addr_foot">
        <input class="detail_btn" type="submit" id="submit" value="添加新地址">
    </div>
</div>