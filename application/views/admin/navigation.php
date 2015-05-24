<div class="page-sidebar nav-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->
	<ul class="page-sidebar-menu">
		<li style="margin-bottom:15px">
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		</li>
        <?php foreach($user_menu as $main_menu){ ?>
            <li class="">

                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title"><?php echo $main_menu['menu_name']?></span>
                    <span class="<?php if($main_menu['selected']){echo 'selected';} else{ echo 'arrow';} ?>"></span>
                </a>
                <?php if(count($main_menu['sub_menu'])>0){ ?>
                <ul class="sub-menu">
                    <?php foreach($main_menu['sub_menu'] as $sub_menu){ ?>
                    <li ><a href="<?php echo $sub_menu['permission_action'] ?>"><?php echo $sub_menu['menu_name'] ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
            </li>
    <?php } ?>
	</ul>
	<!-- END SIDEBAR MENU -->
</div>