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
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title"><?php echo $projectname;?></h3>
    <ul class="page-breadcrumb breadcrumb">
      <li> <i class="fa fa-home"></i> <a href="<?php echo URL_ROOT;?>/manage/">Home</a> <i class="fa fa-angle-right"></i> </li>
      <li>Change Password</li>
    </ul>
    <!-- END PAGE TITLE & BREADCRUMB--> 
  </div>
</div>
<div class="box-buttons">
    <div id="forms" class="tab-content no-padding">
        <div style="padding:5px 10px;">
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
		elseif(is_array($alert_msg) && count($alert_msg)>0)
		{
			foreach($alert_msg as $iMsg)
			{
				?>
	                <div class="alert alert-success"><?php echo $iMsg; ?></div>
                <?php
			}
		}
		?>
        </div>
        
        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
      <div class="form-body">
        <div class="form-group">
          <label class="col-md-3 control-label">Current Password *</label>
          <div class="col-md-4">
            <input type="password" name="pswd_cur" id="pswd_cur" value="<?php echo $aryForm['pswd_cur']; ?>" class="form-control required"></input>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-3 control-label">New Password *</label>
          <div class="col-md-4">
            <input type="password" name="pswd_new" id="pswd_new" value="<?php echo $aryForm['pswd_new']; ?>" class="form-control required"></input>
          </div>
        </div>
          
        <div class="form-group">
          <label class="col-md-3 control-label">Re-Type Password</label>
          <div class="col-md-4">
            <input type="password" name="pswd_retype" id="pswd_retype" value="<?php echo $aryForm['pswd_retype']; ?>" class="form-control required">
          </div>  
        </div>
      </div>
      <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
          <button type="submit" name="submit" class="btn btn-info">Submit</button>
        </div>
      </div>
    </form>
    </div>				
</div>