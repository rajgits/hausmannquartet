<?php 
defined("PATH_ADMIN_MODULE") or die("Restrcited Access");
$pgMod="resources";
$pgSec="lconstants";
$pageid=2;
$pgAct="view";
if(isset($_GET['action']) && trim($_GET['action'])!='')
$pgAct=strtolower($_GET['action']);
if($_POST)
{
    $_SESSION['form']=$_POST;
    $caption=$_POST['caption'];
    $flgEr=FALSE;

    if($flgEr!=TRUE && $pgAct=="add" && count($alert_err)==0)
    {
	$lancount = $db->getVal("select count(lan_con_junc_id) from language_constant_junc where constant_id = '".trim($_POST['constant_id'])."' AND language_id = '".trim($_POST['language_id'])."'");
		
        if($lancount==0)
        {
            $aryData=array(	
                        'constant_value'	=>	htmlentities($_POST['constant_value']),
                        'constant_id'		=>	$_POST['constant_id'],
                        'language_id'		=>	$_POST['language_id'],
                        'status'	   	=>  $_POST['status']
                    );
            $flgIn=$db->insertAry("language_constant_junc",$aryData);
            if(!is_null($flgIn))
            {
                $_SESSION['msg']='Saved Successfully';
                unset($_SESSION['form']);


                $languagev =$db->getRow("SELECT * FROM languages WHERE id ='".$_POST['language_id']."'");
                echo $db->getErMsg();
                //echo $db->getLastQuery();

                $languageName1=$languagev['short'];

                $languageval=$db->getRows("SELECT language_constant_junc.*,constants.constant_name FROM language_constant_junc,constants WHERE language_constant_junc.constant_id =constants.constant_id and language_constant_junc.language_id='".$_POST['language_id']."' ");

                echo $db->getErMsg();

                if(count($languageval)>0)
                {
                    $fileName = "../language/".$languageName1."_language.php" ;
                    $file = fopen($fileName,"w") or exit("Unable to open file!");        
                    $ilanguage = "<?php"." ";
                    foreach($languageval as $language)
                    {
                        $ilanguage.="define("."\"".$language['constant_name']."\"".","."\"".$language['constant_value']."\"".")".";"; 
                    }
                    $ilanguage.= "?>";
                    fwrite($file, $ilanguage);
                    fclose($file);
                    
                    
                    /*  start used in mobile application     */
                    $fileNamejs = "../language/".$languageName1."_language.js" ;
                    $filejs = fopen($fileNamejs,"w") or exit("Unable to open file!");        
                    
                    $ilanguagejs='';
                    foreach($languageval as $language)
                    {
                        if($language['constant_name']=='ENTER YOUR_NETLER')
                        {
                            $language['constant_name']='ENTER_YOUR_NETLER';
                        }
                        if($language['constant_name']=='E-CURRENCY2')
                        {
                            $language['constant_name']='E_CURRENCY2';
                        }
                        
                        $ilanguagejs.="var ".$language['constant_name']."="."\"".$language['constant_value']."\"".";";
                    }
                   
                    fwrite($filejs, $ilanguagejs);
                    fclose($filejs);
                    /*  end used in mobile application     */
                }

                redirect(URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)));
            }
            else
            {
                array_push($alert_err,$db->getErMsg());			
            }
        }
        else
        {
            $flgEr=TRUE;
            array_push($alert_err,"Value is alrealy added to the selected Constant");
        }
    }
    elseif($pgAct=="edit" && isset($_GET['id']) && trim($_GET['id'])!='' && count($alert_err)==0)
    {
        $lancount = $db->getVal("select count(lan_con_junc_id) from language_constant_junc where constant_id = '".trim($_POST['constant_id'])."' AND language_id = '".trim($_POST['language_id'])."' AND lan_con_junc_id!='".$_GET['id']."' ");
        if($lancount==0)
        {

            $aryData=array(	
                            'constant_value'	=>	htmlentities($_POST['constant_value']),
                            'constant_id'		=>	$_POST['constant_id'],
                            'language_id'		=>	$_POST['language_id'],
                            'status'	   		=>  $_POST['status']
            );

            $flgUp=$db->updateAry("language_constant_junc",$aryData,"where lan_con_junc_id='".$_GET['id']."'");
            if(!is_null($flgUp))
            {	
                $_SESSION['msg']='Saved Successfully';
                unset($_SESSION['form']);

                $languagev =$db->getRow("SELECT * FROM languages WHERE id ='".$_POST['language_id']."'");
                echo $db->getErMsg();
                //echo $db->getLastQuery();

                $languageName1=$languagev['short'];

                $languageval=$db->getRows("SELECT language_constant_junc.*,constants.constant_name FROM language_constant_junc,constants WHERE language_constant_junc.constant_id =constants.constant_id and language_constant_junc.language_id='".$_POST['language_id']."' ");

                echo $db->getErMsg();

                if(count($languageval)>0)
                {

                    $fileName = "../en_language.csv" ;
                    $file = fopen($fileName,"w") or exit("Unable to open file!");        
                    $header = array('constant_name','constant_value');
                    fputcsv($file, $header);

                    foreach($languageval as $language)
                    {

                        $ilanguage = array($language['constant_name'] => $language['constant_value']);	
                        //$ilanguage.="define("."\"".$language['constant_name']."\"".","."\"".$language['constant_value']."\"".")".";"; 
                        fputcsv($file,$ilanguage);  
                    }

                    // fputcsv($file,$ilanguage);
                    // fwrite($file, $ilanguage);
                    fclose($file);



                    $fileName = "../language/".$languageName1."_language.php" ;
                    $file = fopen($fileName,"w") or exit("Unable to open file!");        
                    $ilanguage = "<?php"." ";
                    foreach($languageval as $language)
                    {
                        $ilanguage.="define("."\"".$language['constant_name']."\"".","."\"".$language['constant_value']."\"".")".";"; 
                    }
                    $ilanguage.= "?>";
                    fwrite($file, $ilanguage);
                    fclose($file);
                    
                    /*  start used in mobile application     */
                    $fileNamejs = "../language/".$languageName1."_language.js" ;
                    $filejs = fopen($fileNamejs,"w") or exit("Unable to open file!");        
                    
                    $ilanguagejs='';
                    foreach($languageval as $language)
                    {
                        if($language['constant_name']=='ENTER YOUR_NETLER')
                        {
                            $language['constant_name']='ENTER_YOUR_NETLER';
                        }
                        if($language['constant_name']=='E-CURRENCY2')
                        {
                            $language['constant_name']='E_CURRENCY2';
                        }
                        
                        $ilanguagejs.="var ".$language['constant_name']."="."\"".$language['constant_value']."\"".";";
                    }
                   
                    fwrite($filejs, $ilanguagejs);
                    fclose($filejs);
                    /*  end used in mobile application     */
                }


                redirect(URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)));
            }
            else
            {
                array_push($alert_err,$db->getErMsg());
            }
        }
        else
        {
            $flgEr=TRUE;
            array_push($alert_err,"Value is alrealy added to the selected Constant");
        }
    } 
}
elseif($pgAct=="delete" && isset($_GET['id']) && trim($_GET['id'])!='')
{
    $res=$db->delete('language_constant_junc',"where lan_con_junc_id='".$_GET['id']."'");
    if(!is_null($res)) { $_SESSION['msg']='Deleted Successfully'; }
    else { array_push($alert_err,$db->getErMsg()); }
    redirect(URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)));
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
                        <li>Constant Value</li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php                
        if($pgAct=="add" || ($pgAct=="edit" && isset($_GET['id']) && trim($_GET['id']) !=''))
        {
            if($pgAct=="edit" && !isset($_SESSION['form']))
            {   
                $aryForm=$db->getRow("SELECT * FROM language_constant_junc WHERE lan_con_junc_id='".$_GET['id']."'");
            }
            /////////get total photo ///////
            if(isset($_SESSION['form']))
            {
                $aryForm=$_SESSION['form'];
                unset($_SESSION['form']);
            }
            $aryFrmAct=array("module"=>$pgMod, "section"=>$pgSec, "action"=>$pgAct);
            if($pgAct=="edit") $aryFrmAct['id']=$_GET['id'];
            ?>
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
                                <i class="fa fa-reorder"></i>Constants
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" id="myForm">
                                <div class="form-body">
                                    <div class="form-group">
                                            <label class="col-md-3 control-label">Language  *</label>
                                            <div class="col-md-4">
                                                   
                                                   <select name="language_id" id="language_id"  class="form-control" >
                                                  <option value="0">Select</option>
                                                  <?php
                                                  $LanguageAry=$db->getRows("select * from languages WHERE status = 1 order by name asc");
                                                  if(count($LanguageAry)>0)
                                                  {
                                                    foreach($LanguageAry as $iLang)
                                                    {
                                                            ?>
                                                            <option value="<?php echo $iLang['id'];?>" <?=selected($iLang['id'],$aryForm['language_id'])?> ><?php echo ucwords($iLang['name']); ?></option>
                                                            <?php 	
                                                    }
                                                  }
                                                  ?>
                                                </select>
                                              </div>
                                    </div>
                                     
                                     
                                    <div class="form-group">
                                            <label class="col-md-3 control-label"> Constant *</label>
                                            <div class="col-md-4">
                                                   
                                                   <select name="constant_id" id="constant_id" class="form-control"  >
                                                  <option value="0">Select</option>
                                                  <?php
                                                $ConstantAry=$db->getRows("select * from constants order by constant_id desc");
												if(count($ConstantAry)>0)
												{
												  foreach($ConstantAry as $iConst)
												  {
													?>
													<option value="<?php echo $iConst['constant_id'];?>" <?=selected($iConst['constant_id'],$aryForm['constant_id'])?> ><?php echo $iConst['constant_name']; ?></option>
													<?php 	
												  }
												}
                                                  ?>
                                                </select>
                                              </div>
                                    </div>     
                                    
                                    
                                     <div class="form-group">
                                            <label class="col-md-3 control-label">Value  *</label>
                                            <div class="col-md-7">
                                                    <input type="text" name="constant_value" id="constant_value" class="form-control required" placeholder="Enter Constants" value="<?php echo $aryForm['constant_value']; ?>">
                                            </div>
                                    </div>                              
								
                                    <div class="form-group">
                                            <label class="col-md-3 control-label">Status *</label>
                                            <div class="col-md-4">
                                                    <select name="status" c id="status" class="form-control" >
                                                        <option value="1" <?php echo selected("1",$aryForm['status']); ?>>Active</option>
                                                        <option value="0" <?php echo selected("0",$aryForm['status']); ?>>Inactive</option>
                                                    </select>
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
            <?php
        }	
        elseif($pgAct=="view" && isset($_GET['id']) && trim($_GET['id']) !='')
        {
            $aryForm=$db->getRow("SELECT * FROM language_constant_junc WHERE lan_con_junc_id='".(int)$_GET['id']."'");
            ?>
            <div class="portlet">
                <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-reorder"></i>Constant Value
                        </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form role="form" class="form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Constant Value:</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">
                                                <?php echo ucfirst($aryForm['constant_value']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
							   <div class="row">
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                            <label class="control-label col-md-3">Status   :</label>
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
                                                          <?php  if(permission("edit",$pageid)) {?>
                                                            <button class="btn btn-success" type="button" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec,"action"=>"edit","id"=>$_GET['id'])); ?>'"><i class="fa fa-pencil"></i> Edit</button>
                                                          <?php } ?>
                                                            <button class="btn btn-default" type="button" onclick="window.location='<?php echo URL_ADMIN_HOME.getQueryString(array("module"=>$pgMod,"section"=>$pgSec)); ?>'">Cancel</button>
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
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
           // $sqlLimit="SELECT * FROM 	language_constant_junc ORDER BY lan_con_junc_id ASC limit ".$pgRecOffset.",".$pgRec;
		    $sqlLimit="SELECT * FROM language_constant_junc ORDER BY lan_con_junc_id ASC ";
	
            $sqlCnt="select count(lan_con_junc_id) from  language_constant_junc ";
	
            $recCnt=$db->getVal($sqlCnt);
            $aryList=$db->getRows($sqlLimit);
	
            if(isset($_SESSION['msg']) && $_SESSION['msg']!="")
            {
            ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']); 
                    ?>
                </div>
            <?php
            }
            ?>   
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption">
                            <i class="fa fa-globe"></i>Manage Constants Value
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="btn-group">
                                <?php  $aryPgAct=array("module"=>$pgMod,"section"=>$pgSec,"action"=>"add");?>
                                  <?php  if(permission("add",$pageid)) {?>
                                <a href="<?php echo URL_ADMIN_HOME.getQueryString($aryPgAct); ?>">
                                <button class="btn btn-success">Add  <i class="fa fa-plus" ></i></button></a> <?php }?>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                            <tr>	
                                <th width="20%">Language</th>
                                <th width="15%">Constant</th>
                                <th width="20%">Value</th>
                                <th width="15%">Status</th>
                                <th width="30%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(count($aryList)>0)
                            {
                                foreach($aryList as $iList)
                                {
                                    $pgCnt=ceil($recCnt/$pgRec); 
                                    $aryPgAct["id"]=$iList['lan_con_junc_id'];
                                    ?>                                                   
                                    <tr class="odd gradeX">
                                        <td><?php 
                      $Language=$db->getRow("select name,short from languages where id=".$iList['language_id']."");
                       echo ucwords($Language['name']).' ('.$Language['short'].')';
                      ?></td>
                      <td><?php
                      $Constant=$db->getRow("select constant_name from constants where constant_id=".$iList['constant_id'].""); 
                      echo $Constant['constant_name'];
                      ?></td>
                      <td><?php echo ucwords(substr($iList['constant_value'],"0","50")); if(strlen($iList['constant_value'])>50){ echo "..."; }
					 //echo $iList['constant_value'];
					   ?></td>
                      
                      
                                          <td>
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
                                             <?php  if(permission("edit",$pageid)) {?>
                                                <?php  $aryPgAct['action']="edit";?>
                                            <a class="btn btn-default btn-xs purple" href="<?php echo URL_ADMIN_HOME.getQueryString($aryPgAct); ?>"><i class="fa fa-edit"></i> Edit</a>
                                             <?php }  if(permission("delete",$pageid)) {?>
                                                <?php  $aryPgAct['action']="delete";?>
                                            <a class="btn btn-default btn-xs black" onclick="return confirm('Are you sure?');" href="<?php echo URL_ADMIN_HOME.getQueryString($aryPgAct); ?>"><i class="fa fa-trash-o"></i> Delete</a>
                                        <?php }?>
                                        </td>
                                    </tr>
                                <?php 
                                } 
                            } 
                            else
                            {
                            ?>
                                <tr class="odd gradeX"><td colspan="7">No record found</td></tr>
                            <?php                            
                            } 
                            ?>                                         									
                        </tbody>
                    </table>
                    <?php
                    if($pgCnt>1)
                    {
                      //  echo getPaging(URL_ADMIN,$_GET,$pgCnt,$pgCur);
                    }
                    ?>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->						
        <?php         
        } 
        ?>					
    </div>
</div>
<!-- END PAGE CONTENT-->
<script>
$(document).ready(function() {
    $('#sample_editable_1').DataTable( {
        "iDisplayLength": 50,
        "aLengthMenu": [[50, 100 , -1], [50, 100, "All"]],
       // "sPaginationType": "full_numbers",
        "aaSorting": [], 

    } );
} );
</script>
<?php
if(isset($_GET['id']) && $_GET['id']!="" && $action='edit')
    $aryPgAct=array("module"=>$pgMod,"section"=>$pgSec,"action"=>"edit","id"=>$_GET['id']);
else
    $aryPgAct=array("module"=>$pgMod,"section"=>$pgSec,"action"=>"add");
?>