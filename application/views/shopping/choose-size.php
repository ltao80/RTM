<div id="confirm" class="confirm_box">
    <div class="confirm">
        <p class="confirm_title">请选择数量<span id="close">×</span></p>
        <div class="confirm_main">
            <h1 product_image="<?php if(isset($product_info['image_url'])){echo $product_info['image_url'];}?>"><?php if(isset($product_info['name'])){echo $product_info['name'];}?></h1>
            <p>所需积分 <span id="total_score"></span> 积分</p>
            <div ></div>
            <div class="choose_size">
                <?php foreach($product_spec_list as $product_spec){?>
                    <div spec_id="<?php if(isset($product_spec['spec_id'])){echo $product_spec['spec_id'];}?>" score="<?php if(isset($product_spec['score'])){echo $product_spec['score'];}?>"><?php if(isset($product_spec['spec_name'])){echo $product_spec['spec_name'];}?></div>
                <?php } ?>
            </div>
            <div class="confirm_count">
                <div class="reduce">-</div>
                <p class="count">1</p>
                <div class="plus">+</div>
            </div>
            <div class="product_foot">
                <a href="javascript:void(0)" class="detail_btn" id="submit">确认提交</a>
            </div>
            <form id="form">
                <input type="hidden" name="name" id="name" value="<?php if(isset($product_info['name'])){echo $product_info['name'];}?>" />
                <input type="hidden" name="count" id="count" value="1" />
            </form>
        </div>
    </div>
</div>