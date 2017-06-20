<?php 
class JPDetailWatch {
	
	private $param=array();	
	private $user_profile=null;
	private $config=array();
	private $db_model=null;

	public function init_hooks(){
		$this->set_param_default();
		add_action('wp_ajax_watchlist', array($this, 'handle_ajax'));
		add_action('wp_ajax_nopriv_watchlist', array($this, 'handle_ajax'));	
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_shortcode('watchlist', array( $this, 'shortcode_output' ));
	}
	public function enqueue_scripts(){
		if(is_page(507)){
			wp_enqueue_script('detail_watchlist', plugins_url( '/js/watchlist.js', __FILE__ ), array( 'jquery' ), '1.0', true );
			wp_localize_script('detail_watchlist', 'watchlist', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('watchlist')));

			wp_enqueue_style('detail_watchlist_picker', plugins_url( '/css/jquery-ui.css', __FILE__ ));
			wp_enqueue_script('detail_watchlist_picker', plugins_url( '/js/jquery-ui.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		}

        }
	private function set_param_default(){
                $this->param['stockid']=null;
                $this->param['make']=null;
                $this->param['model']=null;
                $this->param['max_yearsize']=date("Y");
                $this->param['min_yearsize']=1986;
                $this->param['max_year']=null;
                $this->param['min_year']=null;
                $this->param['auction_hall']=null;
                $this->param['create-start']=null;
                $this->param['create-end']=null;
                $this->param['lotnum']=null;
                $this->param['car_total']=null;
                $this->param['pg_limit']=5;
		$this->param['pg_pagin_item']=5;
                $this->param['pg_current']=1;
        }
        private function set_param($prop=0, $data=0){
                if(!empty($prop) && !empty($data)){
                        $this->param["$prop"]=$data;
                }
        }
	
	private function db_model(){
                if(empty($this->db_model)){
                        require_once( JPCARS_PLUGIN_DIR . '/models/Watchlist.php');
                        $this->db_model=new Watchlist();
                }
                return $this->db_model;
        }

	public function handle_ajax(){
		if( ! wp_verify_nonce($_REQUEST['nonce'], 'watchlist')){
                        wp_send_json_error('error');
                }
		if(isset($_REQUEST['watchlist'])){
			if($_REQUEST['watchlist']=='add'){
				if(isset($_REQUEST['stockid']) && isset($_REQUEST['lotnum'])){
					if(preg_match('/^[a-z0-9]{8,20}$/i', $_REQUEST['stockid'])){
						$this->set_param('stockid' , $_REQUEST['stockid']);	
					}
					if(preg_match('/^[0-9]{1,6}$/i', $_REQUEST['lotnum'])){
                                        	$this->set_param('lotnum' , $_REQUEST['lotnum']); 
                                	}
							
					$result=$this->db_add_list();
					wp_send_json_success(array('add_list'=>$result, 'nonce'=> wp_create_nonce('watchlist')));
				}
			}
			
			if($_REQUEST['watchlist']=='model'){
				if(isset($_REQUEST['make'])){
					 if(preg_match('/^[a-z0-9]{1,50}$/i', $_REQUEST['make'])){
                                                $this->set_param('make', $_REQUEST['make']);
                                        }
					$auction=$this->db_get_auction_ajax();    
					wp_send_json_success(array('carsmodel'=>$auction['model'], 'auction'=>$auction['auction'], 'nonce'=> wp_create_nonce('watchlist')));
				}
			}
			
			if($_REQUEST['watchlist']=='get'){
				
				if(isset($_REQUEST['manufacturer_make'])){
					if(preg_match('/(?=^[a-z0-9\s]{2,50}$)(?!any$)/i', $_REQUEST['manufacturer_make'])){
                                        	$this->set_param('make' , $_REQUEST['manufacturer_make']);
                                	}		
				}
				if(isset($_REQUEST['manufacturer_model'])){
					if(preg_match('/(?=^[a-z0-9\s]{1,50}$)(?!any$)/i', $_REQUEST['manufacturer_model'])){
                                        	$this->set_param('model' , $_REQUEST['manufacturer_model']);
                                	}
                        	}
				if(isset($_REQUEST['max_yearsize'])){
					if(preg_match('/^19[0-9]{2}$|^20[0-9]{2}$/', $_REQUEST['max_yearsize']) 
						&& ($_REQUEST['max_yearsize']>=$this->param['min_yearsize'] 
						&& $_REQUEST['max_yearsize']<$this->param['max_yearsize'])){
						$this->set_param('max_year' , $_REQUEST['max_yearsize']);	
					}
				}			
				if(isset($_REQUEST['min_yearsize'])){
                                        if(preg_match('/^19[0-9]{2}$|^20[0-9]{2}$/', $_REQUEST['min_yearsize'])
						&& ($_REQUEST['min_yearsize']>$this->param['min_yearsize'] 
						&& $_REQUEST['min_yearsize']<=$this->param['max_yearsize'])){
						$this->set_param('min_year' , $_REQUEST['min_yearsize']);
                                        }
                                }
				if(isset($_REQUEST['auction_hall'])){
					if(preg_match('/(?=^[a-z\s]{2,50}$)(?!any$)/i', $_REQUEST['auction_hall'])){
						 $this->set_param('auction_hall' , $_REQUEST['auction_hall']);	
					}	
				}
				if(isset($_REQUEST['create-start'])){
                                        if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST['create-start'])){ 
                                                 $this->set_param('create-start' , $_REQUEST['create-start']);
                                        }
                                }
				if(isset($_REQUEST['create-end'])){
                                        if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST['create-end'])){
                                                 $this->set_param('create-end' , $_REQUEST['create-end']);
                                        }
                                }
				if(isset($_REQUEST['search-lot-number'])){
                                        if(preg_match('/^[0-9]{1,6}$/i', $_REQUEST['search-lot-number'])){
                                                $this->set_param('lotnum' , $_REQUEST['search-lot-number']);
                                        }
                                }
				if(isset($_REQUEST['pg_current'])){
                                        if(preg_match('/^[0-9]{1,3}$/', $_REQUEST['pg_current'])){
                                                 $this->set_param('pg_current' , $_REQUEST['pg_current']);
                                        }      
                                }				
				
				$this->result_table($this->db_get_list());
				wp_send_json_success(array('get_list'=>'done',  'nonce'=> wp_create_nonce('watchlist')));
			}
			
