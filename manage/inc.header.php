<?php


?>

<div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="<?php echo URL_ROOT."manage/";?>">
		<img src="<?php echo URL_ROOT; ?>images/logo.png" alt="logo" class="img-responsive" style="width:50%;height:50%;"/>
		</a>

		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<img src="assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">

			<li class="devider"> &nbsp;</li>
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="<?php echo URL_ROOT ?>images/logo.png"/ height="20px" width="20px;">
				<span class="username"><?php echo ucfirst($_SESSION[LOGIN_ADMIN]['name']);?></span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">



				</li>
				<li>
					<a href="<?php echo URL_ROOT;?>manage/logout.php"><i class="fa fa-key"></i> Log Out</a>
				</li>
<?php
                                if($_SESSION[LOGIN_ADMIN]['is_superadmin']==0)
                                {
                                ?>
                                <li><a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"password",'section'=>"change"));?>"  title="Change Password">Change Password</a></li>
                                <?php
                                }
                                ?>
<!--                                <li>
					<a href="<?php echo URL_ROOT;?>manage/password_change.php"><i class="fa fa-key"></i>Change Password</a>
				</li>-->
			</ul>
		</li>
		<!-- END USER LOGIN DROPDOWN -->
	</ul>
	<!-- END TOP NAVIGATION MENU -->
</div>
<!-- END TOP NAVIGATION BAR -->
</div>
<script>$(window).off('beforeunload');</script>