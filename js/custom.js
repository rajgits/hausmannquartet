
 $(window).scroll(function() {

    var scroll = $(window).scrollTop();

    if (scroll > 40) {

        $(".navbar-dark").addClass("navbar-light");
        $(".navbar-dark").addClass("navbar-dark-scrolled");
        $(".navbar-dark-scrolled").removeClass("navbar-dark");

        $(".navbar").addClass("sticky-head");

    } else {

        $(".navbar-dark-scrolled").removeClass("navbar-light");
        $(".navbar-dark-scrolled").addClass("navbar-dark");
        $(".navbar-dark").removeClass("navbar-dark-scrolled");

        $(".navbar").removeClass("sticky-head");
    }

});


 $(document).ready(function() {
  var owl = $('.owl-carousel');
    owl.owlCarousel({
	items: 3,
	loop: true,
	singleItem: true,
	margin: 10,
	autoplay: false,
	responsiveClass: true,
	responsive: {
	  0: {
		items: 1,
		nav: true
	  },
	  600: {
		items: 3,
		nav: true
	  },
	  1000: {
		items: 3,
		nav: true
	  }
	}
  })


})


/**
 * Created by USER on 9/10/2015.
 */
function submitSubscription() {
    if ($('#subscription-email').val() != '') {
        $('.subscr-control').hide();$('.loader-wrap').show();
        var email = $('#subscription-email').val();
		/*var fname = $('#subscription-fname').val();*/
		//alert(email);
        jQuery.ajax({
            type: "POST",
            url: $('#rootUrlLink').val() + 'subscribe',
            dataType: 'json',
            data: {email:email},
            cache: false,
            success: function(data) {
                $('.subscr-control').show();$('.loader-wrap').hide();
                var status = data.status;
                var msg = data.message;
                if(status*1 == 1)
                {
                    $('#subsc-response').html(msg).removeClass('alert-danger').addClass('alert-success').show();
                }
                else
                {
                    $('#subsc-response').html(msg).removeClass('alert-success').addClass('alert-danger').show();
                }
            },
            complete: function(){
                $('.subscr-control').show();$('.loader-wrap').hide();
            },
            error: function(){
                $('#subCategoryContainer').html('Something went wrong!! Please try later');
                $('.subscr-control').show();$('.loader-wrap').hide();
            }
        });
    }
    //$('.subscr-control').show();$('.loader-wrap').hide();

    return false;
}
