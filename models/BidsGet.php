<?php 
class BidsGet {
	
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

	private function compose_query_where($data){
		
		$query=array();
		
		if($data['lotnum']!==null){
                        $query['lotnum']="list.lot_number='".$data['lotnum']."'";
                }
		if($data['stockid']!==null){
			$query['stockid']="list.stockid='".$data['stockid']."'";
		}
		
		if($data['max_year']!==null && $data['min_year']===null){
                        $query['year']="list.year<='".$data['max_year']."'";
                }
                if($data['max_year']===null && $data['min_year']!==null){
                        $query['year']="list.year>='".$data['min_year']."'";
                }
                if($data['max_year']!==null && $data['min_year']!==null){
                        $query['year']="list.year BETWEEN '".$data['min_year']."' AND '".$data['max_year']."'";
                }
		
		if($data['make']!==null){
                        $query['make']="list.mark='".$data['make']."'";
                }
		if($data['model']!==null){
                	$query['model']="list.model='".$data['model']."'";
                }

		if($data['auction_hall']!==null){
			$query['auction_hall']="list.auction_hall='".$data['auction_hall']."'";	
		}			
		
		if($data['create-start']!==null && $data['create-end']===null){
                        $query['create']="MaxDates.MaxDate>='".$data['create-start']."'";
                }
                if($data['create-start']===null && $data['create-end']!==null){
                        $query['create']="MaxDates.MaxDate<='".$data['create-end']."'";
                }
                if($data['create-start']!==null && $data['create-end']!==null){
                        $query['create']="MaxDates.MaxDate BETWEEN '".$data['create-start']."' AND '".$data['create-end']."'";
                }

		if($data['auction-start']!==null && $data['auction-end']===null){
                        $query['auction_time']="list.auction_time>='".$data['auction-start']."'";
                }
                if($data['auction-start']===null && $data['auction-end']!==null){
                        $query['auction_time']="list.auction_time<='".$data['auction-end']."'";
                }
                if($data['auction-start']!==null && $data['auction-end']!==null){
                        $query['auction_time']="list.auction_time BETWEEN '".$data['auction-start']."' AND '".$data['auction-end']."'";
                }
		if($data['bid_status']!==null){
                        $query['bid_status']="list.bid_status='".$data['bid_status']."'";
                }	
		
		$condition='';	
		
		if(!empty($query)){
                       	foreach($query as $key=>$qr){
				$condition.=' AND (' .$qr.')';
                     	}
                 }
		return $condition;
	}

	function get_list($param){
		global $wpdb;
		$where=$this->compose_query_where($param);	
		$query_body="FROM wp_cars_bid_list AS list 
		INNER JOIN (SELECT list_id, MAX(date_create) MaxDate FROM wp_cars_bid_fund group by list_id) MaxDates 
			ON list.id=MaxDates.list_id AND list.user_id='".$this->user_profile['user_id']."' 
			AND list.cleared!='1' ".(!empty($where) ?  $where : '')."  
		INNER JOIN wp_cars_bid_fund as fund2 ON MaxDates.list_id=fund2.list_id AND MaxDates.MaxDate=fund2.date_create";
		
		$query='SELECT list.*, fund2.* '.$query_body.' ORDER BY list.id DESC';
		$query_cnt='SELECT count(*) as cnt '.$query_body;

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
			
			return ['carlist'=>$result_carlist, 'car_total'=>$carstotal['cnt'], 'pg_total'=>$pagetotal];
		}
		return null;
	}
}
?>
