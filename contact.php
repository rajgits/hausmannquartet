<?php
include("header.php");
?>

<style>
    body{ 
       background-image:none !important;
}
</style>
<div class="contact_back"  >
    <img src="./wp-content/uploads/2014/11/N-14.jpg"/>
</div>
<div class="wrap container" role="document">
    <div class="content row">
        <main class="main">

            <div class="page-header">
                <h1>Contact</h1>
            </div>
            <div class="col-sm-8 pull-right">
                <div class="google-maps"><iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3354.6797180681606!2d-117.07271000000003!3d32.77423199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80d95686d9f4405d%3A0x74b2f0e02a22d7e7!2sSchool+of+Music+and+Dance!5e0!3m2!1sen!2sus!4v1419750401175" width="600" height="400" frameborder="0"></iframe></div>
            </div>
            <p>For booking inquiries:</p>
            <p>619.432.2314</p>
            <p><a href="mailto:info%40hausmannquartet.com" target="_blank">email Hausmann Quartet</a></p>
            <p>Attention: Hausmann Quartet<br>
                SDSU-School of Music and Dance<br>
                5500 Campanile Drive<br>
                San Diego, CA 92182-7902</p>
            <p>&nbsp;</p>
           
        </main><!-- /.main -->
    </div>
    <div class="col-md-12">
    <div class="container mt-1 mb-5 mt-md-3 mb-md-15">
                <h2 class="ls-n-20 text-center">Got questions?<br>Write us a message.</h2><br>
                <div class="book-form book-form-contact mr-lg-20 ml-lg-20"> 
                    <div class="row row-joined">
                        
                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-group col-md-7">
                                <input type="text" class="form-control demoInputBox" name="userName" id="userName" placeholder="Name *" ><br>
                                <span id="userName-info" class="info"> </span>
                            </div>
                        </div>
                      
                        <div class="col-sm-12 col-md-12 mt-2">
                            <div class="form-group col-md-7">
                                <input type="email" class="form-control demoInputBox" name="userEmail" id="userEmail" placeholder="Email *"><br>
                                <span id="userEmail-info" class="info"> </span>
                            </div>
                        </div>
                       
                        <div class="col-lg-12 mt-2">
                            <div class="form-group col-md-7">
                                <textarea class="form-control text-area demoInputBox" name="content" id="content" placeholder="Message *"></textarea><br>
                                <span id="content-info" class="info"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary-color btn-form d-flex mr-auto ml-auto mb-1"  onClick="sendContact();">Send Message</button>
                </div>
            </div>
    </div>
    <!-- /.content -->
</div>
<?php
include("footer.php");
?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
            function sendContact() {
                   
                    var valid;	 
                    valid = validateContact();
                    if(valid) {
                        jQuery.ajax({
                            url: "contact_mail_send.php", 
                            data:'userName='+$("#userName").val()+'&userEmail='+
                            $("#userEmail").val()+'&content='+
                            $(content).val(),
                            type: "POST",
                            success:function(data){
                               // $("#mail-status").html(data);
                               swal({
                                    title: "Thank You!",
                                    text: "we will get back to you soon.",
                                    icon: "success",
                                });
                            },
                            error:function (){}
                        }); 
                    }
                }  

                function validateContact() {
                    var valid = true;	
                    $(".demoInputBox").css('background-color','');
                    $(".info").html('');
                    if(!$("#userName").val()) {
                        $("#userName-info").html("(<style='color:red'>required </style>)");
                        $("#userName").css('background-color','#FFFFDF');
                        valid = false;
                    }
                    if(!$("#userEmail").val()) {
                        $("#userEmail-info").html("(required)");
                        $("#userEmail").css('background-color','#FFFFDF');
                        valid = false;
                    }
                    if(!$("#userEmail").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
                        $("#userEmail-info").html("(invalid)");
                        $("#userEmail").css('background-color','#FFFFDF');
                        valid = false;
                    }
                
                    if(!$("#content").val()) {
                        $("#content-info").html("(required)");
                        $("#content").css('background-color','#FFFFDF');
                        valid = false;
                    }
                    return valid;
                }
    </script>