<?php
    /**
	 * try to speed up.
	 */
    if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	/**
	 * config settings.
	 */
	include ('./php/config.php');

	/**
	 * lang.
	 */
	include ('./php/lang.php');

	/**
	 * php Functions.
	 */
	include ('./php/functions.php');
?>
<!DOCTYPE html>
<html lang="<?php echo substr($lang, 0, 2); ?>" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>document.documentElement.className = 'js';</script>

    <title><?php echo $profile['name']; ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?></title>

    <meta name="description" content="<?php echo $profile['name']; ?> <?php if (isset($profile['about'])) { echo cleaner($profile['about']); } ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?>">
    <meta name="keywords" content="<?php if (isset($profile['about'])) { echo cleaner(getMetaString($profile['about'])); } ?>">
    <link rel="shortcut icon" href="<?php echo $profile['picture']['data']['url']; ?>">
    <link rel="apple-touch-icon" href="<?php echo $profile['picture']['data']['url']; ?>">

    <!-- Open Graph data -->
    <meta property="fb:app_id" content="<?php echo $tokenID; ?>">
    <meta property="og:title" content="<?php echo $profile['name']; ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php echo $profile['name']; ?> <?php if (isset($profile['about'])) { echo cleaner($profile['about']); } ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?>">
    <meta property="og:image" content="<?php echo $profile['cover']['source']; ?>">
    <meta property="og:url" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="<?php echo $profile['name']; ?>">
    <meta itemprop="name" content="<?php echo $profile['name']; ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?>">
    <meta itemprop="description" content="<?php echo $profile['name']; ?> <?php if (isset($profile['about'])) { echo cleaner($profile['about']); } ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?> <?php if (isset($profile['category'])) { echo $profile['category']; } ?>">
    <meta itemprop="image" content="<?php echo $profile['cover']['source']; ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@<?php echo $twittername; ?>">
    <meta name="twitter:site" content="@<?php echo $twittername; ?>">

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap social icons -->
    <link href="bootstrap/css/twitter.css" rel="stylesheet">

    <!-- video popup -->
    <link href="bootstrap/css/magnific-popup.min.css" rel="stylesheet">

    <?php if ($youtube) { ?><!-- youtube CSS -->
    <link href="bootstrap/css/youtube-responsive.min.css" rel="stylesheet">
    <?php } ?>

    <!-- custom CSS -->
    <link href="bootstrap/css/style.css" rel="stylesheet">

    <!-- custom color CSS -->
    <?php
        $color = autocolor($autocolor,$profile,$user);
        if ($autocolor) {
          //check if color is to light
          if(lightness($color['rgb']) >= .9) {
            $color['rgb'] = '102,102,102';
            $color['hex'] = '#666666';
          }
        	echo '<style> a , .jumbotron h1, .container h2 { color: rgb('.$color['rgb'].'); } .rows2 h2, .bgh { background: rgb('.$color['rgb'].'); color:#fff!important; padding:3px; }
        		 .navbar-inverse { background: rgb('.$color['rgb'].'); } .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a { color: #fff; }</style>';
    	}
    ?>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <!-- /debug container -->
    <?php if ($debugjson) { ?>
    <div class="container debug">
        <pre><?php print_r($profile) ?></pre>
    </div>
    <?php } ?>

    <!-- navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" onclick="window.location.reload();return false;"><?php echo $profile['name']; ?></a>
        </div>
        <nav class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a class="home" href="#">Home</a></li>
            <li><a class="scroll" href="#over"><?php echo $labout; ?></a></li>
            <?php if($showalbums && isset($profile['albums']['data'])) { ?>
            <li><a class="scroll" href="#albums"><?php echo $lalbums; ?></a></li>
             <?php } ?>
            <li><a class="scroll" href="#news"><?php echo $lnews; ?></a></li>
            <?php if ($showevents && isset($profile['events']['data'])) { ?>
            <li><a class="scroll" href="#events"><?php echo $levents; ?></a></li>
            <?php } ?>
            <?php if($youtube) { ?>
            <li><a class="scroll" href="#youtube"><?php echo $lyoutube; ?></a></li>
             <?php } ?>
            <?php if($facebookvideo && isset($profile['videos']['data'])) { ?>
            <li><a class="scroll" href="#videos"><?php echo $lfacebookvid; ?></a></li>
             <?php } ?>
            <li><a class="scroll" href="#adres"><?php echo $ladress; ?></a></li>
            <?php if(isset($profile['phone'])) { ?>
            <li><a href="tel:<?php echo $profile['phone']; ?>"><span class="glyphicon glyphicon-earphone telmenu" title="<?php echo $lcall; ?>"></span></a></li>
            <?php } ?>
          </ul>
        </nav><!--/.nav-collapse -->
      </div>
    </div>

    <!-- /logo container -->
    <div class="logo">
        <img class="img-rounded" src="https://graph.facebook.com/<?php echo $user; ?>/picture?redirect=1&amp;type=normal&amp;width=100&amp;height=100" alt="<?php echo $profile['name']; ?>" data-pin-no-hover="true">
    </div>

    <!-- /cover photo container -->
    <div class="bs-header">
	    <div class="headerpic">
	    <?php if ($resizecover) {
         	$size = "php/thumb.php?src=".urlencode($profile['cover']['source'])."&amp;zc=1&amp;w=850&amp;h=315";
         }else{
            $size = $profile['cover']['source'];
         }
        ?>
           <img data-pin-no-hover="true" src="<?php echo $size; ?>" width="100%" class="img-responsive" alt="<?php echo $profile['name']; ?> <?php if (isset($profile['category_list']['0']['name'])) { echo $profile['category_list']['0']['name']; } ?>">
	    </div>
    </div>

    <!-- /about container -->
    <div class="jumbotron">
    <section>
      <div class="container">
        <h1><?php echo $profile['name']; ?></h1>
        <p><?php if (isset($profile['about'])) { echo make_clickable($profile['about']); } ?></p>
      </div>
    </section>
    </div>

    <!-- /description container -->
    <div class="container text">
        <p class="expander"><?php if (isset($profile['description'])) { echo nl2br2(make_clickable($profile['description'])); } ?></p>
    </div>

    <!-- /about,adress and facebook container -->
    <div class="facebook-container">
      <!-- Example row of columns -->
      <div class="rows2">
        <div id="over" class="col-md-4">
        <article>
          <h2><?php echo $labout; ?></h2>
          <p class="expander">
          <?php
          if(isset($profile['mission'])):
              $fabout = $profile['mission'];
          elseif(isset($profile['company_overview'])):
              $fabout = $profile['company_overview'];
          else:
              if (isset($profile['about'])) { $fabout = $profile['about']; }
          endif;
          if (isset($fabout)) {
          	echo nl2br2(make_clickable($fabout));
          }
          ?>
          </p>
        </article>
        </div>
        <div id="adres" class="col-md-4">
        <article>
          <h2><?php echo $ladress; ?></h2>
          <p><?php echo $profile['name'] ?></p>
          <p><?php if (isset($profile[' ']['zip'])) { echo $profile['location']['zip']; } ?> <?php if (isset($profile['location']['street'])) { echo $profile['location']['street']; } ?></p>
          <p><?php if (isset($profile['location']['city'])) { echo $profile['location']['city']; } ?></p>
          <?php if(isset($profile['phone'])) { ?>
          <p><span class="glyphicon glyphicon-earphone"></span>&nbsp;<a href="tel:<?php echo $profile['phone']; ?>"><?php echo $profile['phone']; ?></a></p>
          <?php } ?>
	      <p>
	      <?php
	      if (isset($profile['website'])) {
	      $links = preg_split('/[\ \n\,]+/', $profile['website']);
	          foreach($links as $link){
	              	echo '<p class="ellipsis"><span class="glyphicon glyphicon-globe"></span>&nbsp;'.make_clickable(rtrim($link, ',')).'</p>';
	          }
	      }
	      ?>
	      </p>
	      <?php
	      if ($email != '') {
	      echo '<p>'.obfuscate_email('<span class="glyphicon glyphicon-envelope"></span>&nbsp;<a href="mailto:'.$email.'">'.$email.'</a>').'</p>';
	      } ?>
	       <?php if(isset($profile['location'])) { ?>
	        <p class="ellipsis"><span class="glyphicon glyphicon-road"></span>&nbsp;<a class="popup-gmaps" href="https://maps.google.com/maps?hl=nl&amp;daddr=<?php if (isset($profile['location']['street'])) { echo $profile['location']['street']; } ?>%2C+<?php if (isset($profile['location']['city'])) { echo $profile['location']['city']; } ?>">
	        <span class='address-container' rel="v:address">
	          <span typeof="v:Address" class="address">
	            <span class='sub-label'><?php echo $lroute; ?></span>
	            <span property="v:street-address"><?php if (isset($profile['location']['street'])) { echo $profile['location']['street']; } ?></span>
	            <span property="v:locality"><?php if (isset($profile['location']['city'])) { echo $profile['location']['city']; } ?></span>
	          </span>
	        </span>
	        </a>
            </p>
	       <?php } ?>
       </article>
       </div>
        <div class="col-md-4">
        <article>
          <h2>Facebook</h2>
	        <div id="fb-root"></div><div class="fb-like-box" data-href="http://www.facebook.com/<?php echo $user; ?>" data-colorscheme="light" data-width="350" data-height="290" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>
        </article>
        </div>
      </div>
      <div class="divider"></div>

      <?php if ($newsoutput == 'feed' && isset($profile[$newstype]['data'])) { ?>
      <!-- /news container with twitter feeds -->
  	    <div id="news" class="news">
      <?php if($nowidgets) { ?>
      <div class="col-md-12">
      <?php }else{ ?>
  	    <div class="col-md-8">
      <?php } ?>
  	    <section>
  	    <h2 class="bgh"><?php echo $lnews; ?></h2>
            <ul class="first">
	        <?php
	          $feeds = $profile[$newstype]['data'];
	          if (isset($feeds)) {
	              foreach($feeds as $feed){
	                  if (!$newsfilter || isset($feed['message'])) {
	                      $fsource = '';
                          $name = '';
                          if(isset($feed['message'])):
                              $fsource = $feed['message'];
                          elseif(isset($feed['caption'])):
                              $fsource = $feed['caption'];
                          else:
                              if (isset($feed['story'])) { $fsource = $feed['story']; }
                          endif;
	                      $id = explode( '_',$feed['id'] );
	                      $ftime = $feed['created_time'];
	                        echo '<li><h3>' . get_time($ftime) . '</h3>';
	                        echo '<img src="'.$profile['picture']['data']['url'].'" width="50" height="50" alt="'.$profile['name'].'">';
	                        echo '<div class=wallcontent>'.make_clickable(make_hashtag($fsource)).'</div>';
	                        echo '<div class="divider"></div>';
                            if ($wallimages && isset($feed['message'])) {
	                           if (isset($feed['name'])) { $name = $feed['name']; } else { $name = preg_replace('/\r|\n/','', substr($feed['message'], 0, 70)); }
                                if ($feed['type'] == 'video' && stripos($feed['source'], 'youtu')) {
	                                echo '<div class="wallimg video-container" title="'.$name.'">'.embedYoutube($feed['source']).'</div>';
	                                echo '<div class="divider"></div>';
                                } else {

                                if (isset($feed['full_picture'])) {
                                    if ($high_picture && !isset($feed['object_id'])) {
                                    	$pictures = $feed['full_picture'];
                                      $bigjpg = '_s.jpg%';
                                      $bigpng = '_s.png%';
                                      $biggif = '_s.gif%';
                                      $bigbmp = '_s.bmp%';
                                      $imagecheck1 = stripos($pictures, $bigjpg);
                                      $imagecheck2 = stripos($pictures, $bigpng);
                                      $imagecheck3 = stripos($pictures, $biggif);
                                      $imagecheck4 = stripos($pictures, $bigbmp);
                                      if ( !($imagecheck1 || $imagecheck2 || $imagecheck3 || $imagecheck4) ) {
                                          //Show larger image
                                          $pictures = str_replace('_s.','_b.',$pictures);
                                          $pictures = str_replace('_q.','_b.',$pictures);
                                          $pictures = str_replace('_t.','_b.',$pictures);
                                      }
                                    }else if ($high_picture && isset($feed['object_id'])) {
                                        $pictures = 'https://graph.facebook.com/'.$feed['object_id'].'/picture?width=9999&height=9999';
                                    }else{
                                        $pictures = $feed['picture'];
                                    }
                                    $picremove = array('%2Fp100x100','%2Fs100x100','','%2Fs200x200');
                                    echo '<div class="wallimg"><img itemprop="image" data-src="'.str_replace($picremove,'',$pictures).'" src="'.$feed['picture'].'" alt="'.$name.'"></div>';
                                    echo '<div class="divider"></div>';
                                }
	                            }
	                        }
                            echo '<div class="walllink">
                                    <a title="'.$lsharegoogle.'" rel="nofollow" href="https://plus.google.com/share?url='.urlencode('http://www.facebook.com/'.$user.'/posts/'.$id[1]).'&t='.$name.'" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="icon-googleplus-rect"></span></a>&nbsp;&nbsp;
                            		<a title="'.$lcomment.'" rel="nofollow" href="https://www.facebook.com/'.$user.'/posts/'.$id[1].'" target="_blank"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-comment"></span></a>
                                 </div>';
                            echo '<div class="divider"></div>';
                      		echo '</li>';
	                  }
	              }
	          }
	        ?>
            </ul>
	      </section>
	      </div>
        <?php if($nowidgets == false) { ?>
	      <div class="col-md-4">
          <article>
          <?php if ($twitter) { ?>
          <h2 class="bgh">Tweets</h2>
          <p>
			<a class="twitter-timeline" href="https://twitter.com/<?php echo $twittername; ?>" data-link-color="<?php echo $color['hex']; ?>" data-chrome="noheader noborders" data-widget-id="<?php echo $twitterwidgetid; ?>" width="350" height="500" data-theme="light">Tweets by @<?php echo $twittername; ?></a>
	      </p>
          <?php } ?>
	      <?php if($pinterest) { ?>
	      <h2 class="bgh">Pinterest</h2>
          <p id="pinterest-widget">
          	<a data-pin-do="<?php echo $pinterestuser; ?>" href="http://www.pinterest.com/<?php echo $pinterestname; ?>/" data-pin-scale-width="80" data-pin-scale-height="320" data-pin-board-width=""><?php echo $profile['name']; ?></a>
          </p>
          <?php } ?>
          </article>
	      </div>
        <?php } ?>
	      </div>
	  <div class="divider"></div>
      <?php } ?>

      <?php if ($newsoutput == 'wall' && isset($profile[$newstype]['data'])) { ?>
      <!-- /news wall container with twitter feeds -->
      <div class="wall">
      <?php if($nowidgets) { ?>
      <div id="news" class="col-md-12">
      <?php }else{ ?>
  	    <div id="news" class="col-md-8">
      <?php } ?>
  	    <section>
  	    <h2 class="bgh"><?php echo $lnews; ?></h2>
  	    	<div id="loader"></div>
  	        <div id="posts">
	        <?php
	          $feeds = $profile[$newstype]['data'];
	          if (isset($feeds)) {
	              foreach($feeds as $feed){
                    if (!$newsfilter || isset($feed['message'])) {
	                      $fsource = '';
                          $name = '';
                          if(isset($feed['message'])):
                              $fsource = $feed['message'];
                          elseif(isset($feed['caption'])):
                              $fsource = $feed['caption'];
                          else:
                              if (isset($feed['story'])) { $fsource = $feed['story']; }
                          endif;
	                      $id = explode( '_',$feed['id'] );
	                      $ftime = $feed['created_time'];
                            echo '<div itemscope itemtype="http://schema.org/Article" class="post">';
	                        echo '<div class="walltime"><h3>' . get_time($ftime) . ' ' . $lby . ' <a title="'.$profile['name'].'" href="https://www.facebook.com/'.$user.'?hc_location=timeline" target="_blank">' .$profile['name'] . '</a></h3></div>';
	                        echo '<img class="img-rounded" src="'.$profile['picture']['data']['url'].'" width="50" height="50" alt="'.$profile['name'].'">';
	                        echo '<div itemprop="articleBody" class=wallcontent>'.make_clickable(make_hashtag($fsource)).'</div>';
	                        echo '<div class="divider"></div>';
                            if ($wallimages && isset($feed['message'])) {
	                           if (isset($feed['name'])) { $name = $feed['name']; } else { $name = preg_replace('/\r|\n/','', substr($feed['message'], 0, 70)); }
                                if ($feed['type'] == 'video' && stripos($feed['source'], 'youtu')) {
	                                echo '<div class="wallimg video-container" title="'.$name.'">'.embedYoutube($feed['source']).'</div>';
	                                echo '<div class="divider"></div>';
                                } else {

                                if (isset($feed['full_picture'])) {
                                    if ($high_picture && !isset($feed['object_id'])) {
                                    	$pictures = $feed['full_picture'];
                                      $bigjpg = '_s.jpg%';
                                      $bigpng = '_s.png%';
                                      $biggif = '_s.gif%';
                                      $bigbmp = '_s.bmp%';
                                      $imagecheck1 = stripos($pictures, $bigjpg);
                                      $imagecheck2 = stripos($pictures, $bigpng);
                                      $imagecheck3 = stripos($pictures, $biggif);
                                      $imagecheck4 = stripos($pictures, $bigbmp);
                                      if ( !($imagecheck1 || $imagecheck2 || $imagecheck3 || $imagecheck4) ) {
                                          //Show larger image
                                          $pictures = str_replace('_s.','_b.',$pictures);
                                          $pictures = str_replace('_q.','_b.',$pictures);
                                          $pictures = str_replace('_t.','_b.',$pictures);
                                      }
                                    }else if ($high_picture && isset($feed['object_id'])) {
                                        $pictures = 'https://graph.facebook.com/'.$feed['object_id'].'/picture?width=9999&height=9999';
                                    }else{
                                        $pictures = $feed['picture'];
                                    }
                                    $picremove = array('%2Fp100x100','%2Fs100x100','','%2Fs200x200');
                                    echo '<div class="wallimg"><img itemprop="image" data-src="'.str_replace($picremove,'',$pictures).'" src="'.$feed['picture'].'" alt="'.$name.'"></div>';
	                                echo '<div class="divider"></div>';
                                }
	                            }
	                        }
                            if (isset($feed['status_type']) && strpos($feed['status_type'],'shared_story') !== false) {
                              echo '<div class="link">';
                              if (isset($feed['link'])) {
                                if ($name == '' && isset($feed['story'])) {
                                    $name = $feed['story'];
                                }
                                    echo '<h5><a itemprop="url" href="' . $feed['link'] . '" target="_blank"><span itemprop="name">' . $name . '</span></a></h5>';
                                if (isset($feed['caption'])) {
                                    echo '<div class="caption">'.$feed['caption'].'</div>';
                                }
                              }
                              if (isset($feed['description'])) {
                                 $description = rel_nofollow(make_clickable($feed['description']));
                              }else{
                                 $description = '';
                              }
                              echo $description;
                              echo '</div>';
                              echo '<div class="divider"></div>';
                            }
                                  //comments section
                                  if ($showcomments) {
	                                  if (isset($feed['comments']['data'])) {
	                                    $comments = $feed['comments']['data'];
	                                    rsort($comments);
	                                    foreach($comments as $comment) {
	                                       if (isset($comment['message'])) {
                                            //How many comment likes are there?
                                            if (!empty($comment['like_count'])) {
                                                $like_count_comments = '<br><span class="lcount">'.$comment['like_count'].'</span>&nbsp;<span class="glyphicon glyphicon-thumbs-up small-icon"></span>';
                                            } else {
                                                $like_count_comments = '';
                                            }
	                                        echo '<div class="comments">';
	                                        echo '<i>'.get_time($comment['created_time']).'</i>';
	                                        //echo '<img src="https://graph.facebook.com/'.$comment['from']['id'].'/picture?type=square" width="32" height="32">';
	                                        echo '<div><a href="https://www.facebook.com/app_scoped_user_id/'.$comment['from']['id'].'" target="_blank" rel="nofollow">'.$comment['from']['name'].'</a> - '.rel_nofollow(make_clickable(make_hashtag($comment['message']))) . $like_count_comments . ' </div>';
                      		                echo '</div>';
	                                       }
	                                    }
	                                  }
	                              }
								 //end comments
                                //How many likes are there?
                                if (!empty($feed['likes'])) {
                                    $like_count = $feed['likes']['summary']['total_count'];
                                } else {
                                    $like_count = '';
                                }
                            if ($showcomments) {
	                            if (isset($feed['comments']['data'])) {
	                                $commenticon = '&nbsp;&nbsp;<a class="view-comments" title="'.$lseecomment.'" href="javascript:void(0);"><span class="lcount">'.$feed['comments']['summary']['total_count'].'</span>&nbsp;<span class="cicon glyphicon glyphicon-comment"></span></a>';
	                            }else{
	                                $commenticon = '';
	                            }
                                echo '<div class="wallshare"><a title="'.$lsharegoogle.'" rel="nofollow" href="https://plus.google.com/share?url='.urlencode('http://www.facebook.com/'.$user.'/posts/'.$id[1]).'&amp;t='.urlencode($name).'" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="icon-googleplus-rect"></span></a>';
                                echo '&nbsp;&nbsp;<a title="'.$lshare.'" rel="nofollow" href="https://twitter.com/share?url='.urlencode('http://www.facebook.com/'.$user.'/posts/'.$id[1]).'&amp;text='.urlencode($name).'&amp;hashtags='.$twittername.'" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="icon-twitter-bird"></span></a>';
	                            echo '<div class="walllink"><a class="view-comments" title="'.$lcomment.'" rel="nofollow" href="https://www.facebook.com/'.$user.'/posts/'.$id[1].'" target="_blank"><span class="lcount">'.$like_count.'</span>&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span></a>'.$commenticon.'</div></div>';
	                            echo '<span itemprop="author" itemscope itemtype="http://schema.org/Person"><meta itemprop="name" content="['.$profile['name'].']"></span></div>';
                            }else{
                                echo '<div class="wallshare"><a title="'.$lsharegoogle.'" rel="nofollow" href="https://plus.google.com/share?url='.urlencode('http://www.facebook.com/'.$user.'/posts/'.$id[1]).'&amp;t='.urlencode($name).'" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="glyphicon glyphicon-plus"></span></a>';
                                echo '&nbsp;&nbsp;<a title="'.$lshare.'" rel="nofollow" href="https://twitter.com/share?url='.urlencode('http://www.facebook.com/'.$user.'/posts/'.$id[1]).'&amp;text='.urlencode($name).'&amp;hashtags='.$twittername.'" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="icon-twitter-bird"></span></a>';
	                            echo '<div class="walllink"><a class="view-comments" title="'.$lcomment.'" rel="nofollow" href="https://www.facebook.com/'.$user.'/posts/'.$id[1].'" target="_blank"><span class="lcount">'.$like_count.'</span>&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-comment"></span></a></div></div>';
	                            echo '<span itemprop="author" itemscope itemtype="http://schema.org/Person"><meta itemprop="name" content="['.$profile['name'].']"></span></div>';
                            }
	                  }
	              }
	          }
	        ?>
            </div>
	      </section>
	      </div>
          <?php if($nowidgets == false) { ?>
	      <div class="col-md-4">
          <article>
          <?php if($twitter) { ?>
          <h2 class="bgh">Tweets</h2>
          <p class="twitters">
			<a class="twitter-timeline" href="https://twitter.com/<?php echo $twittername; ?>" data-link-color="<?php echo $color['hex']; ?>" data-chrome="noheader noborders" data-widget-id="<?php echo $twitterwidgetid; ?>" data-tweet-limit="" width="350" height="500" data-theme="light">Tweets by @<?php echo $twittername; ?></a>
	      </p>
          <?php } ?>
	      <?php if($pinterest) { ?>
	      <h2 class="bgh">Pinterest</h2>
          <p id="pinterest-widget">
          	<a data-pin-do="<?php echo $pinterestuser; ?>" href="http://www.pinterest.com/<?php echo $pinterestname; ?>/" data-pin-scale-width="80" data-pin-scale-height="320" data-pin-board-width=""><?php echo $profile['name']; ?></a>
          </p>
          <?php } ?>
          </article>
	      </div>
          <?php } ?>
      </div>
      <div class="divider"></div>
      <?php } ?>

      <?php if ($showevents && isset($profile['events']['data'])) { ?>
      <!-- /events container -->
      <div id="events" class="container text">
      <section>
      <h2 class="bgh"><?php echo $levents; ?></h2>
      <ul>
         <?php
          $events = $profile['events']['data'];
          if (isset($events)) {
              foreach($events as $event){
				echo '<li><h3>'.$event['name'].'</h3>';
				echo '<em>'.convertIETF($event['start_time']).'</em><br>';
                if (isset($event['location'])) {
					echo '<strong>'.$event['location'].'</strong><br>';
				}
                if (isset($event['description'])) {
					echo nl2br2(make_clickable($event['description'])).'<br>';
				}
				echo '<a href="https://www.facebook.com/events/'.$event['id'].'/" target="_blank" rel="nofollow">'.$lmore.' ...</a></li>';
              }
          }
         ?>
      </ul>
      </section>
      </div>
      <?php } ?>

      <?php if ($youtube) { ?>
      <!-- /youtube container -->
	  <div id="youtube" class="container">
      <h2 class="bgh"><?php echo $lyoutube; ?></h2>
      	<div id="youtubevideos"></div>
      <?php
      if ($youtubetype == 'user_uploads') {
        if(preg_match("/UC/i", $youtubevalue)) {
          $channel = 'data-channelid';
        }else{
          $channel = 'data-channel';
        }
        echo '<div class="ysubscribe"><div class="g-ytsubscribe" '.$channel.'="'.$youtubevalue.'"></div></div>';
      }
      ?>
      </div>

      <?php } ?>

      <?php if ($facebookvideo && isset($profile['videos']['data'])) { ?>
      <div id="videos" class="container">
      <section>
      <h2 class="bgh"><?php echo $lfacebookvid; ?></h2>
  	    <div id="videoposts">
  	    <ul class="row-fluid">
	        <?php
	          $videos = $profile['videos']['data'];
	          foreach($videos as $video){
	              if (isset($video['id'])) {

	              if (isset($video['name'])) {
	                $altname = $video['name'];
	              }else{
	                $altname = substr($video['description'],0,125);
	              }
	              if (isset($video['source'])) { $vsource = $video['source']; }

	              	echo '<li class="flashvideo"><a class="popup-facebook" href="https://www.facebook.com/video/embed?video_id='.$video['id'].'"><img class="img-rounded" src="'.$video['picture'].'" alt="'.$altname.'" data-pin-no-hover="true"></a>
	              		  <span class="videodesc">'.$altname.'</span></li>';
	              	echo '<li class="mp4video"><a class="popup-facebook" href="'.$vsource.'"><img class="img-rounded" src="'.$video['picture'].'" alt="'.$altname.'" data-pin-no-hover="true"></a></li>';
	              }
	          }
	        ?>
         </ul>
	     </div>
	     <div class="divider"></div>
      </section>
      </div>

      <?php } ?>

      <?php if ($showalbums && isset($profile['albums']['data'])) { ?>
      <!-- /photo album container -->
      <div id="albums" class="container">
      <section>
        <h2 class="bgh"><?php echo $lalbumst; ?></h2>
  	    <div class="centered">
	        <?php
	          $images = $profile['albums']['data'];
	          foreach($images as $image){
                if (isset($image['count']) && $image['count'] != '') {
	              if (isset($image['cover_photo'])) {$source = $image['cover_photo']; }
	              $link = $image['link'];
	              $name = $image['name'];
                       if (isset($source) != '' && $name != in_array($name,$excludealbums)) {
                        //Set to type album if you want the original size https://graph.facebook.com/'.$source.'/picture?type=album (thumbnail, normal, album)
                    //echo '<div style="width:150px;height:150px;float:left;border-width: 1px;border-style:solid;border-color:#DBDBDB;margin:4px;"><a href="'.$link.'" target="_blank"><img class="img-rounded albumsc" src="https://graph.facebook.com/'.$source.'/picture?type=album" alt="'.$name.'" title="'.$name.'"></a></div>';
                    echo '<a href="'.$link.'" title="'.$name.'" target="_blank"><img class="img-circle albumsc" src="https://graph.facebook.com/'.$source.'/picture?width=200&amp;height=200" data-placement="top" width="200" height="200" alt="'.$name.'"></a>';
	          }
	          }
	        ?>
	      </div>
      </section>
      </div>

      <?php } ?>

	  <hr>

      <a href="#" class="scrollup">Scroll</a>

      <footer>
        <p>&copy; <?php echo $profile['name']; ?> <?php echo date("Y"); ?></p>
      </footer>
    </div> <!-- /container -->

    </div> <!-- /END container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js">\x3C/script>')</script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
    <script>window.Masonry || document.write('<script src="bootstrap/js/masonry.pkgd.min.js">\x3C/script>')</script>
    <script defer src="bootstrap/js/imagesloaded.pkgd.min.js"></script>
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
    <script defer src="bootstrap/js/jquery.lazyload.min.js"></script>
    <?php if ($youtube) { ?>
    <script defer src="bootstrap/js/jquery.youtube-responsive.min.js"></script>
    <?php } ?>
    <script src="bootstrap/js/jquery.magnific-popup.min.js"></script>
    <script src="bootstrap/js/hideMaxListItem-min.js"></script>
    <script src="bootstrap/js/jquery.expander.min.js"></script>
    <script src="bootstrap/js/settings.js"></script>
	<script>
	$(document).ready(function() {
	    $('#news ul, #events ul').hideMaxListItems({
	        'max':<?php echo $maxposts; ?>,
	        'speed':2000,
	        'moreText':'<?php echo $lmore; ?> ([COUNT])',
	        'lessText':'<?php echo $lles; ?>',
	        moreHTML:'<div class="maxlist-more"><a href="#"></a></div>',
	    });
        $('p.expander').show();
        $('p.expander, div.wallcontent').expander({
          slicePoint: 400,
          widow: 4,
          preserveWords: true,
          expandEffect: 'show',
          expandText: '<?php echo $lmore; ?>',
          expandPrefix: '... ',
          userCollapseText: '<br><br>[^]',
          userCollapsePrefix: '',
          afterExpand: function(){ $('#posts').masonry(); },
          afterCollapse: function(){ $('#posts').masonry(); },
          onCollapse: function() {
            $('html, body').animate( {scrollTop: $(this).offset().top}, {duration: 500} );
          }
        });
        <?php if ($youtube) { ?>
	    $('#youtubevideos').youTubePlaylistResponsive({
		<?php
		if ($youtubetype == 'user_uploads') {
		  if(preg_match("/UC/i", $youtubevalue)) {
		    $youtubevalue = str_replace('UC','UU',$youtubevalue);
			}
		}
		?>
	        listtype : '<?php echo $youtubetype; ?>',
	        listvalue : '<?php echo $youtubevalue; ?>',
	        showInfo: false,
	        theme: true,
	        lightsout: false,
	        center: true,
            hd: true
	    });
        <?php } ?> 
	});
    //Load social sdk's
    (function(doc, script) {
      var js,
          fjs = doc.getElementsByTagName(script)[0],
          frag = doc.createDocumentFragment(),
          add = function(url, id) {
              if (doc.getElementById(id)) {return;}
              js = doc.createElement(script);
              js.src = url;
              id && (js.id = id);
              frag.appendChild( js );
          };
        // Facebook SDK
        add('//connect.facebook.net/<?php echo $lang; ?>/sdk.js#xfbml=1&appId=<?php echo $tokenID; ?>&version=v2.0', 'facebook-jssdk');
        fjs.parentNode.insertBefore(frag, fjs);
    }(document, 'script'));
	</script>
    <?php if ($twitter) { ?>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.async=true;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    <?php } ?>
    <?php if ($youtube) { ?>
    <script>
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js?onload=onLoadCallback';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <?php } ?>
	<!-- AddThis Smart Layers BEGIN -->
	<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
	<script async data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
    <script src="//s7.addthis.com/js/300/addthis_widget.js#async=1&amp;domready=1"></script>
    <script>
	  var addthis_config = addthis_config||{};addthis_config.data_track_addressbar = false;addthis_config.data_track_clickback = false;
	  addthis.layers({
	    'theme' : 'transparent',
	    'share' : {
	      'position' : 'left',
	      'numPreferredServices' : 4,
	      'services' : 'facebook,twitter,google_plusone_share,youtube,more'
	    },
	    'thankyou' : false
	  });
	</script>
	<!-- Call for AddThis init() function -->
	<script>
	    function initAddThis()
	     {
	          addthis.init()
	     }
	     initAddThis();
	</script>
	<!-- AddThis Smart Layers END -->
  </body>
</html>