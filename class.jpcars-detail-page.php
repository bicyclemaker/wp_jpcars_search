<?php

class JPCarsDetailPage{

	private $wp_post;
	public $card=null;
	private $prarm=array();
	private $page_title;
	public $image;		
	public $meta_tags=null;
	public $chk_watch=null;
	private $user_profile=null;

	function init_hooks(){
		
		add_action('init', array( $this, 'jpcars_init_rules'));
		add_filter('query_vars', array($this, 'jpcars_query_vars'));
		add_action('parse_request', array($this, 'jpcars_parse_request'));
		add_shortcode('jpdetail', array( $this, 'shortcode_detail_page'));
	}
	
	function jpcars_init_rules(){
		
		add_rewrite_rule( '^search-auction-detail/?stockid=([A-Za-z0-9]{,16})&auction=([A-Za-z0-9]{,32})&lot=([0-9]{,7})$', 'index.php?page_id=325&stockid=$matches[1]&auction=$matches[2]&lot=$matches[3]', 'top' );
		
	}
	function enqueue_scripts(){
		wp_enqueue_script('highslide1', plugins_url( '/js/highslide1.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script('detail_bidlist', plugins_url( '/js/details.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	}	
	function jpcars_query_vars($query_vars){ //query_vars of url request
		
		$query_vars[] = 'stockid';
		$query_vars[] = 'auction';
		$query_vars[] = 'lot';
		return $query_vars;
	
	}
	function jpcars_parse_request(&$wp){
		
		if(array_key_exists('stockid', $wp->query_vars) && array_key_exists('pagename', $wp->query_vars)
                     && preg_match('/^search-auction-detail$/i', $wp->query_vars['pagename'])){

		$this->initiated = true;
			$conf=$wp->query_vars;
			$card=$this->card=$this->getCarDetail($conf);
			if(empty($card)){
				wp_redirect(home_url());
				exit();
			}			
			//post_to_fb ==2 for first visit facebook publisher/scraper during posting on page
			//post_to_fb ==3 users from facebook can see posted cars
			if($card->post_to_fb ==2 || $card->post_to_fb==3  || $this->check_user() || is_user_logged_in()){
				$this->enqueue_scripts();
				$this->checkWatchlist($conf); //presence check on watchlist
				
				$permalink = site_url();
				$find = array( 'http://', 'https://' );
				$site_url = str_replace( $find, '', $permalink );
				$this->page_title=$site_url.' | '.$card->mark.' '.$card->model;
				
				add_action('wp_head', array($this, 'add_meta_tags'), 0);
				add_action('wp_head', array($this, 'add_ajax_nonce'), 0);
				$this->image=$this->getImage($conf['stockid']);
				
			}else{
				// setcookie 'rd-data' for redirect from facebook 
				setcookie('rd-data', 'lot_num='.$conf['lot'].'&id='.$conf['stockid'], time()+3600*24, '/');
				$url=home_url().'/my-profile/login/';
				wp_redirect($url);
				exit();
			}
		}

		if(array_key_exists('stockid', $wp->query_vars) && array_key_exists('attachment', $wp->query_vars)
			&& preg_match('/^printview$/i', $wp->query_vars['attachment'])){
		
			$this->enqueue_scripts();
			$conf=$wp->query_vars;
			$card=$this->card=$this->getCarDetail($conf);	
			if($this->check_user() || is_user_logged_in()){

				$permalink = site_url();
                                $find = array( 'http://', 'https://' );
                                $site_url = str_replace( $find, '', $permalink );
                                $this->page_title=$site_url.' | '.$card->mark.' '.$card->model;

                                $this->image=$this->getImage($conf['stockid']);

				include_once JPCARS_PLUGIN_DIR . 'views/details/page-printview.php';
				echo $body;	
				exit();
			}
			
		}
	
		return false;
	}
	

	public function getCarDetail($conf){
		global $wpdb;
		$carinf=$wpdb->get_row($wpdb->prepare("SELECT * FROM wp_cars_new1 as cr 
		LEFT JOIN wp_cars_auction_hall as hall ON cr.id_auction_hall=hall.id 
		LEFT JOIN wp_cars_mark AS mk ON cr.id_cars_mark=mk.id 
		LEFT JOIN wp_cars_model AS md ON cr.id_cars_model=md.id 
		WHERE cr.stock_id='%s' AND cr.lot_number='%d'", $conf['stockid'], $conf['lot']));
		return $carinf;
	}
	public function getImage($stockid){
		global $wpdb;
                $img=$wpdb->get_results($wpdb->prepare("SELECT photo_url FROM wp_cars_img WHERE stock_id='%d'", $stockid));
                return $img;
	}
	public function checkWatchlist($conf){
		global $wpdb;
		$inlist=$wpdb->get_row($wpdb->prepare("SELECT * FROM `wp_cars_watch_list` WHERE `stock_id`='%s' and lot_number='%d';", $conf['stockid'], $conf['lot']));
		if(!empty($inlist)){
			$this->chk_watch=true;	
		}
	}
	public function check_user(){
		if(empty($this->user_profile)){
                        $this->user_profile=jp_privilege::getInstance()->check_user();
                }
                if(!isset($this->user_profile['user_status']) || $this->user_profile['user_status']===null){
                	return false;
		}else{
			return true;
		}
		
	
	}
	public function add_meta_tags(){
		$card=$this->card;
		$str_meta='<meta property="og:title" cmntent="'.$card->mark.' '.((preg_match("/other/i", $card->model)) ? '' : $card->model).'"/>'."\n";
		//$str_meta.='<meta property="og:type" content="article" />'."\n";
                $str_meta.='<meta property="og:type" content="website" />'."\n";
		$str_meta.='<meta property="og:image" content="'.$card->photo_url.'"/>'."\n";
                $str_meta.='<meta property="og:url" content="'.get_site_url().'/search-auction-detail/?stockid='.$card->stock_id.'&auction='.$this->card->auction_hall.'&lot='.$card->lot_number.'"/>'."\n";
		$str_meta.='<meta property="og:description" content="Bidding starts at '.number_format($card->start_price).' Yen. Submit your BID and make it yours!" />';
		echo $str_meta;
	}
	public function add_ajax_nonce(){
	?>
  		<script type="text/javascript">
			var watchlist =<?php echo json_encode(array(
				'ajax_url' => admin_url( "admin-ajax.php" ),
				'nonce' => wp_create_nonce( "watchlist" )
				));?>;
			var bidlist = <?php echo json_encode(array(
				'ajax_url' => admin_url("admin-ajax.php"),
				'nonce' => wp_create_nonce("bidlist")
				));?>;		 
  		</script>
	<?php
	}	
	public function add_title(){
		return 'new title';
	}
	public function shortcode_detail_page($atts){

		//add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));

		extract(shortcode_atts( array('show'=>null), $atts));
		if(!empty($show) && $show=='page'){
			return $this->output_detail_page();
		}
	}
	private function output_detail_page(){
		$card=$this->card;
                $img=$this->image;
                include_once('views/details/page-details1.php');
                return $body;
	}
}
$jpcar_detail = new JPCarsDetailPage(); 
$jpcar_detail->init_hooks();
