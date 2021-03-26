<?php
//header( 'Content-Type: text/html; charset=utf-8' );
defined('PATH_LIB') or die("Restricted Access");
// require __DIR__ . '/vendor/autoload.php';
// use Twilio\Rest\Client;

function __autoload($strClass)
{
	$strFile="class.".strtolower($strClass).".php";
	require_once(PATH_CLASS.$strFile);
}
function smart_resize_image( $file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false )
{
	if ( $height <= 0 && $width <= 0 )
	{
  		return false;
	}
    $info = getimagesize($file);

    $image = '';

    $final_width = 0;

    $final_height = 0;

    list($width_old, $height_old) = $info;

    if ($proportional) {

      if ($width == 0) $factor = $height/$height_old;

      elseif ($height == 0) $factor = $width/$width_old;

      else $factor = min ( $width / $width_old, $height / $height_old);

      $final_width = round ($width_old * $factor);

      $final_height = round ($height_old * $factor);

    }

    else {

      $final_width = ( $width <= 0 ) ? $width_old : $width;

      $final_height = ( $height <= 0 ) ? $height_old : $height;
    }

    switch ( $info[2] ) {

      case IMAGETYPE_GIF:

        $image = imagecreatefromgif($file);

      break;

      case IMAGETYPE_JPEG:

        $image = imagecreatefromjpeg($file);

      break;

      case IMAGETYPE_PNG:

        $image = imagecreatefrompng($file);

      break;

      default:

        return false;

    }



    $image_resized = imagecreatetruecolor( $final_width, $final_height );



    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {

      $trnprt_indx = imagecolortransparent($image);



      // If we have a specific transparent color

      if ($trnprt_indx >= 0) {



        // Get the original image's transparent color's RGB values
        $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);

        // Allocate the same color in the new image resource
        $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $trnprt_indx);

        // Set the background color for new image to transparent

        imagecolortransparent($image_resized, $trnprt_indx);
      }

      // Always make a transparent background color for PNGs that don't have one allocated already

      elseif ($info[2] == IMAGETYPE_PNG) {



        // Turn off transparency blending (temporarily)

        imagealphablending($image_resized, false);

        // Create a new transparent color for image

        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);


        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $color);


        // Restore transparency blending

        imagesavealpha($image_resized, true);
      }
    }


    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);



    if ( $delete_original ) {

      if ( $use_linux_commands )

        exec('rm '.$file);

      else

        @unlink($file);

    }



    switch ( strtolower($output) ) {

      case 'browser':

        $mime = image_type_to_mime_type($info[2]);

        header("Content-type: $mime");

        $output = NULL;

      break;

      case 'file':

        $output = $file;

      break;

      case 'return':

        return $image_resized;

      break;

      default:

      break;

    }



    switch ( $info[2] ) {

      case IMAGETYPE_GIF:

        imagegif($image_resized, $output);

      break;

      case IMAGETYPE_JPEG:

        imagejpeg($image_resized, $output);

      break;

      case IMAGETYPE_PNG:

        imagepng($image_resized, $output);

      break;

      default:

        return false;

    }



    return true;

  }


function redirect($url=NULL)
{
	if(is_null($url)) $url=curPageURL();
	if(headers_sent())
	{
		echo "<script>window.location='".$url."'</script>";
	}
	else
	{
		header("Location:".$url);
	}
	exit;
}

function chkHeader()
{
	if(strpos($_SERVER['HTTP_REFERER'],URL_ROOT)==0) return true;
	return false;
}

function setMsgPage($mod, $sec, $type, $note)
{
	//possible values for type
	//success
	//information
	//warning
	//error
	if(!isset($_SESSION['msg_er'])) $_SESSION['msg_er']=array();
	if(!isset($_SESSION['msg_er'][$mod])) $_SESSION['msg_er'][$mod]=array();
	if(!isset($_SESSION['msg_er'][$mod][$sec])) $_SESSION['msg_er'][$mod][$sec]=array();

	$_SESSION['msg_er'][$mod][$sec]['page']=array(
												  'type'=>$type,
												  'note'=>$note
												  );
}

function getMsgPage($mod, $sec)
{
	$return='';
	if(isset($_SESSION['msg_er'][$mod][$sec]['page']) && is_array($_SESSION['msg_er'][$mod][$sec]['page']) && count($_SESSION['msg_er'][$mod][$sec]['page'])>0)
	{
		$class=$_SESSION['msg_er'][$mod][$sec]['page']['type'];
		$return="<div class=\"notification ".$class."\">";
		$return.=$_SESSION['msg_er'][$mod][$sec]['page']['note'];
		$return.="</div>";

		unset($_SESSION['msg_er'][$mod][$sec]['page']);
	}

	clearErMsg($mod,$sec);

	return $return;
}

function setMsgField($mod, $sec, $field, $type, $note)
{
	//possible values for type
	//success
	//information
	//warning
	//error

	if(!isset($_SESSION['msg_er'])) $_SESSION['msg_er']=array();

	if(!isset($_SESSION['msg_er'][$mod])) $_SESSION['msg_er'][$mod]=array();
	if(!isset($_SESSION['msg_er'][$mod][$sec])) $_SESSION['msg_er'][$mod][$sec]=array();

	if(!isset($_SESSION['msg_er'][$mod][$sec]['field'])) $_SESSION['msg_er'][$mod][$sec]['field']=array();

	$_SESSION['msg_er'][$mod][$sec]['field'][$field]=array(
														   'type'=>$type,
														   'note'=>$note
														   );
}

function getMsgField($mod, $sec, $field)
{
	$return='';
	if(isset($_SESSION['msg_er'][$mod][$sec]['field'][$field]) && is_array($_SESSION['msg_er'][$mod][$sec]['field'][$field]) && count($_SESSION['msg_er'][$mod][$sec]['field'][$field])>0)
	{
		$class=$_SESSION['msg_er'][$mod][$sec]['field'][$field]['type'];
		$return="<span class=\"notification ".$class."\">";
		$return.=$_SESSION['msg_er'][$mod][$sec]['field'][$field]['note'];
		$return.="</span>";
		unset($_SESSION['msg_er'][$mod][$sec]['field'][$field]);
	}
	if(isset($_SESSION['msg_er'][$mod][$sec]['field']) && is_array($_SESSION['msg_er'][$mod][$sec]['field']) && count($_SESSION['msg_er'][$mod][$sec]['field'])===0) unset($_SESSION['msg_er'][$mod][$sec]['field']);

	clearErMsg($mod,$sec);

	return $return;
}

function clearErMsg($mod,$sec)
{
	if(isset($_SESSION['msg_er'][$mod][$sec]) && is_array($_SESSION['msg_er'][$mod][$sec]) && count($_SESSION['msg_er'][$mod][$sec])===0) unset($_SESSION['msg_er'][$mod][$sec]);

	if(isset($_SESSION['msg_er'][$mod]) && is_array($_SESSION['msg_er'][$mod]) && count($_SESSION['msg_er'][$mod])===0) unset($_SESSION['msg_er'][$mod]);

	if(isset($_SESSION['msg_er']) && is_array($_SESSION['msg_er']) && count($_SESSION['msg_er'])===0) unset($_SESSION['msg_er']);
}

function setSort($mod,$sec,$val)
{
	if(!isset($_SESSION['sort'])) $_SESSION['sort']=array();
	if(!isset($_SESSION['sort'][$mod])) $_SESSION['sort'][$mod]=array();

	$_SESSION['sort'][$mod][$sec]=$val;
}

function getSort($mod,$sec)
{
	return $_SESSION['sort'][$mod][$sec];
}

function curPageURL()
{
	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80")
	{
  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	}
	else
	{
  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}

function getQueryString($aryQueryStr)
{
	$aryMatch=array();
	foreach($aryQueryStr as $opt=>$val) { $aryMatch[]=$opt.'='.urlencode($val); }
	return '?'.implode('&',$aryMatch);
}

function selected($needle,$haystack)
{
	if(is_array($haystack) && in_array($needle,$haystack)) { return 'selected="selected"'; }
	elseif(!is_array($haystack) && $needle===$haystack) { return 'selected="selected"'; }
	else { return ''; }
}

function checked($needle,$haystack)
{
	if(is_array($haystack) && in_array($needle,$haystack)) { return 'checked="checked"'; }
	elseif(!is_array($haystack) && $needle===$haystack) { return 'checked="checked"'; }
	else { return ''; }
}

function isValidDate($val)
{
	if(preg_match(REGX_DATE,$val))
	{
		list($year,$month,$date)=explode("-",$val);
		if(checkdate($month,$date,$year)) return true;
	}
	return false;
}

function getPaging($refUrl,$aryOpts,$pgCnt,$curPg)
{
//	echo $aryOpts." ".$pgCnt." ".$curPg;
	$return='';
	$return.='<div class="dataTables_paginate paging_bootstrap"><ul class="pagination" >';
	if($curPg>1)
	{
		$aryOpts['pg']=1;
		$return.='<li><a href="'.$refUrl.getQueryString($aryOpts).'">First</a></li>';

		$aryOpts['pg']=$curPg-1;
		$return.='<li><a href="'.$refUrl.getQueryString($aryOpts).'">Prev</a></li>';
	}
	for($i=1;$i<=$pgCnt;$i++)
	{
		$aryOpts['pg']=$i;

		if($curPg==$i)
		{
			$return.='<li class="active" ><a href="'.$refUrl.getQueryString($aryOpts).'" class="';
			$return.='" >'.$i.'</a></li>';
		}
		else
		{
			$return.='<li ><a href="'.$refUrl.getQueryString($aryOpts).'" class="';
			$return.='" >'.$i.'</a></li>';
		}
		/*
		$return.='<li ><a href="'.$refUrl.getQueryString($aryOpts).'" class="';
		if($curPg==$i) $return.=' active';
		$return.='" >'.$i.'</a></li>';*/
	}
	if($curPg<$pgCnt)
	{
		$aryOpts['pg']=$curPg+1;
		$return.='<li><a href="'.$refUrl.getQueryString($aryOpts).'">Next</a></li>';
		$aryOpts['pg']=$pgCnt;
		$return.='<li><a href="'.$refUrl.getQueryString($aryOpts).'">Last</a></li>';
	}
	$return.='</ul></div>';
	return $return;
}

function isAdmin()
{
	if(isset($_SESSION[LOGIN_ADMIN]) && is_array($_SESSION[LOGIN_ADMIN]) && isset($_SESSION[LOGIN_ADMIN]['id'])) return true;
	return false;
}

function getFileSize($path)
{
	if(is_array($path) && count($path)>0)
	{
		//if(!file_exists($path)) return 0;
		//if(is_file($path)) return filesize($path);
		$ret = 0;
		foreach($path as $file)
			$ret+=getFileSize($file);
		return $ret;
	}
	else
	{
		if(!file_exists($path)) return 0;
		if(is_file($path)) return filesize($path);
	}
}

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
	//return $bytes;
}

