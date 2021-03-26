<?php
include("config.php");



if (isset($_SESSION[LOGIN_USER]['userid']) && $_SESSION[LOGIN_USER]['userid'] != '')
{

    $userdetails=$db->getRow("select * from users where id='".$_SESSION[LOGIN_USER]['userid']."' ");
  

    /*print_r('<pre>');
    print_r($userdetails);
    exit(); */

    $expdetails=$db->getRows("select * from users_experience where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
    //echo "select * from users_experience where user_id='".$_SESSION[LOGIN_USER]['userid']."'";
    $userskills=$db->getRows("select * from users_skills where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
    if(count($userskills)>0)
    {
        foreach($userskills as $userskillsi)
        {
            $skillsid[]=$userskillsi['skill_id'];
        }
    }
}
//print_r($skillsid);
function getLocationInfoByIp()
{

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    //$client  = '117.248.186.43';

    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

    $remote  = @$_SERVER['REMOTE_ADDR'];

    $result  = array('country'=>'', 'city'=>'', 'currency'=>'');

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $result['country'] = $ip_data->geoplugin_countryName;
        $result['city'] = $ip_data->geoplugin_city;
        $result['currency'] = $ip_data->geoplugin_currencyCode;
    }
    return $result;
}
if (count($_SESSION['country_data']) > 0 && $_SESSION['country_data'] != '')
{
    $autolocationary=$_SESSION['country_data'];
    $aryData = array(
                        'city'     =>  trim($autolocationary['city']),
                        'country'  =>  trim($autolocationary['country']),
                    );
    $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
}
else
{
    $autolocationary=getLocationInfoByIp();
    $aryData = array(
                        'city'     =>  trim($autolocationary['city']),
                        'country'  =>  trim($autolocationary['country']),
                    );
    $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
}
 $array_set=$db->getRows("select * from settings ORDER BY `id` ASC"); 
//    print_r('<pre>');
//    print_r($array_set[12][2]);
//    exit();

?>
