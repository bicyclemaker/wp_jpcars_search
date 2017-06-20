<?php 
class BidsAdd {
	
	private $param=array();	
	private $user_profile=null;
	private $model_ar=null;
	private $query_fund=array();
	
	function __construct(){
		
		if(empty($this->user_profile)){
                        $this->user_profile=jp_privilege::getInstance()->check_user();
                }
	}
	
	function add_list($param){
		
		global $wpdb;
		$this->param=$param;

		// Cheking existence bid of car in main wp_cars_bid_list. in this table have to be only one record for many bid-records in wp_cars_bid_fund.
                $row_list=$wpdb->get_row($wpdb->prepare("SELECT * FROM `wp_cars_bid_list` 
			WHERE `user_id`='%d' AND `stock_id`='%s' AND lot_number ='%d'", 
			$this->user_profile['user_id'], $param['stockid'], $param['lotnum']), 'ARRAY_A');
		
		if(empty($row_list)){
			//if empty bid-car in wp_cars_bid_list lets add new record from main auction tables. 
			//wp_cars_bid_list->wp_cars_bid_fund
			$wpdb->query('START TRANSACTION');
			 
			$car=$wpdb->get_row($wpdb->prepare("SELECT cr.stock_id, cr.lot_number, cr.year, cr.mileage, cr.start_price, cr.transmission, cr.engine_cc, cr.color, cr.date, cr.auction_time, cr.model_grade, cr.chassis_and_accecories, cr.auction_grade, mark.mark, model.model, hall.auction_hall 
			FROM wp_cars_new1 as cr 
			LEFT JOIN wp_cars_mark as mark ON cr.id_cars_mark=mark.id 
			LEFT JOIN wp_cars_model as model ON cr.id_cars_model=model.id 
			LEFT JOIN wp_cars_auction_hall as hall ON cr.id_auction_hall=hall.id 
			WHERE cr.stock_id=%s AND cr.lot_number=%d", $this->param['stockid'], $this->param['lotnum']), 'ARRAY_A');
			
			if(empty($car)){$wpdb->query('ROLLBACK'); return 'false';}
				
			$car['user_id']=$this->user_profile['user_id'];
			$car['bid_status']=1;
			
			$er=$wpdb->insert('wp_cars_bid_list', $car, array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d'));
		
			$this->query_fund['list_id']=$wpdb->insert_id;
			
			//Add row of bid, wp_cars_bid_list->wp_cars_bid_fund;
			$this->query_fund['date_create']=date("Y-m-d H:i:s");
			$result=$wpdb->insert('wp_cars_bid_fund', $this->query_fund, array('%s', '%d', '%d', '%s', '%d', '%s'));		

			if($er && $result){
				//after creating row, now marking (count up) one bid in users table for restriction rule "bids per day"
				$wpdb->query("UPDATE wp_EWD_FEUP_Users SET BID_Day=1, BID_Time='".date('Y-m-d H:i:s')."' WHERE User_ID='".$this->user_profile['user_id']."'");

				$wpdb->query('COMMIT');
				return array('stat'=>'added_new', 'message'=>'Bid has been set', 'last_bid'=>$this->get_bid_last());
			}else{
				$wpdb->query('ROLLBACK');
				return array('stat'=>'false', 'message'=>'Bid has not been set');
			}
			
		}else{	//user has previous bid  
			
			$this->query_fund['list_id']=$row_list['id'];
			$this->query_fund['date_create']=date("Y-m-d H:i:s");

			$wpdb->query('START TRANSACTION');
			
			$result=$wpdb->insert('wp_cars_bid_fund', $this->query_fund, array('%s', '%d', '%d', '%s', '%d', '%s'));
			//checking if users bid previously was deleted in own Bid History List, if true lets turn-on again
			if($row_list['cleared']==1){
				$wpdb->query("UPDATE `wp_cars_bid_list` SET cleared='' WHERE `user_id`='".$this->user_profile['user_id']."' AND  stock_id='".$this->query_fund['stock_id']."'");			
			}

			if($result){
				$wpdb->query("UPDATE wp_EWD_FEUP_Users SET BID_Day=BID_Day+1, BID_Time='".date('Y-m-d H:i:s')."' WHERE User_ID='".$this->user_profile['user_id']."'");
				$wpdb->query('COMMIT');
				return array('stat'=>'updated', 'message'=>'Bid has been updated', 'last_bid'=>$this->get_bid_last()['bid']);
			}else{
				$wpdb->query('ROLLBACK');	
				return array('stat'=>'false', 'message'=>'Bid has not been updated');
			}
		}
	}
	
	private function get_bid_last(){
		global $wpdb;
		$bid_last=$wpdb->get_row($wpdb->prepare("SELECT fund2.*, list.cleared FROM wp_cars_bid_list AS list 
		INNER JOIN (SELECT list_id, MAX(date_create) MaxDate FROM wp_cars_bid_fund group by list_id) MaxDates 
			ON list.id=MaxDates.list_id AND list.user_id=%d AND list.cleared!='1' AND list.stock_id=%s 
			AND list.lot_number=%d 
		INNER JOIN wp_cars_bid_fund as fund2 ON MaxDates.list_id=fund2.list_id 
			AND MaxDates.MaxDate=fund2.date_create ORDER BY list.id DESC", $this->user_profile['user_id'], $this->param['stockid'], $this->param['lotnum']), 'ARRAY_A');
		return $bid_last;
	}
}
?>
