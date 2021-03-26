<?php include('header.php');?>
<?php
$link_name=$_GET['link_name'];
?>
<?php $ms=$db->getRows("select * from career_cms");  


$sub=$db->getRows("select * from subservice_cms where `service_page`=".$id  ); 

?>   
  

<style>
    #topnav .navigation-menu>li>a{ 
    color:black !important;
}
       

</style>

<div class="mission-vision">
            <section class="page-title parallax">
                <div data-parallax="scroll" data-image-src="./uploads/cms/univers.jpg" class="parallax-bg"></div> 
                <div class="parallax-overlay">
                    <div class="centrize">
                        <div class="v-center">
                            <div class="container"> 
                                <div class="title center">
                                    <h1 class="upper"><div data-aos="zoom-in" class="aos-init aos-animate">WE'RE HIRING</div></h1>
                                    <div data-aos="fade-up" data-aos-duration="3000" class="aos-init"><h4>Join the team.</h4></div>
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <a class="prev" href="https://www.titechglobal.com/about-us/">❮ <span>About Us</span> </a> <a class="next" href="https://www.titechglobal.com/about-us/management/"> <span>Management</span>❯ </a> -->
                </div>
           


                      




                            
            
            
            <div class="clearfix"></div>
            <section class="footer-hight"></section>
        </div>

<?php include('footer.php');?>