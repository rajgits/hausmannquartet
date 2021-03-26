<?php
require_once("../config.php");
if($_POST)
{
        if(!isset($_POST['email']) || trim($_POST['email'])=='')
        {
                $flgEr=TRUE;
                array_push($alert_err,"Please enter Email.");
        }
        $aryChk=$db->getVal("select count(admin_id) from admin where email = '".$_POST['email']."'");
        if($aryChk>0)
        {
                        $reqLen=$_pswd_len['min']+1;
			$pswdNewMd5=md5(time());
			$pswdNew=substr($pswdNewMd5,rand(0,strlen($pswdNewMd5)-$reqLen),$reqLen);
                        $aryData=array(         'value'                  =>	$pswdNew,    
                                                );


                        $flgUp=$db->updateAry("settings",$aryData,"where field = 'admin_pswd'");
                        $admin_name=$db->getVal("select name from admin where email = '".$_POST['email']."'");
                        $link = URL_ROOT. "login.php?vcode=" .$newpas;
                        $href = "<a href='$link'>Click here to login!</a>";
                        $vars = array(
                                                   'admin_fname'     =>    $admin_name,
                                                   'admin_pswd'      =>    $pswdNew,
                                                   'link'            =>    $href,
                                      );
                        
                        mail_template($_POST['email'], "forgot_passwordadmin", $vars,"");
                        $_SESSION['msg']='Password Sent Successfully';
                        redirect("forgot.php");
        }
        else
        {
            array_push($alert_err,"Email is invalid.");
             //   array_push($alert_err,"Password Reset Failed.".$db->getErMsg());
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
<title>Dealala| Forgot Password</title>
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
	<img src="<?php echo URL_ROOT; ?>images/logo.png" alt=""/>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="forget-form1" action="" method="post" id="myForm">
		<h3>Forget Password ?</h3>
        
                            <?php 
                                if(is_array($alert_err) && count($alert_err)>0)
                                {
                                        foreach($alert_err as $iError)
                                        {
                                                ?>
                                                <div class="alert alert-danger"><?php echo $iError; ?></div>
                                                <?php		
                                        }
                                }
                                 if(isset($_SESSION['msg']) && $_SESSION['msg']!="")
                {
                        ?>
                        <div class="alert alert-success"><?php echo $_SESSION['msg'];
                                unset($_SESSION['msg']); ?></div>
                <?php
                }
        ?>
        
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix required" type="email" autocomplete="off" placeholder="Email" name="email" value="<?php echo $_POST['email']?>" id="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn btn-default" onClick="window.location='<?php echo URL_ADMIN;?>login.php'">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn btn-info pull-right">
			Submit </button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
	
	</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright" style="color:#FFF;">     2017 &copy; Design & Development by <a href="https://prowebtechnos.com/"  style="color:#FFF; text-decoration:none;" target="_blank"> Pro Web Technos</a>. </div>
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
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>scripts/validation.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
  App.init();
  Login.init();
});
</script>
 <script type="text/javascript">  
	$(document).ready(function(){
		$("#myForm").validate();
	});
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>