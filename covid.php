<style>
    body{  
	background-image:none !important;
	
}
</style>

<?php
include("header.php");
$covid = $db->getRows("select * from covid_cms  where status= 1  ORDER BY `cms_id` ASC");  
$covidPage = $db->getRow("select * from covid_cms  where link_name='".$_GET['link_name']."' ");  

?> 
 
 <div class="">           
<div class="row submenu">
	<div class="col-sm-12">
		<div class="menu-covid-19-container">
      <ul id="menu-covid-19" class="nav nav-pills nav-justified">
      <?php foreach($covid as $cov){?>
          <li id="menu-item-1995" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1995"><a href="./covid.php?link_name=<?=$cov['link_name']?>"><?=$cov['title']?></a></li>
      <?php } ?>
      </ul>
      </div>	
    </div>
</div>

  
<div class="page-header">
  <h1><?=$covidPage['title'] ?></h1>
  <p><?= $covidPage['description'] ?>
</div>
</div>

<?php
include("footer.php");
?>	
</div>


 