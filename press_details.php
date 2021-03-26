<style>
    body {
        background-image: none !important;

    }
</style>

<?php
include("header.php");
$press = $db->getRow("select * from press_cms where link_name='".$_GET['link_name']."'  ");   

?>

<div class="wrap container" role="document">
        <div class="content row">
          <main class="main">
              <article class="post-1600 post type-post status-publish format-standard hentry category-uncategorized">
    <header>
      <h1 class="entry-title"><?= $press['title']?></h1>
      <?= $press['date']?>    </header>
    <div class="entry-content">
      <p><?= $press['description']?></p>
    </div>
    <footer>
          </footer>
      </article>
          </main><!-- /.main -->
                  </div>
<!-- /.content -->
      </div>

