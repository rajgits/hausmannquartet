/* ===========================================
----------------- Demo.js ----------------- */

(function ($) {
    'use strict';
    var CareMed = {
        initialised: false,
        mobile: false,
        init: function () {
            if (!this.initialised) {
                this.initialised = true;
            } else {
                return;
            }

            //Call CareMed Functions
            this.stickyHeader();
            this.mobileMenu();
            this.searchToggle();
            this.selectToggle();
            this.datePicker();
            this.tabBorder();
            this.cardToggle();
            this.appointToggle();
            this.accordionBorder();

            /* if superfish plugin is included */
            if ( $.fn.superfish ) {
                this.menuInit();
            }

            /* if carousel plugin is included */
            if ( $.fn.owlCarousel ) {
                this.owlCarousels();
            }

            /* if isotope plugin is included */
            if ($.fn.isotope) {
                this.isotope();
            }

            /* if appear plugin is included */
            if ($.fn.appear) {
                this.appearAnimate();
            }

        },
        scrollToTop: function () {
            
            var $scrollTop = $('#scroll-top');
            $(window).on('load scroll', function() {
                if ( $(window).scrollTop() >= 400 ) {
                    $scrollTop.addClass('show');
                } else {
                    $scrollTop.removeClass('show');
                }
            });

            //move to top

            $scrollTop.on('click', function ( e ){
                $('html, body').animate({'scrollTop':0}, 800);
                e.preventDefault();
            });
        },
        menuInit: function () {
            $('.menu, .menu-vertical').superfish({
                popUpSelector: 'ul, .megamenu',
                hoverClass: 'show',
                delay: 0,
                speed: 80,
                speedOut: 80,
                autoArrows: true
            });
        },
        viewAllDemos: function () {
            var $viewAll = $('.view-all-demos');
            $viewAll.on('click', function (e){
                e.preventDefault();
                $('.demo-item.hidden').addClass('show');
                $(this).addClass('disabled-hidden');
            });

            var $megamenu = $('.megamenu-container .sf-with-ul');
            $megamenu.hover(function() {
                $('.demo-item.show').addClass('hidden');
                $('.demo-item.show').removeClass('show');
                $viewAll.removeClass('disabled-hidden');
            });
        },
        stickyHeader: function () {
            if ( $('.sticky-header').length && $(window).width() >= 992 ) {
                var sticky = new Waypoint.Sticky({
                    element: $('.sticky-header')[0],
                    stuckClass: 'fixed',
                    offset: -300,
                });
            }
        },
        searchToggle: function() {
            var $searchWrapper = $('.header-search-wrapper'),
            $body = $('body'),
            $searchToggle = $('.search-toggle');
    
            $searchToggle.on('click',function(e){
                $searchWrapper.toggleClass('show');
                $(this).toggleClass('active');
                $searchWrapper.find('input').focus();
                e.preventDefault();
            })
        
            $body.on('click', function (e) {
                if ( $searchToggle.hasClass('active') ) {
                    $searchWrapper.removeClass('show');
                    $searchToggle.removeClass('active');
                    $body.removeClass('is-search-active');
                }
            });
        
            $('.header-search').on('click', function(e){
                e.stopPropagation();
            })
        },
        mobileMenu: function () {
            var $body = $("body");
            
            $('.mobile-menu-toggler').on('click', function(e) {
                $body.toggleClass('mmenu-active');
                $(this).toggleClass('active');
                e.preventDefault();
            });

            $('.mobile-menu-overlay, .mobile-menu-close').on('click', function(e){
                $body.removeClass('mmenu-active');
                $('.menu-toggler').removeClass('active');
                e.preventDefault();
            });

            //add mobile menu icon arrows to items with children
            $('.mobile-menu').find('li').each(function(){
                var $this = $(this);

                if($this.find('ul').length) {
                    $('<span/>', {
                        'class': 'mmenu-btn'
                    }).appendTo($this.children('a'));
                }
            });

            //mobile menu toggle children menu
            $('.mmenu-btn').on('click', function(e){
                var $parent = $(this).closest('li'),
                    $targetUl = $parent.find('ul').eq(0);

                    if (!$parent.hasClass('open')) {
                        $targetUl.slideDown(600, function(){
                            $parent.addClass('open');
                        });
                    } else {
                        $targetUl.slideUp(600, function(){
                            $parent.removeClass('open');
                        })
                    }
                e.stopPropagation();
                e.preventDefault();
            });
        },
        selectToggle: function () {
            var $body = $("body");
            $('.select-control').on('click', function (e) {
                $('.select-control').removeClass('active');
                $('.option-menu').removeClass('show');
                $(this).toggleClass('active');
                $(this).next().toggleClass('show');
                e.preventDefault();
            });
            
            $('.option-list').on('click', function(e) {
                var option = $(this).find('.option').text();
                $(this).parent().prev().text(option);
                $(this).parent().prev().removeClass('active');
                $(this).parent().prev().append('<i class="fas fa-angle-down"></i>');
                $(this).parent().removeClass('show');
            });
            $body.on('click', function(e){
                if( $('.select-control').hasClass('active') ) {
                    $('.select-control').removeClass('active');
                    $('.option-menu').removeClass('show');
                }
            });
            $('.select-control').on('click', function(e){
                e.stopPropagation();
            });
        },
        datePicker: function() {
            $('#form-calendar-light').datepicker({
                defaultDate: '+1d',
                startDate: '+1d',
                autoclose: true,
                orientation: (($('html[dir="rtl"]').get(0)) ? 'bottom right' : 'bottom'),
                container: '.input-calendar-light',
                rtl: (($('html[dir="rtl"]').get(0)) ? true : false)
            });
            $('#form-calendar-dark').datepicker({
                defaultDate: '+1d',
                startDate: '+1d',
                autoclose: true,
                orientation: (($('html[dir="rtl"]').get(0)) ? 'bottom right' : 'bottom'),
                container: '.input-calendar-dark',
                rtl: (($('html[dir="rtl"]').get(0)) ? true : false)
            });
            $(document).scroll(function(){
                $('#form-calendar').datepicker('hide').blur();
            });
        },
        tabBorder: function() {
            $('.nav-item:first-child').find('.nav-link-custom').on('click', function() {
                $('.tab-content').css('border-top-left-radius', '0');
                $('.tab-content').css('border-top-right-radius', '35px');
            });
            $('.nav-item:last-child').find('.nav-link-custom').on('click', function() {
                $('.tab-content').css('border-top-right-radius', '0');
                $('.tab-content').css('border-top-left-radius', '35px');
            });
        },
        cardToggle: function() {
            $('.btn-toggle').on('click', function() {
                var $this = $(this);
                $this.prev().slideToggle("slow", function(){
                    if($this.prev().css('display') == 'block') {
                        $this.find('i.fa-plus-circle').replaceWith("<i class='fas fa-minus-circle'></i>");
                    } else {
                        $this.find('i.fa-minus-circle').replaceWith("<i class='fas fa-plus-circle'></i>");
                    }
                });
                setTimeout(function() {
                    $('.grid-container').isotope('layout');
                }, 600);
            });
        },
        appointToggle: function() {
            $('.btn-book').on('click', function() {
                var $this = $(this);
                $this.next().slideToggle("slow", function() {
                    if($this.next().css('display') == 'none') {
                        $this.find('i.fa-sort-up').replaceWith("<i class='fas fa-sort-down'></i>");
                    } else {
                        $this.find('i.fa-sort-down').replaceWith("<i class='fas fa-sort-up'></i>");
                    }
                });
            });
        },
        accordionBorder: function() {
            $('.accordion-link').on('click', function() {
                var $parent = $(this).closest('.field');
                $parent.siblings().removeClass('active');
                $parent.toggleClass('active');
            });
        },
        owlCarousels: function ($wrap, options) {
            var owlSettings = {
                items: 1,
                loop: true,
                margin: 0,
                responsiveClass: true,
                nav: true,
                navText: ['<i class="fas fa-arrow-left">', '<i class="fas fa-arrow-right">'],
                dots: true,
                smartSpeed: 400,
                autoplay: false,
                autoplayTimeout: 15000
            };
            if (typeof $wrap == 'undefined') {
                $wrap = $('body');
            }
            if (options) {
                owlSettings = $.extend({}, owlSettings, options);
            }
    
            // Init all carousel
            $wrap.find('[data-toggle="owl"]').each(function () {
                var $this = $(this);
                var temp = $this.data('owl-options');
                var newOwlSettings = $.extend({}, owlSettings, temp);
                if (!$this.hasClass('slide-animate')) {
                    $this.on('initialized.owl.carousel', function () {
                        $this.find('.owl-item:not(.active)').find('.appear-animate').each(function(){
                            $(this).removeClass('appear-animate');  
                        });
                    });
                }
                var owlIns = $(this).owlCarousel(newOwlSettings);
            });
    
            $(window).resize( function(){
                $(".nav-out").trigger("refresh.owl.carousel");
            });
            
        },
        isotope: function () {
            $('.grid').imagesLoaded( function () {
                $('.grid').isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.grid-sizer'
                    }
                })
            });
            $('.grid-filter-item.filter-clear').on('click', function() {
                $(this).closest('.filter-form').find('.select-control').html('Other select<i class="fas fa-angle-down"></i>');
            });
        },
        appearAnimate: function () {
            var times = new Array();
            $( '.owl-item [data-animation-name="splitRight"]' ).each( function() {
                var text = $( this ).text();
                var delay = ( $( this ).data( "animation-delay" ) ? $( this ).data( "animation-delay" ) : "0" );
                $( this ).text("");
                for( var j = text.length - 1; j >= 0 ; j -- ) {
                    $(this).prepend('<div class="d-inline-block appear-animate" data-animation-delay="' + ( delay + 90 * j ) + '">' + ( text[j] === " " ? '&nbsp' : text[j] ) + '</div>');
                }
            });

            $( ".appear-animate" ).each(function() {
                if( ! $( this ).hasClass( 'animated' ) ) {
                $( this ).appear(function() {
                   
                    var $this = $( this );
                    if ($this.hasClass('appear-animate')) {
                        if( $this.closest( ".owl-carousel.slide-animate" ).length > 0 )
                        if( $this.closest( '.owl-item.active' ).length === 0 ) 
                            return;
                        var name, delay, duration;
                        name = ( $this.data( "animation-name" ) ? $this.data( "animation-name" ) : "fadeIn" );
                        duration = ( $this.data( "animation-duration" ) ? $this.data( "animation-duration" ) : "750" );
                        delay = ( $this.data( "animation-delay" ) ? $this.data( "animation-delay" ) : "0" );
                        $this.addClass( name );
                        $this.css( 'animationDelay', delay + "ms" );
                        $this.css( 'animationDuration', duration + "ms" );
                        $this.addClass( "animated" );
                        var id = setTimeout( function() {
                            $this.addClass( "appear-animation-visible" );
                        }, parseInt( delay ? delay : 0 ));
                        if( $this.closest( ".owl-carousel.slide-animate" ).length > 0 )
                        times.push( id );
                    }
                },{
                    accX: $( this ).data( 'x' ) ? $( this ).data( 'x' ) : 0,
                    accY: $( this ).data( 'y' ) ? $( this ).data( 'y' ) : -50
                })
                }
            });
            $( ".owl-carousel.slide-animate" ).each(function() {
                var translateCarousel;
                $( this ).on('translate.owl.carousel', function(event) {
                    translateCarousel = $( this ).find( ".owl-item.active" );
                });

                $( this ).on('translated.owl.carousel', function(event) {
                    var item = $( this );
                    
                    if( $(this).find( ".owl-item.active")[0] !== translateCarousel[0] ) {
                        for( var i = 0; i < times.length; i++ )
                            clearTimeout( times[i] );
                        times = times.splice();
                        translateCarousel.find( ".appear-animate" ).removeClass( "appear-animation-visible" );
                        translateCarousel.find( ".appear-animate" ).css( 'animationDelay', "" );
                        translateCarousel.find( ".appear-animate" ).css( 'animationDuration', "" );
                        translateCarousel.find( ".appear-animate" ).removeClass( "animated" );
                        translateCarousel.find( ".appear-animate" ).each(function() {
                            var $this = $( this );
                            var name;
                            name = ( $this.data( "animation-name" ) ? $this.data( "animation-name" ) : "fadeIn" );
                            $this.removeClass( name );
                        });
                    }
                    item.find( ".owl-item.active .appear-animate" ).each(function() {
                        var $this = $( this );
                        var name, delay, duration;
                        name = ( $this.data( "animation-name" ) ? $this.data( "animation-name" ) : "fadeIn" );
                        duration = ( $this.data( "animation-duration" ) ? $this.data( "animation-duration" ) : "750" );
                        delay = ( $this.data( "animation-delay" ) ? $this.data( "animation-delay" ) : "0" );

                        $this.addClass( name );
                        if( name != "splitRight" ) {
                            $this.css( 'animationDelay', delay + "ms" );
                            $this.css( 'animationDuration', duration + "ms" );
                        }
                        $this.addClass( "animated" );
                        var id = setTimeout( function() {
                            $this.addClass( "appear-animation-visible" );
                        }, parseInt( delay ? delay : 0 ));
                        times.push( id );
                    });
                });
            });
        }

    }

    jQuery(document).ready(function () {
        // Init our app
        CareMed.init();
    });

    //Load Event
    $(window).on('load', function() {
        $('body').addClass("loaded");
        CareMed.scrollToTop();
    });

})(jQuery);