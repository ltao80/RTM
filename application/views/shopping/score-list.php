<div class="main">
    <div class="cur_info">
        <p>尊敬的人头马会员:  <?php if(isset($customer_info['name'])){echo $customer_info['name'];}?></p>
        <p>您目前享有的积分：</p>
        <h1><?php if(isset($customer_info['total_score'])){echo $customer_info['total_score'];}?> 分</h1>
    </div>
    <ul class="query_list">
        <?php foreach($score_list as $score_info){?>
        <li>
            <h1>时间：<?php if(isset($score_info['order_datetime'])){echo $score_info['order_datetime'];}?><span><?php if
            (isset($score_info['store_name'])){echo $score_info['store_name'];}?></span></h1>
            <p><?php if(isset($score_info['order_type'])){if($score_info['order_type'] == "1"){echo "消耗积分";}else{echo "获取积分";}}?>：<span><?php if(isset($score_info['order_type'])){if($score_info['order_type'] == "1"){echo "-";}else{echo "+";}}?><?php if(isset($score_info['total_score'])){echo $score_info['total_score'];}?>分</span></p>
            <a href="javascript:void(0)" class="detail_btn" extra-data="1" order_code="<?php if(isset($score_info['order_code'])){echo $score_info['order_code'];}?>" order_type="<?php if(isset($score_info['order_type'])){echo $score_info['order_type'];}?>">查看积分</a>
        </li>
        <?php } ?>
    </ul>
</div>