function getRealIpAddr()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP']))//check ip from share internet
    {
		$ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))//to check ip is pass from proxy
    {
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
		$ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function fetchSetting($mixVal)
{
	$aryReturn=array();
	$strSetting='';
	if(is_array($mixVal) && count($mixVal)>0)
	{
		$strSetting="'".implode("', '",$mixVal)."'";
	}
	elseif(trim($mixVal)!='')
	{
		$strSetting="'".$mixVal."'";
	}
	if(trim($strSetting)!='')
	{
		global $db;
		$arySetData=$db->getRows("select * from settings where `field` in (".$strSetting.")");
		if(is_array($arySetData) && count($arySetData)>0)
		{
			foreach($arySetData as $iSetData)
			{
				$aryReturn[$iSetData['field']]=$iSetData['value'];
			}
		}
	}
	return $aryReturn;
}

function getStatusImg($status)
{
	$aryImg=array(
				  '0'=>"status_inactive.png",
				  '1'=>"status_active.png"
				  );
	return '<img src="'.URL_ADMIN_IMG.$aryImg[$status].'" title="'.getStatusStr($status).'" />';
}

function getStatusAds($status)
{
	$aryImg=array(
				  '0'=>"status_inactive.png",
				  '1'=>"status_active.png",
				   '2'=>"status_inactive.png"
				  );
	return '<img src="'.URL_ADMIN_IMG.$aryImg[$status].'" title="'.getStatusAdsstr($status).'" />';
}

function getStatusUserImg($status)
{
	$aryImg=array(
				  '0'=>"status_pending.png",
				  '1'=>"status_active.png",
				  '2'=>"status_inactive.png"
				  );
	return '<img src="'.URL_ADMIN_IMG.$aryImg[$status].'" title="'.getStatusUserStr($status).'" />';
}




function getOptionImg($status)
{
	$aryImg=array(
				  '0'=>"cross.png",
				  '1'=>"tick.png"
				  );
	return '<img src="'.URL_ADMIN_IMG."icons/".$aryImg[$status].'" />';
}

function getStatusStr($val)
{
	if($val==0)
	{
		return "Inactive";
	}
	else
	{
		return "Active";
	}
}
function getStatusAdsstr($val)
{
	if($val==0)
	{
		return "Pending";
	}
	else if($val==2)
	{
		return "Reject";
	}
	else
	{
		return "Approved";
	}
}

function getStatusUserStr1($val)
{
	if($val==2)
	{
		return "Block";
	}
	else if($val==0)
	{
		return "Pending";
	}
	else
	{
		return "Active";
	}
}

function getStatusUserStr($val)
{
	if($val==2)
	{
		return "Inactive";
	}
	elseif($val==0)
	{
		return "Pending";
	}
	else
	{
		return "Active";
	}
}

function getOptionStr($val)
{
	if($val==0)
	{
		return "No";
	}
	else
	{
		return "Yes";
	}
}

function delete_directory($dirname)
{
	if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle))
   {
      if ($file != "." && $file != "..")
	  {
         if (!is_dir($dirname.DS.$file))
            @unlink($dirname.DS.$file);
         else
            delete_directory($dirname.DS.$file);
      }
   }
   closedir($dir_handle);
   @rmdir($dirname);
   return true;
}

function check_login($userType='User')
{
	if($userType=='User' && (!isset($_SESSION[LOGIN_USER]) || count($_SESSION[LOGIN_USER])==0))
		return false;
	elseif($userType=='Admin' && (!isset($_SESSION[LOGIN_ADMIN]) || count($_SESSION[LOGIN_ADMIN])==0))
		return false;

	return true;
}

function resizeVideo($markup, $dimensions)
{
    $w = $dimensions['width'];
    $h = $dimensions['height'];

    $patterns = array();
    $replacements = array();
    if( !empty($w) )
    {
        $patterns[] = '/width="([0-9]+)"/';
        $patterns[] = '/width:([0-9]+)/';
        $patterns[] = '/width="([0-9]+)px"/';

        $replacements[] = 'width="'.$w.'"';
        $replacements[] = 'width:'.$w;
		$replacements[] = 'width="'.$w.'px"';
    }

    if( !empty($h) )
    {
        $patterns[] = '/height="([0-9]+)"/';
        $patterns[] = '/height:([0-9]+)/';
        $patterns[] = '/height="([0-9]+)px"/';

        $replacements[] = 'height="'.$h.'"';
        $replacements[] = 'height:'.$h;
		$replacements[] = 'height="'.$h.'px"';
    }

    return preg_replace($patterns, $replacements, $markup);
}
function listDirs($where){
	$directoryarr=array();
    $itemHandler=opendir($where);
    $i=0;
    while(($item=readdir($itemHandler)) !== false){
	if ($item == "." || $item == "..") { }
	else {$directoryarr[]=$item;}
       }
	  return($directoryarr);
}
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
function calc_dist($latitude1, $longitude1, $latitude2, $longitude2) {
$thet = $longitude1 - $longitude2;
$dist = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($thet)));
$dist = acos($dist);
$dist = rad2deg($dist);
$kmperlat = 111.325; // Kilometers per degree latitude constant
$dist = $dist * $kmperlat;
return (round($dist));
}

//Calculates distance in KM between postcodes
function postcode_dist($postcode1,$postcode2, $suburb1 = '', $suburb2 = '') {
//Get lat and lon for postcode 1
$extra = "";
if ($suburb1 != '') {
$extra = " and suburb = '$suburb1'";
}
$sqlquery = "SELECT * FROM postcode_db WHERE lat <> 0 and lon <> 0 and postcode = '$postcode1'$extra";
$res = mysql_query($sqlquery);
$num = mysql_num_rows($res);


//Get lat and lon for postcode 2

$extra = "";
if ($suburb2 != '') {
$extra = " and suburb = '$suburb2'";
}
$sqlquery = "SELECT * FROM postcode_db WHERE lat <> 0 and lon <> 0 and postcode = '$postcode2'$extra";
$res1 = mysql_query($sqlquery);
$num1 = mysql_num_rows($res1);

if ($num != 0 && $num1 != 0) {
//proceed
$lat1 = mysql_result($res,0,"lat");
$lon1 = mysql_result($res,0,"lon");
$lat2 = mysql_result($res1,0,"lat");
$lon2 = mysql_result($res1,0,"lon");
$dist = calc_dist($lat1, $lon1, $lat2, $lon2);
if (is_numeric($dist)) {
return $dist;
}
else
{
return "Unknown";
}
}
else
{
return "Unknown";
}
}
function getPagingfront($refUrl,$aryOpts,$pgCnt,$curPg)
{
//	echo $aryOpts." ".$pgCnt." ".$curPg;
	$return='';
	$return.='<div class="pagination"><ul>';
	if($curPg>1)
	{
		$aryOpts['pg']=1;
		$return.='<li class="prev"><a href="'.$refUrl.getQueryString($aryOpts).'">First</a></li>';

		$aryOpts['pg']=$curPg-1;
		$return.='<li class="prev"><a href="'.$refUrl.getQueryString($aryOpts).'">Prev</a></li>';
	}
	for($i=1;$i<=$pgCnt;$i++)
	{
		$aryOpts['pg']=$i;
		$return.='<li><a href="'.$refUrl.getQueryString($aryOpts).'" class="graybutton pagelink';
		if($curPg==$i) $return.=' active';
		$return.='" >'.$i.'</a></li>';
	}
	if($curPg<$pgCnt)
	{
		$aryOpts['pg']=$curPg+1;
		$return.='<li class="prev"><a href="'.$refUrl.getQueryString($aryOpts).'">Next</a></li>';
		$aryOpts['pg']=$pgCnt;
		$return.='<li class="prev"><a href="'.$refUrl.getQueryString($aryOpts).'">Last</a></li>';
	}
	$return.='</ul></div>';
	return $return;
}


function getPagingfront2($refUrl,$aryOpts,$pgCnt,$curPg)
{

	$maxPage = 0;
	$return='';

        $return.='<div ><ul class="pagination">';
	if($curPg>1)
	{
		$aryOpts['pg']=1;
		$return.=' <li><a href="'.$refUrl.getQueryString($aryOpts).'">First</a></li> ';

		$aryOpts['pg']=$curPg-1;
		$return.=' <li><a href="'.$refUrl.getQueryString($aryOpts).'"> �? Previous</a></li> ';
	}
	$range = $curPg;

	$upto = $range+2;

	$downto = $range-2;

	if($upto > $maxPage)
	{

		$maxPage = $upto;
	}
	if($downto<=0)
	{
		$downto = 1;
	}
	if($maxPage>1)
	{
		for($i=$downto;$i<=$upto && $i<=$pgCnt;$i++)
		{
                    /*
                    $aryOpts['pg']=$i;
                    $return.=' <li><a href="'.$refUrl.getQueryString($aryOpts).'" class="';
                    if($curPg==$i) $return.=' active';
                    $return.='" >'.$i.'</a></li> ';

                     */

                    $aryOpts['pg']=$i;
                    $return.=' <li class="';
                    if($curPg==$i) $return.=' active';
                    $return.='" ><a href="'.$refUrl.getQueryString($aryOpts).'">'.$i.'</a></li> ';

		}
	}

	if($curPg<$pgCnt)
	{
		$aryOpts['pg']=$curPg+1;
		$return.=' <li><a href="'.$refUrl.getQueryString($aryOpts).'">Next → </a></li> ';
		$aryOpts['pg']=$pgCnt;
		$return.=' <li><a href="'.$refUrl.getQueryString($aryOpts).'">Last</a></li> ';
	}
        $return.='</ul></div>';

	return $return;
}



