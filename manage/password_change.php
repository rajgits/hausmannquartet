<?php
defined("PATH_ADMIN_MODULE") or die("Restrcited Access");
$pgMod="password";
$pgSec="change";
$pageid=21;
$pgAct="edit";
if(isset($_GET['action']) && trim($_GET['action'])!='')
$pgAct=strtolower($_GET['action']);
if($_POST)
{
   
                $_SESSION['form'] = $_POST;
                $flgEr=FALSE;
                if(!isset($_POST['from_name']) || trim($_POST['from_name'])=='')
                {
                        $flgEr=TRUE;
                        array_push($alert_err,"Please enter From Name.");
                }
               
                elseif(!isset($_POST['from_email']) || trim($_POST['from_email'])=='')
                {
                        $flgEr=TRUE;
                        array_push($alert_err,"Please enter From Email.");
                }
                elseif(!isset($_POST['subject']) || trim($_POST['subject'])=='')
                {
                        $flgEr=TRUE;
                        array_push($alert_err,"Please enter Subject.");
                }
                elseif(!isset($_POST['body']) || trim($_POST['body'])=='')
                {
                        $flgEr=TRUE;
                        array_push($alert_err,"Please enter Body.");
                }
                elseif(!isset($_POST['email_type']) || trim($_POST['email_type'])=='')
                {
                        $flgEr=TRUE;
                        array_push($alert_err,"Please enter Emailt type.");
                }
    
		if($pgAct=="edit" && isset($_GET['id']) && trim($_GET['id'])!='' && count($alert_err)==0)
		{
                    
			$chkemail = $db->getVal("select count(email_type) from emails where email_type = '".$_POST['email_type']."' and emails_id != ".$_GET['id']);
			if($chkemail == 0)
			{
					$aryData = array(
                                                            'from_name'		=>		$_POST['from_name'],
                                                            'from_email'	=>		$_POST['from_email'],
                                                            'subject'		=>		$_POST['subject'],
                                                            'body'		=>		$_POST['body'],
                                                            'email_type'	=>		$_POST['email_type'],
                                                          );				  
					$flgUp = $db->updateAry("emails",$aryData,"where emails_id=".$_GET['id']);
                                        //echo $db->getLastQuery();
					echo $db->getErMsg();
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
			else
			{
				array_push($alert_err,"Email Type Already Exists.");
			}
		}
	
}
elseif($pgAct=="delete" && isset($_GET['link_id']) && trim($_GET['link_id'])!='')
{
    
    $res=$db->delete("cms","where link_id='".$_GET['link_id']."'");
    if(!is_null($res)) 
    {
    $_SESSION['success']="Deleted Successfully";
    }
    else { $stat['error'] = $validate->errors(); }
    redirect(URL_ADMIN."email_settings.php");
}
?>
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Trans Deal </h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo URL_ROOT;?>/manage/">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>Emails</li>
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
    <div class="portlet">
        <div class="portlet-title">
                <div class="caption">
                        <i class="fa fa-reorder"></i>Email</div>
        </div>
        <div class="portlet-body form">
                <!-- BEGIN FORM-->
            <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
                        <div class="form-body">


                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Password</label>
                            <div class="col-md-7">
                                    <input type="text" name="old_password" id="old_password" class="form-control" placeholder="Old Password" value="<?php echo $aryForm['old_password']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Password</label>
                            <div class="col-md-7">
                                    <input type="text" name="new_password" id="new_password" class="form-control required" placeholder="New Password" value="<?php echo $aryForm['new_password']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm Password</label>
                            <div class="col-md-7">
                                    <input type="text" name="con_password" id="con_password" class="form-control required" placeholder="Confirm Password" value="<?php echo $aryForm['con_password']; ?>">
                            </div>
                        </div>
                        </div>
                        <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                        <button type="button" class="btn btn-default" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)); ?>'">Cancel</button>
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
	


 
