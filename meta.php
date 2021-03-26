
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo header('Content-Type: text/html; charset=UTF-8'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!--<meta name="description" content="">-->
<meta name="author" content=""> 
<meta http-equiv="Cache-Control" content="no-cache" />
<link rel="icon" href="<?php echo URL_ROOT;?>img/footlogo.png">
<!--<title>SAHM</title>-->
<!-- Bootstrap core CSS  font-family: 'Raleway', sans-serif;-->
<?php
    $sess_lang = 'en';
  ?>
  <link href="<?php echo URL_ROOT;?>css/<?php echo ($sess_lang=='ar'||$sess_lang=='ur'?'rtl.css':'ltr.css')  ?>?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
<link href="<?php echo URL_ROOT;?>css/<?php echo ($sess_lang=='ar'||$sess_lang=='ur'?'layout_ar.css':'layout.css')  ?>?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet"> 
<link href="<?php echo URL_ROOT;?>css/<?php echo ($sess_lang=='ar'||$sess_lang=='ur'?'responsive_ar.css':'responsive.css')  ?>?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet"> 




<link href="<?php echo URL_ROOT;?>fonts/fonts.css" rel="stylesheet"> 
<link href="<?php echo URL_ROOT;?>css/custom_version.css" rel="stylesheet">
<link href="<?php echo URL_ROOT;?>js/Tags/tagsinput.css" rel="stylesheet">
<link href="<?php echo URL_ROOT;?>css/animate.css" rel="stylesheet"> 
<link href="<?php echo URL_ROOT;?>css/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js-bootstrap-css/1.2.1/typeaheadjs.css">
<!--<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!--<script src="<?php echo URL_ROOT ?>js/Tags/tagsinput.js"></script>
<script src="<?php echo URL_ROOT ?>js/Tags/typeahead.bundle.js"></script>
<script src="<?php echo URL_ROOT ?>js/Tags/typeahead.jquery.js"></script>-->
<script src="//platform-api.sharethis.com/js/sharethis.js#property=5c47fb00058f100011a5adc7&product=inline-share-buttons"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js-bootstrap-css/1.2.1/typeaheadjs.css">
 -->
 <script src="<?php echo URL_ROOT;?>js/jquery-ui.min.js"></script>
<script>
    // Error & Success Message div
    function MsgDiv(cls,msg) {
        return '<div class="alert alert-'+cls+'">'+msg+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>';
    }
    // End of Error & Success Message div
</script>
<script>
    function getStars(rating)
    {
      rating = Math.round(rating * 2) / 2;
      var output = [];
      for (var i = rating; i >= 1; i--)
        output.push('<i class="fa fa-star" aria-hidden="true" ></i> ');
      if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true"></i> ');
      for (var i = (5 - rating); i >= 1; i--)
        output.push('<i class="fas fa-star"></i> ');
      return output.join("");
    }
</script>

<!-- Global site tag (gtag.js) - Google Analytics --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135926254-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-135926254-1');
</script>  


  
 
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<script>

 (adsbygoogle = window.adsbygoogle || []).push({

   google_ad_client: "ca-pub-1641529781938912",

   enable_page_level_ads: true

 });

</script>  


 