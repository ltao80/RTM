
<div class="cart_main">
    <ul class="cart_list" id="cart_list">
        <li productId="<?php if(isset($product_info['id'])){echo $product_info['id'];}?>" credit="<?php if(isset($product_info['score'])){echo $product_info['score'];}?>" product="<?php if(isset($product_info['name'])){echo $product_info['name'];}?>" size="<?php if(isset($product_info['spec_name'])){echo $product_info['spec_name'];}?>">
            <label class="label"><input type="checkbox" name="item" /><i></i></label>
            <div class="cart_right">
                <img src="/static/images/<?php if(isset($product_info['image_url'])){echo $product_info['image_url'];}?>" />
                <p><?php if(isset($product_info['description'])){echo $product_info['description'];}?></p>
                <h1><?php if(isset($product_info['spec_name'])){echo $product_info['spec_name'];}?><span><i><?php if(isset($product_info['score'])){echo $product_info['score'];}?></i>积分</span></h1>
                <div class="confirm_count">
                    <div class="reduce">-</div>
                    <p class="count">1</p>
                    <div class="plus">+</div>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="product_foot cart_foot">
    <div class="select_all">
        <label class="label"><input type="checkbox" name="item" id="addAll" /><i></i></label>
        <span>全选</span>
        <p>当前积分<span id="totalCredit">0</span></p>
        <input type="hidden" value="10000" id="max" />
    </div>
    <a href="javascript:void(0)" class="detail_btn" id="submit">兑换</a>
</div>
