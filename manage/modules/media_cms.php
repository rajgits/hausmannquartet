<?php
defined("PATH_ADMIN_MODULE") or die("Restrcited Access");
$services=$db->getrows("select cms_id, title from about_cms");
$pgMod = "media"; 
$pgSec = "cms";
$pageid = 3;
?> 
<?php
$pgAct = "view";
if (isset($_GET['action']) && trim($_GET['action']) != '')
    $pgAct = strtolower($_GET['action']);

if (isset($_POST['submit']))
{
    $_SESSION['form'] = $_POST;
    $caption = $_POST['caption'];
    $flgEr = FALSE;
    if (!isset($_POST['title']) || trim($_POST['title']) == '') 
    {
        $flgEr = TRUE;
        array_push($alert_err, "Please enter Title.");
    } 
  

    if ($flgEr != TRUE && $pgAct == "add" && count($alert_err) == 0)
    {
        $chktitle=$db->getVal("select title from  media_cms where title='".trim($_POST['title'])."'");
        if($chktitle=='')
        {
            $linkname= seo_url($_POST['title']);
            $aryData = array(
                                'link_name'         => $linkname,
                                'title'             => trim($_POST['title']),
                                'status'            => trim($_POST['status']),
                                'image'              => trim($_POST['image']),
                            );
            if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]!='')
            {
                $filename = basename($_FILES['image']['name']); 
                $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
                if(in_array($ext,array('jpeg','jpg','gif','png','mp4','avi')))
                {
                    $newfile=md5(microtime()).".".$ext;  
                    if(move_uploaded_file($_FILES['image']['tmp_name'],"../uploads/cms/".$newfile))
                    {
                        copy("../uploads/cms/".$newfile,"../uploads/cms/100x100/".$newfile);
                        smart_resize_image("../uploads/cms/100x100/".$newfile,100,100);
                        $aryData['image'] = $newfile;
                    }
                }
            }
            $flgIn = $db->insertAry(" media_cms", $aryData);  
            if (!is_null($flgIn))
            { 
                $_SESSION['msg'] = 'Saved Successfully';
                unset($_SESSION['form']);
                redirect(URL_ADMIN_HOME . getQueryString(array("module" => $pgMod, "section" => $pgSec)));
            } 
            else
            {
                array_push($alert_err, $db->getErMsg());
            }
        }
        else
        {
            array_push($alert_err,"Title Already Exists.");			
        } 
    }  
    elseif($pgAct == "edit" && isset($_GET['id']) && trim($_GET['id']) != '' && count($alert_err) == 0)
    {
        $chktitle=$db->getVal("select title from  media_cms where title='".trim($_POST['title'])."' && cms_id!='".$_GET['id']."'");
        if($chktitle=='')
        {
            $linkname= seo_url($_POST['title']);
            $aryData = array(
                                'link_name'         => $linkname,
                                'title'             => trim($_POST['title']),
                                'status'            => trim($_POST['status']),
                                'image'              => trim($_POST['image']),
                            );
            if($_FILES["image"]["error"]==0)
            {
                $filename = basename($_FILES['image']['name']); 
                $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
                if(in_array($ext,array('jpeg','jpg','gif','png','mp4','avi')))
                {
                    $imgi = $db->getVal("select image from  media_cms where cms_id = '".$_GET['id']."'");
                    @unlink("../uploads/cms/$imgi");
                    @unlink("../uploads/cms/100x100/$imgi");
                    $newfile=md5(microtime()).".".$ext; 
                    if(move_uploaded_file($_FILES['image']['tmp_name'],"../uploads/cms/".$newfile))
                    {
                      copy("../uploads/cms/".$newfile,"../uploads/cms/100x100/".$newfile);
                      smart_resize_image("../uploads/cms/100x100/".$newfile,100,100); 
                      $aryData['image'] = $newfile;
                    }
                }              
            }
            $flgUp = $db->updateAry(" media_cms", $aryData, "where cms_id='".$_GET['id']."'");
            if (!is_null($flgUp))
            {
                $_SESSION['msg'] = 'Saved Successfully';
                unset($_SESSION['form']);
                redirect(URL_ADMIN_HOME . getQueryString(array("module" => $pgMod, "section" => $pgSec)));
            } 
            else
            {
                array_push($alert_err, $db->getErMsg());
            }
        }
        else
        {
            array_push($alert_err,"Title Already Exists.");			
        }
    }
}
elseif ($pgAct == "delete" && isset($_GET['id']) && trim($_GET['id']) != '') 
{
    $imgi = $db->getVal("select image from  media_cms where cms_id ='".$_GET['id']."'");
    @unlink("../uploads/cms/$imgi");
    @unlink("../uploads/cms/100x100/$imgi");
    $res=$db->delete(' media_cms',"where cms_id='".$_GET['id']."'"); 
    if(!is_null($res))
    {
        $_SESSION['msg'] = 'Deleted Successfully';
    } 
    else
    {
        array_push($alert_err, $db->getErMsg());
    }
    redirect(URL_ADMIN_HOME . getQueryString(array("module" => $pgMod, "section" => $pgSec)));
}
?>

