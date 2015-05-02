<div class="main">
    <div class="info_form">
        <form action="/customer/<?php echo $type ?>" id="info_form" method="POST">
            <p>收货人姓名</p>
            <input type="text" name="info_name" value="<?php if(isset($result['name'])){echo $result['name'];}?>" class="required info_input" placeholder="收货人姓名" />
            <p>手机号码</p>
            <input type="tel" name="info_tel" value="<?php if(isset($result['phone'])){echo $result['phone'];}?>"  class="required info_input" placeholder="手机号码" />
            <p>省市区</p>
            <input type="text" name="info_addr" value="<?php if(isset($result['address'])){echo $result['address'];}?>"  class="required info_input" placeholder="省市区" />
            <p>详细地址</p>
            <input type="text" name="info_addr_detail" value="<?php if(isset($result['address'])){echo $result['address'];}?>"  class="required info_input" placeholder="详细地址"/>
            <p>生日</p>
            <input type="text" name="info_birthday" value="<?php if(isset($result['birthday'])){echo $result['birthday'];}?>"  class="required info_input" placeholder="生日"/>
            <input type="hidden" name="wechat_id" value="<?php echo $openId;?>">
            <input type="hidden" name="id" value="<?php if(isset($id)){echo $id;};?>">
            <button class="detail_btn">确认提交</button>
        </form>
    </div>
</div>