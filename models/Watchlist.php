<?php 
class Watchlist {
	
	private $param=array();	
	private $user_profile=null;
	private $model_ar=null;
	private $config=array();

	function __construct(){

                if(empty($this->user_profile)){
                        $this->user_profile=jp_privilege::getInstance()->check_user();
                }
        }

	function add_list($param){
		
		global $wpdb;
		
		$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM `wp_cars_watch_list` 
		WHERE `user_id`='%d' AND `stock_id`='%s' AND lot_number ='%d'", $this->user_profile['user_id'], $param['stockid'], $param['lotnum']), 'ARRAY_A');	
		if(empty($row)){
			$car=$wpdb->get_row($wpdb->prepare("SELECT cr.stock_id, cr.lot_number, cr.year, cr.mileage, cr.start_price, cr.transmission, cr.engine_cc, cr.color, cr.date, cr.auction_time, cr.model_grade, cr.chassis_and_accecories, cr.auction_grade, mark.mark, model.model, hall.auction_hall from wp_cars_new1 as cr 
			LEFT JOIN wp_cars_mark as mark ON cr.id_cars_mark=mark.id 
			LEFT JOIN wp_cars_model as model ON cr.id_cars_model=model.id 
			LEFT JOIN wp_cars_auction_hall as hall ON cr.id_auction_hall=hall.id 
			WHERE cr.stock_id=%s AND cr.lot_number=%d", $param['stockid'], $param['lotnum']), 'ARRAY_A');
			if($car){
				$car['user_id']=$this->user_profile['user_id'];
				$er=$wpdb->insert('wp_cars_watch_list', $car, 
		array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
				if($er){
					return 'done';
				}else{
					return 'false';
				}
			}else{
				 return 'false';
			}
		}else{
			return 'exists';
		}
	}
	
	private function compose_query_where($data){
		$query=array();
		
		if($data['lotnum']!==null){
                        $query['lotnum']="`lot_number`='".$data['lotnum']."'";
                }
		if($data['stockid']!==null){
			$query['stockid']="`stockid`='".$data['stockid']."'";
		}
		
		if($data['max_year']!==null && $data['min_year']===null){
                        $query['year']="`year`<='".$data['max_year']."'";
                }
                if($data['max_year']===null && $data['min_year']!==null){
                        $query['year']="`year`>='".$data['min_year']."'";
                }
                if($data['max_year']!==null && $data['min_year']!==null){
                        $query['year']="`year` BETWEEN '".$data['min_year']."' AND '".$data['max_year']."'";
                }
		
		if($data['make']!==null){
                        $query['make']="`mark`='".$data['make']."'";
                }
		if($data['model']!==null){
                	$query['model']="`model`='".$data['model']."'";
                }

		if($data['auction_hall']!==null){
			$query['auction_hall']="`auction_hall`='".$data['auction_hall']."'";	
		}			
		
		if($data['create-start']!==null && $data['create-end']===null){
                        $query['create']="`create_date`>='".$data['create-start']."'";
                }
                if($data['create-start']===null && $data['create-end']!==null){
                        $query['create']="`create_date`<='".$data['create-end']."'";
                }
                if($data['create-start']!==null && $data['create-end']!==null){
                        $query['create']="`create_date` BETWEEN '".$data['create-start']."' AND '".$data['create-end']."'";
                }
		
		//var_dump($data);
		//var_dump($query);
		
		$condition='';	
		
		if(!empty($query)){
                       	foreach($query as $key=>$qr){
				$condition.=' AND (' .$qr.')';
                     	}
                 }
               //echo $condition; 
		return $condition;
	}

	function get_list($param){
		global $wpdb;
		
		$where_request=$this->compose_query_where($param);
		$query_cnt="SELECT count(*) as cnt FROM `wp_cars_watch_list` WHERE `user_id`='".$this->user_profile['user_id']."' ".$where_request;
		$query="SELECT * FROM `wp_cars_watch_list` WHERE `user_id`='".$this->user_profile['user_id']."' ".$where_req;
		//echo $query_cnt;
		$carstotal=$wpdb->get_row($query_cnt, 'ARRAY_A');
		if(!empty($carstotal['cnt'])){
			
			//pagination
                        $pg_limit=$param['pg_limit'];
                        $pg_current=$param['pg_current'];
                        $pagetotal=ceil($carstotal['cnt'] / $pg_limit);

                        if($pagetotal>=$pg_current && $pagetotal>1){
                                
				$offset = ( $pg_current - 1 ) * $pg_limit;
                        
			}else if($pagetotal<$pg_current && $pagetotal>=1){
                                
				$offset = ( $pagetotal - 1 ) * $pg_limit;
                        
			}else{
                                $offset = 0;
                        }

			$query.=' LIMIT '.$offset.', '.$pg_limit;
			//echo '  '.$query.'  ';
			$result_carlist=$wpdb->get_results($query, 'ARRAY_A');
			return ['result_list'=>$result_carlist, 'car_total'=>$carstotal['cnt'], 'pg_total'=>$pagetotal];;
		}
		return null;
	}
	function del_list($param){
                global $wpdb;
                $result=$wpdb->query($wpdb->prepare("DELETE FROM `wp_cars_watch_list` WHERE `user_id`='%d' AND `stock_id`='%s' AND lot_number='%d'", $this->user_profile['user_id'], $this->param['stockid'], $this->param['lotnum']));
                return $result;
        }
        function clearall_watchlist($selected){
                global $wpdb;
                $this->check_user();
                $sql="DELETE FROM `wp_cars_watch_list` WHERE `user_id`='".$this->user_profile['user_id']."' AND `stock_id` IN ('".implode('\', \'', $selected)."')";
                $wpdb->query($sql);

        }
	function get_mark(){
		global $wpdb;
		$result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `mark` FROM `wp_cars_watch_list` WHERE `user_id`='%d'", $this->user_profile['user_id']), 'ARRAY_A');
                return $result;
	}
	function get_model($param){
		global $wpdb;
		//$param['make']='TOYOTA';
		if(!empty($param['make'])){
			$result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `model` FROM `wp_cars_watch_list` WHERE `user_id`='%d' AND mark='%s'", $this->user_profile['user_id'], $param['make']), 'ARRAY_A');
			$this->model_ar=$result;
			return $result;
		}else{
			return null;
		}
	}
	function get_auction(){
		global $wpdb;

                $result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `auction_hall` FROM `wp_cars_watch_list` WHERE `user_id`='%d'", $this->user_profile['user_id']), 'ARRAY_A');

                return $result;
	}
	function get_auction_ajax($param){

                if(!empty($model_ar=$this->get_model())){
                        $model='';
                        foreach($model_ar as $k){
                                $model.="'".$k['model']."', ";
                        }
                        $model=rtrim($model, ', ');
                }
                $result=$wpdb->get_results("SELECT DISTINCT `auction_hall` FROM `wp_cars_watch_list` WHERE `user_id`='".$this->user_profile['user_id']."' AND `mark`='".$param['make']."' AND `model` IN (".$model.")", 'ARRAY_A');      
                return ['auction'=>$result, 'model'=>$model_ar];
        }
}
$watchlist=new JPDetailWatch();
$watchlist->init_hooks();

?>
