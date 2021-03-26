<?php
include("header.php");
$about = $db->getRow("select * from about_cms where status = 1 AND cms_id = 8"); 
$about1 = $db->getRow("select * from about_cms where status = 1 AND cms_id = 9"); 
$about2 = $db->getRow("select * from about_cms where status = 1 AND cms_id = 10"); 
$about3 = $db->getRow("select * from about_cms where status = 1 AND cms_id = 11"); 
$about4 = $db->getRow("select * from about_cms where status = 1 AND cms_id = 12"); 

?>
<style>
    body{ 
	background-image:url('./wp-content/uploads/2013/09/J-20-e1437676953810.jpg');
}
</style>

  <div class="darkener about-darkener">
      <div class="wrap container" role="document">
        <div class="content row">
          <main class="main">
            <div class="row submenu">
	<div class="col-sm-12">
		<ul class="nav nav-pills nav-justified" id="menu-about">
			<li class="menu-the-hausmann-quartet"><a href="#sec1" >Hausmann<br>Quartet</a></li>
			<li class="menu-isaac-allen"><a href="#sec2" >Isaac,<br>Violin</a></li>
			<li class="menu-bram-goldstein"><a href="#sec3" >Bram,<br>Violin</a></li>
			<li class="menu-angela-choong"><a href="#sec4" >Angela,<br>Viola</a></li>
			<li class="menu-alex-greenbaum"><a href="#sec5" >Alex,<br>Cello</a></li> 
		</ul>
	</div>
</div>
<sectin id="sec1">
<div class="row about-slides">
	
	<div class="member quartet col-sm-12">
	
<div class="page-header">
  <h1><?=$about['title']  ?></h1> 
</div>
		<div class="col-sm-7 pull-right">
				<img src="./wp-content/uploads/2015/12/SZWZ7693.jpg" alt="">
			<p class="text-center"><a href="./../repertoire-list/index.html">Repertoire List</a></p>
		</div>
	<p dir="ltr"><?=$about['description']  ?></p>
	</div>
	</div> 
</sectin>

<sectin id="sec2">
	<div class="member isaac col-sm-12">
		<h1 style="text-align: center;"><?=$about1['title'] ?></h1> 
<div class="about-photo"><img loading="lazy" class="alignnone wp-image-874 size-large" src="./wp-content/uploads/2014/12/Garden-154-683x1024.jpg" alt="Isaac Allen" width="683" height="1024" srcset="./wp-content/uploads/2014/12/Garden-154-683x1024.jpg 683w, ./wp-content/uploads/2014/12/Garden-154-200x300.jpg 200w, ./wp-content/uploads/2014/12/Garden-154-768x1152.jpg 768w" sizes="(max-width: 683px) 100vw, 683px"></div>
<p><?=$about1['description'] ?></p>
	</div>
</sectin>

<sectin id="sec3">

	<div class="member melody col-sm-12">
		<h1 style="text-align: center;"><?=$about2['title']  ?></h1>
<div class="about-photo"><img loading="lazy" class="alignnone wp-image-1139 size-large" src="./wp-content/uploads/2014/12/Bram-8-e1437698840573-861x1024.jpg" alt="Bram" width="861" height="1024" srcset="./wp-content/uploads/2014/12/Bram-8-e1437698840573-861x1024.jpg 861w, ./wp-content/uploads/2014/12/Bram-8-e1437698840573-252x300.jpg 252w, ./wp-content/uploads/2014/12/Bram-8-e1437698840573-768x913.jpg 768w, ./wp-content/uploads/2014/12/Bram-8-e1437698840573.jpg 1731w" sizes="(max-width: 861px) 100vw, 861px"></div>
<p><?=$about2['description'] ?></p> 
	</div>
</sectin>


<sectin id="sec4">
	<div class="member angela col-sm-12">
		<h1 style="text-align: center;"><?=$about3['title']  ?></h1>
<div class="about-photo"><img loading="lazy" class="alignnone wp-image-873 size-large" src="./wp-content/uploads/2014/12/Garden-148-683x1024.jpg" alt="Angela Choong" width="683" height="1024" srcset="./wp-content/uploads/2014/12/Garden-148-683x1024.jpg 683w, ./wp-content/uploads/2014/12/Garden-148-200x300.jpg 200w, ./wp-content/uploads/2014/12/Garden-148-768x1152.jpg 768w" sizes="(max-width: 683px) 100vw, 683px"></div>
<p><?=$about3['description']  ?></p>
	</div>
</sectin>


<sectin id="sec5">
	<div class="member alex col-sm-12">
		<h1 style="text-align: center;"><?=$about4['title']  ?></h1>
<div class="about-photo"><img loading="lazy" class="alignnone wp-image-875 size-large" src="./wp-content/uploads/2014/12/Garden-157-683x1024.jpg" alt="Alex Greenberg" width="683" height="1024" srcset="./wp-content/uploads/2014/12/Garden-157-683x1024.jpg 683w, ./wp-content/uploads/2014/12/Garden-157-200x300.jpg 200w, ./wp-content/uploads/2014/12/Garden-157-768x1152.jpg 768w" sizes="(max-width: 683px) 100vw, 683px"></div>
<p><?=$about4['description'] ?></p>
	</div>
</sectin>
	
</div>
          </main><!-- /.main -->
                  </div>
<!-- /.content -->
      </div>
<!-- /.wrap -->	
</div>

<?php
include("footer.php");
?> 
