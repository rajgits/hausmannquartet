<?php
include("header.php");
$schedule = $db->getRow("select * from schedule_cms where link_name='" . $_GET['link_name'] . "'  ");

?>
<style>
  .content.row {
    padding-top: 100px;
  }

  body {
    background-image: none !important;
  }
</style>

<div class="wrap container" role="document">
  <div class="content row">
    <main class="main">
      <div class="intro-concert event-info">
        <p class="back"><a href="./schedule.php"><i class="fa fa-caret-left"></i> Back to All Events</a></p>
        <h1><?= $schedule['title'] ?></h1>
        <h3 class="event-subtitle"><?= $schedule['small_title'] ?></h3> 
        <p><strong> <?=date("F j, Y", strtotime( $schedule['date'])) ?> at <?= $schedule['time'] ?> <?= $schedule['mer']==2?'PM' : 'AM' ?>&nbsp; | &nbsp;<?= $schedule['venue'] ?></strong></p>
        <div class="row share">
          <div class="col-sm-3">
            <div class="row">
              <div class="sharelabel">Share</div> 
              <a class="sharelink" href="http://www.facebook.com/" onclick="popUp=window.open(
        'http://www.facebook.com/sharer.php?u=./event/haydn-voyages-17/',
        'popupwindow',
        'scrollbars=yes,width=800,height=400');
        popUp.focus();
        return false"><i class="fa fa-facebook"></i></a>
              <a class="sharelink" href="http://twitter.com/" onclick="popUp=window.open(
        'http://twitter.com/home?status=\'Haydn Voyages\' via @Hausmannquartet - ./event/haydn-voyages-17/',
        'popupwindow',
        'scrollbars=yes,width=800,height=400');
        popUp.focus();
        return false"><i class="fa fa-twitter"></i></a>
              <a class="sharelink" href="http://www.plus.google.com/" onclick="popUp=window.open(
        'https://plus.google.com/share?url=./event/haydn-voyages-17/',
        'popupwindow',
        'scrollbars=yes,width=800,height=400');
        popUp.focus();
        return false"><i class="fa fa-google-plus"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="row single-event-content">
        <aside class="col-sm-5 pull-right">
          <img width="2772" height="1641" src="./uploads/cms/<?= $schedule['image'] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" sizes="(max-width: 2772px) 100vw, 2772px">
        </aside>
        <article class="col-sm-7">
          <p><?= $schedule['description'] ?></p>

          <?php if(!empty($schedule['ticket_link'])){?>      
            <h3>Ticket Information:</h3>
            <a href="<?= $schedule['ticket_link'] ?>" target="_blank" class="btn-blue">Buy Tickets</a>
          <?php } ?>

          <h3>Venue Information:</h3>
          <p><?= $schedule['venue'] ?><br></p>
          <div class="google-maps">
            <iframe src="<?=$schedule['map_link'] ?>" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>       
          </div>
        </article>
      </div>

      <p class="back"><a href="./schedule.php"><i class="fa fa-caret-left"></i> Back to All Events</a></p>

    </main><!-- /.main -->
  </div>
  <!-- /.content -->
</div>

<?php
include("footer.php");
?>
</div>