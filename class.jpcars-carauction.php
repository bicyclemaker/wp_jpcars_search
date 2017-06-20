<?php

class CarAuction{
	
	private $config=array(); //admin config variables
	private $param=array(); //variables for forming answer 		
	private $db_model=null;
	
	function init_hooks(){
		
		add_action('wp_ajax_jpcar', array( $this, 'handle_ajax' ));
        	add_action('wp_ajax_nopriv_jpcar', array( $this, 'handle_ajax' ));
	       	add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
	        //add_action('wp_head', array($this, 'get_cookie'));
		add_shortcode('carsearch', array( $this, 'shortcode_output' ));	
	}

	function set_param_default(){
                
		$this->param['mark']=null;
                $this->param['model']=null;
                $this->param['max_mileage']=null;
                $this->param['min_mileage']=null;
                $this->param['max_price']=null;
                $this->param['min_price']=null;
                $this->param['max_year']=null;
                $this->param['min_year']=null;
                $this->param['trans']=null;
                $this->param['auction_hall']=null;
                $this->param['color']=null;
                $this->param['min_engine']=null;
                $this->param['max_engine']=null;
                $this->param['pg_current']=1;
                $this->param['pg_limit']=12;
                $this->param['car_total']=null;
                $this->param['pg_total']=null;
                $this->param['lot_number']=null;
                $this->param['auction_grade']=null;
                $this->user_profile=array();
        }

	function set_param($prop=null, $data=null){
                
		if(!empty($prop) && !empty($data)){
                        $this->param["$prop"]=$data;
                }
        }

        function get_param(){
		
		return $this->param;
        }

	function get_config_admin(){
                
		$this->config['max_mileage']=500000-1; //in database this saved without thousand part '000',  like 500
                $this->config['min_mileage']=0;
                $this->config['max_price']=20000000-1;
                $this->config['min_price']=0;
                $this->config['max_year']=date('Y', strtotime('-1 year'));
                $this->config['min_year']=1986+1;
                $this->config['pg_limit']=1000;
		$this->config['pg_pagin_li']=10;

                return $this->config;
        }      
	
	function db_model(){
		if(empty($this->db_model)){
			require_once( JPCARS_PLUGIN_DIR . '/models/HomeSearchCars.php');
			$this->db_model=new HomeSearchCars();
		}
		return $this->db_model;
	}      
 
