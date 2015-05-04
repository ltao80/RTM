<div class="main">
    <div class="info_form">
        <form action="" id="info_form">
            <p>收货人姓名</p>
            <input type="text" name="info_name" value="<?php if(isset($delivery_info['receiver_name'])){echo $delivery_info['receiver_name'];}?>" class="required info_input" placeholder="收货人姓名" />
            <p>手机号码</p>
            <input type="tel" name="info_tel" value="<?php if(isset($delivery_info['receiver_phone'])){echo $delivery_info['receiver_phone'];}?>" class="required info_input" placeholder="手机号码" />
            <p>省市区</p>
            <input type="text" name="info_province" value="<?php if(isset($delivery_info['receiver_province'])){echo
            $delivery_info['receiver_province'];}?>" class="required info_input info_input_addr" placeholder="省" />
            <input type="text" name="info_city" value="<?php if(isset($delivery_info['receiver_city'])){echo
            $delivery_info['receiver_city'];}?>" class="required info_input info_input_addr" placeholder="市" />
            <input type="text" name="info_region" value="<?php if(isset($delivery_info['receiver_region'])){echo
            $delivery_info['receiver_region'];}?>" class="required info_input info_input_addr" placeholder="区"
            style="margin-right:0" />
            <p>详细地址</p>
            <input type="text" name="info_addr_detail" value="<?php if(isset($delivery_info['receiver_address'])){echo $delivery_info['receiver_address'];}?>" class="required info_input" placeholder="详细地址ַ" />

            <button class="detail_btn">确定提交</button>
        </form>
    </div>
</div>