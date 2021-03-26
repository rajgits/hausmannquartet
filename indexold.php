<?php include('header.php');?>
<?php

$home_title=$db->getRows("select * from sectiontitle_cms where status= 1  ORDER BY `cms_id` ASC");  
?>

<main class="main">
			<div class="intro-slider intro-slider-1 owl-carousel owl-theme owl-nav-inside bg-gradient owl-light slide-animate mb-0" data-toggle="owl" data-owl-options='{
					"dots": false,
					"nav": false, 
					"responsive": {
						"1200": {
							"nav": true
						}
					}
				}' style="height: calc(100vh - 48px);">
                
                <?php $array_slider1=$db->getRows("select * from slider1_cms where status=1 ORDER BY `cms_id` ASC"); 
                    foreach($array_slider1 as $sl1){
                     
                ?> 

                <div class="banner intro-slide bg-gradient"> 
					<div class="container">
						<figure>
							<img src="./uploads/cms/<?=$sl1['image']?>" class="appear-animate"  
							data-animation-name="fadeInUp" data-animation-delay="0" data-animation-duration="1s" 
							alt="Banner-slide" width="1506" height="905">
						</figure>
						<div class="banner-content">
							<h2 class="banner-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
							<?= stripslashes($sl1['title']); ?>
							</h2>
							<p class="banner-info appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1000">
                                <?= stripslashes($sl1['description']); ?> 
									</p>
							
						</div>
					</div>
                </div>

                <?php    
                    } 
                    
                ?>
                

				<!-- <div class="banner intro-slide bg-gradient">
					<div class="container">
						<figure>
							<img src="assets/images/demos/demo-1/banner/banner-2.png" class="appear-animate" 
							data-animation-name="fadeInUp" data-animation-delay="0" data-animation-duration="1s" 
							alt="Banner-slide" width="1506" height="905">
						</figure>
						<div class="banner-content">
							<h2 class="banner-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
								Doctors who <br> treat with care.
							</h2>
							<p class="banner-info appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1000">
									Our skilled doctors have tremendous experience with wide <br>
									range of diseases to serve the needs of our patients.</p>
							
						</div>
					</div>
				</div> -->
			</div>
			<?php $section1=$db->getRows("select * from section1_cms where status=1 ORDER BY `cms_id` ASC"); ?> 
			<div class="bg-primary-color">
				<div class="container">
					<div class="row position-relative">
						<img src="assets/images/logo-white.png" class="puzzle " alt="Puzzle">
						<div class="col-md-12 col-lg-6">
							<div class="widget appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="100">
								<h4 class="widget-title"><?= stripslashes($section1[0]['title'] ); ?> </h4>
								<p class="widget-desc">
								<?= stripslashes($section1[0]['description'] ); ?> 
								</p>
								<!-- <div class="widget-hours">
									<span>Monday<i class="fas fa-minus"></i>Friday</span>
									<span class="time">9:00<sup>AM</sup><i class="fas fa-minus"></i>10:00<sup>PM</sup></span>
								</div> -->
								<!-- <div class="widget-hours">
									<span>Saturday<i class="fas fa-minus"></i>Sunday</span>
									<span class="time">10:00<sup>AM</sup><i class="fas fa-minus"></i>9:00<sup>PM</sup></span>
								</div> -->
							</div>
						</div>
						<div class="col-md-12 col-lg-6">
							<div class="widget appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="400">
								<h4 class="widget-title"><?= stripslashes($section1[0]['small_title'] ); ?></h4>
								<p class="widget-desc">
								<?= stripslashes($section1[0]['description2'] ); ?>
								</p>
								<a href="<?=$section1[0]['link']?>" class="btn btn-sm btn-secondary-color ls-0">Buy Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="container mt-5 mb-5 mt-md-15 mb-md-15">
				<h2 class="ls-n-20 text-center mb-3 appear-animate" data-animation-name="blurIn" data-animation-delay="0"><?=$home_title[0]['title']?></h2>  
				
				<div class="blog-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{
					"margin": 30,
					"dots": false,
					"nav": false,
					"loop": false,
					"responsive": {
						"480": {
							"items": 1
						},
						"768": {
							"items": 2
						},
						"1200": {
							"items": 3
						}
					}
				}'>

				<?php $section2=$db->getRows("select * from section2_cms where status=1 ORDER BY `cms_id` ASC"); ?> 
				 <?php foreach($section2 as $sec){ ?>
					<div class="card appear-animate" data-animation-name="fadeInUp" data-animation-delay="500">
						<div class="card-heading">
							<figure>
								<img src="uploads/cms/<?=$sec['image'] ?>" alt="home-section-2"/>
							</figure>
							<h4 class="card-title"><?= stripslashes($sec['title'] ); ?> </h4>  
						</div>
						<div class="card-content">
							<ul class="card-menu ls-20">
								<?= stripslashes($sec['description'] ); ?>
							</ul>

							<div class="btn-link">
								<a href="<?=$sec['link'] ?>">Learn More</a><i class="fas fa-caret-right"></i>
							</div>
						</div>
						
					</div>

					<?php } ?>
				
		
				</div>

			</div> 
			<?php $slider2=$db->getRows("select * from slider2_cms where status=1 ORDER BY `cms_id` ASC"); ?> 

			<div class="banner-big bg-image" style="background-image: url('uploads/cms/<?=$slider2[0]['image'] ?>');">
				<div class="container position-relative">
					<div class="banner-content pt-md-15 pb-md-15">
						<h2 class="banner-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="0">
						   <?= stripslashes($slider2[0]['title'] ); ?> 
                        </h2>
						<p class="banner-info appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500"> <?= stripslashes($slider2[0]['description'] ); ?> </p> 
						<div class="icon-boxes mt-5 mb-3">
						<?php $slider2menu=$db->getRows("select * from slider2menu_cms where status=1 ORDER BY `cms_id` ASC");
							foreach($slider2menu as $menu2){?> 
								<div class="icon-box text-center appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="750">
									<figure>
										<img src="uploads/cms/<?=$menu2['image'] ?>" alt="menu-slider-2"/>
									</figure>
									<div class="iconbox-content">
										<h4 class="box-title"><?=$menu2['title'] ?></h4>
									</div>
								</div>
							<?php } ?>

						</div>
						<!-- <div class="banner-actions appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1500">
							<a href="#" class="btn btn-secondary-color">View Pricing Plans</a>
						</div> -->
					</div>
					<!-- <div class="card-rating appear-animate" data-animation-name="bounceIn" data-animation-delay="500">
						 <div class="ratings-container">
							<div class="ratings">
								<div class="ratings-val" style="width: 100%;"></div>
							</div>
						</div>
						<p class="card-info ls-0">
						<?=$slider2[0]['small_title']  ?>
						</p>
						
					</div> -->
						
				</div>
            </div>
			<div class="container mt-5 mb-5 mt-md-15 mb-md-15">
				<h2 class="ls-n-20 text-center appear-animate" data-animation-name="blurIn" data-animation-duration="0"><?=$home_title[1]['title']?></h2>
				<div class="owl-carousel owl-theme owl-nav-inside owl-light owl-imageover-15" data-toggle="owl" data-owl-options='{
					"margin": 30,
					"dots": false,
					"nav": false,
					"loop": false,
					"responsive": {
						"480": {
							"items": 1
						},
						"768": {
							"items": 2
						},
						"1200": {
							"items": 3
						}
					}
				}'>

				<?php $section3=$db->getRows("select * from section3_cms where status=1 ORDER BY `cms_id` ASC"); ?> 
				<?php foreach($section3 as $sec3){ ?>
					<div class="image-box image-over appear-animate" data-animation-name="fadeInUp" data-animation-delay="500">
						<figure>
							<img src="./uploads/cms/<?=stripslashes($sec3['image'] );?>" alt="Image-over" width="298" height="461">
						</figure>
						
						<div class="box-content">
							<h4 class="box-title"><?= stripslashes($sec3['title'] ); ?> </h4>
							<p class="box-desc">
								<?=stripslashes($sec3['description'] );?>
							</p>
						</div>
					</div>
					<?php } ?>

				</div>
				
			</div> 
			
			
			
			<?php $slider3=$db->getRows("select * from slider3_cms ORDER BY `cms_id` ASC"); ?> 

			<div class="banner-big bg-image" style="background-image: url('uploads/cms/<?=$slider3[0]['image'] ?>');">
				<div class="container position-relative">
					<div class="banner-content pt-0 pb-0 pt-md-15 pb-md-15">
						<h2 class="banner-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="0" style="color:#ffff">
						<?= stripslashes($slider3[0]['title'] ); ?> 
						</h2>
						<p style="color:#ffff" class="banner-info appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
						<?= stripslashes($slider3[0]['description'] ); ?></p>
					
							<div  class="row" style="margin-left: 30px;">
							<?php $slider3menu=$db->getRows("select * from slider3menu_cms ORDER BY `cms_id` ASC");
							foreach($slider3menu as $menu3){?> 
								<div class="icon-box  icon-box-left mb-3 appear-animate mr-5" data-animation-name="fadeInUpShorter" data-animation-delay="750">
									<figure>
										<img src="uploads/cms/<?=$menu3['image'] ?>" alt="menu-slider-"/>
									</figure>
									<div class="iconbox-content">
										<h4 class="box-title"><?= stripslashes($menu3['title'] ); ?> </h4>
									</div>
								</div>
							<?php } ?>	
								</div>
						
						
						<!-- <div class="banner-actions appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1500">
							<a href="#" class="btn btn-primary-color">Book an Appointment</a>
							<a href="#" class="btn">Learn More</a>
						</div> -->
					</div>
				</div>
			</div>
			<div class="container mt-5 mb-5 mt-md-15 mb-md-15">
				<h2 class="ls-n-20 text-center appear-animate" data-animation-name="blurIn" data-animation-duration="0"><?=$home_title[2]['title'] ?></h2>
				<div class="blog-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{
					"margin": 30,
					"dots": false,
					"nav": false,
					"loop": false,
					"responsive": {
						"576": {
							"items": 1
						},
						"992": {
							"items": 2
						},
						"1200": {
							"items": 3
						}
					}
				}'>

                <?php $news=$db->getRows("select * from service_cms where status=1 ORDER BY `cms_id` ASC"); ?> 
					<?php foreach($news as $sec4){ ?>
					<div class="post-box appear-animate" data-animation-name="fadeInUp" data-animation-delay="500">
						<figure>
							<a href="./news_details.php?link=<?= $sec4['link_name']?>">
								<img src="./uploads/cms/<?=$sec4['image'] ?>" alt="Blog" class="img-fluid. max-width: 100%;"> 
							</a>
						</figure>
						<div class="box-content">
							<h4 class="box-title"><a href="./news_details.php?link=<?= $sec4['link_name']?>"><?php echo substr(stripslashes($sec4['title']), 0, 150);if (strlen($sec4['title']) > 150) { echo '...';} ?> </a></h4>
							<p class="post-desc">
						<?php echo substr(stripslashes($sec4['description']), 0, 80);if (strlen($sec4['description']) > 80) { echo '...';} ?> 
							</p>
						</div>
					</div>

					<?php } ?> 


				</div>
			</div>
			<?php $slider4=$db->getRows("select * from slider4_cms where status=1 ORDER BY `cms_id` ASC"); ?> 
			<div class="banner banner-simple bg-gradient pt-md-18 pb-md-19 pt-5 pb-5">
				<figure>
					<!-- <img src="assets/images/demos/demo-1/banner/Screen_Shot_2020-09-17_at_8.04.49_AM-removebg-preview.png " class="appear-animate" data-animation-name="fadeInRightBig" data-animation-delay="1000"
						 id="img-banner-4" alt="Banner-simple" width="368" height="539"> -->
					<img src="./uploads/cms/<?=$slider4[0]['image']?>" class="appear-animate" data-animation-name="fadeInLeftBig" data-animation-delay="500"
						>
				</figure>
			
				<div class="container">
					<div class="banner-content">
						<h2 class="banner-title ls-n-20 appear-animate" data-animation-name="blurIn" data-animation-delay="1500">
								
								<?= stripslashes($slider4[0]['title'] ); ?> 
						</h2>
						<!-- <div class="banner-actions appear-animate" data-animation-name="blurIn" data-animation-delay="2000">
							<a href="#" class="btn btn-secondary-color">Book an Appointment</a>
							<a href="#" class="btn">Learn More</a>
						</div> -->
					</div>
				</div> 
			</div>
		</main>

<?php include('footer.php');?>