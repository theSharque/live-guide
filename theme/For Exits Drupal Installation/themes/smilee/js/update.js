(function($) {

    // Call this function once the rest of the document is loaded
    function loadAddThis() {
        addthis.init()
    }
    // Google map
    // ---------------------------------------------------------------------------------------
    var path = Drupal.settings.pathToTheme;
    jQuery(document).ready(function() {
        if (typeof google === 'object' && typeof google.maps === 'object') {
            if ($('#map-canvas').length) {
                var map;
                var marker;
                var image = 'images/icon-google-map.png'; // marker icon
                google.maps.event.addDomListener(window, 'load', function() {
                    var mapOptions = {
                        scrollwheel: false,
                        zoom: 12,
                        center: new google.maps.LatLng(40.9807648, 28.9866516) // map coordinates
                    };

                    map = new google.maps.Map(document.getElementById('map-canvas'),
                            mapOptions);
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(41.0096559, 28.9755535), // marker coordinates
                        map: map,
                        icon: image,
                        title: 'Hello World!'
                    });
                });
            }
        }
    });
    /*
     * modal 
     */
    $(document).ready(function() {
        $('.modal1').each(function(index, el) {
            $(this).find('.col-md-5 .ps-slider-nav ul li').each(function(index, el) {
                $(this).on("click", function() {
                    var id = '.' + $(this).attr('id');
//               $('.modal .col-md-5 .ps-slider .ps-img').css('opacity','0');
                    $(id).css('opacity', '1');
                    $(id).siblings().css('opacity', '0');
                });
            });
        });
//        $('.item-colors ').each(function(index, el) {
//            $(this).find('div').each(function(index, el) {
//                var aclass = $(this).attr('class');
//                $(this).css('background', aclass);
//            });
//        });

        /**
         * 
         * @type @call;_L1.$@call;attr
         * Seting background for body
         */
        var url_bg = $('body').attr('data-bg');
        $('body').css('background-image', 'url(' + path + url_bg + ')');

        if ($('#background-image').val()) {

            var background = $('#background-image').val();

            if ($('#background-image').val() != "") {

                var background_image = $('#background-image').val();

                $('body').css('background', background + " url('" + background_image + "') ");

            }

        }

        $('.settings-section.bg-list div').click(function() {
            var bg = $(this).css("backgroundImage");
            $("body").css("backgroundImage", bg);
        });

        /*
         * rewrite ouput of reset button.
         */
        $(".reset").click(function(e) {
            $('body').css('background-image', 'url(' + path + url_bg + ')');
            var boxed_wide = $('#boxed-wide').attr('value');
            if (boxed_wide == "active" && !$('.body').is('boxed')) {
                $('.body').addClass('boxed');
                $('.switch-handle').addClass('active');
            } else if (boxed_wide != "active" && $('.body').is('boxed'))
            {
                $('.body').remove('boxed');
                $('.switch-handle').removeClass('active');
            }

        });
        $('.dropdown-submenu >ul').addClass("submenu");
        $('.top-search3 form input[type=submit]').val('');
        $('.top-search3 form .form-actions').prepend('<i class="fa fa-search"></i>');
        $('.top-search2 form input[type=submit]').val('');
        $('.top-search2 form .form-actions').prepend('<i class="fa fa-search"></i>');
        $('.vsearch form input[type=submit]').val('');
        $('.vsearch form .form-actions').prepend('<i class="fa fa-search"></i>');
        $('.search-widget form input[type=submit]').val('');
        $('.search-widget form .form-actions').prepend('<i class="fa fa-search"></i>');
        $('#simplenews-block-form-32 input[type=text]').attr('placeholder', 'Enter your email address here.');
        $('.contact-form form input[type=submit]').attr('class', 'btn-black');
        $('.modal  form input[type=submit]').attr('class', 'btn-color');
        $('.product-single .ps-header form input[type=submit]').attr('class', 'btn-color');
        $('.account-wrap form input[type=submit]').attr('class', 'btn-black');
        $('.checkout input[type=submit]').addClass('btn-black');
        $('.comment-form.reply-form textarea').attr('placeholder', 'Comment');
        $('footer #simplenews-block-form-32 input[type=submit]').attr('class', 'btn-color');
        $('.cart-table form .commerce-line-item-actions input[type=submit]').attr('class', 'btn-color');
    });
})(jQuery);

