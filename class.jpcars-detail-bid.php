<?php 
class JPDetailBid {
	
	private $param=array();	
	private $user_profile=null;
	private $model_ar=null;
	private $config=array();
	private $query_fund=array();
	private $db_model_form=null;

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
                $this->param['auction-start']=null;
                $this->param['auction-end']=null;
                $this->param['bid_status']=null;
                $this->param['lotnum']=null;
                $this->param['car_total']=null;
                $this->param['bid']=null;
                $this->param['currency']=null;
                $this->param['message']=null;
                $this->param['pg_limit']=5;
		$this->param['pg_pagin_item']=10;
                $this->param['pg_current']=1;
        }
        private function set_param($prop=0, $data=0){
                if(!empty($prop) && !empty($data)){
                        $this->param["$prop"]=$data;
                }
        }
	public function init_hooks(){
		$this->set_param_default();
		add_action('wp_ajax_bidlist', array($this, 'handle_ajax'));
		add_action('wp_ajax_nopriv_bidlist', array($this, 'handle_ajax'));	
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_shortcode('bidlist', array( $this, 'shortcode_output' ));
	}
	public function enqueue_scripts(){
		//if(is_page(525)){
		if(is_page(522)){	
		wp_enqueue_script('detail_bidlist', plugins_url( '/js/bidlist.js', __FILE__ ), array( 'jquery' ), '1.0', true );
			wp_localize_script('detail_bidlist', 'bidlist', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('bidlist')));
			wp_enqueue_style('detail_bidlist_picker', plugins_url( '/css/jquery-ui.css', __FILE__ ));
			wp_enqueue_script('detail_bidlist_picker', plugins_url( '/js/jquery-ui.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		}

        }
	public function handle_ajax(){
		if( ! wp_verify_nonce($_REQUEST['nonce'], 'bidlist')){
			wp_send_json_error('error');
                }
		if(isset($_REQUEST['bidlist'])){
			if($_REQUEST['bidlist']=='add'){
				if(isset($_REQUEST['stockid']) && isset($_REQUEST['lotnum'])){
					
					if(preg_match('/^[a-z0-9]{8,20}$/i', $_REQUEST['stockid'])){
						$this->set_param('stockid' , $_REQUEST['stockid']);
						$this->query_fund['stock_id']=$_REQUEST['stockid'];	
					}
					if(preg_match('/^[0-9]{1,6}$/', $_REQUEST['lotnum'])){
                                        	$this->set_param('lotnum' , $_REQUEST['lotnum']); 
                                		$this->query_fund['lot_number']=$_REQUEST['lotnum'];
					}
					if(preg_match('/^[0-9]{1,9}$/', $_REQUEST['bid'])){
                                                $this->set_param('bid' , $_REQUEST['bid']);
						$this->query_fund['bid']=$_REQUEST['bid'];
                                        }
					if(preg_match('/^[a-z]{3}$/i', $_REQUEST['currency'])){
                                                $this->set_param('currency' , $_REQUEST['currency']);
                                        	$this->query_fund['currency']=$_REQUEST['currency'];
					}
					if(isset($_REQUEST['message'])){
						$this->set_param('message', $_REQUEST['message']);
						$this->query_fund['message']=$_REQUEST['message'];
					}
							
					$result=$this->db_add_list();
					$result['nonce']=wp_create_nonce('bidlist');
					wp_send_json_success($result);
				}
			}
			
			if($_REQUEST['bidlist']=='model'){
				if(isset($_REQUEST['make'])){
					 if(preg_match('/^[a-z0-9]{1,50}$/i', $_REQUEST['make'])){
                                                $this->set_param('make', $_REQUEST['make']);
                                        }    
					$auction=$this->db_get_auction_ajax();	
				wp_send_json_success(array('carsmodel'=>$model_list, 'auction'=>$auction, 'nonce'=> wp_create_nonce('bidlist')));
				}
			}
			
			if($_REQUEST['bidlist']=='get'){
				
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
                                                 $this->set_param('create-start' , $_REQUEST['create-start'].' 00:00:00');
                                        }
                                }
				if(isset($_REQUEST['create-end'])){
                                        if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST['create-end'])){
                                                 $this->set_param('create-end' , $_REQUEST['create-end'].' 23:59:59');
                                        }
                                }
				if(isset($_REQUEST['auction-start'])){
                                        if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST['auction-start'])){
                                                 $this->set_param('auction-start' , $_REQUEST['auction-start']);
                                        }
                                }
                                if(isset($_REQUEST['auction-end'])){
                                        if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST['auction-end'])){
                                                 $this->set_param('auction-end' , $_REQUEST['auction-end']);
                                        }
                                }
				if(isset($_REQUEST['search-lot-number'])){
                                        if(preg_match('/^[0-9]{1,6}$/i', $_REQUEST['search-lot-number'])){
                                                $this->set_param('lotnum' , $_REQUEST['search-lot-number']);
                                        }
                                }
				if(isset($_REQUEST['bid_status'])){
                                        if(preg_match('/^[0-9]{1}$/', $_REQUEST['bid_status'])){
                                                 $this->set_param('bid_status' , $_REQUEST['bid_status']);
                                        }      
                                }
				if(isset($_REQUEST['pg_current'])){
                                        if(preg_match('/^[0-9]{1,3}$/', $_REQUEST['pg_current'])){
                                                 $this->set_param('pg_current' , $_REQUEST['pg_current']);
                                        }
                                }
				
				$this->result_table($this->db_get_list());
				wp_send_json_success(array('get_list'=>'done', 'nonce'=> wp_create_nonce('bidlist')));
			}
			
			if($_REQUEST['bidlist']=='del'){
                                if(isset($_REQUEST['stockid']) && isset($_REQUEST['lotnum'])){
                                        if(preg_match('/^[a-z0-9]{8,20}$/i', $_REQUEST['stockid'])){
                                                $this->set_param('stockid' , $_REQUEST['stockid']);
                                        }
                                        if(preg_match('/^[0-9]{1,6}$/i', $_REQUEST['lotnum'])){
                                                $this->set_param('lotnum' , $_REQUEST['lotnum']);
                                        }

                                        $result=$this->db_del_list();
                                        wp_send_json_success(array('del_list'=>$result, 'nonce'=> wp_create_nonce('bidlist')));
                                }
                        }
			
			if($_REQUEST['bidlist']=='clear'){
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
			
				$this->clearall_bid($checked);
				$this->result_table($this->db_get_list());
			}	
			
			if($_REQUEST['bidlist']=='cancel'){
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
					
				$this->cancel_bid($checked);
				$this->result_table($this->db_get_list());	
			}
	
		}else{
			 end_json_error('error');
		}
	}
	private function db_add_list(){
		global $wpdb;
		$this->check_user();
		
		if(empty($this->check_user())){
			return ['stat'=>'false', 'message'=>'Please login'];	
		}	
	
		if(empty($this->user_profile['bid_allow'])){
			return ['stat'=>'false', 'message'=>'Try to get subsribtion'];
		}
	
		if(empty($this->user_profile['bid_day_access']) && !array_key_exists('stock_id', $row_list)){
			return ['stat'=>'false', 'message'=>'Quantity of allowed bids per day was exceeded'];	
		}
	
		require_once( JPCARS_PLUGIN_DIR . '/models/BidsAdd.php');
                $new_bid=new BidsAdd();	
		return $new_bid->add_list($this->param);	
	}

	private function db_get_list(){
		
		global $wpdb;
	
		if(empty($this->check_user())){ return false; }
		
		$param=$this->param;
		
		require_once( JPCARS_PLUGIN_DIR . '/models/BidsGet.php');
                $get_bid=new BidsGet();
		$rowscar=$get_bid->get_list($param);
		$this->param['car_total']=$rowscar['car_total'];
		$pagin=jpcars_pagintaion_html($rowscar['car_total'], $param['pg_current'], $rowscar['pg_total'], $param['pg_pagin_item']);

		return ['result_list'=>$rowscar['carlist'], 'pagin'=>$pagin];
	}
	private function db_model_form(){
                if(empty($this->db_model_form)){
                        require_once( JPCARS_PLUGIN_DIR . '/models/BidsServ.php');
                        $this->db_model_form=new BidsServ();
                }
                return $this->db_model_form;
        }
	private function db_del_list(){
		
		if(empty($this->check_user())) { return false; }
		
		return $this->db_model_form()->del_list();

        }
	private function db_get_mark(){
                
		return $this->db_model_form()->get_mark();
        }
        private function db_get_model(){
                
		if(empty($this->check_user())) { return false; }
        	
		return $this->db_model_form()->get_model();
        }
	private function db_get_auction(){
	
		return $this->db_model_form()->get_auction();	
	}
	private function db_get_auction_ajax(){

		if(empty($this->check_user())) { return null;}

                return $this->db_model_form()->get_auction_ajax($this->param);
	}
	private function clearall_bid($selected){

		if(empty($this->check_user())) { return null;}
	
		return $this->db_model_form()->clearall_bid($selected);
	}
	private function cancel_bid($selected){

		if(empty($this->check_user())) { return null;}

        	return $this->db_model_form()->clearall_bid($selected);
	}	
	private function check_user(){
                if(empty($this->user_profile)){
			$this->user_profile=jp_privilege::getInstance()->check_user();
		}
		if(!isset($this->user_profile['user_status']) || $this->user_profile['user_status']===null){
			//wp_redirect(site_url().'/my-profile/login/', 301);
			//return  array('stat'=>'false', 'message'=>'Please login');
			return null;
		}
		return $this->user_profile;	
	}
	private function result_table($bidcar){
		if(!empty($bidcar)){
			include_once('views/bidlist/result-table.php');
		}else{
			include_once('views/bidlist/empty-page.php');
		}
	}	
	public function shortcode_output(){
		$bidcar=$this->db_get_list();
		include_once('views/bidlist/search-panel.php');
		//$this->result_table($wishcar);
	}


}
$bidlist=new JPDetailBid();
$bidlist->init_hooks();

?>
