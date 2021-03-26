<?php
require_once("../config.php");


if ($_POST) {
    if (!isset($_POST['username']) || trim($_POST['username']) == '' || trim($_POST['username']) == 'Username') {
        array_push($alert_err, "Please enter Username");
    } elseif (!isset($_POST['password']) || trim($_POST['password']) == '') {
        array_push($alert_err, "Please enter Password");
    } else {
        $aryChkName = $db->getVal("select value from settings where field='admin_uname' ");
        if ($aryChkName == $_POST['username']) {
            $aryChkPswd = $db->getVal("select value from settings where field='admin_pswd' ");
            if ($aryChkPswd == $_POST['password']) {


                $_SESSION[LOGIN_ADMIN]['admin_id'] = 1001;
                $_SESSION[LOGIN_ADMIN]['name'] = 'admin';
                $_SESSION[LOGIN_ADMIN]['type'] = 1;
                $_SESSION[LOGIN_ADMIN]['is_superadmin'] = 0;


                redirect(URL_ADMIN_HOME);
            } else {
                array_push($alert_err, "Username & Password is Invalid");
            }
        } else {
            array_push($alert_err, "Username & Password is Invalid");
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
    <meta charset="utf-8" />
    <title><?php echo $projectname; ?> | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_ASSETS; ?>plugins/select2/select2_conquer.css" />
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-conquer.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/style-responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/pages/login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_ADMIN_ASSETS; ?>css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="img/favicon.ico" />
</head>
<!-- BEGIN BODY --> 

<body class="login">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <img src="<?php echo URL_ROOT; ?>images/logo.png" alt="hausmannquartet" />
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="" method="post">
            <h3 class="form-title">Login to your account</h3>
            <?php
            if (is_array($alert_err) && count($alert_err) > 0) {
                foreach ($alert_err as $iError) {
            ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> <?php echo $iError; ?></span>
                    </div>
            <?php
                }
            }
            ?>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="<?php if ($_POST) {
                                                                                                                                                    echo trim($_POST['username']);
                                                                                                                                                } ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" value="<?php if ($_POST) {
                                                                                                                                                        echo trim($_POST['password']);
                                                                                                                                                    } ?>" />
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary pull-right">Login</button>
            </div>

        </form>
        <!-- END LOGIN FORM -->

    </div>

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