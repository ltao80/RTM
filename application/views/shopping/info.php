<div class="main">
    <div class="info_form">
        <form action="/customer/update" id="info_form" method="POST">
            <p>姓名</p>
            <input type="text" name="info_name" value="<?php if(isset($customer_info['name'])){echo $customer_info['name'];}?>" class="required info_input" placeholder="姓名" />
            <p>手机号码</p>
            <input type="tel" maxlength="11" name="info_tel" value="<?php if(isset($customer_info['phone'])){echo
            $customer_info['phone'];}?>"  class="required info_input" placeholder="手机号码" />
            <p>电子邮箱</p>
            <input type="email" name="info_email" value="<?php if(isset($customer_info['email'])){echo $customer_info['email'];}?>"  class="required info_input" placeholder="电子邮箱"/>
            <p>生日</p>
            <input type="date" name="info_birthday" value="<?php if(isset($customer_info['birthday'])){echo
            $customer_info['birthday'];}?>"  class="required info_input" placeholder="生日"/>
            <input type="hidden" name="wechat_id" value="<?php  if(isset($customer_info['wechat_id'])){echo $customer_info['wechat_id'];}?>">
            <input type="hidden" name="id" value="<?php  if(isset($customer_info['id'])){echo $customer_info['id'];}?>">
            <button class="detail_btn">确认提交</button>
        </form>
    </div>
</div>
