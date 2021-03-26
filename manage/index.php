<?php
require_once("../config.php");
require_once("../library/resize_image.php");


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
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $projectname;?> | Admin Panel </title>
<link rel="icon" href="<?php echo URL_ROOT; ?>images/icon.png" type="image/x-icon">   
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
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_ASSETS; ?>plugins/select2/select2_conquer.css"/>
<link rel="stylesheet" href="<?php echo URL_ADMIN_ASSETS; ?>plugins/data-tables/DT_bootstrap.css"/>


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



              <?php
				if($flgLogged===TRUE)
				{
					$incFile="dashboard";
					//echo $_GET['module'];
					if(isset($_GET['module']) && trim($_GET['module'])!='') $incFile=strtolower($_GET['module']);
					if(isset($_GET['section']) && trim($_GET['section'])!='') $incFile.="_".strtolower($_GET['section']);
					$incFile.=".php";
					//echo $incFile;
					
					if(file_exists(PATH_ADMIN_MODULE.$incFile))
					{
                        if(isset($_SESSION[LOGIN_ADMIN]['type']) && $_SESSION[LOGIN_ADMIN]['type'] == 1)
                        {
                               // echo "<pre>";
                               // print_r($pagepermition);
                               // echo "</pre>";
                          foreach($pagepermition as $key=>$value)
                          {
                              if($value == $_GET['section'])
                              {
                                   $aryPerMition = $db->getRow("SELECT * FROM permissions WHERE admin_id = ".$_SESSION[LOGIN_ADMIN]['admin_id']." and page_id = ".$key." ");
									 var_dump($aryPerMition);
									 exit();  
								   echo $db->getErMsg();
                                   if($aryPerMition['add_access'] !=$key && $_GET['action']=="add")
                                    {
                                        redirect("404.php");
                                    }
                                    elseif($aryPerMition['edit_access'] =='' && $_GET['action']=="edit")
                                    {
                                         redirect("404.php");
                                    }
                                    elseif($aryPerMition['delete_access'] =='' && $_GET['action']=="delete")
                                    {
                                         redirect("404.php");
                                    }
//                                                        elseif($aryPerMition['all_access'] =='' && ($_GET['action']=="add" || $_GET['action']=="edit" || $_GET['action']=="delete"))
//                                                        {
//                                                             redirect("404.php");
//                                                        }

                              }

                          }
						}
						
					
                         require_once(PATH_ADMIN_MODULE.$incFile);
					}
					else
					{
						
						require_once(PATH_ADMIN_MODULE."404.php");
					}
				}
				else
				{
					if(trim($_SERVER['QUERY_STRING'])!='' && strtolower($_SERVER['QUERY_STRING'])=="forgot" && file_exists(PATH_ADMIN_MODULE."forgot.php"))
					{
						require_once(PATH_ADMIN_MODULE."forgot.php");
					}
					elseif(file_exists(PATH_ADMIN_MODULE."login.php"))
					{
						require_once(PATH_ADMIN_MODULE."login.php");
					}
					else
					{
					   	require_once(PATH_ADMIN_MODULE."404.php");
					}
				}
				?>
			<div class="clearfix">
			</div>

			<div class="clearfix">
			</div>
				<!-- BEGIN OVERVIEW STATISTIC BLOCKS-->
                <!-- END OVERVIEW STATISTIC BLOCKS-->
		</div>
	</div>

	



</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include_once("inc.footer.php");?>
<![endif]-->
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>plugins/bootstrap-markdown/lib/markdown.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>scripts/validation.js"></script>
<script type="text/javascript" src="<?php echo URL_ROOT;?>manage/js/canvasjs.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script src="<?php echo URL_ADMIN_ASSETS; ?>scripts/app.js"></script>
<script src="<?php echo URL_ADMIN_ASSETS; ?>scripts/form-validation.js"></script>
 <script type="text/javascript">
	$(document).ready(function(){
		$("#myForm").validate();
	});
	</script>
<?php if($_GET['section']=='demo'){?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT;?>css/jquery.datetimepicker.css"/>
<script type="text/javascript" src="<?php echo URL_ROOT;?>js/jquery.datetimepicker.js"></script>
<script>
jQuery('#datetimepicker').datetimepicker();
</script>
<?php } ?>
<!-- END PAGE LEVEL STYLES -->
<script type="application/x-javascript">
jQuery(document).ready(function() {
   // initiate layout and plugins
   App.init();
   FormValidation.init();
});
</script>
<script type="text/javascript" src="<?php echo URL_ROOT;?>manage/assets/plugins/select2/select2.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo URL_ROOT;?>manage/assets/plugins/data-tables/jquery.dataTables.js"></script> -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ROOT;?>manage/assets/plugins/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- <script type="text/javascript" type="text/javascript" src=""></script> -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/scripts/app.js"></script>
<script src="assets/scripts/table-editable.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
  // App.init();
   TableEditable.init();
});
</script>
<script>
  $(document).ready(function() {
        var table = $('#sample_editable_11').DataTable( {
            "aaSorting": [],
        } );
        var buttons = new $.fn.dataTable.Buttons(table, {
             buttons: [
                 'copy', 'csv', 'excel', 'pdf', 'print',
             ],
        }).container().appendTo($('#DTbuttons'));
    });

</script>
</body>
</html>
