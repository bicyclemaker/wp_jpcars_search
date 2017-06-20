<?php 
class BidsServ {
	
	private $param=array();	
	private $user_profile=null;
	private $model_ar=null;
	private $config=array();
	private $query_fund=array();
	
	function __construct(){
		
		if(empty($this->user_profile)){
                        $this->user_profile=jp_privilege::getInstance()->check_user();
                }
	}
	

	function get_mark(){
		global $wpdb;
		
		$result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `mark` FROM `wp_cars_bid_list` WHERE `user_id`='%d'", $this->user_profile['user_id']), 'ARRAY_A');
                return $result;
	}
	
	function get_model(){
		global $wpdb;
		
		if(!empty($this->param['make'])){
			$result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `model` FROM `wp_cars_bid_list` WHERE `user_id`='%d' AND cleared!='1' AND mark='%s'", $this->user_profile['user_id'], $this->param['make']), 'ARRAY_A');
			return $result;
		}else{
			return null;
		}
	}
	
	function get_auction(){
		global $wpdb;	
		
		$result=$wpdb->get_results($wpdb->prepare("SELECT DISTINCT `auction_hall` FROM `wp_cars_bid_list` WHERE `user_id`='%d' AND cleared!='1'", $this->user_profile['user_id']), 'ARRAY_A');
		
		return $result;
	}
	
	function get_auction_ajax(){
		global $wpdb;

		if(!empty($model_ar=$this->get_model())){
			$model='';
			foreach($model_ar as $k){
				$model.="'".$k['model']."', ";
			}
			$model=rtrim($model, ', ');	
		}
		$result=$wpdb->get_results("SELECT DISTINCT `auction_hall` FROM `wp_cars_bid_list` 
		WHERE `user_id`='".$this->user_profile['user_id']."' AND `mark`='".$this->param['make']."' AND `model` IN (".$model.")", 'ARRAY_A');		
		return ['auction'=>$result, 'model'=>$model_ar];
	}
	
	function clearall_bid($selected){
		global $wpdb;
		
		$sql="UPDATE `wp_cars_bid_list` SET `cleared`='1' WHERE `user_id`='".$this->user_profile['user_id']."' AND `stock_id` IN ('".implode('\', \'', $selected)."')";	
		$wpdb->query($sql);
	}
	
	function cancel_bid($selected){
                global $wpdb;
                
		$sql="UPDATE `wp_cars_bid_list` SET `bid_status`='8' WHERE `user_id`='".$this->user_profile['user_id']."' AND `stock_id` IN ('".implode('\', \'', $selected)."')";   
                $result=$wpdb->query($sql);
        }
	function del_list(){
                global $wpdb;
                
		$result=$wpdb->query($wpdb->prepare("DELETE FROM `wp_cars_bid_list` WHERE `user_id`='%d' AND `stock_id`='%s' AND lot_number='%d'", $this->user_profile['user_id'], $this->param['stockid'], $this->param['lotnum']));
                return $result;
        }
		
	
}
?>
