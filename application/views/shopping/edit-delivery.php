<div class="main">
    <div class="info_form">
        <form action="" id="info_form">
            <p>收货人姓名</p>
            <input type="text" name="info_name" value="<?php if(isset($customer_info['receiver_name'])){echo $customer_info['receiver_name'];}?>" class="required info_input" placeholder="收货人姓名" />
            <p>手机号码</p>
            <input type="tel" name="info_tel" value="<?php if(isset($customer_info['receiver_phone'])){echo $customer_info['receiver_phone'];}?>" class="required info_input" placeholder="手机号码" />
            <p>省</p>
            <input type="text" name="info_province" value="<?php if(isset($customer_info['receiver_province'])){echo $customer_info['receiver_province'];}?>" class="required info_input" placeholder="省" />
            <p>市</p>
            <input type="text" name="info_city" value="<?php if(isset($customer_info['receiver_city'])){echo $customer_info['receiver_city'];}?>" class="required info_input" placeholder="市" />
            <p>区</p>
            <input type="text" name="info_region" value="<?php if(isset($customer_info['receiver_region'])){echo $customer_info['receiver_region'];}?>" class="required info_input" placeholder="区" />
            <p>详细地址</p>
            <input type="text" name="info_addr_detail" value="<?php if(isset($customer_info['receiver_address'])){echo $customer_info['receiver_address'];}?>" class="required info_input" placeholder="详细地址ַ" />

            <button class="detail_btn">确定提交</button>
        </form>
    </div>
</div>