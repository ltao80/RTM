<div class="main">
    <div class="info_form">
        <form action="/customer/update" id="info_form" method="POST">
            <p>收货人姓名</p>
            <input type="text" name="info_name" value="<?php if(isset($customer_info['name'])){echo $customer_info['name'];}?>" class="required info_input" placeholder="收货人姓名" />
            <p>手机号码</p>
            <input type="tel" name="info_tel" value="<?php if(isset($customer_info['phone'])){echo $customer_info['phone'];}?>"  class="required info_input" placeholder="手机号码" />
            <p>省市区</p>
            <input type="text" name="info_province" value="<?php if(isset($customer_info['province'])){echo
            $customer_info['province'];}?>"  class="required info_input info_input_addr" placeholder="省" />
            <input type="text" name="info_city" value="<?php if(isset($customer_info['city'])){echo
            $customer_info['city'];}?>"  class="required info_input info_input_addr" placeholder="市" />
            <input type="text" name="info_region" value="<?php if(isset($customer_info['region'])){echo
            $customer_info['region'];}?>"  class="required info_input info_input_addr" placeholder="区" style="
            margin-right:0" />
            <p>详细地址</p>
            <input type="text" name="info_addr_detail" value="<?php if(isset($customer_info['address'])){echo $customer_info['address'];}?>"  class="required info_input" placeholder="详细地址"/>
            <p>生日</p>
            <input type="date" name="info_birthday" value="<?php if(isset($customer_info['birthday'])){echo
            $customer_info['birthday'];}?>"  class="required info_input" placeholder="生日"/>
            <input type="hidden" name="wechat_id" value="<?php  if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id'];}?>">
            <input type="hidden" name="id" value="<?php  if(isset($customer_info['id'])){echo $customer_info['id'];}?>">
            <button class="detail_btn">确认提交</button>
        </form>
    </div>
</div>