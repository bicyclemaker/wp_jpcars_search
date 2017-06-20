<?php

//For getting rows from db from home search panel.

class HomeSearchCars{

	function get_cars_from_db($data){
                
		global $wpdb;
	
	//compose query
                $select_count='SELECT count(*) FROM wp_cars_new1 as cr';
                $select='SELECT';
		$field=' cr.id as ids, cr.stock_id as stock_id, cr.year as year, cr.lot_number as lot_number, cr.year as year, cr.mileage as mileage, cr.start_price as start_price, cr.transmission as transmission, cr.engine_cc as engine_cc, cr.color as color, cr.auction_time as auction_time, cr.model_grade as model_grade, cr.chassis_and_accecories as chassis, cr.result as result, cr.auction_grade as auction_grade, cr.make as make, cr.photo_url as photo_url';
		$query_join=array();
		$query=array();
	//'mark' is 'make' in db
		if($data['mark']!==null && $data['model']===null){
			
			$query['mark']="cr.id_cars_mark='".$data['mark']."'";
		}
	//model
		$query_join['model']='LEFT JOIN wp_cars_model as md ON cr.id_cars_model=md.id';
		
		$field.=', md.model as model';			

		if($data['model']!==null){
			
			$query['model']="md.id='".$data['model']."'";
		}
	//transmission
                if($data['trans']!==null){
                        $query_join['trans']='LEFT JOIN wp_cars_trans as trans ON cr.id_trans=trans.id';
                        $query['trans']="trans.id='".$data['trans']."'";
                }
	
	//auction_hall		
		$query_join['auction_hall']='LEFT JOIN wp_cars_auction_hall as hall ON cr.id_auction_hall=hall.id';	
		
		$field.=', hall.auction_hall as auction_hall';		

		if($data['auction_hall']!==null){
			$query['auction_hall']="hall.id='".$data['auction_hall']."'";
		}
	//color
                if($data['color']!==null){
                        $query_join['color']='LEFT JOIN wp_cars_color as color ON cr.id_color=color.id';
			$query['color']="color.id='".$data['color']."'";
		}
	//year
                if($data['min_year']!==null && $data['max_year']!==null){
                        $sql_year="cr.year BETWEEN '".$data['min_year']."' AND '".$data['max_year']."'";
                }
                if($data['min_year']!==null && $data['max_year']===null){
                        $sql_year="cr.year>='".$data['min_year']."'";
                }
                if($data['min_year']===null && $data['max_year']!==null){
                        $sql_year="cr.year<='".$data['max_year']."'";
                }

                if(isset($sql_year)){
                        $query['sql_year']=$sql_year;
                }	

	//price		
		if($data['min_price']!==null && $data['max_price']!==null){
			$sql_price="cr.start_price BETWEEN '".$data['min_price']."' AND '".$data['max_price']."'";
		}
		if($data['min_price']!==null && $data['max_price']===null){
			$sql_price="cr.start_price>='".$data['min_price']."'"; 
		}
		if($data['min_price']===null && $data['max_price']!==null){
			$sql_price="cr.start_price<='".$data['max_price']."'";
		}
		
		if(isset($sql_price)){
			$query['sql_price']=$sql_price;
		}
	
	//mileage
		if($data['min_mileage']!==null && $data['max_mileage']!==null){
                        $sql_mileage="cr.mileage BETWEEN '".$data['min_mileage']."' AND '".$data['max_mileage']."'";
                }
                if($data['min_mileage']!==null && $data['max_mileage']===null){
                        $sql_mileage="cr.mileage>='".$data['min_mileage']."'";
                }
                if($data['min_mileage']===null && $data['max_mileage']!==null){
                        $sql_mileage="cr.mileage<='".$data['max_mileage']."'";
                }

                if(isset($sql_mileage)){
                        $query['sql_mileage']=$sql_mileage;
                }

	//engine
		if($data['min_engine']!==null && $data['max_engine']!==null){
                        $sql_engine="cr.engine_cc BETWEEN '".$data['min_engine']."' AND '".$data['max_engine']."'";
                }
                if($data['min_engine']!==null && $data['max_engine']===null){
                        $sql_engine="cr.engine_cc>='".$data['min_engine']."'";
                }
                if($data['min_engine']===null && $data['max_engine']!==null){
                        $sql_engine="cr.engine_cc<='".$data['max_engine']."'";
                }

                if(isset($sql_engine)){
                        $query['sql_engine']=$sql_engine;
                }
	//lot number 
		if($data['lot_number']!==null){
			$query['lot_number']="cr.lot_number='".$data['lot_number']."'";
		}
	//auction_grade
		if($data['auction_grade']!==null){
                        $query['auction_grade']="cr.auction_grade='".$data['auction_grade']."'";
                }
	
	//auction_date_
		$high_date='';
		for($i=1;$i<7;$i++){
			if(isset($data["auction_date_$i"])){
				if(empty($high_date)){
					$high_date=$data["auction_date_$i"];
				}else{
					$high_date=(($high_date>$data["auction_date_$i"]) ? $high_date : $data["auction_date_$i"]);		
				}
			}	
		}
		if(!empty($high_date)){
			 $sql_auction_date="cr.auction_time <='".$high_date."'";
			 $query['auction_time']=$sql_auction_date;
		}
	
	//model_name
                $query_join['model']='LEFT JOIN wp_cars_model as md ON cr.id_cars_model=md.id';

                $field.=', md.model as model';

                if($data['model']!==null){

                        $query['model']="md.id='".$data['model']."'";
                }
	

	
	//assamble part of JOINs
		$join='';
		if(!empty($query_join)){
			foreach($query_join as $key=>$qr){
				$join.=' '.$qr.' ';
			}
		}
	//add WHERE, AND	
		$where=' WHERE ';
                $condition='';
                
		if(!empty($query)){
			foreach($query as $key=>$qr){
                       		if(isset($where)){
                               		$condition.=$where.' ('.$qr.')';
                               		unset($where);
                       		}else{
                               		$condition.=' AND ('.$qr.')';
                       		}
                	}
		}
	// assamble part of query		
		$sql=(isset($join) ?  $join : '' ).$condition;
		$sqlcount=$select_count.$sql;
		$select.=$field.' FROM wp_cars_new1 as cr';	
		$sql=$select.(isset($join) ?  $join : '' ).$condition;
	//pagination
		$carstotal=$wpdb->get_var($sqlcount);
		//echo ' $sqlcount = '.$sqlcount.' ; ';
		//echo ' $carstotal = '.$carstotal;
		if($carstotal>0){
			
			$pg_limit=$data['pg_limit'];
	                $pg_current=$data['pg_current'];
			
			if($pg_current>1){
				
				$offset = ( $pg_current - 1 ) * $pg_limit;
			}else{
			
				$offset = 0;
			
			}
			
			$pagetotal=ceil($carstotal / $pg_limit);
			
			$sql.=' ORDER BY cr.id LIMIT '.$offset.','.$pg_limit;	
			
			$result_carlist=$wpdb->get_results($sql);
			
			//echo '  $sql = '.$sql.'  ';
			unset($data);
			return ['carlist'=>$result_carlist, 'car_total'=>$carstotal, 'pg_total'=>$pagetotal];
		}else{
		
			return false;
		
		}
	}
	