function enum_select( $table , $field )
{
	$query = "SHOW COLUMNS FROM `$table` LIKE '$field' ";
	$result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() );
	$row = mysql_fetch_array( $result , MYSQL_NUM );
	#extract the values
	#the values are enclosed in single quotes
	#and separated by commas
	$regex = "/'(.*?)'/";
	preg_match_all( $regex , $row[1], $enum_array );
	$enum_fields = $enum_array[1];
	return( $enum_fields );
}
function randomFix($length)
{
	$random= "";

	srand((double)microtime()*1000000);

	$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
	$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
	$data .= "0FGH45OP89";

	for($i = 0; $i < $length; $i++)
	{
		$random .= substr($data, (rand()%(strlen($data))), 1);
	}
	return $random;
}
function href($page,$param="")
{
	global $db;
	$sef="1";
	if($sef=="1")
	{
		$x = explode("&",$param);
		$var = array();
		foreach($x as $k1 => $v1)
		{
			$x2 = explode("=",$v1);
			$var[$x2[0]]=$x2[1];
		}

		switch($page)
		{
                    case 'aboutus.php' :
                    {
                        return 	URL_ROOT.'aboutus/';
                        break;
                    }
                    case 'googlelogin.php' :
                    {
                        return  URL_ROOT.'googlelogin/';
                        break;
                    }
                    case 'fblogin.php' :
                    {
                        return  URL_ROOT.'fblogin/';
                        break;
                    }
                    case 'howitworks.php' :
                    {
                        return 	URL_ROOT.'howitworks/';
                        break;
                    }
                    case 'joblist.php' :
                    {
                        return 	URL_ROOT.'joblist/';
                        break;
                    }
                    case 'contactus.php' :
                    {
                        return 	URL_ROOT.'contact/';
                        break;
                    }
                    case 'dashboard.php' :
                    {
                        return 	URL_ROOT.'dashboard/';
                        break;
                    }
                    case 'cms.php' :
                    {
                        if($var['linkname']!='')
                        {
                            return URL_ROOT.'content/'.$var['linkname'];
                            break;
                        }
                    }
                    case 'editjobpost.php' :
                    {
                        if($var['id']!='')
                        {
                            return URL_ROOT.'editjobs/'.$var['id'];
                            break;
                        }
                    }
                    case 'editexperience.php' :
                    {
                        if($var['id']!='')
                        {
                            return URL_ROOT.'editexperience/'.$var['id'];
                            break;
                        }
                    }
                    case 'userprofile.php' :
                    {
                        if($var['id']!='')
                        {
                            return URL_ROOT.'userprofile/'.$var['id'];
                            break;
                        }
                    }
                    case 'jobdetail.php' :
                    {
                        if($var['id']!='')
                        {
                            return URL_ROOT.'jobdetail/'.$var['id'];
                            break;
                        }
                    }
                    case 'helpcenter.php' :
                    {
                        return 	URL_ROOT.'help/';
                        break;
                    }
                    case 'forgot_password.php' :
                    {
                        return URL_ROOT.'forgot-password';
                        break;
                    }
                    case 'notifications.php' :
                    {
                        return 	URL_ROOT.'notifications/';
                        break;
                    }
                    case 'lookingforcandidate.php' :
                    {
                        return 	URL_ROOT.'lookingforcandidate/';
                        break;
                    }
                    case 'lookingforjob.php' :
                    {
                        return 	URL_ROOT.'lookingforjob/';
                        break;
                    }
                    case 'myposts.php' :
                    {
                        return 	URL_ROOT.'myposts/';
                        break;
                    }
                    case 'myfavourites.php' :
                    {
                        return 	URL_ROOT.'myfavourites/';
                        break;
                    }
                    case 'appliedjobshistory.php' :
                    {
                        return 	URL_ROOT.'appliedjobs/';
                        break;
                    }
                    case 'jobapplicanthistory.php' :
                    {
                        if($var['post_id']!='')
                        {
                            return URL_ROOT.'jobapplicants/'.$var['post_id'];
                            break;
                        }
                    }
                    case 'messages.php' :
                    {
                        return 	URL_ROOT.'messages/';
                        break;
                    }
                    case 'edit_profile.php' :
                    {
                        return 	URL_ROOT.'edit-profile/';
                        break;
                    }
                    

		default:
			{
				if($param=="")
				{
				  return URL_ROOT.$page;
				}
				else
				{
				  return URL_ROOT.$page.'?'.$param;
				}
			}

		}

	}
	else
	{
		if($param=="")
		{
		  return URL_ROOT.$page;
		}
		else
		{
		  return URL_ROOT.'/'.$page.'?'.$param;
		}
	}
}
function create_token($nm="token")
{
	$_SESSION[$nm] = time();
	echo '<input type="hidden" name="'.$nm.'"  value="'.$_SESSION[$nm].'"/>';
}

function token($nm="token")
{
 if($_SESSION[$nm]==$_POST[$nm])
	return true;
 else
 	return false;
}
function convertdatenew($date)
{
$arrdate=explode('-',$date);
return $arrdate[2].'-'.$arrdate[0].'-'.$arrdate[1];
}

function convertdatenew1($date)
{
$arrdate=explode('-',$date);
return $arrdate[0].'-'.$arrdate[1].'-'.$arrdate[2];
}

class Paging
{

	var $rowsPerPage =30;

	var $pageNum = 1;

	var $numrows = 0;

	var $maxPage = 0;

	var $offset = 0;



	function sql($sqlquery)

	{

	  $this->pageNum = isset($_REQUEST['gotopage'])?$_REQUEST['gotopage']:1;

	  $this->offset = ($this->pageNum - 1) * $this->rowsPerPage;

	  $q = mysql_query($sqlquery. " LIMIT ".$this->offset.", ".$this->rowsPerPage) or die(mysql_error());

	  $q2 = mysql_query($sqlquery) or die(mysql_error());

	  $this->numrows = mysql_num_rows($q2);

 	  $this->maxPage = ceil($this->numrows/$this->rowsPerPage);

		while($row=mysql_fetch_array($q)) { $aryResult[]=$row; }
	  return $aryResult;

	}
	function navigations($param='ser=')
	{

		$self = basename($_SERVER['PHP_SELF']);


		$self = $self ."?".$param;

		if ($this->pageNum > 1)

		{

			$gotopage = $this->pageNum - 1;

			$prev = "<td class=\"text\"><a class=\"head\" href=\"$self&gotopage=$gotopage\">Previous</a></td>";



			$first = "<td class=\"text\"><a class=\"head\" href=\"$self&gotopage=1\">First</a></td>";

		}

		else

		{

			$prev  = '';       // we're on page one, don't enable 'previous' link

			$first = ''; // nor 'first page' link

		}

		if ($this->pageNum < $this->maxPage)

		{

			$gotopage = $this->pageNum + 1;

			$next = "<td class=\"text\"><a class=\"head\" href=\"$self&gotopage=$gotopage\">Next</a></td>";



			$last = "<td class=\"text\"><a class=\"head\" href=\"$self&gotopage=".$this->maxPage."\">Last</a></td>";

		}

		else

		{

			$next = '';      // we're on the last page, don't enable 'next' link

			$last = ''; // nor 'last page' link

		}

		$i=$this->pageNum;

		$upto=$i+5;

		$downto=$i-5;

		if($upto>$this->maxPage)
		{
			$upto=$this->maxPage;
		}
		if($downto<=0)
		{
			$downto=1;
		}
		if($this->maxPage>1)
		{
			for($i=$downto;$i<=$upto;$i++)
			{

				if($i==$this->pageNum)

				{

				$pages .= '<td class="page">'."<a href=\"$self&gotopage=$i\">".$i.'</a></td>';

				}

				else

				{

				$pages .= "<td><a href=\"$self&gotopage=$i\">$i</a></td>";

				}



			}

		}


		return '<tr>'.$first . $prev."&nbsp;&nbsp;$pages&nbsp;&nbsp;".$next . $last.'</tr>';

	}
}
class Paging_social
{
	var $rowsPerPage =10;

	var $pageNum = 1;

	var $numrows = 0;

	var $maxPage = 0;

	var $offset = 0;

	function sql($fields="*",$table,$cond='')

	{

	  $this->pageNum = isset($_REQUEST['gotopage'])?$_REQUEST['gotopage']:1;

	  $this->offset = ($this->pageNum - 1) * $this->rowsPerPage;

	  $q = mysql_query("select $fields from $table $cond LIMIT ".$this->offset.", ".$this->rowsPerPage);

	  $q2 = mysql_query("select $fields from $table $cond  ");

	  $this->numrows = mysql_num_rows($q2);

 	  $this->maxPage = ceil($this->numrows/$this->rowsPerPage);

	  return $q;

	}


	function navigations($param='')

	{
		$self = basename($_SERVER['PHP_SELF']);

		if ($this->pageNum > 1)
		{
			$gotopage = $this->pageNum - 1;
			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");
				$prev = '<li><a href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=1");

				$first = '<li><a href="'.$href.'">'.FIRST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");
				}
				else
				{
					$href= href($self,"gotopage=$gotopage");
				}
				$prev = '<li><a  href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href= href($self,"gotopage=1");

				$first = '<li><a  href="'.$href.'">'.FIRST.'</a></li>';

			}
		}
		else
		{
			$prev  = '';       // we're on page one, don't enable 'previous' link

			$first = ''; // nor 'first page' link
		}
		if ($this->pageNum < $this->maxPage)
		{
			$gotopage = $this->pageNum + 1;

			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");

				$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=".$this->maxPage);

				$last = '<li><a  href="'.$href.'">'.LAST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");

					$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

					$href= href($self,"gotopage=".$this->maxPage."&$param");

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

				else

				{

					$href= href($self,"gotopage=$gotopage");

					$next = '<li><a href="'.$href.'">'.NEXT.'</a></li>';



					$href= href($self,"gotopage=".$this->maxPage);

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

			}

		}

		else

		{
			$next = '';      // we're on the last page, don't enable 'next' link

			$last = ''; // nor 'last page' link

		}

		$i=$this->pageNum;

		$upto=$i+5;

		$downto=$i-5;

		if($upto>$this->maxPage)

		{

			$upto=$this->maxPage;

		}

		if($downto<=0)

		{

			$downto=1;

		}

		if($this->maxPage>1)

		{

			for($i=$downto;$i<=$upto;$i++)

			{

				if($i==$this->pageNum)

				{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");
				$pages .= '<li class="selected"><a href="'.$href.'">'.$i.'</a></li>';

				}

				else

				{
					if($self=='index.php')

					{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");

						$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
				}
				else
				{
						if($param)
						{
							$href= href($self,"gotopage=$i&$param");
							$pages .= '<li><a  href="'.$href.'">'.$i.'</a></li>';
						}
						else
						{
							$href= href($self,"gotopage=$i");
							$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
						}
					}
				}
			}
		}
		if($pages)
		return '<ul class="pagination">'."$prev $pages $next".'</ul>';
		else
		return false;
	}



}

class Paging_social2
{
	var $rowsPerPage =10;

	var $pageNum = 1;

	var $numrows = 0;

	var $maxPage = 0;

	var $offset = 0;

	function sql2($fields="*",$table,$cond='')

	{

	  $this->pageNum = isset($_REQUEST['gotopage'])?$_REQUEST['gotopage']:1;

	  $this->offset = ($this->pageNum - 1) * $this->rowsPerPage;

	  $q = mysql_query("select $fields from $table $cond LIMIT ".$this->offset.", ".$this->rowsPerPage);

	  $q2 = mysql_query("select $fields from $table $cond  ");

	  $this->numrows = mysql_num_rows($q2);

 	  $this->maxPage = ceil($this->numrows/$this->rowsPerPage);

	  return $q;

	}


	function navigations($param='')

	{
		$self = basename($_SERVER['PHP_SELF']);

		if ($this->pageNum > 1)
		{
			$gotopage = $this->pageNum - 1;
			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");
				$prev = '<li><a href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=1");

				$first = '<li><a href="'.$href.'">'.FIRST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");
				}
				else
				{
					$href= href($self,"gotopage=$gotopage");
				}
				$prev = '<li><a  href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href= href($self,"gotopage=1");

				$first = '<li><a  href="'.$href.'">'.FIRST.'</a></li>';

			}
		}
		else
		{
			$prev  = '';       // we're on page one, don't enable 'previous' link

			$first = ''; // nor 'first page' link
		}
		if ($this->pageNum < $this->maxPage)
		{
			$gotopage = $this->pageNum + 1;

			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");

				$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=".$this->maxPage);

				$last = '<li><a  href="'.$href.'">'.LAST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");

					$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

					$href= href($self,"gotopage=".$this->maxPage."&$param");

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

				else

				{

					$href= href($self,"gotopage=$gotopage");

					$next = '<li><a href="'.$href.'">'.NEXT.'</a></li>';



					$href= href($self,"gotopage=".$this->maxPage);

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

			}

		}

		else

		{
			$next = '';      // we're on the last page, don't enable 'next' link

			$last = ''; // nor 'last page' link

		}

		$i=$this->pageNum;

		$upto=$i+5;

		$downto=$i-5;

		if($upto>$this->maxPage)

		{

			$upto=$this->maxPage;

		}

		if($downto<=0)

		{

			$downto=1;

		}

		if($this->maxPage>1)

		{

			for($i=$downto;$i<=$upto;$i++)

			{

				if($i==$this->pageNum)

				{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");
				$pages .= '<li class="selected"><a href="'.$href.'">'.$i.'</a></li>';

				}

				else

				{
					if($self=='index.php')

					{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");

						$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
				}
				else
				{
						if($param)
						{
							$href= href($self,"gotopage=$i&$param");
							$pages .= '<li><a  href="'.$href.'">'.$i.'</a></li>';
						}
						else
						{
							$href= href($self,"gotopage=$i");
							$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
						}
					}
				}
			}
		}
		if($pages)
		return '<ul class="pagination">'."$prev $pages $next".'</ul>';
		else
		return false;
	}



}

