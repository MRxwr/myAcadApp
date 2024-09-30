(function ($) {
    "use strict";

    $(window).on('load', function(){
        //===== Prealoder
        $("#preloader").delay(400).fadeOut();

    });

    $(document).ready(function () {
        //$('select[name="checkout[subscription]"]').select2();

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
		
        $('#homeAcadimes').on('click', function (event) {
            $("input[name=isTournament]").val(0);
            $("#homeForm").attr("action","?v=Listing");
            $("#homeTournaments").removeClass("homeSelected");
            $("#homeAcadimes").addClass("homeSelected");
        });

        $('#homeTournaments').on('click', function (event) {
            $("input[name=isTournament]").val(1);
            $("#homeForm").attr("action","?v=Tournaments");
            $("#homeAcadimes").removeClass("homeSelected");
            $("#homeTournaments").addClass("homeSelected");
        });

		// change the view of select gender
		$('.selectSport').on('click', function (event) {
			event.preventDefault();
			var id = $(this).attr("id");
            //get country code from cookie
            var countryCode = $.cookie("createmyacadcountry");
			var sportImage = $("#sportImage"+id).attr("src");
			var sportTitle = $("#sportTitle"+id).html();
			var isTournament = $("input[name=isTournament]").val();
            var langCookieValue = $.cookie("CREATEkwLANG");
            var settings = {
                "url": "requests/index.php?a=Genders&sportId="+id+"&countryCode="+countryCode+"&isTournament="+isTournament,
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

        // change the view of select governates
		$('.selectGender').on('change', function (event) {
			event.preventDefault();
			var id = $(this).val();
            var countryCode = $.cookie("createmyacadcountry");
            var sportId = $("input[name=sport]").val();
            var langCookieValue = $.cookie("CREATEkwLANG");
            var isTournament = $("input[name=isTournament]").val();
            var settings = {
                "url": "requests/index.php?a=Governates&sportId="+sportId+"&countryCode="+countryCode+"&genderId="+id+"&isTournament="+isTournament,
                "method": "GET",
                "timeout": 0,
                "headers": {
                  "myacadheader": "myAcadAppCreate"
                },
              };
              $.ajax(settings).done(function (response) {
                var $select = $('select[name=governate]');
                $select.empty();
                var selectedLanguage = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "enGovernate" : "arGovernate";
                $.each(response.data.governates, function(index, item) {
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
			$("select[name=governate]").prop("disabled",false);
			$("select[name=governate]").prop("required",true);
		});
		
		// change the view of select sport
		$('select[name=governate]').on('change', function (event) {
			event.preventDefault();
            if ($(this).val() != 0) {
                $("select[name=governate]").prop("disabled",false);
			    $("#homeBtnSubmit").prop("disabled",false).attr("style","");
            }else{
                $("select[name=governate]").prop("disabled",true);
			    $("#homeBtnSubmit").prop("disabled",true).attr("style","background: gray;color: black;");
            }
		});

        $('#submitTeam').on('click', function (event) {
            var langCookieValue = $.cookie("CREATEkwLANG");
            var selectedLanguage = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "Please fill all feilds" : "يرجى ملء جميع الحقول";
            var isValid = true;

            // do ajax check in input name="teamName" to check if exists
            var teamName = $("input[name='teamName']").val();
            var tournamentId = $("input[name='tournamentId']").val();
            var settings = {
                "url": "requests/index.php?a=CheckTeamName&teamName="+teamName+"&tournamentId="+tournamentId,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "myacadheader": "myAcadAppCreate"
                },
            };  
            $.ajax(settings).done(function (response) {
                if (response.error === "1" ) {
                    var selectedLanguageTeam = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "Team name already exists" : "اسم الفريق موجود بالفعل";
                    alert(selectedLanguageTeam);
                    isValid = false;
                    return false;
                }
            })
        
            // Check players[] fields
            $("input[name='players[]']").each(function() {
                if ($(this).val() === "") {
                    isValid = false;
                }
            });
        
            // Check teamName field
            var teamName = $("input[name='teamName']").val();
            if (teamName === "") {
                isValid = false;
            }
        
            if (isValid) {
                $('#teamInitForm').submit();
                return true;
            } else {
                event.preventDefault();
                alert(selectedLanguage);
                return false;
                
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
        $('#checkTerms').on('change', function (event) {
            event.preventDefault();
            var goToTeamInit = $(this).prop('checked');
            console.log(goToTeamInit);
            if (goToTeamInit) {
                $('#goToTeamInit').prop('disabled', false);
                $('#goToTeamInit').attr('style', "");
            } else {
                $('#goToTeamInit').prop('disabled', true);
                $('#goToTeamInit').attr('style', "background: gray;color: black;");
            }
        })
		$('input[type="radio"]').on('click', function (event) {
			event.preventDefault();
            var sessionId = $(this).val();
            var langCookieValue = $.cookie("CREATEkwLANG");
            var settings = {
                "url": "requests/index.php?a=SessionSubscription&sessionId="+sessionId,
                "method": "GET",
                "timeout": 0,
                "headers": {
                  "myacadheader": "myAcadAppCreate"
                },
              };
              $.ajax(settings).done(function (response) {
                var $select = $('select[name="checkout[subscription]"]');
                $select.empty();
                var selectedLanguage = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "enTitle" : "arTitle";
                $.each(response.data.subscriptions, function(index, outerItem) {
                  $.each(outerItem, function(index, innerItem) {
                    var title = innerItem[selectedLanguage];
                    var price = innerItem.price;
                    var priceAfterDiscount = innerItem.priceAfterDiscount;
                    var optionText = priceAfterDiscount > 0
                      ? `${title} <del>(${price}KD)</del> (${priceAfterDiscount}KD)`
                      : `${title} (${price}KD)`;
                    var $option = $('<option>', {
                      class: 'strike-through',
                      value: innerItem.id,
                      'data-display': optionText,
                      text: optionText
                    });
                    $select.append($option);
                  });
                });
                $select.niceSelect('update');
              });
			$('select[name="checkout[subscription]"]').prop("disabled",false);
			$('select[name="checkout[subscription]"]').prop("required",true);
		});
    });

})(jQuery);