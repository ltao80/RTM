<div class="wrapper" id="wrapper">
    <div id="background"></div>
    <div class="nav_box">
        <div class="nav_li" id="nav_menu_close">
            <span></span>
            <p>我的专区</p>
        </div>
        <a class="nav_li" href="#">
            <span></span>
            <p>购物车</p>
        </a>
        <a class="nav_li" href="query-list.html">
            <span></span>
            <p>积分查询</p>
        </a>
        <a class="nav_li" href="oders-list.html">
            <span></span>
            <p>积分订单</p>
        </a>
        <a class="nav_li" href="info.html">
            <span></span>
            <p>个人信息</p>
        </a>
    </div>
    <div class="header">
        <a href="javascript:void(0)" id="nav_menu_open"></a>
        <p>商品详情</p>
        <img src="images/logo.png" />
    </div>
    <div class="detail_top">
        <div class="show_pic">
            <img src="images/detail.png" />
        </div>
        <p class="detail_titel"><?php if(isset($product_info['title'])){echo $product_info['title'];}?></p>
        <p class="detail_price">尊享价：<span><?php if(isset($product_info['score'])){echo $product_info['score'];}?></span>积分</p>
    </div>
    <div class="product_foot detail_btns">
        <a href="javascript:void(0)" class="detail_btn">加入购物车</a>
        <a href="javascript:void(0)" class="detail_btn">立即兑换</a>
    </div>
    <div class="detail_main">
        <h1>产品信息</h1>
        <p><?php if(isset($product_info['description'])){echo $product_info['description'];}?></p>
        <h1>购物须知</h1>
        <p>1.快递：我们将使用顺丰快递为您寄送礼品，如果您所在的地区不在顺丰寄送范围之内，请您联系微信客服进行咨询。<br><br>
            2.发货：正常情况下，您在每日16:00前拍下的商品将会当天发送，晚于16:00将会次日发送。<br><br>
            3.签收：请您务必在收到礼品后第一时间开箱进行检查，确保礼品无任何破损后再进行签收。<br><br>
            4.退货：由于此次活动属于积分兑礼活动，故礼品如无质量问题，我们将不提供退货服务。<br><br>
            ※ 人头马对此次活动保有最终解释权
        </p>
    </div>
    <div class="product_foot detail_btns" style="margin-bottom:20px">
        <a href="javascript:void(0)" class="detail_btn">加入购物车</a>
        <a href="javascript:void(0)" class="detail_btn">立即兑换</a>
    </div>
</div>
<div id="confirm" class="confirm_box">
    <div class="confirm">
        <p class="confirm_title">请选择数量<span id="close">×</span></p>
        <div class="confirm_main">
            <h1><?php if(isset($product_info['title'])){echo $product_info['title'];}?></h1>
            <p>所需积分 <span><?php if(isset($product_info['score'])){echo $product_info['score'];}?></span> 积分</p>
            <div class="confirm_count">
                <div class="reduce">-</div>
                <p class="count">1</p>
                <div class="plus">+</div>
            </div>
            <div class="product_foot">
                <a href="javascript:void(0)" class="detail_btn" id="submit">确认提交</a>
            </div>
            <form id="form">
                <input type="hidden" name="name" id="name" value="人头马禧钻特优香槟干邑" />
                <input type="hidden" name="count" id="count" value="1" />
            </form>
        </div>
    </div>
</div>
