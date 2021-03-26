<style>
	.content.row {
		padding-top: 100px;
	}

	body {
		background-image: none !important;
		padding-left: 60px;
		padding-right: 60px;
	}
</style>
<?php
include("header.php");
$education = $db->getRows("select * from education_cms where status= 1  ORDER BY `cms_id` ASC");
$education_dl = $db->getRow("select * from education_cms where link_name='" . $_GET['link_name'] . "'  ");

?>


<div class="row submenu">
	<div class="col-sm-12">
		<div class="menu-education-container">
			<ul id="menu-education" class="nav nav-pills nav-justified">
				<?php foreach ($education as $ed) { ?>
					<li id="menu-item-1268" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="./education.php?link_name=<?= $ed['link_name'] ?>"><?= $ed['title'] ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>


<div class="page-header">
	<h1><?= $education_dl['title'] ?></h1>
</div>
<?= $education_dl['description'] ?>

<?php
include("footer.php");
?>
</div>