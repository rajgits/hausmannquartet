<?php
include("header.php");
$ldate = date('Y-m-d');
$scheduleUpcoming = $db->getRows("select * from schedule_cms where status= 1 AND date >  '".$ldate."' ORDER BY `cms_id` ASC"); 
$schedulePostEvent  = $db->getRows("select * from schedule_cms where status= 1 AND date <  '".$ldate."' ORDER BY `cms_id` ASC"); 
?>

<style>
	.content.row {
		padding-top: 100px;
	}

	body {
		background-image: none !important;
	}
</style>

<div class="page-header">
	<h1>Schedule</h1>
</div>

<div class="row">
	<div class="col-sm-6">
		<h2 class="evt-title">Upcoming Concerts:</h2>

		<?php
		if(empty($scheduleUpcoming)){?>
			<p>No upcoming events currently posted. Please check back soon!</p>
		<?php }else{ 
			foreach($scheduleUpcoming as $sh){ ?>
		
		
		
		<div class="row concert-listing">
			<div class="col-sm-3 thumb"> 
				<a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>">
					<img width="2048" height="1365" src="./uploads/cms/<?=$sh['image'] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" > </a>
			</div>
			<div class="col-sm-9">
				<h3 class="evt-title"><a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>"><?=$sh['title'] ?></a></h3> 
				<div class="past-event-content">
					<p class="evt-date">
						<a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>">
						<?=$sh['date'] ?> </a> 
					</p>
					<p>
						<?=$sh['venue'] ?>
						|
						<?=$sh['time'] ?>  <?=($sh['mer']==2?'PM' : 'AM' )?>     
					</p>
					<p><a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>"><strong class="btn btn-default">More information <i class="fa fa-caret-right"></i></strong></a></p>
				</div>
			</div>
		</div>
		<?php }
		}
		?> 

<div class="event-spacer">

</div>

<h2 class="evt-title title">Past Concerts:</h2>

<?php
		if(empty($schedulePostEvent)){?>
			<p>No more post events</p>     
		<?php }else{ 
			foreach($schedulePostEvent as $sh){ ?> 
		
		
		
		<div class="row concert-listing">
			<div class="col-sm-3 thumb"> 
				<a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>">  
					<img width="2048" height="1365" src="./uploads/cms/<?=$sh['image'] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" > </a>
			</div>
			<div class="col-sm-9">
				<h3 class="evt-title"><a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>"><?=$sh['title'] ?></a></h3> 
				<div class="past-event-content">
					<p class="evt-date">
						<a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>"> 
						<?=$sh['date'] ?> </a> 
					</p>
					<p>
						<?=$sh['venue'] ?>
						|
						<?=$sh['time'] ?>  <?=($sh['mer']==2?'PM' : 'AM' )?>      
					</p>
					<p><a href="./schedule_details.php?link_name=<?= $sh['link_name'] ?>"><strong class="btn btn-default">More information <i class="fa fa-caret-right"></i></strong></a></p>
				</div>
			</div>
		</div>
		<?php }
		}
		?> 
	</div>

	<div class="schedule-img col-sm-6">
		<img src="./wp-content/uploads/2013/09/J-46.jpg" alt="">
	</div>
</div>   

<?php
include("footer.php");
?>
</div>