class Paging_ads
{
	var $rowsPerPage =10;

	var $pageNum = 1;

	var $numrows = 0;

	var $maxPage = 0;

	var $offset = 0;

	function sql($fields="*",$table,$cond='')

	{

	  $this->pageNum = isset($_REQUEST['gotopage'])?$_REQUEST['gotopage']:1;

	  $this->offset = ($this->pageNum - 1) * $this->rowsPerPage;

	  $q = mysql_query("select $fields from $table $cond LIMIT ".$this->offset.", ".$this->rowsPerPage);

	  $q2 = mysql_query("select $fields from $table $cond  ");

	  $this->numrows = mysql_num_rows($q2);

 	  $this->maxPage = ceil($this->numrows/$this->rowsPerPage);

	  return $q;

	}


	function navigations($param='')

	{
		$self = basename($_SERVER['PHP_SELF']);

		if ($this->pageNum > 1)
		{
			$gotopage = $this->pageNum - 1;
			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");
				$prev = '<li><a href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=1");

				$first = '<li><a href="'.$href.'">'.FIRST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");
				}
				else
				{
					$href= href($self,"gotopage=$gotopage");
				}
				$prev = '<li><a  href="'.$href.'">'.PREVIOUS.'</a></li>';

				$href= href($self,"gotopage=1");

				$first = '<li><a  href="'.$href.'">'.FIRST.'</a></li>';

			}
		}
		else
		{
			$prev  = '';       // we're on page one, don't enable 'previous' link

			$first = ''; // nor 'first page' link
		}
		if ($this->pageNum < $this->maxPage)
		{
			$gotopage = $this->pageNum + 1;

			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");

				$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=".$this->maxPage);

				$last = '<li><a  href="'.$href.'">'.LAST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");

					$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

					$href= href($self,"gotopage=".$this->maxPage."&$param");

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

				else

				{

					$href= href($self,"gotopage=$gotopage");

					$next = '<li><a href="'.$href.'">'.NEXT.'</a></li>';



					$href= href($self,"gotopage=".$this->maxPage);

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

			}

		}

		else

		{
			$next = '';      // we're on the last page, don't enable 'next' link

			$last = ''; // nor 'last page' link

		}

		$i=$this->pageNum;

		$upto=$i+5;

		$downto=$i-5;

		if($upto>$this->maxPage)

		{

			$upto=$this->maxPage;

		}

		if($downto<=0)

		{

			$downto=1;

		}

		if($this->maxPage>1)

		{

			for($i=$downto;$i<=$upto;$i++)

			{

				if($i==$this->pageNum)

				{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");
				$pages .= '<li ><a href="'.$href.'" class="active">'.$i.'</a></li>';

				}

				else

				{
					if($self=='index.php')

					{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");

						$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
				}
				else
				{
						if($param)
						{
							$href= href($self,"gotopage=$i&$param");
							$pages .= '<li><a  href="'.$href.'">'.$i.'</a></li>';
						}
						else
						{
							$href= href($self,"gotopage=$i");
							$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
						}
					}
				}
			}
		}
		if($pages)
		return '<ul class="paging">'."$prev $pages $next".'</ul>';
		else
		return false;
	}



}


function get_youtube_video_image($youtube_code)
{
	// get the video code if this is an embed code	(old embed)
	preg_match('/youtube\.com\/v\/([\w\-]+)/', $youtube_code, $match);

	// if old embed returned an empty ID, try capuring the ID from the new iframe embed
	if($match[1] == '')
		preg_match('/youtube\.com\/embed\/([\w\-]+)/', $youtube_code, $match);

	// if it is not an embed code, get the video code from the youtube URL
	if($match[1] == '')
		preg_match('/v\=(.+)&/',$youtube_code ,$match);

	// get the corresponding thumbnail images
	$full_size_thumbnail_image = "http://img.youtube.com/vi/".$match[1]."/0.jpg";
	$small_thumbnail_image1 = "http://img.youtube.com/vi/".$match[1]."/1.jpg";
	$small_thumbnail_image2 = "http://img.youtube.com/vi/".$match[1]."/2.jpg";
	$small_thumbnail_image3 = "http://img.youtube.com/vi/".$match[1]."/3.jpg";

	// return whichever thumbnail image you would like to retrieve
	return $small_thumbnail_image1;
}
function get_Advertise_Banner($cookie,$page_id,$banner_area)
{
	global $db;
	if(isset($cookie) && $cookie!="" && $cookie!='All')
	{
		$getTopBanner=$db->getVal("SELECT banner_image FROM advertisement WHERE region = '".$cookie."' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND (from_date<='".date('Y-m-d')."' AND to_date>='".date('Y-m-d')."') AND payment_status=2 AND status=1");
		if(!isset($getTopBanner))
		{
				$getTopBanner=$db->getVal("SELECT banner_image FROM advertisement WHERE region = '".$cookie."' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND user_id=0 AND payment_status=2 AND status=1");
		}
	}
	else
	{
		$getTopBanner=$db->getVal("SELECT banner_image FROM advertisement WHERE region = 'All' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND (from_date<='".date('Y-m-d')."' AND to_date>='".date('Y-m-d')."') AND payment_status=2 AND status=1");
		if(!isset($getTopBanner))
		{
				$getTopBanner=$db->getVal("SELECT banner_image FROM advertisement WHERE region = 'All' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND user_id=0 AND payment_status=2 AND status=1");
		}
	}
	return $getTopBanner;
}
function getFeatureBanner($cookie,$page_id,$banner_area)
{
	global $db;
	if(isset($cookie) && $cookie!="" && $cookie!='All')
	{
		$getFeatureBanner=$db->getRows("SELECT banner_image, description FROM advertisement WHERE region = '".$cookie."' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND (from_date<='".date('Y-m-d')."' AND to_date>='".date('Y-m-d')."') AND payment_status=2 AND status=1");
		if(is_array($getFeatureBanner) && count($getFeatureBanner)==0)
		{
				$getFeatureBanner=$db->getRows("SELECT banner_image, description FROM advertisement WHERE region = '".$cookie."' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND user_id=0 AND payment_status=2 AND status=1");
		}
	}
	else
	{
		$getFeatureBanner=$db->getRows("SELECT banner_image, description FROM advertisement WHERE region = 'All' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND (from_date<='".date('Y-m-d')."' AND to_date>='".date('Y-m-d')."') AND payment_status=2 AND status=1");
		if(is_array($getFeatureBanner)  && count($getFeatureBanner)==0)
		{
				$getFeatureBanner=$db->getRows("SELECT banner_image, description FROM advertisement WHERE region = 'All' AND page_id='".$page_id."' AND banner_area='".$banner_area."' AND user_id=0 AND payment_status=2 AND status=1");
		}
	}
	return $getFeatureBanner;
}
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

// edit by saurabh

/*function get_difftime($datefr,$dateto=-1)
{
// Defaults and assume if 0 is passed in that
// its an error rather than the epoch
$datefrom = strtotime($datefr);
if($datefrom<=0) { return "A long time ago"; }
if($dateto==-1) { $dateto = time(); }

// Calculate the difference in seconds betweeen
// the two timestamps

$difference = $dateto - $datefrom;

// If difference is less than 60 seconds,
// seconds is a good interval of choice

if($difference < 60)
{
$interval = "s";
}

// If difference is between 60 seconds and
// 60 minutes, minutes is a good interval
elseif($difference >= 60 && $difference<60*60)
{
$interval = "n";
}

// If difference is between 1 hour and 24 hours
// hours is a good interval
elseif($difference >= 60*60 && $difference<60*60*24)
{
$interval = "h";
}

// If difference is between 1 day and 7 days
// days is a good interval
elseif($difference >= 60*60*24 && $difference<60*60*24*7)
{
$interval = "d";
}

// If difference is between 1 week and 30 days
// weeks is a good interval
elseif($difference >= 60*60*24*7 && $difference <
60*60*24*30)
{
$interval = "ww";
}

// If difference is between 30 days and 365 days
// months is a good interval, again, the same thing
// applies, if the 29th February happens to exist
// between your 2 dates, the function will return
// the 'incorrect' value for a day
elseif($difference >= 60*60*24*30 && $difference <
60*60*24*365)
{
$interval = "m";
}

// If difference is greater than or equal to 365
// days, return year. This will be incorrect if
// for example, you call the function on the 28th April
// 2008 passing in 29th April 2007. It will return
// 1 year ago when in actual fact (yawn!) not quite
// a year has gone by
elseif($difference >= 60*60*24*365)
{
$interval = "y";
}

// Based on the interval, determine the
// number of units between the two dates
// From this point on, you would be hard
// pushed telling the difference between
// this function and DateDiff. If the $datediff
// returned is 1, be sure to return the singular
// of the unit, e.g. 'day' rather 'days'

switch($interval)
{
case "m":
$months_difference = floor($difference / 60 / 60 / 24 /
29);
while (mktime(date("H", $datefrom), date("i", $datefrom),
date("s", $datefrom), date("n", $datefrom)+($months_difference),
date("j", $dateto), date("Y", $datefrom)) < $dateto)
{
$months_difference++;
}
$datediff = $months_difference;

// We need this in here because it is possible
// to have an 'm' interval and a months
// difference of 12 because we are using 29 days
// in a month

if($datediff==12)
{
$datediff--;
}

$res = ($datediff==1) ? "$datediff month ago" : "$datediff
months ago";
break;

case "y":
$datediff = floor($difference / 60 / 60 / 24 / 365);
$res = ($datediff==1) ? "$datediff year ago" : "$datediff
years ago";
break;

case "d":
$datediff = floor($difference / 60 / 60 / 24);
$res = ($datediff==1) ? "$datediff day ago" : "$datediff
days ago";
break;

case "ww":
$datediff = floor($difference / 60 / 60 / 24 / 7);
$res = ($datediff==1) ? "$datediff week ago" : "$datediff
weeks ago";
break;

case "h":
$datediff = floor($difference / 60 / 60);
$res = ($datediff==1) ? "$datediff hour ago" : "$datediff
hours ago";
break;

case "n":
$datediff = floor($difference / 60);
$res = ($datediff==1) ? "$datediff minute ago" :
"$datediff minutes ago";
break;

case "s":
$datediff = $difference;
$res = ($datediff==1) ? "$datediff second ago" :
"$datediff seconds ago";
break;
}
return $res;
}*/