			if($_REQUEST['watchlist']=='del'){ //ajax query is handled from page details
                                if(isset($_REQUEST['stockid']) && isset($_REQUEST['lotnum'])){
                                        if(preg_match('/^[a-z0-9]{8,20}$/i', $_REQUEST['stockid'])){
                                                $this->set_param('stockid' , $_REQUEST['stockid']);
                                        }
                                        if(preg_match('/^[0-9]{1,6}$/i', $_REQUEST['lotnum'])){
                                                $this->set_param('lotnum' , $_REQUEST['lotnum']);
                                        }

                                        $result=$this->db_del_list();
                                        wp_send_json_success(array('del_list'=>$result, 'nonce'=> wp_create_nonce('watchlist')));
                                }
                        }
			if($_REQUEST['watchlist']=='clear'){ //ajax query is handled from page watchlist
                                if(isset($_REQUEST['selected'])){
                                        $selected=$_REQUEST['selected'];
                                        foreach($selected as $k=>$val){
                                                if(preg_match("/^[a-z0-9]{2,20}$/i", $val, $matches)){
                                                        $checked[]=$matches[0];
                                                }
                                        }
                                }
                                if(isset($_REQUEST['page'])){
                                        if(preg_match('/^[0-9]{1,3}$/', $_REQUEST['page'])){
                                                $this->set_param('pg_current', $_REQUEST['page']);
                                        }
                                }

                                $this->clearall_watchlist($checked);
                                $this->result_table($this->db_get_list());
                        }

		}else{
			 end_json_error('error');
		}
	}
	
	private function db_add_list(){

		if(empty($this->check_user())){ return false; };

                return $this->db_model()->add_list($this->param);	
	}
	private function db_get_list(){
		
		if(empty($this->check_user())){ return null; } 
		
		$rowscar=$this->db_model()->get_list($this->param);
                $pagin=jpcars_pagintaion_html($rowscar['car_total'], $this->param['pg_current'], $rowscar['pg_total'], $this->param['pg_pagin_item']);
                return ['result_list'=>$rowscar['result_list'], 'pagin'=>$pagin];
	}
	private function db_del_list(){
               
		if(empty($this->check_user())){ return null; } 
		
		return $this->db_model()->del_list($this->param);
        
	}
        private function clearall_watchlist($selected){
		
		if(empty($this->check_user())){ return null; }

		return $this->db_model()->clearall_watchlist($selected);
        }
	private function db_get_mark(){

                return $this->db_model()->get_mark();
	}
	private function db_get_model(){
		
		return $this->db_model()->get_model($this->param);
	}
	private function db_get_auction(){
		
		return $this->db_model()->get_model($this->param);
	}
	private function db_get_auction_ajax(){
		
		if(empty($this->check_user())) { return null;}
		
		return $this->db_model()->get_auction_ajax($this->param);	
	}		
	private function check_user(){
                
		if(empty($this->user_profile)){
			$this->user_profile=jp_privilege::getInstance()->check_user();
		}
		if(!isset($this->user_profile['user_status']) || $this->user_profile['user_status']===null){
			return false;
		}else{
			return $this->user_profile;
		}
	}
	public function result_table($wishcar){
		if($wishcar!==null){
			include_once('views/watchlist/result-table.php');
		}else{
			include_once('views/watchlist/empty-page.php');
		}
	}	
	public function shortcode_output(){
		$wishcar=$this->db_get_list();
		include_once('views/watchlist/search-panel.php');
		//$this->result_table($wishcar);
	}
}
$watchlist=new JPDetailWatch();
$watchlist->init_hooks();

?>
