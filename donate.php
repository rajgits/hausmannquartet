<?php
include("header.php");
$covid = $db->getRow("select * from donate_cms  where status= 1  ORDER BY `cms_id` ASC");
?>
<style>
    body {
        background-image: none !important;
    }
</style>

<div class="wrap container" role="document">
    <div class="content row">
        <main class="main">

            <div class="page-header">
                <h1>Donate</h1>
            </div>

            <p><?= $covid['description']; ?></p>
        </main>
    </div> 
    </div>
    <?php
    include("footer.php");
    ?>
 </div>