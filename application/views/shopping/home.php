<div class="main_home">
    <a href="#" class="menu_btn" id="nav_menu_open">
        <span>菜单</span>
    </a>
    <div class="right_info">
        <img src="../../static/images/logo.png" />
        <h1>尊敬的人头马会员<?php echo $customer_list['name']?>，</h1>
        <p>您目前享有积分：<?php echo $customer_list['total_score']?>分 </p>
    </div>
    <div class="main_left">
        <ul>
            <?php foreach($promation_list as $p){?>
                <li extra-data="<?php echo $p['id'];?>"><img src="/static/images/<?php echo $p['image_url']?>" /></li>
            <?php } ?>
        </ul>
    </div>
    <div class="main_right">
        <div class="preview">
            <img src="../../static/images/item_l_1.png" id="detail_pic" />
        </div>
    </div>
    <div class="main_bottom">
        <div class="hr"></div>
        <div style="width:100%; height:1px; overflow:hidden; clear: both"></div>
        <h1 class="detail_name">人头马 <span id="detail_name">君度橙酒</span></h1>
        <p class="detail_size" id="detail_size"><?php echo $promation_list[0]['name']?></p>
        <p class="detail_cost">所需积分:<span id="detail_cost"><?php echo $promation_list[0]['score']?>分</span></p>
        <button class="home_button">立即兑换</button>
        <div class="hr"></div>
    </div>
</div>