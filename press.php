<style>
    body {
        background-image: none !important;

    }
</style>

<?php
include("header.php");
$press = $db->getRows("select * from press_cms where status= 1 ORDER BY `cms_id` ASC");  
?>

<div class="wrap container" role="document">
    <div class="content row">
        <main class="main">
            <!-- This file edits the blog page -->

            <div class="row">
                <div class="col-sm-5 pull-right press-image">
                    <img src="./wp-content/uploads/2015/12/SZWZ7850.jpg" alt="">
                </div>
                <div class="col-sm-7">

                <?php foreach($press as $ps){ ?>
                    <article class="post-1600 post type-post status-publish format-standard hentry category-uncategorized">
                        <header>
                            <h2 class="entry-title"><a href="./press_details.php?link_name=<?=$ps['link_name'] ?>"><?= $ps['title'] ?></a></h2>
                            <?=date("F j, Y", strtotime( $ps['date'])) ?>
                        </header>
                        <div class="entry-intro">
                            <p><?= $ps['orginal_post'] ?></p> 
                        </div>
                        <div class="entry-summary">
                        <p><?= $ps['description'] ?></p>  
                        </div>
                    </article>
                    <?php } ?>

                </div>
            </div>
        </main>
    </div>

</div>

<?php
include("footer.php");
?>
</div>