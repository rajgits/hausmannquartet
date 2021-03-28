<?php
include("header.php");
$quote = $db->getRows("select * from quote_cms where status= 1  ORDER BY `cms_id` ASC");  
$scheduleUpcoming = $db->getRows("select * from schedule_cms where status= 1 AND date >  '".$ldate."' ORDER BY `cms_id` ASC");
?>
<div class="wrap container" role="document">
				<div class="content row">
					<main class="main">
						  					</main><!-- /.main -->
									</div>
<!-- /.content -->
			</div>
<!-- /.wrap -->
 
			<div class="spacer">
				
			</div>
			<div class="areas">

				
				<div class="col-sm-3 area area1">
					<h2 class="text-center">Next Concert:</h2>
					
				<h3><a href="./schedule_details.php?link_name=<?= $scheduleUpcoming[0]['link_name'] ?>">	<?=$scheduleUpcoming[0]['title'] ?></a></h3>
				<p class="evt-date">
				<a href="./schedule_details.php?link_name=<?= $scheduleUpcoming[0]['link_name'] ?>"><?=date("F j, Y", strtotime( $scheduleUpcoming[0]['date'])) ?> | <?= $scheduleUpcoming[0]['time']?>  <?=$scheduleUpcoming[0]['mer']==2?'PM' : 'AM'  ?></a> 
				</p>
				<p><a href="./schedule_details.php?link_name=<?= $scheduleUpcoming[0]['link_name'] ?>">
					<?=$scheduleUpcoming[0]['venue'] ?>
				</a></p>

    				</div>
				<div class="col-sm-6 area area2">
					<h2 class="text-center"></h2>
					<div class="mid-text">
<p><span style="font-weight: 400;">The Hausmann Quartet has established itself as an integral part of the cultural life of Southern California since its arrival in San Diego in 2010. As faculty Artists-in-Residence at San Diego State University they teach and organize the chamber music program, engage in interdisciplinary collaborations with other departments and visit local schools for concerts and clinics on behalf of the School of Music and Dance. Their latest endeavor is <em>Haydn Voyages: Music at the Maritime, </em>a quarterly concert series on a historic ferry boat exploring the string quartet repertoire through Haydn&#8217;s quartet cycle. They pioneered interactive programs for students, adult amateur musicians and local seniors, veterans and homeless with support from Mainly Mozart, the Irvine Foundation, National Endowment for the Arts and ACMP, and continue to administer and direct these programs as their own non-profit organization serving the Greater San Diego area, with recent grants from the California Arts Council and County of San Diego. Founded in the summer of 2004 at Lyricafest, they have recently been hailed as “Excellent” by <em>U-T San Diego</em> which cited “Their outstanding virtue is a rare one: the ability to disappear into and behind whatever they are playing, leaving only the music in view.&#8221; They maintain an active performance schedule throughout North America and Asia. The members of the Hausmann Quartet are violinists Isaac Allen and Bram Goldstein, violist Angela Choong and cellist Alex Greenbaum.</span></p>
</div>
				</div>
				<div class="col-sm-3 area area3">
					<div class="quotes">
					<?php foreach($quote as $qt){ ?> 
							<div class="quote">
								
								<div class="quote-container">
									<div class="quote-text">
<span class="large">&ldquo;</span> <?= $qt['title']; ?><span class="large">&rdquo;</span>
</div>
									<div class="quote-author"><?= $qt['small_title']; ?></div>
								</div>
							</div>
							<?php } ?>
					</div>
								
						
						</div>
				</div>
			</div>

			<?php
include("footer.php");
?>	