	function handle_ajax(){
	
		if( ! wp_verify_nonce($_REQUEST['nonce'], 'jpcar')){
                        wp_send_json_error('error');
                }
		//
		if(isset($_REQUEST['getcarsmodel'])){
			$this->param['getcarsmodel']=$_REQUEST['getcarsmodel'];
			$carsmodel=$this->getCarModel($this->param['getcarsmodel']);
			wp_send_json_success(array('carsmodel' => $carsmodel, 'nonce'=> wp_create_nonce('jpcar')));
		}
		
		// handling form submit 	
		if(isset($_REQUEST['formsubmit'])){
			
			$this->set_param_default();
			$conf=$this->get_config_admin();
			
			if(isset($_REQUEST['manufacturer_level1'])){
				if($mark=($this->check_digit($_REQUEST['manufacturer_level1'], 1, 10000))){
                                        $this->set_param('mark', $mark);            
                                }	
			
			if(isset($_REQUEST['manufacturer_level2'])){
				if($model=($this->check_digit($_REQUEST['manufacturer_level2'], 1, 10000))){
					$this->set_param('model', $model);
				}
			}
			if(isset($_REQUEST['max_mileagesize'])){
				if($max_mileage=($this->check_digit($_REQUEST['max_mileagesize'], $conf['min_mileage'], $conf['max_mileage']))){
					$max_mileage=((int) substr($max_mileage, 0, -3));
					$this->set_param('max_mileage', $max_mileage);
				}	
			}
			if(isset($_REQUEST['min_mileagesize'])){
				if($min_mileage=($this->check_digit($_REQUEST['min_mileagesize'], $conf['min_mileage'], $conf['max_mileage']))){
					$min_mileage=((int) substr($min_mileage, 0, -3));
					$this->set_param('min_mileage', $min_mileage);

				}
			}
			if(isset($_REQUEST['max_pricesize'])){
				if($max_price=($this->check_digit($_REQUEST['max_pricesize'], $conf['min_price'], $conf['max_price']))){
					$this->set_param('max_price', $max_price);
				}
			}
			if(isset($_REQUEST['min_pricesize'])){
				if($min_price=($this->check_digit($_REQUEST['min_pricesize'], $conf['min_price'], $conf['max_price']))){
					$this->set_param('min_price', $min_price);
				}			
                        }
			if(isset($_REQUEST['max_yearsize'])){
				if($max_year=($this->check_digit($_REQUEST['max_yearsize'], $conf['min_year'], $conf['max_year']))){
					$this->set_param('max_year', $max_year);
				}
                        }
			if(isset($_REQUEST['min_yearsize'])){
				if($min_year=($this->check_digit($_REQUEST['min_yearsize'], $conf['min_year'], $conf['max_year']))){
					$this->set_param('min_year', $min_year);
				}
                        }
			if(isset($_REQUEST['transmission'])){
				if($trans=($this->check_digit($_REQUEST['transmission'], 1, 100))){
					$this->set_param('trans', $trans);
				}
                        }			
			if(isset($_REQUEST['auction_hall'])){
				if($auction_hall=($this->check_digit($_REQUEST['auction_hall'], 1, 100))){
					$this->set_param('auction_hall', $auction_hall);
				}
			}
			if(isset($_REQUEST['color'])){
				if($color=($this->check_digit($_REQUEST['color'], 1, 300))){
					$this->set_param('color', $color);
				}
                        }
			if(isset($_REQUEST['engine_displacement'])){
                                $engine=$_REQUEST['engine_displacement'];
                                if($engine!='any' && $engine!='Any'){
					$engine=explode("-", $engine);
					$eng_min=$this->check_digit($engine[0], 0, 10000);
					$eng_max=$this->check_digit($engine[1], 0, 10000);
					if($eng_min>0){
						$this->set_param('min_engine', $eng_min);
					}
					if($eng_max>0){
                                        	$this->set_param('max_engine', $eng_max);
                                	}
				}	
                        }		
			for($i=1;$i<7;$i++){
				if(isset($_REQUEST["auction_date_$i"])){
					if(preg_match('/^20[0-9]{2}\-[0-9]{2}\-[0-9]{2}$/', $_REQUEST["auction_date_$i"])){
						$this->set_param("auction_date_$i", $_REQUEST["auction_date_$i"]);
					}

				}
			}
			if(isset($_REQUEST['auction_grade'])){
                                $auction_grade=$this->filter_string($_REQUEST['auction_grade']);
                 			if(!empty($auction_grade) && $auction_grade!='any' && $auction_grade!='Any'){ 
						$this->set_param('auction_grade', $auction_grade);
					}      	
			}
			if(isset($_REQUEST['pg_current'])){
				if($pg_current=($this->check_digit($_REQUEST['pg_current'], 1, 1000))){
					$this->param['pg_current']=$pg_current;
				}
			}
			if(isset($_REQUEST['pg_limit'])){
				if($pg_limit=($this->check_digit($_REQUEST['pg_limit'], 1, $conf['pg_limit']))){
					$this->param['pg_limit']=$pg_limit;
				}
			}
			if(isset($_REQUEST['lot_number'])){
                                if(preg_match("/\d{2,5}/", $_REQUEST['lot_number'])){
                                        $this->set_param('lot_number', $_REQUEST['lot_number'] );
				}
                        }
		
				$this->getCar('carstable_ajax');
				unset($this->param);	
				wp_send_json_success(array('formsubmit'=>'done', 'nonce'=> wp_create_nonce('jpcar')));
			}
		}
		// get images from gallery		
		if(isset($_REQUEST['getimg']) && isset($_REQUEST['ids'])){
			$stock_id=$this->filter_string($_REQUEST['getimg']);
			$ids=$this->filter_string($_REQUEST['ids']);
			$rowimg=$this->getImg($ids, $stock_id);
			if(!empty($rowimg) && $rowimg!==null){
				wp_send_json_success(array('getimg'=>$rowimg, 'nonce'=> wp_create_nonce('jpcar')));
			}else{
				wp_send_json_error('error');	
			}
		}
		//post to Facebook
		if(isset($_REQUEST['selected'])){
			$selected=$_REQUEST['selected'];
			$postfb=$this->postFb($selected);
			if($postfb){			
				wp_send_json_success(array('postfb'=>'done', 'nonce'=> wp_create_nonce('jpcar')));
			}else{
				wp_send_json_error('error');
			}
		}
		if(isset($_REQUEST['posttofb'])){
                	$path = get_home_path();
			$path.='search-addon-fb/postToFB.php';
			shell_exec("php ".$path." test  > /dev/null 1> /dev/null 2>&1");
                	wp_send_json_success(array('posttofb'=>$path, 'nonce'=> wp_create_nonce('jpcar')));
        	}else{
                	end_json_error('error');
        	}
		//end post to Facebook	
	}
	
