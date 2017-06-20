<?php

function jp_cookie_redirect(){
	global $wpdb;
	$site_url=get_site_url();
	if(isset($_COOKIE["rd-data"])){
		parse_str($_COOKIE['rd-data'], $req_car);
		if(array_key_exists('lot_num', $req_car) &&  preg_match('/^[0-9]{1,6}$/', $req_car['lot_num'])){
			$lot_num=$req_car['lot_num'];
		}
                if(array_key_exists('id', $req_car) && preg_match('/^[a-z0-9]{12,16}$/i', $req_car['id'])){
                	$idcar=$req_car['id'];
                }
	}
	if(!empty($lot_num) && !empty($idcar)){
		$rec=$wpdb->get_row($wpdb->prepare("SELECT cr.stock_id, cr.lot_number, hall.auction_hall, mk.mark, md.model 
			FROM wp_cars_new1 as cr 
			LEFT JOIN wp_cars_auction_hall as hall ON cr.id_auction_hall=hall.id 
			LEFT JOIN wp_cars_mark AS mk ON cr.id_cars_mark=mk.id 
			LEFT JOIN wp_cars_model AS md ON cr.id_cars_model=md.id  
			WHERE cr.stock_id='%s' AND cr.lot_number='%d'", $idcar, $lot_num), ARRAY_A);
		if(count($rec)>0){
			$href=$site_url.'/search-auction-detail/?stockid='.$rec['stock_id'].'&auction='.$rec['auction_hall'].'&lot='.$rec['lot_number'];
			return ['href'=>$href, 'mark'=>$rec['mark'], 'model'=>$rec['model']];
		}else{
			return $site_url;
		}	

	}else{
		 return $site_url;	
		
	}
}
function jp_breadcrumbs($current=null){

	if(empty($detail_path=jp_cookie_redirect())){ return null; }
	$site_url=get_site_url();
	$html='<ol class="breadcrumb">
		<li><a href="'.$site_url.'">Home</a></li>
		<li><a href="'.$detail_path['href'].'">'.$detail_path['mark'].' - '.$detail_path['model'].'</a></li>';
	if(!empty($current)){
		$html.='<li class="breadcrumb_last"><a href="'.$current["href"].'">'.$current['name'].'</a></li>';
	}	
		$html.='</ol>';
	return $html;
	
}


add_shortcode("jp-cookie-redirect", "jp_cookie_redirect");
?>
