<div class="product_head">
    <p>请完善以下信息</p>
    <img src="/static/images/logo.png" />
</div>
<div class="main product_main">
    <div class="info_form user-confirm-form">
          <div class="info_input drop_down">
              <p>请选择省份</p><span></span>
              <ul class="provinces">
                  <?php foreach($provinces as $province) {?>
                  <li value="<?php echo $province ?>"><?php echo $province ?></li>
                  <?php } ?>
              </ul>
          </div>

          <select class="cities">
              <option>请选择城市</option>
          </select>
          <select class="stores">
              <option>请选择门店</option>
          </select>
          <input type="text" name="user_name" class="required info_input user_name" placeholder="*请输入真实姓名" />
          <input type="tel" name="user_phone" class="required info_input user_phone" placeholder="*请输入有效手机号" />
          <input type="email" name="user_email" class="required info_input user_email" placeholder="*请选择电子邮箱" />
          <button class="detail_btn submit-user-info">确 认</button>
    </div>
</div>