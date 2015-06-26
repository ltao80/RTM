<div class="product_head">
    <p>请完善以下信息</p>
    <img src="<?php echo base_url()?>static/images/logo.png" />
</div>
<div class="main product_main">
    <div class="info_form user-confirm-form">
    <form id="user-confirm-form">
          <div class="info_input drop_down" style=" width:278px; float:left; margin-right:20px; z-index:9">
              <p>请选择省份</p><span></span>
              <ul class="provinces">
                  <?php foreach($provinces as $province) {?>
                  <li value="<?php echo $province ?>"><?php echo $province ?></li>
                  <?php } ?>
              </ul>
              <input name="province" class="required"  style="visibility: hidden; height:0" />
          </div>

          <div class="info_input drop_down" style=" width:278px; float:left; z-index:8">
              <p>请选择城市</p><span></span>
              <ul class="cities"></ul>
              <input name="cities" class="required"  style="visibility: hidden; height:0" />
          </div>

          <div style="clear:both"></div>

          <div class="info_input drop_down" style="z-index:7">
              <p>请选择门店</p><span></span>
              <ul class="stores"></ul>
              <input name="stores" class="required"  style="visibility: hidden; height:0" />
          </div>
          <input type="text" name="user_name" class="required info_input user_name" placeholder="*请输入真实姓名" />
          <input type="tel" name="user_phone" class="required info_input user_phone" placeholder="*请输入有效手机号" />
          <button class="detail_btn submit-user-info">确 认</button>
    </form>
    </div>
</div>