<style>
    body{  
	background-image:none !important;
	padding-left: 60px;
    padding-right: 60px;
}
</style>

<?php
include("header.php");
$hyden = $db->getRow("select * from haydn_cms  where status= 1  ORDER BY `cms_id` ASC");  
?> 
<h1><?=$hyden['title']?></h1>
<p><?=$hyden['description']?></p> 
