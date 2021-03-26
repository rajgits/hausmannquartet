<div class="page-sidebar-wrapper">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->          
            <ul class="page-sidebar-menu">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <div class="clearfix">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <li>
                    <form class="search-form" role="form" action="<?php echo URL_ADMIN; ?>" method="post">
                        <div class="input-icon right">
                            <i class="fa fa-search"></i>
                            <input type="text" class="form-control input-medium input-sm" name="query" placeholder="Search...">
                        </div>
                    </form>
                </li>
              

             

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">     
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"qoute",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Qoute</span>
                        <span class="arrow ">
                        </span>
                    </a> 
                   
                </li>

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">      
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"Haydn",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Haydn Voyages</span>
                        <span class="arrow ">
                        </span>
                    </a>    
                   
                </li>

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">      
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"education",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Education</span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>
                

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">      
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"about",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">About Us</span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">       
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"schedule",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Schedule</span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">        
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"covid",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Covid-19</span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>

                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">         
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"press",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Press </span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>


                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">         
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"media",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Media </span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>


                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">        
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"donate",'section'=>"cms"));?>">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                        <span class="title">Donate</span>
                        <span class="arrow ">
                        </span>
                    </a>
                </li>


                <li class="<?php if($_GET['module']=='users'){?> active <?php } ?>">  
                    <a href="<?php echo URL_ADMIN.getQueryString(array('module'=>"contactfile",'section'=>"cms"));?>"> 
                        <i class="fa fa-book"></i> 
                        <span class="title">Contact Queries</span> 
                        <span class="arrow">
                        </span>
                    </a>
                       
                </li>



               
                <li class="last ">
                    <a href="<?php echo URL_ROOT.'manage/logout.php'; ?>">
                    <i class="fa fa-user"></i>
                    <span class="title">Logout</span></a>
                </li>
            </ul>
        
        </div>
    </div>
</div>