<!-- BEGIN PAGE HEADER-->

<div class="row">
    <div class="col-md-12"> 
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"><?php echo $projectname;?></h3>
        <ul class="page-breadcrumb breadcrumb">
            <li> <i class="fa fa-home"></i> <a href="<?php echo URL_ROOT; ?>/manage/">Home</a> <i class="fa fa-angle-right"></i> </li>
            <li>Media CMS</li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB--> 
    </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
<?php
if ($pgAct == "add" || ($pgAct == "edit" && isset($_GET['id']) && trim($_GET['id']) != '')) 
{
    if ($pgAct == "edit" && !isset($_SESSION['form']))
    {
        $aryForm = $db->getRow("SELECT * FROM  media_cms WHERE cms_id='" . $_GET['id'] . "'");
    }
    if (isset($_SESSION['form']))
    {
        $aryForm = $_SESSION['form'];
        unset($_SESSION['form']);
    }
    $aryFrmAct = array("module" => $pgMod, "section" => $pgSec, "action" => $pgAct);
    if ($pgAct == "edit")
    {
        $aryFrmAct['id'] = $_GET['id'];
    }
    ?>
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
                    ?>
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-reorder"></i><?php echo ucfirst($pgAct); ?></div>
                        </div>
                        <div class="portlet-body form"> 
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Title *</label>
                                        <div class="col-md-7">
                                            <input type='text' name="title" id="title" class="form-control" value='<?php if($_POST) { echo trim($_POST['title']);}else { echo $aryForm['title'];} ?>' placeholder="Enter Title">
                                        </div>
                                    </div>

                                      <div class="form-group">
                                        <label class="col-md-3 control-label"> Image  </label>
                                        <div class="col-md-7">
                                            <input type="file" name="image" id="image"><br/>
                                            <?php 
                                            if($aryForm['image']!='' && file_exists("../uploads/cms/".$aryForm['image']))
                                            {
                                                ?>
                                                <img src="<?php echo URL_ROOT ?>uploads/cms/100x100/<?php echo $aryForm['image'] ?>">
                                                <?php
                                            }
                                            ?>
                                          </div>
                                    </div>   



                                    <div class="form-body"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Status *</label>
                                        <div class="col-md-4">
                                            <select name="status" class="form-control" id="status">
                                            <option value="1" <?php echo selected("1",$aryForm['status']); ?>>Active</option>
                                            <option value="2" <?php echo selected("2",$aryForm['status']); ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions fluid">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                        <button type="button" class="btn btn-default" onclick="window.location = '<?php echo URL_ADMIN_HOME . getQueryString(array("module" => $pgMod, "section" => $pgSec)); ?>'">Back</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM--> 
                        </div>
                    </div>
                </div>
            </div>
    <?php
}
elseif($pgAct=="view" && isset($_GET['id']) && trim($_GET['id']) !='')
{
    $aryForm=$db->getRow("SELECT * FROM  media_cms WHERE cms_id='".(int)$_GET['id']."'");
    ?>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-reorder"></i>CMS
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-3">Title :</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">
                                    <?php echo ucfirst($aryForm['title']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Image  </label>
                                        <div class="col-md-7">
                                            <input type="file" name="image" id="image"><br/>
                                            <?php 
                                            if($aryForm['image']!='' && file_exists("../uploads/cms/".$aryForm['image']))
                                            {
                                                ?>
                                                <img src="<?php echo URL_ROOT ?>uploads/cms/100x100/<?php echo $aryForm['image'] ?>">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
 

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-3">Status :</label>
                                <div class="col-md-9">
                                <p class="form-control-static"><?php if($aryForm['status']==1){ echo "Active";} else{ echo "Inactive";} ?></p>
                                    </div>
                            </div>
                        </div>
                    </div>          
                </div>
                <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-offset-3 col-md-9">
                               
                                  <button class="btn btn-success" type="button" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec,"action"=>"edit","id"=>$_GET['id'])); ?>'"><i class="fa fa-pencil"></i> Edit</button>
                                  <button class="btn btn-default" type="button" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)); ?>'">Cancel</button>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
    <?php 
}
else 
{
    $sqlLimit = "SELECT * FROM   media_cms ORDER BY cms_id DESC";
    $sqlCnt = "select count(cms_id) from  cms";
    $recCnt = $db->getVal($sqlCnt);
    $aryList = $db->getRows($sqlLimit);
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"> <i class="fa fa-globe"></i>CMS </div>   
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <?php $aryPgAct = array("module" => $pgMod, "section" => $pgSec, "action" => "add"); ?>
                           
                            <a href="<?php echo URL_ADMIN_HOME . getQueryString($aryPgAct); ?>">
                                <button class="btn btn-success"> Add <i class="fa fa-plus" ></i> </button>
                            </a>
                        
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_editable_1" width="100%">
                    <thead>
                        <tr>
                            <th style="display:none"></th>
                            <th width="20%">Title </th>
                            <th width="20%">Status </th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($aryList) > 0)
                        {
                            foreach ($aryList as $iList)
                            {
                                $pgCnt = ceil($recCnt / $pgRec);
                                $aryPgAct["id"] = $iList['cms_id'];
                                ?>
                                <tr class="odd gradeX">
                                    <td style="display:none"></td>
                                    <td><?php echo substr(ucfirst($iList['title']), 0, 100);if (strlen($iList['title']) > 100) { echo '...';} ?></td>
                                    <td style="width:20%">
                                        <?php 
                                            if($iList['status']==1)
                                            {
                                            ?>
                                                <span class="label label-sm label-success">Active</span>
                                            <?php                                            
                                            }
                                            else
                                            { 
                                            ?>
                                                <span class="label label-sm label-danger">Inactive</span>
                                            <?php 
                                            } 
                                            $aryPgAct['action']="view";?>
                                    </td>
                                    <td>
                                         <a class="btn btn-default btn-xs purple" href="<?php echo URL_ADMIN_HOME.getQueryString($aryPgAct); ?>"><i class="fa fa-share"></i> View</a>
                                        <?php $aryPgAct['action'] = "edit"; ?>
                                            <a class="btn btn-default btn-xs purple" href="<?php echo URL_ADMIN_HOME . getQueryString($aryPgAct); ?>"><i class="fa fa-edit"></i> Edit</a>
                                        <?php $aryPgAct['action'] = "delete"; ?>
                                            <a class="btn btn-default btn-xs black" onclick="return confirm('Are you sure?');" href="<?php echo URL_ADMIN_HOME . getQueryString($aryPgAct); ?>"><i class="fa fa-trash-o"></i> Delete</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php  
                        } 
                        ?>
                        </tbody>
                    </table>
                    <?php
                    if ($pgCnt > 1) {
                        //echo getPaging(URL_ADMIN,$_GET,$pgCnt,$pgCur);
                    }
                    ?>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
<?php } ?>
    </div>
</div>
<!-- END PAGE CONTENT-->

<?php
if (isset($_GET['id']) && $_GET['id'] != "" && $action = 'edit')
{
    $aryPgAct = array("module" => $pgMod, "section" => $pgSec, "action" => "edit", "id" => $_GET['id']);
}
else
{
    $aryPgAct = array("module" => $pgMod, "section" => $pgSec, "action" => "add");
}
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
