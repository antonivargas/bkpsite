<?php
	/**
	 * config settings. version 1.5
	 */
    //username
	$user = '';
    //language nl_NL, de_DE, fr_FR or en_EN
	$lang = 'en_EN';
    //Facebook APP id | and App Secret
	$tokenID = 'HERE THE APP ID';
	$tokenSECRET= 'HERE THE APP SECRET';
    //cache time in seconds
	$cachetime = '21600';
	//resize cover photo
	$resizecover = true;
    //show albums true or false
    //$showalbums - If true only the albums will be fetched with a link to the facebook album
	$showalbums = false;
	$limitalbums = '7';
    //Exclude albums
    $excludealbums = array('Cover Photos','Profile Pictures','Omslagfoto\'s','Profielfoto\'s');
    //show events true or false
	$showevents = true;
    //auto color from image for H1 end links
	$autocolor = true;
    //total feeds
	$feeditems = '30';
    //type feed or posts
	$newstype = 'posts';
    //news output 'wall' or 'feed'. wall is masonry colums
	$newsoutput = 'wall';
    //Filter only posts if it contains text (so no status updates)
    $newsfilter = true;
    //show max post (only for output feed and events)
	$maxposts = '1';
	//show images on posts
	$wallimages = true;
	//higher resolution images ? (slower for website)
	$high_picture = true;
	//Show hide comments true or false
	$showcomments = true;
    //show max comments
	$totalcomments = '10';
    //full post columns if the twitter and pinterest widgets are set to false
    $nowidgets = false;

	//Youtube
    $youtube = false;
    //listType youtube - playlist, user_uploads, custom or search (the default)
    $youtubetype = 'user_uploads';
    //value youtube
	$youtubevalue = '';

	//Video's facebook (on mobile it will be the mp4 link else flash object)
	$facebookvideo = false;
    //Max video's
	$limitvideo = '12';

    //twitter
	$twitter = false;
	$twittername = '';
	$twitterwidgetid = '';

	//Email adress
    $email = '';

    //Pinterest
    $pinterest = false;
    //Name EX 'name' or add your board. EX. 'name/boardname'
    $pinterestname= '';
    //User (embedBoard) or board (embedUser) ?
    $pinterestuser = 'embedUser';

    //show output in array
	$debugjson = false;

	/**
	 * Set cache to 0 for testing.
	 */
	if(isset($_GET['cache']) && $_GET['cache'] == 'false') {
		$cachetime = '0';
	}
?>
