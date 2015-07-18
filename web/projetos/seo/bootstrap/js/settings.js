$(document).ready(function(){

    // Takes the gutter width from the bottom margin of .post
    var gutter = 25;
    var container = $( '#posts, #videoposts' );
    // Creates an instance of Masonry on #posts
    container.imagesLoaded(function(){
	    $('#loader').show();
	    container.show();
	    $('#loader').hide();
	    container.masonry({
	    gutter: gutter,
	    itemSelector: '.post, .flashvideo, .mp4video',
	        columnWidth: '.post, .flashvideo, .mp4video'
	    });
		if ($(window).width() > 480) {
	        $('.wallimg img').addClass('not-loaded');
	        $('.wallimg img.not-loaded').lazyload({
	            threshold : 400,
	            //effect: 'fadeIn',
	            data_attribute: 'src',
	            load: function() {
	                // Disable trigger on this image
	                $(this).removeClass("not-loaded");
	                //setTimeout(function(){ container.masonry('reloadItems') }, 50);
	            }
	        });
	        $('.wallimg img.not-loaded').trigger('scroll');
	    }
    });

	$('#posts .glyphicon-comment').click(function(){
        $(this).closest('.post').find('.comments').toggle('fast', function(){ $('#posts').masonry(); });
        $(this).closest('.post').find('.cicon').toggleClass('glyphicon-comment').toggleClass('glyphicon-arrow-up');
        var titlec = $(this).closest('.post').find('.view-comments').attr('title');
        var ccomment = $(this);
	    if ($('.glyphicon-arrow-up')) {
	        $('.glyphicon-arrow-up').attr('title', ' X ');
            scrollToAnchor($(this).closest('.post').find('.comments'));
	    }
	    if ($('.glyphicon-comment')) {
	        $('.glyphicon-comment').attr('title', titlec);
	    }
	});

    function scrollToAnchor(anchor){
      var aTag = $(anchor);
        $('html, body').animate( {scrollTop: aTag.offset().top - 100}, {duration: 500} );
    }

    $('.popup-facebook, .popup-gmaps').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      fixedContentPos: false
    });

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
            $('.navbar').css('opacity','0.9');
        } else {
            $('.scrollup').fadeOut();
            $('.navbar').css('opacity','1.0');
        }
    });

    $('.scrollup, .navbar-brand, .home').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });

	/* smooth scrolling sections */
	$('.navbar ul li a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top - 50
	        }, 1000);
	        return false;
	      }
	    }
	});

    $('.nav a').on('click', function(){
        if($('.navbar-toggle').css('display') !='none'){
            $(".navbar-toggle").trigger( "click" );
        }
    });

	/**
 	* jQuery.browser.mobile (http://detectmobilebrowser.com/)
 	*
 	* jQuery.browser.mobile will be true if the browser is a mobile device
 	*
 	**/
	(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|android|ipad|playbook|silk|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

	if(jQuery.browser.mobile) {
		$('.flashvideo').hide();
		$('.mp4video').show();
	}else{
	    $('.flashvideo').show();
	    $('.mp4video').hide();
	}

});

	players = new Array();

	function onYouTubeIframeAPIReady() {
	    var temp = $("iframe.yt_players");
	    for (var i = 0; i < temp.length; i++) {
	        var t = new YT.Player($(temp[i]).attr('id'), {
	            events: {
	                'onStateChange': onPlayerStateChange
	            }
	        });
	        players.push(t);
	    }

	}
    // Define YT_ready function.
    var YT_ready = (function(){
        var onReady_funcs = [], api_isReady = false;
        return function(func, b_before){
            if (func === true) {
                api_isReady = true;
                for (var i=0; i<onReady_funcs.length; i++){
                    // Removes the first func from the array, and execute func
                    onReady_funcs.shift()();
                }
            }
            else if(typeof func == 'function') {
                if (api_isReady) func();
                else onReady_funcs[b_before?'unshift':'push'](func);
            }
        }
    })();
    // This function will be called when the API is fully loaded
    function onYouTubePlayerAPIReady() {YT_ready(true);}

    // Load YouTube Frame API
    (function(){ //Closure, to not leak to the scope
      var s = document.createElement('script');
      s.src = '//www.youtube.com/player_api'; /* Load Player API*/
      var before = document.getElementsByTagName('script')[0];
      before.parentNode.insertBefore(s, before);
    })();


	function onPlayerStateChange(event) {

	    if (event.data == YT.PlayerState.PLAYING) {
	        var temp = event.target.a.src;
	        var tempPlayers = $("iframe.yt_players");
	        for (var i = 0; i < players.length; i++) {
	            if (players[i].a.src != temp) players[i].stopVideo();

	        }
	    }
	}


