<form id="addr_form">
    <div class="main">
        <?php foreach($product_list as $product_info){?>
        <div class="oders_main oders_main2">
            <img src="/static/images/<?php if(isset($product_info['image_url'])){echo $product_info['image_url'];}?>" />
            <p><?php if(isset($product_info['description'])){echo $product_info['description'];}?></p>
            <h2>规格：<?php if(isset($product_info['spec_name'])){echo $product_info['spec_name'];}?></h2>
            <h3><i><?php if(isset($product_info['score'])){echo $product_info['score'];}?></i> 积分</h3>
        </div>
        <?php } ?>
        <p class="oder_title">再次确认订单信息</p>
        <input type="text" name="message" class="info_input" placeholder="买家留言" />
        <p class="oder_title">共 <?php if(isset($product_list)){echo count($product_info);}?> 件商品<span>合计：<?php if(isset($total_score)){echo count($total_score);}?> 积分</span></p>
    </div>
    <div class="address">
        <?php foreach($delivery_list as $delivery_info){?>
        <div class="addr_left">
            <p>��û�е�ַ</p>
        </div>
        <?php } ?>
        <div class="addr_right">
            <a href="javascript:void(0)" class="detail_btn" id="select_address">新建地址</a>
            <input type="text" style="visibility: hidden; height:0" class="required" id="address"
                   name="address" />
            <p><span>*</span>请填写完整的地址信息</p>
        </div>
    </div>
    <div class="product_foot addr_foot">
        <input class="detail_btn" type="submit" id="submit" value="确认提交"/>
    </div>
</form>
