<?php

if ( isset( $userdata) && ! isset($asPdf) ){

	echo "<p class=\"footer\"> <b>User:</b>".$userdata['username']."<b>Role:</b>".$userdata['role']."&nbsp;";
	echo "&nbsp;<a href=\"".base_url()."/index.php/change_pwd\">Password</a>";
	echo "&nbsp;&nbsp;<a href=\"".base_url()."/index.php/welcome/logout\">Logout</a>";
	
	echo "</p>";

}
else {
	if ( ! isset($asPdf) ){
		echo "<p class=\"footer\"> &nbsp;<a href=\"".base_url()."/index.php/welcome/logout\">Logout</a>";
	}
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
