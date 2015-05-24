<div class="page-sidebar nav-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->
	<ul class="page-sidebar-menu">
		<li style="margin-bottom:15px">
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		</li>
		<li class="start active ">
			<a href="index.html">
				<i class="icon-home"></i>
				<span class="title">PG管理</span>
				<span class="selected"></span>
				<span class="arrow "></span>
			</a>
			<ul class="sub-menu">
				<li class="active"><a href="index.html">新建</a></li>
				<li><a href="index.html">PG列表</a></li>
			</ul>
		</li>
        <?php foreach($user_menu as $main_menu){ ?>
            <li class="">

                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title"><?php $main_menu['name']?></span>
                    <span class="<?php if($main_menu['selected']){echo 'selected';} else{ echo 'arrow';} ?>"></span>
                </a>
                <?php if(count($main_menu['sub_menus'])>0){ ?>
                <ul class="sub-menu">
                    <?php foreach($main_menu['sub_menu'] as $sub_menu){ ?>
                    <li ><a href="<?php $sub_menu['permission_path'] ?>">$sub_menu['name']</a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
            </li>
    <?php } ?>
	</ul>
	<!-- END SIDEBAR MENU -->
</div>