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
                var $option = $('<option>', {
                    value: "",
                    text: ( langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "SELECT GENDER" : "إختر الجنس"
                });
                $option.prop('disabled', true);
                $option.prop('selected', true);
                $select.append($option);
                $.each(response.data.genders, function(index, item) {
                    if (item.id != 0) {
                        var $option = $('<option>', {
                            value: item.id,
                            text: item[selectedLanguage]
                        });
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
                var $option = $('<option>', {
                    value: "",
                    text: ( langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "SELECT GOVERNATE" : "إختر المحافظة"
                });
                $option.prop('disabled', true);
                $option.prop('selected', true);
                $select.append($option);
                $.each(response.data.governates, function(index, item) {
                    var $option = $('<option>', {
                        value: item.id,
                        text: item[selectedLanguage]
                    });
                    if (item.id === 0) {
                        //$option.prop('disabled', true);
                        //$option.prop('selected', true);
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
            if ($(this).val() != "") {
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
                $.ajax(settings).done(function (response) {
                    if (response.error === "1" ) {
                        var selectedLanguageTeam = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "Team name already exists" : "اسم الفريق موجود بالفعل";
                        event.preventDefault();
                        alert(selectedLanguageTeam);
                        return false;
                    }else{
                        $('#teamInitForm').submit();
                        return true;
                    }
                })
            } else {
                event.preventDefault();
                alert(selectedLanguage);
                return false;
                
            }
        });

        // redeem points 
        $('#redeemBtn').on('click', function (event) {
            var langCookieValue = $.cookie("CREATEkwLANG");
            var selectedLanguageTeam = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? "Team name already exists" : "اسم الفريق موجود بالفعل";
            // do ajax check in input name="teamName" to check if exists
            var userId = $("#userIdProfile").val();
            var settings = {
                "url": "requests/index.php?a=Points&userId="+userId+"&lang="+langCookieValue,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "myacadheader": "myAcadAppCreate"
                },
            };  
            $.ajax(settings).done(function (response) {
                if (response.error === "1" ) {
                    event.preventDefault();
                    alert(response.data.msg);
                    return false;
                }else{
                    alert(response.data.msg);
                    window.location.reload();
                }
            })
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
            var id = $(this).attr("id");
            $("input[type=radio]").attr('checked', false);
            $(this).attr('checked', true);
            $("input[type=number]").val(0);
            $("."+id).val(0);
            $(".radi_wap input[type=radio] + label span").css("background-color", "white");
            $(this).next("label").find("span").css("background-color", "#FFA300");
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
                
                // Iterate over each subscription item to create options
                $.each(response.data.subscriptions, function(index, outerItem) {
                    var title = outerItem[selectedLanguage];
                    var price = outerItem.price;
                    var priceAfterDiscount = outerItem.priceAfterDiscount;
                    
                    // Construct the option text with HTML tags
                    var optionText = priceAfterDiscount > 0
                        ? `${title} <del>(${price}KD)</del> (${priceAfterDiscount}KD)`
                        : `${title} (${price}KD)`;
            
                    // Create an option element
                    var $option = $('<option>', {
                        class: 'strike-through',
                        value: outerItem.id,
                        'data-display': optionText, // Store HTML formatted string in data attribute
                        text: optionText // Only display the title as plain text for the actual option
                    });
            
                    // Append the option to the select element
                    $select.append($option);
                });
            
                // Update the niceSelect dropdown to refresh the displayed items
                $select.niceSelect('update');
            
                // Modify how the niceSelect displays selected option to use the data-display
                $select.on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var displayText = selectedOption.attr('data-display');
                    
                    // Update the selected niceSelect display with HTML content
                    $(this).next('.nice-select').find('.current').html(displayText);
                });
            
                // Trigger change to ensure the first item is displayed correctly after loading
                $select.trigger('change');
            });
            
			$('select[name="checkout[subscription]"]').prop("disabled",false);
			$('select[name="checkout[subscription]"]').prop("required",true);
		});
    });
/*
    // redeem points 
    $('.mainType').on('click', function (event) {
        event.preventDefault();
        var langCookieValue = $.cookie("CREATEkwLANG");
        var id = $(this).val();
        
        var countryCode = $.cookie("createmyacadcountry");
        console.log(countryCode);
        var settings = {
            "url": "requests/index.php?a=Sports&countryCode="+countryCode+"&isTournament="+id,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "myacadheader": "myAcadAppCreate"
            },
        };  
        $.ajax(settings).done(function (response) {
            console.log(response);
            if (response.error === "1" ) {
                event.preventDefault();
                alert(response.status);
                return false;
            }else{
                var sportsData = document.getElementById("sportsData");
                sportsData.innerHTML = "";
                response.data.sports.forEach(function(sport, i) {
                var sportTtitle = (langCookieValue === undefined || langCookieValue === "" || langCookieValue === "EN") ? sport.sportEn : sport.sportAr;
                    var html = '<div class="col-lg-3 col-sm-4 col-4 mt_30"><a href="#" id="'+sport.id+'" class="selectSport"><div class="sport_model"><img src="logos/'+sport.imageurl+'" id="sportImage'+sport.id+'" alt="'+sport.enTitle+'"></div><h3 id="sportTitle'+sport.id+'">'+sportTtitle+'</h3></a></div>';
                    sportsData.innerHTML += html;
                });
            } 
        })
    });
*/
})(jQuery);