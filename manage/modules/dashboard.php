<?php

defined("PATH_ADMIN_MODULE") or die("Restrcited Access");
$pgMod = "settings";
$pgSec = "general";
$pageid = 13;
if ($_POST) 
{
    
    $_SESSION['form'] = $_POST;
    $flgEr = FALSE;
    if (!isset($_POST['admin_email']) || trim($_POST['admin_email']) == '')
    {
        array_push($alert_err, "Please enter admin email ");
    } 
    if (!isset($_POST['general_meta_title']) || trim($_POST['general_meta_title']) == '')
    {
        array_push($alert_err, "Please enter Meta Title ");
    }
    if(isset($_FILES["homepage_video"]["name"]) && $_FILES["homepage_video"]["name"]!='')
    {
        $filename = basename($_FILES['homepage_video']['name']); 
        $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
        if(!in_array($ext,array('mp3','mp4')))
        {
            array_push($alert_err, "Please Select only mp3 and mp4 video.");
        }
    }
    if ($flgEr === TRUE) 
    {
        array_push($alert_err, "Some Error Occured");
    } 
    else
    {
        foreach ($_POST as $field => $value) 
        {
            
            if($field=='howitworks_description')
            {
                $flgUp = $db->update("update settings set `value`='" .addslashes($value). "' where `field`='" .$field."'");
            }
            else
            {
                $flgUp = $db->update("update settings set `value`='" .$value. "' where `field`='" .$field."'");
            }

            if(isset($_FILES["homepage_video"]["name"]) && $_FILES["homepage_video"]["name"]!='')
            {
                $filename = basename($_FILES['homepage_video']['name']); 
                $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
                if(in_array($ext,array('mp3','mp4')))
                {
                    $newfile=md5(microtime()).".".$ext;
                    
                    if(move_uploaded_file($_FILES['homepage_video']['tmp_name'],"../uploads/home/".$newfile))
                    {
                        $flgUp = $db->update("update settings set `value`='".$newfile."' where `field`='homepage_video'");
                    }
                    
                }
            }
            
        }
        
        $_SESSION['msg'] = 'Updated Successfully';
        unset($_SESSION['form']);
    }
}
if (isset($_SESSION['form']))
{
    $aryForm = $_SESSION['form'];
    unset($_SESSION['form']);
} 
else
{
    $aryFormTemp = $db->getRows("select * from settings where field in ('notification','admin_email', 'general_meta_title', 'general_meta_tags','general_meta_desc','twitter_url','facebook_url','linkedin_url','contact_address','general_google_analytics','contact_number','youtube_url','instagram','google_plus','pinterest_url','contact_title','contact_description','howitworks_description','footer_text','homepage_video','fax')");
    if (!is_null($aryFormTemp) && is_array($aryFormTemp) && count($aryFormTemp) > 0) 
    {
        foreach ($aryFormTemp as $iFormTemp)
        {
            $aryForm[$iFormTemp['field']] = $iFormTemp['value'];
        }
    }
}
?>
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"><?php echo $projectname; ?></h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_ROOT; ?>/manage/">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>General Settings</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_0">
            <?php
            if (is_array($alert_err) && count($alert_err) > 0) 
            {
                foreach ($alert_err as $iError)
                {
                    ?>
                        <div class="alert alert-danger"><?php echo $iError; ?></div>
                    <?php
                }
            }
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != "")
            {
                ?>
                <div class="alert alert-success"><?php echo $_SESSION['msg'];
                unset($_SESSION['msg']);
                ?>
                </div>
                <?php
                }
                ?>
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>General Settings</div>
                    </div>
                    <div class="portlet-body form">
                        <div>&nbsp;</div>
                        <!-- BEGIN FORM-->
                        <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Title *</label>
                                    <div class="col-md-7">
                                        <input type="text" name="general_meta_title" id="general_meta_title" class="form-control required" placeholder="Meta Title" value="<?php echo $aryForm['general_meta_title']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Keyword </label>
                                    <div class="col-md-7">
                                        <input type="text" name="general_meta_tags" id="general_meta_tags" class="form-control" placeholder="Meta Keyword" value="<?php echo $aryForm['general_meta_tags']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Description  </label>
                                    <div class="col-md-7">
                                        <textarea name="general_meta_desc" id="general_meta_desc" class="form-control"><?php echo $aryForm['general_meta_desc']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Google Analytics Code  </label>
                                    <div class="col-md-7">
                                        <textarea name="general_google_analytics" id="general_google_analytics" class="form-control"><?php echo $aryForm['general_google_analytics']; ?></textarea>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Title </label>
                                    <div class="col-md-7">
                                        <input type="text" name="contact_title" id="contact_title" class="form-control" placeholder="Meta Keyword" value="<?php echo ucfirst($aryForm['contact_title']); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Emails & Postitions  </label> 
                                    <div class="col-md-7">
                                        <textarea name="contact_description"  rows="8" id="contact_description" class="form-control"><?php echo ucfirst(stripslashes($aryForm['contact_description'])); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Primary Email *</label> 
                                    <div class="col-md-7">
                                        <input type="text" name="admin_email" id="admin_email" class="form-control email required" placeholder="Enter Contact Email" value="<?php echo $aryForm['admin_email']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Number *</label>
                                    <div class="col-md-7">
                                        <input type="text" name="contact_number" id="contact_number" class="form-control required" placeholder="Enter Contact Number" value="<?php echo $aryForm['contact_number']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Fax</label>
                                    <div class="col-md-7">
                                        <input type="text" name="fax" id="contact_number" class="form-control required" placeholder="Enter Fax Number" value="<?php echo $aryForm['fax']; ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact Address </label>
                                    <div class="col-md-7">
                                        <textarea name="contact_address" id="contact_address" class="form-control"><?php echo $aryForm['contact_address']; ?></textarea>
                                    </div>
                                </div>
                             
                             
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Facebook Url </label>
                                    <div class="col-md-7">
                                        <input type="text" name="facebook_url" id="facebook_url" class="form-control" placeholder="Facebook Url" value="<?php echo $aryForm['facebook_url']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Instagram Url </label>
                                    <div class="col-md-7">
                                        <input type="text" name="instagram" id="instagram" class="form-control" placeholder="Instagram Url" value="<?php echo $aryForm['instagram']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Linkedin Url </label>
                                    <div class="col-md-7">
                                        <input type="text" name="linkedin_url" id="linkedin_url" class="form-control" placeholder="Linkedin Url" value="<?php echo $aryForm['linkedin_url']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Twitter Url </label>
                                    <div class="col-md-7">
                                        <input type="text" name="twitter_url" id="twitter_url" class="form-control" placeholder="Twitter Url" value="<?php echo $aryForm['twitter_url']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pinterest Url</label>
                                    <div class="col-md-7">
                                        <input type="text" name="pinterest_url" id="pinterest_url" class="form-control" placeholder="Pinterest Url" value="<?php echo $aryForm['pinterest_url']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Youtube Url</label>
                                    <div class="col-md-7">
                                        <input type="text" name="youtube_url" id="youtube_url" class="form-control" placeholder="Youtube Url" value="<?php echo $aryForm['youtube_url']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Google Plus Url </label>
                                    <div class="col-md-7">
                                        <input type="text" name="google_plus" id="google_plus" class="form-control" placeholder="Google Plus Url" value="<?php echo $aryForm['google_plus']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                    <button type="button" class="btn btn-default" onclick="window.location = '<?php echo URL_ADMIN_HOME . getQueryString(array("module" => $pgMod, "section" => $pgSec)); ?>'">Cancel</button>
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
<!-- END PAGE CONTENT-->


<?php
if (isset($_GET['id']) && $_GET['id'] != "" && $action = 'edit')
    $aryPgAct = array("module" => $pgMod, "section" => $pgSec, "action" => "edit", "id" => $_GET['id']);
else
    $aryPgAct = array("module" => $pgMod, "section" => $pgSec, "action" => "add");
?>
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

