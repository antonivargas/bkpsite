/**
 *  Responsive auto YouTube channel videos list
 *  @author:  CFconsultancy
 *  @version: 1.1 (Jan/05/2013)
 *  http://www.cfconsultancy.nl
 */

(function($) {

    $.fn.youTubePlaylistResponsive = function(options) {

    var $this = $(this);

        $.fn.youTubePlaylistResponsive.defaults = {
		  listtype: 'search',
          listvalue: 'hd nature',
          autoplay: false,
          showrelated: false,
          showinfo: false,
          autohide: true,
          theme: false,
          modestbranding: true,
          iv_load_policy: false,
          allowfullscreen: true,
          controls: true,
          hd: false,
          maxwidth: '',
          center: false,
          lightsout: false
        };

        var options = $.extend({}, $.fn.youTubePlaylistResponsive.defaults, options);

        var windowsize = $(window).width();

        if (options.lightsout == true && windowsize > 480) {
			$('body').append('<div id="shadow" style="display:none;"></div>');
			$("#shadow").css("height", $(document).height()).hide();
		}

        return this.each(function() {

        var $div = this;

	    $(this).find('div')
	     .addBack()
	     .wrapAll('<div class="youtuberesponsive"></div>');

	    if (options.autohide == true) {
        	$(this).css('padding-bottom', '51.25%');
        }

	    $(this).addClass('responsive_youtube');

	    if (options.theme == true) {

        $(this).closest('.youtuberesponsive').removeClass('youtuberesponsive').addClass('youtuberesponsive-white');

          if (options.maxwidth != '') {

            	$('.youtuberesponsive-white').css('max-width', '' + options.maxwidth + '');

	            if (options.center == true) {

	                $('.youtuberesponsive-white').css('margin', '0 auto');

	            }
            }

        } else {

            $(this).closest('.youtuberesponsive').removeClass('youtuberesponsive').addClass('youtuberesponsive-black');

            if (options.maxwidth != '') {

            	$('.youtuberesponsive-black').css('max-width', '' + options.maxwidth + '');

	            if (options.center == true) {

	                $('.youtuberesponsive-black').css('margin', '0 auto');

	            }
            }

        }

		$("#shadow").click(function() {
			$("#shadow").hide();
		});

	      if (windowsize < 480) {
            $(this).css('padding-bottom', '48.25%');
	      }

	        if (options.listtype == 'custom') {

	        var my_string = options.listvalue;
	        var splitted = my_string.split(',');
	        var firstitem = splitted.shift();
	        var listitems = splitted.join(',');

	            var customplaylist = '<iframe style="visibility:hidden;" onload="this.style.visibility=\'visible\';" src="http://www.youtube.com/embed/' + encodeURI(firstitem) + '?playlist=' + encodeURI(listitems) + '';

	        } else {

	            var customplaylist = '<iframe style="visibility:hidden;" onload="this.style.visibility=\'visible\';" src="http://www.youtube.com/embed/?listType=' + options.listtype + '&list=' + encodeURI(options.listvalue)+ '';

	        }
	            var $iframe = $('' + customplaylist +
	            '&showinfo=' + (options.showinfo ? '1' : '0') +
	            '&autoplay=' + (options.autoplay ? '1' : '0') +
	            '&modestbranding=' + (options.modestbranding ? '1' : '0') +
	            '&autohide=' + (options.autohide ? '1' : '2') +
	            '&rel=' + (options.showrelated ? '1' : '0') +
	            '&fs=' + (options.allowfullscreen ? '1' : '0') +
	            '&controls=' + (options.controls ? '1' : '0') +
	            '&theme=' + (options.theme ? 'light' : 'dark') +
	            '&iv_load_policy=' + (options.iv_load_policy ? '1' : '3') +
	            ''+ (options.hd ? '&vq=hd720' : '') +'&wmode=opaque" frameborder="0" allowfullscreen></iframe>');
	            $iframe.appendTo($div);
	        });
    	};

        var isOverIFrame = false;

        function processMouseOut() {
            isOverIFrame = false;
            $("#shadow").hide();
        }

        function processMouseOver() {
            $('#shadow').show();
            isOverIFrame = true;
        }

        function processIFrameClick() {
            if(isOverIFrame) {
            }
        }

        function attachOnloadEvent(func, obj) {
            if(typeof window.addEventListener != 'undefined') {
                window.addEventListener('load', func, false);
            } else if (typeof document.addEventListener != 'undefined') {
                document.addEventListener('load', func, false);
            } else if (typeof window.attachEvent != 'undefined') {
                window.attachEvent('onload', func);
            } else {
                if (typeof window.onload == 'function') {
                    var oldonload = onload;
                    window.onload = function() {
                        oldonload();
                        func();
                    };
                } else {
                    window.onload = func;
                }
            }
        };

        function init() {
            var element = document.getElementsByClassName("responsive_youtube");
            for (var i=0; i<element.length; i++) {
                element[i].onmouseover = processMouseOver;
                element[i].onmouseout = processMouseOut;
            }
            if (typeof window.attachEvent != 'undefined') {
                top.attachEvent('onblur', processIFrameClick);
            }
            else if (typeof window.addEventListener != 'undefined') {
                top.addEventListener('blur', processIFrameClick, false);
            }
        };

        attachOnloadEvent(init);

})(jQuery);