	function enqueue_scripts(){
		
		wp_enqueue_style('highslide1', plugins_url( '/css/highslide.css', __FILE__ ));
		wp_enqueue_script('highslide1', plugins_url( '/js/highslide1.js', __FILE__ ), array( 'jquery' ), '1.0', true );
        	wp_localize_script('highslide1', 'jpcar', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce( 'jpcar' ),));
	}

	function check_digit($val, $min=0, $max=0){
                
		if(filter_var($val, FILTER_VALIDATE_INT, ["options" => ["min_range"=>$min, "max_range"=>$max]])) {
                        return $val;
                }
                return null;
        }
	
	function filter_string($val){
		
		$field = filter_var($val, FILTER_SANITIZE_STRING);
		if(!empty($field)){
		        return $field;
		}else{
		        return null;
		}
		
	}

	function getCar($template){
		
		if($template=='carstable_ajax'){
			
			$data=$this->get_param();
			$config=$this->get_config_admin();
			$rowscar=$this->db_model()->get_cars_from_db($data);
			if($rowscar['carlist']){
				$pagin=jpcars_pagintaion_html($rowscar['car_total'], $data['pg_current'], $rowscar['pg_total'], $config['pg_pagin_li']);
				
				return $this->view($template, $rowscar['carlist'], $pagin);
			}else{
				return $this->view('empty-page');
			}
		}else{
			return $this->view('empty-page');
		}
	}

	function getCarMark(){
		
		return $this->db_model()->getCarMark();
	}
	
	function getCarModel($make_id){
                
        	return $this->db_model()->getCarModel($make_id);
	}
	
	function getAuctionHall(){
                
                return $this->db_model()->getAuctionHall();
        }
	
	function getTransmission(){
		
		return $this->db_model()->getTransmission();
	}
		
	function getColor(){
		
		return $this->db_model()->getColor();
	}
	function getImg($ids, $stock_id){
                
		$images=$this->db_model()->getImg($ids, $stock_id);
		if(count($images)> 0){
                        $output='[';
                        foreach($images as $row){
                                
				//$pic.='?p2='.$row->stock_id;
				$pic='http://1.ajes.com/ban/';
	
				$output.='{ "src" : "'.$pic.'"},';
                        }
                        $output=rtrim($output, ',');
			return $output.=']';
                }else{
                        return null;
                }       
        }
	
	function postFb($selected){
		
		return $this->db_model()->postFb($selected);
	}

	function check_user(){
		
		if(empty($this->user_profile)){
			$prof=jp_privilege::getInstance()->check_user();
			return $prof;
		}

	}
	
	function shortcode_output($atts){
		
		extract(shortcode_atts( array('template'=>null,), $atts));
		return $this->view($template);
	}
	
	function view($template, $cardata=0, $pagination=0){
		if($template!='empty-page'){
			$user_profile=$this->check_user();
		}
		$file =  JPCARS_PLUGIN_DIR . 'views/home/'. $template . '.php';
                include($file);
	}
}
$jpcar_plugin = new CarAuction();
$jpcar_plugin->init_hooks();