function time_since($time1, $time2, $precision = 6) {
	date_default_timezone_set('Asia/Calcutta');
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s ago";
	}
	else
	{
		$interval .= " ago";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }

 $timeCount = count($times);
     if($times[0]!=''){ return $times[0]; } elseif($times[1]!=''){ return $times[1]; } elseif($times[2]!=''){ return $times[2]; }elseif($times[3]!=''){ return $times[3]; }elseif($times[4]!='') { return $times[4]; }elseif($times[5]!='') { return $times[5]; } else {  }

    // Return string with times
  //  return implode(", ", $times);
  }

class Paging_social1
{
	var $rowsPerPage =10;

	var $pageNum = 1;

	var $numrows = 0;

	var $maxPage = 0;

	var $offset = 0;

	function sql($fields="*",$table,$cond='')

	{

	  $this->pageNum = isset($_REQUEST['gotopage'])?$_REQUEST['gotopage']:1;

	  $this->offset = ($this->pageNum - 1) * $this->rowsPerPage;

	  $q = mysql_query("select $fields from $table $cond LIMIT ".$this->offset.", ".$this->rowsPerPage);

	  $q2 = mysql_query("select $fields from $table $cond  ");

	  $this->numrows = mysql_num_rows($q2);

 	  $this->maxPage = ceil($this->numrows/$this->rowsPerPage);

	  return $q;

	}


	function navigations($param='')

	{

		$self = basename($_SERVER['PHP_SELF']);

		if ($this->pageNum > 1)
		{
			$gotopage = $this->pageNum - 1;
			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");
				$a=URL_IMG.'page_prev.png';
				$prev = '<li><a href="'.$href.'">'.'<img src="'.$a.'">'.'</a></li>';



				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=1");

				$first = '<li><a href="'.$href.'">'.FIRST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");
				}
				else
				{
					$href= href($self,"gotopage=$gotopage");
				}
				$prev = '<li><a  href="'.$href.'"><img src="http://192.168.0.5/deve02/club_deal/images/page_prev.png" title="Previous" /></a></li>';

				$href= href($self,"gotopage=1");

				$first = '<li><a  href="'.$href.'"><img src="http://192.168.0.5/deve02/club_deal/images/page_next.png" title="Next"  /></a></li>';

			}
		}
		else
		{
			$prev  = '';       // we're on page one, don't enable 'previous' link

			$first = ''; // nor 'first page' link
		}
		if ($this->pageNum < $this->maxPage)
		{
			$gotopage = $this->pageNum + 1;

			if($self=='index.php')
			{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$gotopage");

				$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=".$this->maxPage);

				$last = '<li><a  href="'.$href.'">'.LAST.'</a></li>';

			}
			else
			{
				if($param)
				{
					$href= href($self,"gotopage=$gotopage&$param");

					$next = '<li><a  href="'.$href.'">'.NEXT.'</a></li>';

					$href= href($self,"gotopage=".$this->maxPage."&$param");

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

				else

				{

					$href= href($self,"gotopage=$gotopage");

					$next = '<li><a href="'.$href.'"><img src="http://192.168.0.5/deve02/club_deal/images/page_next.png" title="Next" /></a></li>';



					$href= href($self,"gotopage=".$this->maxPage);

					$last = '<li><a href="'.$href.'">'.LAST.'</a></li>';

				}

			}

		}

		else

		{
			$next = '';      // we're on the last page, don't enable 'next' link

			$last = ''; // nor 'last page' link

		}

		$i=$this->pageNum;

		$upto=$i+5;

		$downto=$i-5;

		if($upto>$this->maxPage)

		{

			$upto=$this->maxPage;

		}

		if($downto<=0)

		{

			$downto=1;

		}

		if($this->maxPage>1)

		{

			for($i=$downto;$i<=$upto;$i++)

			{

				if($i==$this->pageNum)

				{
				//$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");
				//$pages .= '<li class="selected"><a href="'.$href.'">'.$i.'</a></li>';

				}

				else

				{
					if($self=='index.php')

					{
				$href =href($self,$_SERVER['QUERY_STRING']."&gotopage=$i");

						//$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
				}
				else
				{
						if($param)
						{
							$href= href($self,"gotopage=$i&$param");
							//$pages .= '<li><a  href="'.$href.'">'.$i.'</a></li>';
						}
						else
						{
							$href= href($self,"gotopage=$i");
							$pages .= '<li><a href="'.$href.'">'.$i.'</a></li>';
						}
					}
				}
			}
		}
		if($pages)
		return "$prev  $next";
		else
		return false;
	}
}

function getdays($day_1,$day_2) {
   $diff = strtotime($day_1) - strtotime($day_2);
	if($diff<0)
	{
		return '0 hour ';
		exit;
	}
   $sec   = $diff % 60;
   $diff  = intval($diff / 60);
   $min   = $diff % 60;
   $diff  = intval($diff / 60);
   $hours = $diff % 24;
   $days  = intval($diff / 24);

   if($days==0)
   {
	   if($hours==0)
	   {

	   return $min .' minute ';
	   }
	   else
	   {
		 return $hours .' hours ';
	   }
  }
   else
   {
	   if($days<10)
	   {
		$days='0'.$days;
		}
	   if($days==1){  return $days .' day :'.$hours.' hrs';  }
	   else{ return $days .' days :'.$hours.' hrs';   }

   }


  // return array($sec,$min,$hours,$days);
}

function gettime($day_1,$day_2) {
   $diff = strtotime($day_1) - strtotime($day_2);

   $sec   = $diff % 60;
   $diff  = intval($diff / 60);
   $min   = $diff % 60;
   $diff  = intval($diff / 60);
   $hours = $diff % 24;
   $days  = intval($diff / 24);

   if($days==0)
   {
	   if($hours==0)
	   {

	   return $min .' minute ';
	   }
	   else
	   {
		 return $hours .' hours ';
	   }
  }
   else
   {
	    return $hours;
   }


  // return array($sec,$min,$hours,$days);
}
/* For currency converter */
function Currency_Converter($from=CURRENCY_FROM,$to=CURRENCY_TO,$amount=1)
{
//make string to be put in API
$string = "1".$from."=?".$to;

//Call Google API
$google_url = "http://www.google.com/ig/calculator?hl=en&q=".$string;

//Get and Store API results into a variable
$result = file_get_contents($google_url);


//Explode result to convert into an array
$result = explode('"', $result);

################################
# Right Hand Side
################################
$converted_amount = explode(' ', $result[3]);
$conversion = $converted_amount[0];
$conversion = $conversion * $amount;
$conversion = round($conversion, 2);

//Get text for converted currency
$rhs_text = ucwords(str_replace($converted_amount[0],"",$result[3]));

//Make right hand side string
$rhs = $conversion;//.$rhs_text;

################################
# Left Hand Side
################################
$google_lhs = explode(' ', $result[1]);
$from_amount = $google_lhs[0];

//Get text for converted from currency
$from_text = ucwords(str_replace($from_amount,"",$result[1]));

//Make left hand side string
$lhs = $amount." ".$from_text;

################################
# Make the result
################################
return $rhs;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
			return $miles;
		  }

}

