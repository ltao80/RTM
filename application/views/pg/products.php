<div class="product_head"><img src="/static/images/logo.png" /></div>
<div class="product_main">
    <div class="product_list" id="product_list">
        <!-- Product begin -->
        <?php foreach($products as $product) {?>
        <div>
            <h1><span></span><?php echo $product->name ?></h1>
            <p>
            	<?php foreach($product->specifications as $specification) {?>
            		<i><?php echo $specification->spec_name ?></i>
            	<?php } ?>
            </p>
            <span></span>
        </div>
        <ul>
        <?php foreach($product->specifications as $specification) {?>
            <li production-id="<?php echo $product->id ?>" spec-id="<?php echo $specification->spec_id ?>" name="<?php echo $specification->spec_name ?>" credit="<?php echo $specification->score ?>">
                <span class="add-number" extra-data="<?php echo $product->id . " " . $specification->spec_id ?>">+</span><span class="product-count-<?php echo $product->id . " " . $specification->spec_id ?>">0</span><span class="reduce-number" extra-data="<?php echo $product->id . " " . $specification->spec_id ?>">-</span><span><?php echo $specification->spec_name ?></span>
            </li>
        <?php } ?>
        </ul>
        <?php } ?>
		<!-- Product end -->
    </div>
</div>
<div class="product_foot">
    <a href="javascript:void(0)" class="detail_btn save-order" id="submit">确认</a>
    <a href="#view=search_order" class="detail_btn query-order">查询订单</a>
</div>
<form id="product_form" action="demo.html" method="post">
    <input type="hidden" name="data" id="product_data" />
</form>