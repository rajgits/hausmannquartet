<?php
defined("PATH_ADMIN_MODULE") or die("Restrcited Access");
$pgMod="cms";
$pgSec="about";
$pageid=7;
$pgAct="view";
//permission("view",$pageid);
if(isset($_GET['action']) && trim($_GET['action'])!='')
	$pgAct=strtolower($_GET['action']);
if($_POST)
{
    $_SESSION['form']=$_POST;
    $caption=$_POST['caption'];
    $flgEr=FALSE;
    if(!isset($_POST['heading1']) || trim($_POST['heading1'])=='')
    {
        $flgEr=TRUE;
        array_push($alert_err,"Please Enter First Heading .");
    }
    if(!isset($_POST['description1']) || trim($_POST['description1'])=='' || trim($_POST['description1'])=='<br>')
    {
        $flgEr=TRUE;
        array_push($alert_err,"Please Enter First Description.");
    }
    if(!isset($_POST['description2']) || trim($_POST['description2'])=='' || trim($_POST['description2'])=='<br>')
    {
        $flgEr=TRUE;
        array_push($alert_err,"Please Enter Second Description.");
    }
    if(!isset($_POST['heading2']) || trim($_POST['heading2'])=='')
    {
        $flgEr=TRUE;
        array_push($alert_err,"Please Enter Second Heading.");
    }
    if(!isset($_POST['description3']) || trim($_POST['description3'])=='' || trim($_POST['description3'])=='<br>')
    {
        $flgEr=TRUE;
        array_push($alert_err,"Please Enter Third Description.");
    }

    $aryData=array(
                    'heading1'                   => trim($_POST['heading1']),
                    'description1'               => trim(addslashes($_POST['description1'])),
                    'description2'               => trim(addslashes($_POST['description2'])),
                    'heading2'                   => trim($_POST['heading2']),
                    'description3'               => trim(addslashes($_POST['description3'])),
                    'status'                    => $_POST['status']
                );
    $flgUp=$db->updateAry("about",$aryData,"");
    if(!is_null($flgUp))
    {	
        $_SESSION['msg']='Saved Successfully';
        unset($_SESSION['form']);
        redirect(URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)));
    }
    else
    {
        array_push($alert_err,$db->getErMsg());
    }
	
}
?>
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"><?php echo $projectname;?></h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_ROOT;?>/manage">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>About</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
 <?php                
$aryForm=$db->getRow("SELECT * FROM about");	
$teamimages=$db->getRows("SELECT * FROM about_team");	
?>		
<div class="tab-content">
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
            ?>
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>About
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                            <!-- BEGIN FORM-->
                            <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">First Heading *</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control required" name="heading1" id="heading1" placeholder="Enter Heading " value="<?php if($_POST){ echo $_POST['heading1'];} else { echo $aryForm['heading1'];}?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">First Description *</label>
                                    <div class="col-md-7">
                                        <textarea id="description1" rows='7' class="form-control tinymce required"   name="description1"><?php if($_POST){ echo $_POST['description1'];} else { echo stripslashes($aryForm['description1']);} ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Second Description *</label>
                                    <div class="col-md-7">
                                        <textarea id="description2" rows='7' class="form-control tinymce required"   name="description2"><?php if($_POST){ echo $_POST['description2'];} else { echo stripslashes($aryForm['description2']);} ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Second Heading *</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control required" name="heading2" id="heading2" placeholder="Enter Heading " value="<?php if($_POST){ echo $_POST['heading2'];} else { echo $aryForm['heading2'];}?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Third Description *</label>
                                    <div class="col-md-7">
                                        <textarea id="description3" rows='7' class="form-control tinymce required"   name="description3"><?php if($_POST){ echo $_POST['description3'];} else { echo stripslashes($aryForm['description3']);} ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status *</label>
                                    <div class="col-md-4">
                                        <select name="status" class="form-control" id="status">
                                        <option value="1" <?php echo selected("1",$aryForm['status']); ?>>Active</option>
                                        <option value="2" <?php echo selected("2",$aryForm['status']); ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions fluid">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                        <button type="button" class="btn btn-default" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)); ?>'">Back</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>			
    </div>
</div>
<script type="text/javascript" src="<?php echo URL_ADMIN_ASSETS; ?>tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		editor_selector : "tinymce",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
