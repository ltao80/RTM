<div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<a class="brand" href="index.html">
				<img src="/static/admin/image/logo.png" alt="logo"/>
			</a>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="/static/admin/image/menu-toggler.png" alt="" />
			</a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<ul class="nav pull-right">
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user">
					<a href="javascript:void(0)" style="background:none!important" class="dropdown-toggle my_nobg">
						<span class="username my_header_span"> 欢迎您： <?php echo $user_info['user_name'] ?></span>
					</a>
				</li>
				<li class="dropdown user">
					<a href="/admin/user_manage/logout" style="background:none!important" class="dropdown-toggle my_nobg">
						<span class="username my_header_span my_underline">退出</span>
					</a>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>