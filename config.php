<?php
@session_start();
error_reporting(0);

//  ini_set('error_reporting', E_ALL);
//  ini_set('display_errors', 'On');


if(!isset($_SESSION['language']))
{
    $_SESSION['language']='en';
}
$isset_language = $_SESSION['language'];
if($isset_language=='en')
{
    $isset_language = '';
}
else
{
    $language_prefix = '_'.$isset_language;
}



  


$varAdminFolder="manage";
$varUserFolder = '';
define("DS",DIRECTORY_SEPARATOR);
define("PATH_ROOT",dirname(__FILE__));
define("PATH_LIB",PATH_ROOT.DS."library".DS);
define("PATH_ADMIN",PATH_ROOT.DS.$varAdminFolder.DS);
define("PATH_ADMIN_MODULE",PATH_ADMIN."modules".DS);
define("PATH_CLASS",PATH_ROOT.DS."classes".DS);



define("PATH_CUSTOMER",PATH_ROOT.DS.$varUserFolder.DS);
define("PATH_CUSTOMER_MODULE",PATH_CUSTOMER."modules".DS);

define("PATH_IMAGES",PATH_ROOT.DS.'images'.DS);
define("PATH_UPLOAD",PATH_ROOT.DS."uploads".DS);
define("PATH_UPLOAD_BROCHURS",PATH_UPLOAD."brochure".DS);
define("PATH_UPLOAD_PRODUCT",PATH_UPLOAD."product".DS);
define("PATH_UPLOAD_RESUME",PATH_UPLOAD."resume".DS);
define("PATH_UPLOAD_CLUB",PATH_UPLOAD."club".DS);
define("PATH_UPLOAD_DEAL",PATH_UPLOAD."deal".DS);
define("PATH_UPLOAD_CATEGORY",PATH_UPLOAD."category".DS);
define("PATH_UPLOAD_BANNER",PATH_UPLOAD."banner".DS);
define("PATH_UPLOAD_USER",PATH_UPLOAD."user".DS);
//define("URL_ROOT","https://bio911.com/");     
define("URL_ROOT","http://localhost/zauch-project/");       
//define("URL_ROOT_SL_RM","https://www.sahmrs.com/samrs/V1/"); 
define("URL_CSS",URL_ROOT."css/");
define("URL_JS",URL_ROOT."js/");
define("URL_IMG",URL_ROOT."images/");
define("URL_ADMIN",URL_ROOT.$varAdminFolder."/");
define("URL_ADMIN_HOME",URL_ADMIN."index.php");
define("URL_ADMIN_CSS",URL_ADMIN."css/");
define("URL_ADMIN_ASSETS",URL_ADMIN."assets/");
define("URL_ADMIN_JS",URL_ADMIN."js/");
define("URL_ADMIN_IMG",URL_ADMIN."img/");
define("SELF",basename($_SERVER['PHP_SELF']));
define("LOGIN_USER","sahmrs");
define("DATE_FORMAT","d/m/Y");

$_pswd_len=array(
                    'min'=>6,
                    'max'=>30 //put 0 for unlimited
                );
$rowperpage = 50;
//define RegX expressions
define("REGX_MAIL","/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/");
define("REGX_URL","/^(http(s)?\:\/\/(?:www\.)?[a-zA-Z0-9]+(?:(?:\-|_)[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:(?:\-|_)[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,4}(?:\/)?)$/i");
define("REGX_PHONE","/^[0-9\+][0-9\-\(\)\s]+[0-9]$/");
//$recPg=20; //records per page
require_once(PATH_LIB."class.database.php");

//$db=new MySqlDb("localhost","biocom_bio","4sh10mca07",'biocom_bio','charset=utf8');     
$db=new MySqlDb("localhost","root","",'hausmannquartet','charset=utf8');      


 
mysqli_set_charset($db,'utf8');  
mysqli_query("SET NAMES 'utf8'");   
mysqli_query("SET CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'"); 


require_once(PATH_LIB."functions.php");

require_once(PATH_LIB."validations.php");

include(PATH_LIB."class.mailer.php");

// include(PATH_LIB."smsclass.php");

$alert_err=array();
$alert_msg=array();

//set time zone
date_default_timezone_set("America/Los_Angeles");

//For pagging Number of record in a page
$numberOfPage=10;

$projectname="hausmannquartet";

$validate=new Validation();


?>