function login()
{
   if($_SESSION[loginuser]['user_id']=='' || !isset($_SESSION[loginuser]['user_id']))
	{
		redirect(href("login.php"));
	}
   elseif($_SESSION[loginuser]['profile']=='0' || $_SESSION[loginuser]['profile']=='')
	{
		redirect(href("password.php"));
	}

}
 function menupermission($ids)
 {
 	if($_SESSION[LOGIN_ADMIN]['type']==0){return true;  }
	else
	{

				  foreach($ids as $val)
				  {
			        if($_SESSION[LOGIN_ADMIN]['access'][$val]['add_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$val]['all_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$val]['edit_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$val]['delete_access']>0) { return true;break;} else{ $return="1";}
				  }
				  if($return==1){ return false; }

	 }
 }
 function permission($action,$page_id)
 {
	 switch ($action)
	  {
            case "add":
               if($_SESSION[LOGIN_ADMIN]['type']==0){return true; }
			   else
			   {
			   if($_SESSION[LOGIN_ADMIN]['access'][$page_id]['add_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['all_access']>0) return true; else  return false;
			   }
            break;

			 case "view":
               if($_SESSION[LOGIN_ADMIN]['type']==0){return true;  }
			   else
			   {
			   if($_SESSION[LOGIN_ADMIN]['access'][$page_id]['add_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['all_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['edit_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['delete_access']>0) {return true; } else {redirect(URL_ADMIN);
			   }
			   }
			break;

		    case "edit":
			 if($_SESSION[LOGIN_ADMIN]['type']==0){return true; }
			   else
			   {
			   if($_SESSION[LOGIN_ADMIN]['access'][$page_id]['edit_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['all_access']>0) return true; else return false;
			   }
		    break;

			case "dashboard":

			   if($_SESSION[LOGIN_ADMIN]['type']==0){return true;  }
			   else
			   {
			   if($_SESSION[LOGIN_ADMIN]['access'][$page_id]['add_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['all_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['edit_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['delete_access']>0) {return true; } else{ return false;}
			   }
			break;

			case "delete":
			 if($_SESSION[LOGIN_ADMIN]['type']==0){return true; }
			   else
			   {
			   if($_SESSION[LOGIN_ADMIN]['access'][$page_id]['delete_access']>0 || $_SESSION[LOGIN_ADMIN]['access'][$page_id]['all_access']>0) return true; else return false;
			   }
		    break;
		}
 }
 function mail_template($to,$type,$vars=NULL,$subject=NULL)
{
    global $db;
    $emails = $db->getRow("select * from emails where email_type = '".$type."'");
    $sub = $emails['subject'];
    $url = URL_ROOT . "user_mail_format.php?email_type=".$type;
    //echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    $body = $result;
//    echo $body;
//    exit;
    if($vars!="")
    {
        if(count($vars))
        {
            foreach($vars as $key => $val)
            {
                if($key=='url'){$val="<a href='".$val."'>Click Here</a></h1>";}
                $body=str_replace($key,$val,$body);
            }
            $body = str_replace("{","",$body);
            $body = str_replace("}","",$body);
        }
    }

    $mail = new PHPMailer();
    $mail->IsSMTP();
    
    $arySettings=fetchSetting(array('mail_host','mail_port','mail_uname','mail_password'));
    $mail->Host = $arySettings['mail_host'];
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->Port = $arySettings['mail_port']; 
    $mail->SMTPSecure = "tls";
    $mail->Username = $arySettings['mail_uname'];
    $mail->Password = $arySettings['mail_password'];
    $mail->SetFrom($emails['from_email'], $emails['from_name']);
    /*if($type == 'monthly_report')
    {
        $mail->AddAttachment('tcpdf/examples/pdf_files/'.$vars['username']."-".date("Y-m-d").'.pdf');
    }*/
    $mail->IsHTML(true);
    $mail->Subject = $sub ;
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    $mail->AddAddress($to, '');
    $mail->Send();
    $mail->ClearAddresses();
}


//function mail_template($to,$type,$vars=NULL,$subject=NULL)
//{
//	global $db;
//	//$emails = $db->getRow("select * from emails where email_type = '".$type."'");
//        if(isset($_SESSION['Transdeal_Language_flag']) && $_SESSION['Transdeal_Language_flag']=='ko')
//        {
//            $language = 'ko';
//        }
//        elseif(isset($_SESSION['Transdeal_Language_flag']) && $_SESSION['Transdeal_Language_flag']=='en')
//        {
//                $language = 'en';
//        }
//        else
//        {
//             $language = 'en';
//        }
//
//        $emails = $db->getRow("select * from emails where email_type = '".$type."' AND language_code = '".$language."'");
//	if($emails['body']!='')
//        {
//            $sub = $emails['subject'];
//            $body = $emails['body'];
//        }
//        else
//        {
//            $emails = $db->getRow("select * from emails where email_type = '".$type."' AND language_code = '".$language."'");
//            $sub = $emails['subject'];
//            $body = $emails['body'];
//        }
//	if($vars!="")
//	{
//	  if(count($vars))
//	  {
//		  foreach($vars as $key => $val)
//		  {
//			  $body=str_replace($key,$val,$body);
//		  }
//		  $body = str_replace("{","",$body);
//		  $body = str_replace("}","",$body);
//	  }
//	}
//
//
//	$mail = new PHPMailer();
//	$mail->IsSMTP();
//	$arySettings=fetchSetting(array('hostname','port_number','smtp_username','smtp_password')); 	//$arySettings=fetchSetting(array('mail_host','mail_port','mail_uname','mail_password'));
//
//
//	// 18 March 2015   Start//
//	// To send HTML mail, the Content-type header must be set
//	$headers  = 'MIME-Version: 1.0' . "\r\n";
//	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//	// Additional headers
//	$headers .= 'From: '.$emails['from_name'].' <'.$emails['from_email'].'>' . "\r\n";
//
//	mail($to, $sub, $body, $headers);
//	// 18 March 2015   End//
//
//	$mail->Host 	= $arySettings['mail_host'];
//	$mail->SMTPDebug= 1;
//	$mail->SMTPAuth = true;
//	$mail->Port = $arySettings['mail_port'];
//	$mail->Username	= $arySettings['mail_uname'];
//	$mail->Password = $arySettings['mail_password'];
//	$mail->SetFrom($emails['from_email'], $emails['from_name']);
//	$mail->Subject    = $sub ;
//	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
//	$mail->MsgHTML($body);
//	$mail->AddAddress($to, '');
//	$mail->Send();
//	$mail->ClearAddresses();
//}

function mail_template_app($to,$type,$vars=NULL,$subject=NULL)
{
    global $db;
    $emails = $db->getRow("select * from emails where email_type = '".$type."'");

    $sub=$emails['subject'];

    $url = URL_ROOT . "user_mail_format.php?email_type=" . $type;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    $body = $result;

    if($vars!="")
    {
        if(count($vars))
        {
            foreach($vars as $key => $val)
            {
                //if($key=='url'){$val="<a href='".$val."'>Click Here</a></h1>";}
                //if($key=='SEE_RESPONSE'){$val="<a href='".$val."'>See full survey details click here</a></h1>";}
                //if($key=='Help_Center'){$val="<a href='".$val."'>Click Here</a></h1>";}
                $body=str_replace($key,$val,$body);
            }
            $body = str_replace("{","",$body);
            $body = str_replace("}","",$body);
        }
    }

    $arySettings=fetchSetting(array('mail_host','mail_port','mail_uname','mail_password','mail_sender_email','mail_sender_name'));
//    $arySettings['mail_host']='mail.omsoftware.us';
//    $arySettings['mail_port']=25;
//    $arySettings['mail_uname']='ayushi@omsoftware.us';
//    $arySettings['mail_password']='gvWGTOaX]nKs';
//    $arySettings['mail_sender_email']='swati.katyal@omsoftware.co.in';
//    $arySettings['mail_sender_name']='Transdeal';

   // print_r($arySettings); exit;
    $mail = new PHPMailer();
    if($_SERVER['HTTP_HOST'] == '192.168.0.5' || $_SERVER['HTTP_HOST'] == '111.93.90.230:82')
    {
        $mail->IsSMTP();
    }


    $mail->Host = $arySettings['mail_host'];
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->Port = $arySettings['mail_port'];
    $mail->Username = $arySettings['mail_uname'];
    $mail->Password = $arySettings['mail_password'];
    $mail->SetFrom($arySettings['mail_sender_email'], $arySettings['mail_sender_name']);
    $mail->Subject = $sub;
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    $mail->AddAddress($to, '');
    $mail->Send();

    $mail->ClearAddresses();

}
function msg($msg)
{
	//TYPE :  success, info, warning, danger
	if(count($msg))
	foreach($msg as $type => $content)
	if($msg[$type]!='')
	{
		if($type=='error')
		{
			$type1 = 'danger';
		}
		else
		{
			$type1 = $type;
		}
			return 	'<div class="alert alert-'.$type1.' fade in alert-dismissable">
        	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
        	<strong></strong> '.ucfirst($content).'.
			</div>';
        //ucfirst($type);
	}
}
function msg_OLD2_11_2017($msg)
{
	if(count($msg))
	foreach($msg as $type => $content)

	if($msg[$type]!='')
	{
	 return '<div class="status '.$type.'">
        	<p class="closestatus"><a href="javascript:void(0);" onclick="$(\'.status\').remove()" title="Close">x</a></p>
        	<p><img src="'.URL_ADMIN.'img/icon_'.$type.'.png" align="absmiddle">&nbsp;&nbsp;'.$content.'</p>
           </div>';
	}
}
function exchangeRate($from,$to,$amount)
{
	if($from!=$to)
	{
             //$amount = $amount * 1000;
	      $string = "$amount&from=".$from."&to=".$to;
		$google_url = 'https://www.google.com/finance/converter?a='.$string;
		//echo $google_url;
		//Get and Store API results into a variable
		$get = file_get_contents($google_url);
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
            	$converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
                if($converted_amount!='')
                {
                   //return number_format($converted_amount,'2','.',',');
				   return $converted_amount;
                }
                else
                {
                    return number_format(0,2);
                }
	}
	else
	{
		return $amount;
    }

}

function exchangeRateAfterCommission($from,$to,$amount)
{
        global $db;
        $aryFormSettingTemp=$db->getRows("select * from settings where field in ('buyer_commission','seller_commission')");

        if(!is_null($aryFormSettingTemp) && is_array($aryFormSettingTemp) && count($aryFormSettingTemp)>0)
        {
                foreach($aryFormSettingTemp as $iFormTemp)
                {
                        $aryForm[$iFormTemp['field']]=$iFormTemp['value'];
                }
        }
        $buyer_commission = $aryForm['buyer_commission'];
        $seller_commission = $aryForm['seller_commission'];

	if($from!=$to)
	{
                //$amount = $amount * 1000;
                $string = "$amount&from=".$from."&to=".$to;
                $google_url = 'https://www.google.com/finance/converter?a='.$string;
                //echo $google_url;
                //Get and Store API results into a variable
                $get = file_get_contents($google_url);
                $get = explode("<span class=bld>",$get);
                $get = explode("</span>",$get[1]);
                $converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
                if($converted_amount!='')
                {
                    if($converted_amount!='')
                    {
                       //return number_format($converted_amount,'0','.',',');
                        if($seller_commission!=0)
                        {
                            $commissionAmount = ( $converted_amount * $seller_commission )/100;
                           // $amount = $amount - $commissionAmount;
                            $converted_amount = $converted_amount - $commissionAmount;
                        }
                       $totalAmount =  $amount * $converted_amount;
                        return round($totalAmount);
                    }
                    else
                    {
                        //return number_format(0,2);
                               return 0;
                    }

                    //return number_format($converted_amount,'2','.',',');
		    //return $converted_amount;
                }
                else
                {
                    return number_format(0,2);
                }
	}
	else
	{
                if($seller_commission!=0)
                {
                    $commissionAmount = ( 1 * $seller_commission )/100;
                   // $amount = $amount - $commissionAmount;
                    $amount = $amount - $commissionAmount;
                }

                return round($amount);
        }

}


function receive_in_wallet($from,$to,$amount,$type)
{
	//change amount according to type (0,-5,5)
	if($type!=0)
	{
            $typediscount = ( $amount * $type )/100;
            $amount = $amount + $typediscount;
	}

	//Fetch commission
	global $db;
	$aryFormSettingTemp=$db->getRows("select * from settings where field in ('buyer_commission','seller_commission')");

	if(!is_null($aryFormSettingTemp) && is_array($aryFormSettingTemp) && count($aryFormSettingTemp)>0)
	{
		foreach($aryFormSettingTemp as $iFormTemp)
		{
			$aryForm[$iFormTemp['field']]=$iFormTemp['value'];
		}
	}
	$buyer_commission = $aryForm['buyer_commission'];
	$seller_commission = $aryForm['seller_commission'];

	if($seller_commission!=0)
	{
           // $commissionAmount = ( $amount * $seller_commission )/100;
           // $amount = $amount - $commissionAmount;
	}

	if($from!=$to)
	{
            //$amount = $amount * 1000;
            $amountoneRupee = 1;
	    $string = "$amountoneRupee&from=".$from."&to=".$to;
            $google_url = 'https://www.google.com/finance/converter?a='.$string;
            //echo $google_url;
            //Get and Store API results into a variable
            $get = file_get_contents($google_url);
            $get = explode("<span class=bld>",$get);
            $get = explode("</span>",$get[1]);
            $converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
            if($converted_amount!='')
            {
               //return number_format($converted_amount,'0','.',',');
                if($seller_commission!=0)
                {
                    $commissionAmount = ( $converted_amount * $seller_commission )/100;
                   // $amount = $amount - $commissionAmount;
                    $converted_amount = $converted_amount - $commissionAmount;
                }
               $totalAmount =  $amount * $converted_amount;
                return round($totalAmount);
            }
            else
            {
                //return number_format(0,2);
                       return 0;
            }
	}
	else
	{
            if($seller_commission!=0)
            {
                $commissionAmount = ( 1 * $seller_commission )/100;
               // $amount = $amount - $commissionAmount;
                $amount = $amount - $commissionAmount;
            }

            return round($amount);
        }

}

function receive_in_wallet_7_10_2015($from,$to,$amount,$type)
{
	//change amount according to type (0,-5,5)
	if($type!=0)
	{
		$typediscount = ( $amount * $type )/100;
		$amount = $amount + $typediscount;
	}

	//Fetch commission
	global $db;
	$aryFormSettingTemp=$db->getRows("select * from settings where field in ('buyer_commission','seller_commission')");

	if(!is_null($aryFormSettingTemp) && is_array($aryFormSettingTemp) && count($aryFormSettingTemp)>0)
	{
		foreach($aryFormSettingTemp as $iFormTemp)
		{
			$aryForm[$iFormTemp['field']]=$iFormTemp['value'];
		}
	}
	$buyer_commission = $aryForm['buyer_commission'];
	$seller_commission = $aryForm['seller_commission'];

	if($seller_commission!=0)
	{
		$commissionAmount = ( $amount * $seller_commission )/100;
		$amount = $amount - $commissionAmount;
	}

	if($from!=$to)
	{
        //$amount = $amount * 1000;
	    $string = "$amount&from=".$from."&to=".$to;
		$google_url = 'https://www.google.com/finance/converter?a='.$string;
		//echo $google_url;
		//Get and Store API results into a variable
		$get = file_get_contents($google_url);
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
        $converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
        if($converted_amount!='')
        {
           //return number_format($converted_amount,'0','.',',');
		    return round($converted_amount);
        }
        else
        {
           //return number_format(0,2);
		   return 0;
        }
	}
	else
	{
		return round($amount);
    }

}

function need_to_pay_for_buy($from,$to,$amount,$type)
{
	//change amount according to type (0,-5,5)
	if($type!=0)
	{
		$typediscount = ( $amount * $type )/100;
		$amount = $amount + $typediscount;
	}

	//Fetch commission
	global $db;
	$aryFormSettingTemp=$db->getRows("select * from settings where field in ('buyer_commission','seller_commission')");

	if(!is_null($aryFormSettingTemp) && is_array($aryFormSettingTemp) && count($aryFormSettingTemp)>0)
	{
		foreach($aryFormSettingTemp as $iFormTemp)
		{
			$aryForm[$iFormTemp['field']]=$iFormTemp['value'];
		}
	}
	$buyer_commission = $aryForm['buyer_commission'];
	$seller_commission = $aryForm['seller_commission'];

	if($buyer_commission!=0)
	{
		$commissionAmount = ( $amount * $buyer_commission )/100;
		$amount = $amount + $commissionAmount;
	}

	if($from!=$to)
	{
        //$amount = $amount * 1000;
	    $string = "$amount&from=".$from."&to=".$to;
		$google_url = 'https://www.google.com/finance/converter?a='.$string;
		//echo $google_url;
		//Get and Store API results into a variable
		$get = file_get_contents($google_url);
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
        $converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
        if($converted_amount!='')
        {
           //return number_format($converted_amount,'0','.',',');
		    return round($converted_amount);
        }
        else
        {
           //return number_format(0,2);
		   return 0;
        }
	}
	else
	{
		return round($amount);
    }

}
function admin_commision($from,$to,$amount,$type,$usertype)
{
	//change amount according to type (0,-5,5)
	if($type!=0)
	{
		$typediscount = ( $amount * $type )/100;
		$amount = $amount + $typediscount;
	}

	//Fetch commission
	global $db;
	$aryFormSettingTemp=$db->getRows("select * from settings where field in ('buyer_commission','seller_commission')");

	if(!is_null($aryFormSettingTemp) && is_array($aryFormSettingTemp) && count($aryFormSettingTemp)>0)
	{
		foreach($aryFormSettingTemp as $iFormTemp)
		{
			$aryForm[$iFormTemp['field']]=$iFormTemp['value'];
		}
	}
	if($usertype=='buyer')
	{
		$commission = $aryForm['buyer_commission'];
	}
	elseif($usertype=='seller')
	{
		$commission = $aryForm['seller_commission'];
	}



	if($commission!=0)
	{
		$commissionAmount = ( $amount * $commission )/100;
		//$amount = $amount + $commissionAmount;
	}

	if($from!=$to)
	{
        //$amount = $amount * 1000;
	    $string = "$commissionAmount&from=".$from."&to=".$to;
		$google_url = 'https://www.google.com/finance/converter?a='.$string;
		//echo $google_url;
		//Get and Store API results into a variable
		$get = file_get_contents($google_url);
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
        $converted_amount = preg_replace("/[^0-9\.]/",null,$get[0]);
        if($converted_amount!='')
        {
           //return number_format($converted_amount,'0','.',',');
		    return $converted_amount;
        }
        else
        {
           //return number_format(0,2);
		   return 0;
        }
	}
	else
	{
		return round($amount);
    }

}
function currency_to_point($amount,$currency)
{
	return round($amount);
}
function point_to_currency($point,$currency)
{
	return round($point);
}
function bitcoin_to_currency($point,$currency)
{
	global $db;
	$BitSetting = $db->getRows("select value from settings where field = 'bitcoin_amount' or field = 'bitcoin_currency'");

	$bitcoinUSD = $BitSetting[0]['value'];
	$bitcoinCurrency = $BitSetting[1]['value'];

	$usdAmount = exchangeRate($bitcoinCurrency,$currency,1);

	$TotalAmount = $point*$bitcoinUSD*$usdAmount;

	return round($TotalAmount);

}
function currency_to_bitcoin($amount,$currency)
{
	global $db;
	$BitSetting = $db->getRows("select value from settings where field = 'bitcoin_amount' or field = 'bitcoin_currency'");

	$bitcoinUSD = $BitSetting[0]['value'];
	$bitcoinCurrency = $BitSetting[1]['value'];

	$usdAmount = exchangeRate($currency,$bitcoinCurrency,$amount);

	$bitCoin = $usdAmount/$bitcoinUSD;

	return round($bitCoin);

}
function remaining_balance($user_id)
{
	global $db;

	$dealsDataADD = $db->getVal("select SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 1 or transaction_type = 4 )");

	$dealsDataDEDUCT = $db->getVal("SELECT SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 2 or transaction_type = 3 ) ");

	return $dealsDataADD - $dealsDataDEDUCT;
	//Issue :  When deduct money null its showing wrong record
	//$dealsData = $db->getRow("select SUM(point) - (SELECT SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 2 or transaction_type = 3 ) ) as remaining_points from wallet where user_id = '".$user_id."' AND status = 1 AND transaction_type = 1 ");

	//return $dealsData['remaining_points'];
}

function remaining_balance_transaction($user_id,$wallet_id)
{
	global $db;

	$dealsDataADD = $db->getVal("select SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 1 or transaction_type = 4 ) AND wallet_id <= '".$wallet_id."' ORDER BY wallet_id ASC" );

	$dealsDataDEDUCT = $db->getVal("SELECT SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 2 or transaction_type = 3 ) AND wallet_id <= '".$wallet_id."' ORDER BY wallet_id ASC");

	return $dealsDataADD - $dealsDataDEDUCT;
	//Issue :  When deduct money null its showing wrong record
	//$dealsData = $db->getRow("select SUM(point) - (SELECT SUM(point)from wallet where user_id = '".$user_id."' AND status = 1 AND ( transaction_type = 2 or transaction_type = 3 ) ) as remaining_points from wallet where user_id = '".$user_id."' AND status = 1 AND transaction_type = 1 ");

	//return $dealsData['remaining_points'];
}

function sendsms($to,$type,$vars)
{
	global $db;
	$api_key=$db->getVal("select value from settings where field = 'api_key'");
	$api_secret=$db->getVal("select value from settings where field = 'api_secret'");
        //ab2ae5fe
        //3b2528d5
        if(isset($_SESSION['Transdeal_Language_flag']) && $_SESSION['Transdeal_Language_flag']=='ko')
	{
		$language = 'ko';
	}
	elseif(isset($_SESSION['Transdeal_Language_flag']) && $_SESSION['Transdeal_Language_flag']=='en')
	{
			$language = 'en';
	}
	else
	{
		 $language = 'en';
	}
	//mysql_query("SET CHARACTER SET 'ISO-8859-1'", $db);
        //mysql_query("SET NAMES 'ISO-8859-1'");

	$emails = $db->getRow("select * from emails where email_type = '".$type."' AND language_code = '".$language."'");
        //echo $db->getLastQuery();



    $sub=$emails['subject'];
    $body = $emails['body'];

    if($vars!="")
    {
        if(count($vars))
        {
            foreach($vars as $key => $val)
            {
              $body=str_replace($key,$val,$body);
            }
            $body = str_replace("{","",$body);
            $body = str_replace("}","",$body);
        }
    }
	$message = $body;

	$message=str_replace("<br>"," ",$message);
        $message=str_replace("\n","",$message);
        $message=str_replace("&nbsp;"," ",$message);
	//$message=str_replace(" ","%20",$message);
	$message = strip_tags($message);

	//$message = htmlentities($message);


    //rawurlencode($message);
    $url="https://rest.nexmo.com/sms/json?api_key=ab2ae5fe&api_secret=3b2528d5&from=MyCompany20&to=919926378747&text=Test%20Message";

    $url="https://rest.nexmo.com/sms/json?api_key=".$api_key."&api_secret=".$api_secret."&from=Transdeal&type=unicode&to=".trim($to)."&text=".trim($message)."";

    //$url="http://78.108.164.67:8080/websmpp/websms?user=OMSCORPS&pass=Om@c98o1@&sid=1&mno=".trim($to)."&text=".trim($message)."&type=1&esm=0&dcs=0";

    //echo "http://rest.nexmo.com/sms/json?api_key=ab2ae5fe&api_secret=3b2528d5&from=Transdeal&type=unicode&to=".trim($to)."&text=".trim(rawurlencode($message))."";
    //echo "<br>";


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://rest.nexmo.com/sms/json?api_key=ab2ae5fe&api_secret=3b2528d5&from=Transdeal&type=unicode&to=".trim($to)."&text=".trim(rawurlencode($message))."");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$order_data = curl_exec($ch);
	curl_close($ch);
	/*$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	$body = curl_exec($ch);
	curl_close($ch);
	return $body;*/
}

function seo_url($title)
{
	$replace = array(" ","?",",",".","'","&","-","_",":","(",")","+",";","#","!","*","{","}","[","]","?","/","\"","|","@","%","$");
	$linkStr_Replace = str_replace($replace,"-",trim($title));
	$linkStr_Replace = str_replace("----","-",$linkStr_Replace);
	$linkStr_Replace = str_replace("---","-",$linkStr_Replace);
	$linkStr_Replace = str_replace("--","-",$linkStr_Replace);
	return $linkname = strtolower($linkStr_Replace);
}
function seo_url2($title)
{
	$replace = array(" ",",",".","'","&","-","_",":","(",")","+",";","#","!","*","{","}","[","]","?","/","\"","|","@","%","$");
	$linkStr_Replace = str_replace($replace,"",trim($title));
	$linkStr_Replace = str_replace("----","",$linkStr_Replace);
	$linkStr_Replace = str_replace("---","",$linkStr_Replace);
	$linkStr_Replace = str_replace("--","",$linkStr_Replace);
	return $linkname = $linkStr_Replace;
}
function success_rate($userid)
{
	global $db;
	$totalDeal = $db->getVal("SELECT count(deal_id) FROM deals WHERE seller_id = '".$userid."' ");

	$successDeal = $db->getVal("SELECT count(deal_id) FROM deals WHERE seller_id = '".$userid."' AND status = 3");

	$successRate = ($successDeal/$totalDeal)*100;
	return round($successRate);

}
function success_deal($userid)
{
	global $db;
	$success_deal = $db->getVal("SELECT count(deal_id) FROM deals WHERE seller_id = '".$userid."' AND status = 3");
	return $success_deal;
}
function recursive_for_category($parent = 0)
{
	global $db;
	$html = '<ul>';
	$allCategories = $db->getRows("select category_id,category_name,parent from category_all where status = 1 and parent = ".$parent." ");
	foreach($allCategories as $categories)
	{
		$current_id = trim($categories['category_id']);
		$html .= '<li>' . $categories['category_name'];
		$allCategories = $db->getVal("select count('parent') from category_all where status = 1 and parent = ".$current_id." ");
		if($allCategories)
		{
			$html .= recursive_for_category($current_id);
		}
		$html .= '</li>';
	}
	$html .= '</ul>';
    return $html;
}

function get_cat_selectlist($current_cat_id, $count, $lastname='')
{
    static $option_results;
    // if there is no current category id set, start off at the top level (zero)
    if (!isset($current_cat_id)) {
        $current_cat_id=1;
    }
    // increment the counter by 1
    $count = $count+1;

    // query the database for the sub-categories of whatever the parent category is
    $sql =  "SELECT category_id,category_name from category_all where parent =  ".$current_cat_id." order by category_name asc";

    $get_options = mysqli_query($sql);
    $num_options = mysqli_num_rows($get_options);

    // our category is apparently valid, so go ahead ��
    if ($num_options > 0) {
        while (list($cat_id, $cat_name) = mysqli_fetch_row($get_options)) {

        // if its not a top-level category, indent it to
        //show that its a child category

        if ($current_cat_id!=0) {
            $indent_flag =  $lastname . '--';
//          for ($x=2; $x<=$count; $x++) {
                $indent_flag .=  '>';
//          }
        }
            $cat_name = $indent_flag.$cat_name;
            $option_results[$cat_id] = $cat_name;
            // now call the function again, to recurse through the child categories
            get_cat_selectlist($cat_id, $count, $cat_name);
        }
    }
    return $option_results;
}
function get_cat_selectlist_link_name($category, $html=array())
{

	global $db;
    $output = '';
	$allCategories = $db->getRows("select category_id,category_name,link_name,parent from category_all where status = 1 and category_id = ".$category." ");
	foreach($allCategories as $categories)
	{
		$querySrting2 = 'category='.$categories['link_name'];


		$parent_id = $categories['parent'];

        $category_name = seo_url2($categories['category_name']);
		array_push($html,'' . $category_name.'');

		//array_push($html,'' . $categories['link_name'].'');

		$allCategories = $db->getVal("select count('parent') from category_all where status = 1 and category_id = ".$parent_id." ");
		if($allCategories>0)
		{
			array_push($html,get_cat_selectlist_link_name($parent_id));
		}
	}
    $html = array_unique($html);
	$html = array_reverse($html);

	foreach($html as $key=>$value)
	{
        if($key!=0)
        {
            $output .= '-'.$html[$key];
        }
        else
        {
		  $output .= $html[$key];
        }
	}
    return $output;
}

function get_parent_cat($parent, $count, $lastname='')
{

	global $db;
	$allCategories = $db->getRows("select category_id,category_name,parent from category_all where status = 1 and category_id = ".$parent." ");

	foreach($allCategories as $categories)
	{
		$current_id = trim($categories['category_id']);
		$html []= '' . $categories['category_name'];
		$parent_id = $categories['parent'];

		$allCategories = $db->getVal("select count('parent') from category_all where status = 1 and category_id = ".$parent_id." ");
		if($allCategories)
		{
			if (!isset($parent)) {
				$current_cat_id=1;
			}
			$count = $count+1;
			$html []= get_parent_cat($parent_id,$count,$categories['category_name']);
		}
	}
	$html = array_reverse($html);
	foreach($html as $key=>$value)
	{
		if($finalHTML!='')
		{
			$preFix = '-->';
		}
		else
		{
			$preFix = '';
		}
			$finalHTML .= $preFix.$value;
	}
    return $finalHTML;
}
function get_parent_cat_breadcrumbs($category, $html=array()) {

	global $db;
	$allCategories = $db->getRows("select category_id,category_name,link_name,parent from category_all where status = 1 and category_id = ".$category." ");
	foreach($allCategories as $categories)
	{
		$querySrting2 = 'category='.$categories['link_name'];


		$parent_id = $categories['parent'];
		array_push($html,'<li><a href="'.href('place_your_ad_2.php',$querySrting2).'" >' . $categories['category_name'].'</a></li>');
		$allCategories = $db->getVal("select count('parent') from category_all where status = 1 and category_id = ".$parent_id." ");
		if($allCategories>0)
		{
			array_push($html,get_parent_cat_breadcrumbs($parent_id));
		}
	}
	$html = array_reverse($html);

	foreach($html as $key=>$value)
	{
		echo $html[$key];
	}
}

function get_root_parent($category_id)
{
	global $db;
	$parents = $db->getRow("select parent,category_id from category_all where category_id = ".$category_id." ");
	//echo $db->getLastQuery();
	$parent = $parents['parent'];
    //echo $parent.'-';
	//echo $category_id.'-';
	$finalRoot = $category_id;
	if($parent!=0)
	{
		$lastCategory = $parents['category_id'];
		$finalRoot = get_root_parent($parent);
	}
	return $finalRoot;

}
function get_top_parent($category_id, $root_id=0)
{
    // Grab the id's and category's
    $item_list = array();
    foreach($this->items as $item) {
        $item_list[$item['id']] = $item['category_id'];
    }

    $current_category = $category_id;

    while(TRUE) {
        if ($item_list[$current_category] == $root_id) {
            // Check to see if we have found the parent category.
            return $current_category;
        } else {
            // update our current category
            $current_category = $item_list[$current_category];
        }
    }

}

function get_faqcat_selectlist($current_cat_id, $count, $lastname='')
{
    static $option_results;
    // if there is no current category id set, start off at the top level (zero)
    if (!isset($current_cat_id))
    {
        $current_cat_id=1;
    }
    // increment the counter by 1
    $count = $count+1;

    // query the database for the sub-categories of whatever the parent category is
    $sql =  "SELECT faq_catid,category_name from faq_category where parent =  ".$current_cat_id." order by category_name asc";

    $get_options = mysql_query($sql);
    $num_options = mysql_num_rows($get_options);

    // our category is apparently valid, so go ahead ��
    if ($num_options > 0) {
        while (list($cat_id, $cat_name) = mysql_fetch_row($get_options)) {

        // if its not a top-level category, indent it to
        //show that its a child category

        if ($current_cat_id!=0) {
            $indent_flag =  $lastname . '--';
//          for ($x=2; $x<=$count; $x++) {
                $indent_flag .=  '>';
//          }
        }
            $cat_name = $indent_flag.$cat_name;
            $option_results[$cat_id] = $cat_name;
            // now call the function again, to recurse through the child categories
            get_faqcat_selectlist($cat_id, $count, $cat_name);
        }
    }
    return $option_results;
}

function get_faqparent_cat($parent, $count, $lastname='')
{

	global $db;
	$allCategories = $db->getRows("select faq_catid,category_name,parent from faq_category where status = 1 and faq_catid = ".$parent." ");

	foreach($allCategories as $categories)
	{
		$current_id = trim($categories['category_id']);
		$html []= '' . $categories['category_name'];
		$parent_id = $categories['parent'];

		$allCategories = $db->getVal("select count('parent') from faq_category where status = 1 and faq_catid = ".$parent_id." ");
		if($allCategories)
		{
			if (!isset($parent)) {
				$current_cat_id=1;
			}
			$count = $count+1;
			$html []= get_faqparent_cat($parent_id,$count,$categories['category_name']);
		}
	}
	$html = array_reverse($html);
	foreach($html as $key=>$value)
	{
		if($finalHTML!='')
		{
			$preFix = '-->';
		}
		else
		{
			$preFix = '';
		}
			$finalHTML .= $preFix.$value;
	}
    return $finalHTML;
}
 // makes the process simpler
function loadImage($url, $width, $height){
    return URL_ROOT.'image.php?url='.urlencode($url).'&w='.$width.'&h='.$height;
}

function SmsSend($tonumber,$smstype,$vars)
{
    global $db;
    $sid = 'ACd439fa652c489ab101a6da92ea229f00';
    $token = 'f94afa253fab0774b3deb855fa78f525';
    $client = new Client($sid, $token);

    $message = $db->getVal("select body from manage_sms_content where type='".$smstype."'");
    if($vars!="")
    {
        if(count($vars))
        {
            foreach($vars as $key => $val)
            {
                if($key=='url'){$val="<a href='".$val."'>Click Here</a></h1>";}
                $message=str_replace($key,$val,$message);
            }
            $message = str_replace("{","",$message);
            $message = str_replace("}","",$message);
        }
    }

    // Use the client to do fun stuff like send text messages!
    $client->messages->create(
        // the number you'd like to send the message to
        $tonumber,
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => 'ACd439fa652c489ab101a6da92ea229f00',
            // the body of the text message you'd like to send
            'body' => $message
        )
    );
    print_r($message->sid);
    }

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function send_notification($type,$curuserid,$triggered_id,$notifyid)
{
    global $db;
    $userdetails=$db->getRow("select firstname,lastname from users where id='".$curuserid."'");
    $userlink=href("userprofile.php?id=".base64_encode($curuserid));
    $usernamelink = "<a href='$userlink'>".ucwords($userdetails['firstname'].' '.$userdetails['lastname'])."</a>";
    if($type==1) 
    {    
        $message=$usernamelink." Wants To Follow You.";
    }
    else if($type==2)
    {
        $message="Follow Request Has Been Accepted By ".$usernamelink;
    }
    else if($type==3)
    {
        $message="Follow Request Has Been Rejected By ".$usernamelink;
    }
      else if($type==4)
    {
        $jobdetail=$db->getRow("select title from manage_posts where post_id='".$triggered_id."'");
        $link = href('jobdetail.php?id='.base64_encode($triggered_id));
        $href = "<a href='$link'>". ucfirst($jobdetail['title'])."</a>";
        $message=$usernamelink." Shortlisted You For ".$href;
    }
    else if($type==5)
    {
        $jobdetail=$db->getRow("select title from manage_posts where post_id='".$triggered_id."'");
        $link = href('jobdetail.php?id='.base64_encode($triggered_id));
        $href = "<a href='$link'>".ucfirst($jobdetail['title'])."</a>";
        $message=$usernamelink." Finalized You For ".$href;
    }
    else if($type==6)
    {
        $jobdetail=$db->getRow("select title from manage_posts where post_id='".$triggered_id."'");
        $link = href('jobdetail.php?id='.base64_encode($triggered_id));
        $href = "<a href='$link'>".ucfirst($jobdetail['title'])."</a>";
        $message=$usernamelink." Posted A New Job ".$href;
    } 
    else if($type==7)
    {
        $postid=$db->getVal("select post_id from user_apply_job where apply_job_id='".$triggered_id."'");
        $jobdetail=$db->getRow("select title from manage_posts where post_id='".$postid."'");
        $link = href('jobdetail.php?id='.base64_encode($postid));
        $href = "<a href='$link'>".ucfirst($jobdetail['title'])."</a>";
        $message=$usernamelink." Has Applied On ".$href;
	}
	else if ($type == 8)
	{
		$message = $usernamelink . " Rated your profile";
	}
    $notificationData =  array(
                                        'notification_type'     => $type,
                                        'triggered_by'          => $curuserid,
                                        'triggered_id'          => $triggered_id,
                                        'notify'                => $notifyid,
                                        'message'               => $message,
                                        'datetime'              => date("Y-m-d H:i:s"),
                                        'is_read'               => 1
                            );
    $flgnoti=$db->insertAry("notification",$notificationData); 
}
function avgrating($userid)
{
	global $db;
	$totalpeople = $db->getVal("select count(review_rating_id) from review_rating where reviewto_id='".$userid."' && rating!=0 order by review_rating_id desc");
        $totalrating = $db->getVal("select SUM(rating) from review_rating where reviewto_id='".$userid."' && rating!=0 order by review_rating_id desc");
	if($totalpeople>0)
        {
            $avgrate =$totalrating/$totalpeople;
        }
        else
        {
            $avgrate=0; 
        }
	return round($avgrate,1);
}
?>
