(function ($) {
    "use strict";

    $(window).on('load', function(){
        //===== Prealoder
        $("#preloader").delay(400).fadeOut();

    });

    $(document).ready(function () {
        //05. sticky header
        function sticky_header(){
            var wind = $(window);
            var sticky = $('header');
            wind.on('scroll', function () {
                var scroll = wind.scrollTop();
                if (scroll < 100) {
                    sticky.removeClass('sticky');
                } else {
                    sticky.addClass('sticky');
                }
            });
        }
        sticky_header();
        //===== Back to top
		
		// change the view of select sport
		$('.selectSport').on('click', function (event) {
			event.preventDefault();
			var id = $(this).attr("id");
			var sportImage = $("#sportImage"+id).attr("src");
			var sportTitle = $("#sportTitle"+id).html();
            var langCookieValue = $.cookie("CREATEkwLANG");
            var settings = {
                "url": "requests/index.php?a=Genders&sportId="+id,
                "method": "GET",
                "timeout": 0,
                "headers": {
                  "myacadheader": "myAcadAppCreate"
                },
              };
              $.ajax(settings).done(function (response) {
                var $select = $('select[name=gender]');
                $select.empty();
                var selectedLanguage = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "genderEn" : "genderAr";
                $.each(response.data.genders, function(index, item) {
                    var $option = $('<option>', {
                        value: item.id,
                        text: item[selectedLanguage]
                    });
                    if (item.id === 0) {
                        $option.prop('disabled', true);
                        $option.prop('selected', true);
                    }
                    $select.append($option);
                });
                $select.select2();
                $select.trigger('change.select2');
              });
			$("#sportMainImage").attr("src",sportImage);
			$("#sportMainTitle").html(sportTitle);
			$("input[name=sport]").val(id);
			$("select[name=gender]").prop("disabled",false);
			$("select[name=gender]").prop("required",true);
            $("#homeBtnSubmit").prop("disabled",true).attr("style","background: gray;color: black;");
			$('#sport').modal('toggle');
		});
		
		// change the view of select sport
		$('select[name=gender]').on('change', function (event) {
			event.preventDefault();
            if ($(this).val() != 0) {
                $("select[name=governate]").prop("disabled",false);
			    $("#homeBtnSubmit").prop("disabled",false).attr("style","");
            }else{
                $("select[name=governate]").prop("disabled",true);
			    $("#homeBtnSubmit").prop("disabled",true).attr("style","background: gray;color: black;");
            }
		});

		// change the view of select sport
		$('.governateSelect').on('change', function () {
			var selectedGovernate = $(this).val();
			var governateDiv = $('#governate' + selectedGovernate);
			
			// Hide all "area" selects first
			$('.areaSelect').prop('disabled', true);
			
			if (governateDiv.length) {
				var areas = governateDiv.html();
				$('.areaSelect').html(areas);
				$('.areaSelect').prop('disabled', false);
			}
		});
		

        $('#btnSubmit').on('click', function (event) {
			$('#formSubmit').submit();
		}); 
		
        // Show or hide the sticky footer button
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 600) {
                $('.back-to-top').fadeIn(200)
            } else {
                $('.back-to-top').fadeOut(200)
            }
        });

        //Animate the scroll to yop
        $('.back-to-top').on('click', function (event) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: 0,
            }, 900);
        });

        // Hamburger-menu
        $('.hamburger-menu').on('click', function () {
            $('.hamburger-menu .line-top, .menu_area').toggleClass('current');
            $('.hamburger-menu .line-center').toggleClass('current');
            $('.hamburger-menu .line-bottom').toggleClass('current');
        });

        $('.detail_img_right a').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },        
        });

        $('.watch_btn').magnificPopup({
            type: 'iframe',
            iframe: {
                patterns: {
                    youtube: {
                      index: 'youtube.com/', 

                      id: 'v=',
                      src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                    },
                },

              srcAction: 'iframe_src',
            }
        });
        
        // niceNumber
        $('input[type="number"]').niceNumber();

        $('.select').select2();
        
        // nice select
        $('select').niceSelect();

        // telephone
        $("#phn").intlTelInput({
            initialCountry: "my",
            separateDialCode: true,
        });
        
        // language
        new JLang({
            id: 'languages',
            framework: 'bootstrap4',
            cookieExp: 30,
            cookieLangName: 'name',
            cookieLangCode: 'code',
            abbreviation: false,
            reload: true,
            alignment: 'left',
            hover: true
        });

            $('.owl-carousel.slider1').owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: false,
                dots: true,
            });
             $('.owl-carousel.slider2').owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                rtl: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: false,
                dots: true,
            });
     
    });

})(jQuery);