	function getCarMark(){

                global $wpdb;
                $make=$wpdb->get_results('SELECT * FROM wp_cars_mark ORDER BY mark ASC');
                return $make;
        }
	
	function getCarModel($make_id){

                global $wpdb;
                $model=$wpdb->get_results($wpdb->prepare("SELECT md.id, md.model FROM wp_cars_mark as mk INNER JOIN wp_cars_model as md WHERE mk.id='%d' AND md.id_cars_mark=mk.id ORDER BY model ASC", $make_id));
                return $model;
        }
	
	function getAuctionHall(){

                global $wpdb;
                $auction=$wpdb->get_results('SELECT * FROM wp_cars_auction_hall ORDER BY auction_hall ASC');
                return $auction;
        }
	
	function getTransmission(){

                global $wpdb;
                $trans=$wpdb->get_results('SELECT * FROM wp_cars_trans ORDER BY trm ASC');
                return $trans;
        }
	
	function getColor(){

                global $wpdb;
                $color=$wpdb->get_results('SELECT * FROM wp_cars_color ORDER BY car_color ASC');
                return $color;
        }

	function getImg($ids, $stock_id){

                global $wpdb;
                $images=$wpdb->get_results($wpdb->prepare("SELECT * FROM wp_cars_img WHERE stock_id='%s'", $stock_id));
		return $images;
	}

	function postFb($selected){

                global $wpdb;
                $sql='UPDATE `wp_cars_new1` SET `post_to_fb`=1 WHERE `id` IN ('.implode(', ', $selected).')';
                if (($result=$wpdb->query($sql))!==false){
                        return true;
                } 
                return false;
                
        }



	
}


