<?php 
# focanocodigo
/*
**********************************************		  
*		        .---.						                 *
*		       /o   o\						               *	
*		    __(=  "  =)__ 					             *
*		     //\'-=-'/\\ 					               *
*		        )   (_   					               *	
*		       /      `"=-._                     *
*		      /       \     ``"=.                *
*		     /  /   \  \         `=..--.         *
*		 ___/  /     \  \___      _,  , `\       * 
*		`-----' `""""`'-----``"""`  \  \_/       *
*		                             `-`         *
**********************************************
*/

include "app/config.php";
include "app/detect.php";

if ($page_name=='') {
	include $browser_t.'/index.html';
	}
elseif ($page_name=='index.html') {
	include $browser_t.'/index.html';
	}
elseif ($page_name=='about.html') {
	include $browser_t.'/about.html';
	}
elseif ($page_name=='pricing.html') {
	include $browser_t.'/pricing.html';
	}
elseif ($page_name=='domain.html') {
	include $browser_t.'/domain.html';
	}
elseif ($page_name=='hosting.html') {
	include $browser_t.'/hosting.html';
	}
elseif ($page_name=='contact.html') {
	include $browser_t.'/contact.html';
	}
elseif ($page_name=='contact-post.html') {
	include 'app/contact.php';
	}
else
	{
		include $browser_t.'/404.html';
	}

?>
