<?php
function jp_login_menu(){
	$user_=jp_privilege::getInstance()->check_user();
	$output='<div class="login-greet"';
	if($user_['user_status']===null){ 
		$output.='<span><strong> Hello! <a href="'.get_site_url().'/my-profile/login/">Login</a> or <a href="'.get_site_url().'/my-profile/registration/">register</a></strong></span> ';
	}else{
		$output.='<span><strong>';
		if(!empty($user_['user_firstname'])) {  
			$output.=$user_['user_firstname'];
		}else if(!empty($user_['user_login'] )){
			$output.=$user_['user_login'].' ';
		}else{
		
		}
		if(!empty($user_['user_wpid'])){
			$output.=', <a href="'.wp_logout_url().'">Logout</a></strong></span>';
		}else{
			$output.=' <a href="'.get_site_url().'/my-profile/">My Profile</a> or <a 
				href="'.get_site_url().'/my-profile/logout/">Logout</a></strong></span> ';
		}
	}
	$output.='</div>';
	echo $output;
}
add_shortcode("jp-login-menu", "jp_login_menu");
?>
