(function($){
	$(document).ready(function() {	

		// Scroll to Top
		jQuery('.scrolltotop').click(function(){
			jQuery('html').animate({'scrollTop' : '0px'}, 400);
			return false;
		});
		
		jQuery(window).scroll(function(){
			var upto = jQuery(window).scrollTop();
			if(upto > 500) {
				jQuery('.scrolltotop').fadeIn();
			} else {
				jQuery('.scrolltotop').fadeOut();
			}
		});


		var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

	    var hamburgers = document.querySelectorAll(".hamburger");
	    if (hamburgers.length > 0) {
	      forEach(hamburgers, function(hamburger) {
	        hamburger.addEventListener("click", function() {
	          this.classList.toggle("is-active");
	        }, false);
	      });
	    }

		$(window).scroll(function() {
			var scroll = $(window).scrollTop();
			
			if (scroll >= 15) {
			$(".header-area").addClass("headerfixed");
			jQuery(".contact-btn").addClass("contnone");
			jQuery(".navbar-nav").addClass("navbar-navmrn")
			} else {
			$(".header-area").removeClass("headerfixed");
			jQuery(".contact-btn").removeClass("contnone");
			jQuery(".navbar-nav").removeClass("navbar-navmrn")
			}

		});

		$(".choose").click(function() {
			$("html, body").animate({ scrollTop: $("#choose").offset().top }, 400);
		});

		$(".client").click(function() {
			$("html, body").animate({ scrollTop: $("#client").offset().top }, 400);
		});

		$(".influence").click(function() {
			$("html, body").animate({ scrollTop: $("#influence").offset().top }, 400);
		});

		$(".about").click(function() {
			$("html, body").animate({ scrollTop: $("#about").offset().top }, 400);
		});
	});
})(jQuery);