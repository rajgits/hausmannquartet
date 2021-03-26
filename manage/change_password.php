<?php
require_once("../config.php");
if($_POST)
{
	$flgEr=FALSE;
	$aryEr=array('type'=>'','note'=>'');
	
	if(!isset($_POST['pswd_cur']) || trim($_POST['pswd_cur'])=='')
	{
		$flgEr=TRUE;
		array_push($alert_err,"Current Password is Required");
	}
	elseif(!isset($_POST['pswd_new']) || trim($_POST['pswd_new'])=='')
	{
		$flgEr=TRUE;
		array_push($alert_err,"New Password is Required");
	}
	elseif(strlen($_POST['pswd_new'])<$_pswd_len['min'])
	{
		$flgEr=TRUE;
		array_push($alert_err,"The new password length should be minimum ".$_pswd_len['min']." characters");
	}
	elseif($_pswd_len['max']>0 && strlen($_POST['pswd_new'])>$_pswd_len['max'])
	{
		$flgEr=TRUE;
		array_push($alert_err,"New Password length is greater than permitted ".$_pswd_len['max']." characters");
	}
	
	elseif(!isset($_POST['pswd_retype']) || trim($_POST['pswd_retype'])=='')
	{
		$flgEr=TRUE;
		array_push($alert_err,"Re-Type Password is Required");
	}
	elseif($_POST['pswd_retype']!==$_POST['pswd_new'])
	{
		$flgEr=TRUE;
		array_push($alert_err,"Password doesn't match.");
	}
	if($flgEr!=TRUE)
	{
		$aryChk=$db->getRow("select * from settings where `field`='admin_pswd' and `value`='".$_POST['pswd_cur']."'");
		if(is_null($aryChk))
		{
			array_push($alert_err,"Check Failed.<br />".$db->getErMsg());
		}
		elseif(is_array($aryChk))
		{
			if(count($aryChk)>0)
			{
				$flgUp=$db->update("update settings set `value`='".$_POST['pswd_new']."' where `field`='admin_pswd'");
				if(!is_null($flgUp))
				{
					array_push($alert_msg,"Updated Successfully");
				}
				else
				{
					array_push($alert_err,"Updated Failed.<br />".$db->getErMsg());
				}
			}
			else
			{
				array_push($alert_err,"Invalid Current Password");
			}
		}
	}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Trans Deal | Login</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="MobileOptimized" content="320">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_ASSETS; ?>plugins/select2/select2_conquer.css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-conquer.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/pages/login.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_ADMIN_ASSETS; ?>css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<img src="<?php echo URL_ADMIN_ASSETS; ?>img/logo.png" alt=""/>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="" method="post">
		<h3 class="form-title">Login to your account</h3>
        <?php 
		if(is_array($alert_err) && count($alert_err)>0)
		{
			foreach($alert_err as $iError)
			{
				?>
                <div class="alert alert-error">
                    <button class="close" data-close="alert"></button>
                    <span> <?php echo $iError; ?></span>
                </div>
	                
                <?php		
			}
		}
		?>
        
        
		
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Current Password</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
                                <input class="form-control placeholder-no-fix" type="password" name="pswd_cur" id="pswd_cur" value="<?php echo $aryForm['pswd_cur']; ?>" placeholder="Current Password"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">New Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
                                <input class="form-control placeholder-no-fix" type="password" name="pswd_new" id="pswd_new" value="<?php echo $aryForm['pswd_new']; ?>" placeholder="New Password"/>
			</div>
		</div>
                <div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Re-Type Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
                                <input class="form-control placeholder-no-fix" type="password" name="pswd_retype" id="pswd_retype" value="<?php echo $aryForm['pswd_retype']; ?>" placeholder="Re type Password"/>
			</div>
		</div>
		<div class="form-actions">
			
			<button type="submit" class="btn btn-info pull-right">
			Login 
                        </button>
		</div>
	
	</form>
	<!-- END LOGIN FORM -->
	
	</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright" style="color:#FFF;">     2014 &copy; design & development by <a href="http://www.omsoftware.net"  style="color:#FFF; text-decoration:none;" target="_blank"> OMSCORPS</a>. </div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/respond.min.js"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_ADMIN_ASSETS; ?>scripts/app.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
  App.init();
  Login.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>