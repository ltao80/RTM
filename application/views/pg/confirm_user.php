<div class="product_head">
    <p></p>
    <img src="images/logo.png" />
</div>
<div class="main">
    <div class="info_form user-confirm-form">
          <select class="provinces">
              <option value="-1">请选择省份</option>
              <?php foreach($provinces as $province) {?>
              <option value="<?php echo $province ?>"><?php echo $province ?></option>
              <?php } ?>
          </select>
          <select class="cities">
              <option>请选择城市</option>
          </select>
          <select class="stores">
              <option>请选择门店</option>
          </select>
          <input type="text" name="user_name" class="required info_input info_input_addr user_name" placeholder="*请输入真实姓名" />
          <input type="text" name="user_phone" class="required info_input info_input_addr user_phone" placeholder="*请输入有效手机号" />
          <input type="text" name="user_email" class="required info_input info_input_addr user_email" placeholder="*请选择电子邮箱" />
          <button class="detail_btn submit-user-info">确认</button>
    </div>
</div>