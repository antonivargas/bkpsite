<?php
	/**
	 * Get json feeds facebook.
	 */
	include_once('FeedCache.php');

	if ($showalbums == true) {
        $albums = 'albums.limit('.$limitalbums.').fields(count,name,link,cover_photo),';
    }else{
        $albums = '';
    }
	if ($facebookvideo == true) {
        $fvideo = 'videos.limit('.$limitvideo.').type(uploaded).fields(name,source,description,picture,id),';
    }else{
        $fvideo = '';
    }
	if ($showevents == true) {
        $events = 'events.limit(6).fields(name,start_time,location,id,description),';
    }else{
        $events = '';
    }
    if ($showcomments == true) {
    	$fcomments = 'comments.limit('.$totalcomments.').summary(true),';
    }else{
        $fcomments = '';
    }
	$url = 'https://graph.facebook.com/v2.0/'.$user.'?fields='.$albums.'about,'.$events.'hours,'.$fvideo.'username,website,company_overview,phone,description,mission,location,name,likes,category_list,picture,category,parking,cover,'.$newstype.'.limit('.$feeditems.').fields('.$fcomments.'name,object_id,description,message,type,link,caption,id,created_time,full_picture,source,picture,status_type,story,likes.limit(1).summary(true))&locale='.$lang.'&access_token='.$tokenID.'|'.$tokenSECRET;
    $feed_cache = new FeedCache('./cache/'.$user.'.json', $url, $cachetime);
	$profile = json_decode($feed_cache->get_data(), true);
	    if ($profile == '') {
	        echo 'No facebook feed !';
	        exit();
	    }
	    if (isset($profile['error'])) {
	        echo $profile['error']['message'];
	        exit();
	    }

	/**
	 * Make clickable links from URLs in text.
	 */
	function _make_url_clickable_cb($matches) {
	    $ret = '';
	    $url = $matches[2];
	    if ( empty($url) )
	        return $matches[0];
	    // removed trailing [.,;:] from URL
	    if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
	        $ret = substr($url, -1);
	        $url = substr($url, 0, strlen($url)-1);
	    }
	    return $matches[1] . "<a href=\"$url\" target=\"_blank\">$url</a>" . $ret;
	}
	function _make_web_ftp_clickable_cb($matches) {
	    $ret = '';
	    $dest = $matches[2];
	    $dest = 'http://' . $dest;
	    if ( empty($dest) )
	        return $matches[0];
	    // removed trailing [,;:] from URL
	    if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
	        $ret = substr($dest, -1);
	        $dest = substr($dest, 0, strlen($dest)-1);
	    }
	    return $matches[1] . "<a href=\"$dest\" target=\"_blank\">$dest</a>" . $ret;
	}
	function _make_email_clickable_cb($matches) {
	    $email = $matches[2] . '@' . $matches[3];
	    return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
	}
	function make_clickable($ret) {
	    $ret = ' ' . $ret;
	    // in testing, using arrays here was found to be faster
	    $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	    $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	    $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
	    // this one is not in an array because we need it to run last, for cleanup of accidental links within links
	    $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	    $ret = trim($ret);
	    return $ret;
	}

	/**
	 * Add rel nofollow for better SEO.
	 */
	function rel_nofollow( $text ) {
	    $text = preg_replace_callback('|<a (.+?)>|i', 'rel_nofollow_callback', $text);
	    return $text;
	}
	function rel_nofollow_callback( $matches ) {
	    $text = $matches[1];
	    $text = str_replace(array(' rel="nofollow"', " rel='nofollow'"), '', $text);
	    return "<a $text rel=\"nofollow\">";
	}


	/**
	 * Show video if youtube.
	 */
    function embedYoutube($url) {
        $search = '%
        (?:https?://)?
        (?:www\.)?
        (?:
          youtu\.be/
        | youtube\.com
          (?:
            /embed/
          | /v/
          | /watch\?v=
          )
        )
        ([\w\-]{10,12})
        (.*)
        %x';
        $replace = '<iframe class="yt_players" id="$1" src="http://www.youtube.com/embed/$1?showinfo=0&autoplay=0&modestbranding=1&autohide=1&rel=0&fs=1&controls=1&theme=light&iv_load_policy=3&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>';
        return preg_replace($search, $replace, $url);
    }

	/**
	 * Remove all url's from string.
	 */
	function cleaner($url) {
	  $U = explode(' ',$url);

	  $W =array();
	  foreach ($U as $k => $u) {
	    if (stristr($u,'http') || (count(explode('.',$u)) > 1)) {
	      unset($U[$k]);
	      return cleaner( implode(' ',$U));
	    }
	  }
	  return implode(' ',$U);
	}


	/**
	 * Create meta keywords.
	 */
    function getMetaString($string) {
        preg_match_all("/[a-z0-9\-]{4,}/i", $string, $output_array);

        if(is_array($output_array) && count($output_array[0])) {
            return strtolower(implode(',', $output_array[0]));
        } else {
            return '';
        }
    }


	/**
	 * Replace all text that precedes a URL with an HTML anchor.
	 */
	function hyperlinks($text)
	{
	        $regex = array (
	            'find' => array (
	                '/(\s|^)([a-z_\-][a-z0-9\._\-]*@[a-z0-9_\-]+(\.[a-z0-9_\-]+)+)/si', // email like user.name@domain.tld
	                '/(\s|^)((?:https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/si', // links with: ftp http or https
	                '/(\s|^)((plus|www).(?:[-A-Z0-9+&@#\/%?=~_|!:,.;]+)\.(?:[a-z]{2,4}))/si' // url's that begin with www.
	            ),
	            'replace' => array (
	                '\1<a href="mailto:\2">\2</a>',
	                '\1<a href="\2" title="\2" rel="nofollow">\2</a>',
	                '\1<a href="http://\2" title="\2" rel="nofollow">\2</a>'
	            )
	        );

	        $text = preg_replace ($regex['find'], $regex['replace'], $text);
	    return $text;
	  }

	/**
	 * Convert the Facebook IETF RFC 3339 datetime to timestamp format.
	 */
    function convertIETF($ret) {
	    $created_time = $ret;
	    $date_source = strtotime($created_time);
	    $timestamp = date('d-m-Y H:i', $date_source);
	    return $timestamp;
	}

	/**
	 * Convert facebook hashtags.
	 */
	function make_hashtag($strHash) {
	  $strHash = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1#<a href="https://www.facebook.com/hashtag/\2?source=feed_text" title="\2" rel="nofollow">\2</a>', $strHash);
	  return $strHash;
	}

	/**
	 * Check color light dark
	 */
    function lightness($R = 255, $G = 255, $B = 255) {
        return (max($R, $G, $B) + min($R, $G, $B)) / 510.0; // HSL algorithm
    }


	/**
	 * HEX to RGB and RGB to HEX converter
	 */
	function rgb2hex($rgb) {
	   $hex = "#";
	   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

	   return $hex; // returns the hex value including the number sign (#)
	}

    /**
     * Return the content of an URL
     *
     * @param string $url
     * @return string
     */
    function url_get_contents($url){
       if(function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_exec')){
         # Use cURL
         $curl = curl_init($url);

         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curl, CURLOPT_HEADER, 0);
         curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
         curl_setopt($curl, CURLOPT_TIMEOUT, 5);
         if(stripos($url,'https:') !== false){
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
         }

         $content = @curl_exec($curl);
         curl_close($curl);
       }else{
         # Use FGC, because cURL is not supported
         ini_set('default_socket_timeout',5);
         $content = @file_get_contents($url);
       }
       return $content;
    }

	/**
	 * Color check header image.
	 */
    function autocolor($enabled,$profile,$user){
      # Disabled
      if(!$enabled || !isset($profile['cover']['source'])){
        return array(
          'rgb' => '0,0,0',
          'hex' => null
        );
      }

      # Get from cache
      $cache_filename = 'cache/' . $user . '-color.json';
      if(file_exists($cache_filename) && filesize($cache_filename) > 0){
        $json = json_decode(file_get_contents($cache_filename),true);
        if($json['source'] == $profile['cover']['source']){
          return array(
            'rgb' => $json['rgb'],
            'hex' => $json['hex']
          );
        }
      }

      # Determine colors
      $image = imagecreatefromstring(url_get_contents($profile['cover']['source']));
      $width = imagesx($image);
      $height = imagesy($image);
      $pixel = imagecreatetruecolor(1, 1);
      imagecopyresampled($pixel, $image, 0, 0, 0, 0, 1, 1, $width, $height);
      $rgb = imagecolorat($pixel, 0, 0);
      $color = imagecolorsforindex($pixel, $rgb);
      $rgb = $color['red'] .','.$color['green'].','.$color['blue'];
      $hex = sprintf('#%02x%02x%02x', $color['red'], $color['green'], $color['blue']);
      imagedestroy($image);

      # Save in cache
      $json = json_encode(array(
        'source' => $profile['cover']['source'],
        'rgb' => $rgb,
        'hex' => $hex
      ));
      file_put_contents($cache_filename,$json);

      # Return
      return array(
        'rgb' => $rgb,
        'hex' => $hex
      );
    }

	/**
	 * Email protecting.
	 */
	function email_obfuscator($email){
	    $new_email = '';
	    for($i = 0; $i < strlen($email); $i++){
	        if(rand(0,1)){
	            $new_email .= '&#x'. sprintf("%X",ord($email{$i})) . ';';
	        }else{
	            $new_email .= '&#' . ord($email{$i}) . ';';
	        }
	    }
	    return $new_email;
	}

	function obfuscate_email($text) {
	    $text = ' ' . $text . ' ';
	        $text = preg_replace_callback(
	                '#(([A-Za-z0-9\-_\.]+?)@([^\s,{}\(\)\[\]]+\.[^\s.,{}\(\)\[\]]+))#isU',
	                function ($m) {
	                    return email_obfuscator($m[1]);
	                },
	                $text
	            );

	    return substr($text,1,strlen($text)-2);
	}

	/**
	 * Get time function.
	 */
	function get_time($sDate)
	    {
        global $prefix,$lsecond,$lminut,$lminuts,$lhour,$lhours,$lday,$ldays,$lweek,$lweeks;
	    $timestamp = strtotime($sDate);
	    $now       = time();
	    $timediff  = floor($now - $timestamp);

	    switch(true)
            {
                case ($timediff < 60):
                return $timediff.$lsecond;

                case($timediff >= 60 && $timediff < 120):
                return $prefix.floor($timediff/60).$lminut;

                case($timediff >= 120 && $timediff < 3600):
                return $prefix.floor($timediff/60).$lminuts;

                case($timediff >= 3600  && $timediff < 7200):
                return $prefix.floor($timediff/3600).$lhour;

                case($timediff >= 7200 && $timediff < 86400):
                return $prefix.floor($timediff/3600).$lhours;

                case($timediff >= 86400 && $timediff < 172800):
                return $prefix.floor($timediff/86400).$lday;

                case($timediff >= 172800 && $timediff < 602800):
                return $prefix.floor($timediff/86400).$ldays;

                case($timediff >= 602800 && $timediff < 1209600):
                return $prefix.floor($timediff/602800).$lweek;

                case($timediff >= 1209600):
                return $prefix.floor($timediff/602800).$lweeks;
            }
	}

	/**
	 * Replace \n to <br>.
	 */
    function nl2br2($string) {
	    $string = preg_replace("/(\n){3,}/","\n\n",trim($string));
	    $string = preg_replace("/ +/", " ", $string);
		$string = preg_replace("/^ +/", "", $string);
    	$string = str_replace(array("\r\n", "\r", "\n"), "<br>", $string);
        return $string;
	}
?>
