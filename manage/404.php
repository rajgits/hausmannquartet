<?php
require_once("../config.php");
require_once("../library/resize_image.php");
require_once("../library/class.phpmailer.php");
require_once("../library/class.smtp.php");
require_once("../library/config-smtp.php");

$flgLogged=FALSE;
if(isset($_SESSION[LOGIN_ADMIN]) && is_array($_SESSION[LOGIN_ADMIN])) $flgLogged=TRUE;
if($flgLogged===TRUE)
{
	if(trim($_SERVER['QUERY_STRING'])!='' && strtolower($_SERVER['QUERY_STRING'])=="logout")
	{
		unset($_SESSION[LOGIN_ADMIN]);
		@session_destroy();
		redirect(URL_ADMIN);
		exit();
	}
}
else
{
	redirect(URL_ADMIN.'login.php');
}
//check if module needs to be included
$modInc=TRUE;
if(isset($_GET['popup']) && trim($_GET['popup'])!='' && is_numeric($_GET['popup'])) $modInc=FALSE;

$aryForm=array(); //array to hold form data

//paging vars
$pgCnt=0; //numberof pages
$pgCur=1; //current page
$pgRec=20; //number of records per page
if(isset($_GET['pg']) && is_numeric($_GET['pg']) && (int)$_GET['pg']>0) $pgCur=(int)$_GET['pg'];
$pgRecOffset=($pgCur-1)*$pgRec; //page offset
?>
<!DOCTYPE html>
<!-- 
Template Name: Conquer - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0.3
Version: 1.5.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Conquer | Pages - 404 Page Option 1</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="MobileOptimized" content="320">
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-1.10.2.min.js" type="text/javascript"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-conquer.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/pages/tasks.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<?php include_once("inc.header.php");?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<?php include_once("inc.sidebar.php");?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success">Save changes</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			<div class="theme-panel hidden-xs hidden-sm">
				<div class="toggler">
					<i class="fa fa-gear"></i>
				</div>
				<div class="theme-options">
					<div class="theme-option theme-colors clearfix">
						<span>
							 Theme Color
						</span>
						<ul>
							<li class="color-black current color-default tooltips" data-style="default" data-original-title="Default">
							</li>
							<li class="color-grey tooltips" data-style="grey" data-original-title="Grey">
							</li>
							<li class="color-blue tooltips" data-style="blue" data-original-title="Blue">
							</li>
							<li class="color-red tooltips" data-style="red" data-original-title="Red">
							</li>
							<li class="color-light tooltips" data-style="light" data-original-title="Light">
							</li>
						</ul>
					</div>
					<div class="theme-option">
						<span>
							 Layout
						</span>
						<select class="layout-option form-control input-small">
							<option value="fluid" selected="selected">Fluid</option>
							<option value="boxed">Boxed</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
							 Header
						</span>
						<select class="header-option form-control input-small">
							<option value="fixed" selected="selected">Fixed</option>
							<option value="default">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
							 Sidebar
						</span>
						<select class="sidebar-option form-control input-small">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
							 Sidebar Position
						</span>
						<select class="sidebar-pos-option form-control input-small">
							<option value="left" selected="selected">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
							 Footer
						</span>
						<select class="footer-option form-control input-small">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
				</div>
			</div>
			<!-- END BEGIN STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					404 Page Option 1 <small>404 page option 1</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="index.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Pages</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">404 Page Option 1</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12 page-404">
					<div class="number">
						 404
					</div>
					<div class="details">
						<h3>Oops! You're lost.</h3>
						<p>
							 We can not find the page you're looking for.<br/>
							<a href="index.html">Return home</a> or try the search bar below.
						</p>
						<form action="#">
							<div class="input-group input-medium">
								<input type="text" class="form-control" placeholder="keyword...">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
								</span>
							</div>
							<!-- /input-group -->
						</form>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content-wrapper">
			</div>
			<!-- END CONTAINER -->
			<!-- BEGIN FOOTER -->
                        <?php include_once("inc.footer.php");?>
			<!-- END FOOTER -->
			<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
			<!-- BEGIN CORE PLUGINS -->
			<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.blockui.min.js" type="text/javascript"></script>
			<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.cokie.min.js" type="text/javascript"></script>
			<script src="a<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
			<!-- END CORE PLUGINS -->
			<script src="<?php echo URL_ADMIN_ASSETS; ?>scripts/app.js"></script>
			<script>
jQuery(document).ready(function() {    
   App.init();
});
			</script>
			<!-- END JAVASCRIPTS -->
			</body>
			<!-- END BODY -->
			</html>