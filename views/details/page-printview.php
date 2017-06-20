<?php $site_url = site_url();?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Your Website</title>
		<link id="bon-stylesheet-css" media="all" type="text/css" href="<?php echo $site_url;?>/wp-content/themes/shandora/style.css" rel="stylesheet">
		<link id="bon-app-css" media="all" type="text/css" href="<?php echo $site_url;?>/wp-content/themes/shandora/assets/css/all.css" rel="stylesheet">
		<link id="bon-app-css" media="all" type="text/css" href="<?php echo $site_url;?>/wp-content/themes/shandora/assets/css/colors/green.css" rel="stylesheet">
	</head>
	
	<body>

	
	<div class="print-row" style="margin-top:55px;">
		<div id="logo" class="text-logo">
                        <h3 class="uncentered" itemprop="name">
                                <a title="<?php echo get_bloginfo();?>" href="<?php $site_url ?>">Japan Direct</a>
                        </h3>   
                </div>	
		<div class="print-addr">
			<p><span class="awe-home"></span><?php echo esc_attr(bon_get_option('hgroup2_line1')); ?></p>
                        <p><span class="awe-time"></span><?php echo esc_attr(bon_get_option('hgroup2_line2')); ?></p>
			<span class="phone-p"><strong><?php echo esc_attr(bon_get_option('hgroup1_content')); ?></strong></span>
		</div>	

	</div>


	<div class="print-row">
		<div class="print-tab-h">
			<h4>VEHICLE DETAIL</h4>
		</div>
	</div>
	<div class="print-row detail-btn-func-p">
										    
	
	<table id="detail-descrp-p" border="0" cellpadding="0" cellspacing="1" width="100%">
        	<thead>
			<tr>
                                <th class="dash rline" style="width:105px;">Auction Date</th>
                                <th class="dash" style="width:105px;">Lot Number</th>
                                <th rowspan=2 style="width:85; vertical-align:top; padding-top:20px;">Year</th>
                                <th class="dash rline" style="width:83px;">Model</th>
                                <th class="dash rline" style="width:125px;">Transmission</th>
                                <th class="dash rline" style="width:83px;">Color</th>
                                <th class="dash rline" style="width:125px;">Chassis No.</th>
                                <th class="dash" style="width:125px;">Start price(JPY)</th>
				<th rowspan=2 style="width:83px; vertical-align:top; padding-top:10px;">Auction grade</th>
                        </tr>
                        <tr style="background-color: #808080; color: #FFF;">
                                        <th>Time</th>
                                        <th>Auction Hall</th>
                                        <th>Grade</th>
                                        <th>Engine cc</th>
                                        <th>Milleage</th>
                                        <th>Accessories</th>
                                        <th>Result(JPY)</th>
                        </tr>
		</thead>    

	<tbody>
	<tr>
<?php	$body='	<td class="td_left_padding" align="left">'.$card->date.'<br>'.$card->auction_time.'</td>
		<td class="td_left_padding smallred_inq" align="left">'.$card->lot_number.'<br>'.$card->auction_hall.'</td>
		<td class="td_left_padding" align="left">'.$card->year.'</td>
		<td class="td_left_padding" align="left">'.$card->make.'<br>'.$card->model; 
			$body.=(!empty($card->model_grade) ? ' '.$card->model_grade : '').$card->auction_hall.'</td>
		<td class="td_left_padding" align="left">'.$card->transmission.'<br>'.$card->engine_cc.'</td>
		<td class="td_left_padding" align="left">'.$card->color.'<br>'.$card->mileage.',000</td>
		<td class="td_left_padding" align="left">'.$card->chassis_and_accecories.'</td>
		<td class="td_left_padding" align="left">'.number_format($card->start_price).'<br>'.number_format($card->result).'</td>
		<td class="td_left_padding" align="left">'.(!empty($card->auction_grade) ? $card->auction_grade : '-').'</td>
	</tr>
 </tbody></table>
			    
	</div>
</div><!-- end row-->';	



$site_url = site_url();


$body.='<div class="print-row">
		<table id="print-tab-ph" width="100%" cellspacing="0" cellpadding="0" style="vertical-align:top;">
			<tbody>';
	

if(!empty($this->image)){
        //foreach($this->image as $key=>$im){
	$cnt=count($this->image);
	$pic_set='<tr>';		
	for($i=0;$i<$cnt;$i++){
		$pic=preg_replace("/(http:\/\/)(?!japan-direct)()/", "$0img.japan-direct.eu/$2", $this->image["$i"]->photo_url);
		$pic.='?p2='.$card->stock_id;
		if($i==1){ 
			$pic_1=preg_replace("/(http:\/\/)(?!japan-direct)()/", "$0img.japan-direct.eu/$2", $card->photo_url);
			$pic_1.=(!empty($pic_1) ? $pic_1.'?p1='.$card->stock_id : '');
	$pic_1='<img id="large_img" src="'.$pic_1.'" style="width:300px;height:240px;padding:1px;"></td></tr>';
			$pic_sec='<td valign="middle" colspan="3">'.$pic_1;			
		}
		if($i!=($cnt-1) && $i!=1){ //  add third, from 2 
			$pic_set.='<td align="center"><img style="width:125px;height:95px;padding:1px;border:1px solid #000000" src="'.$pic.'"></td>';
		}else{// add first schema
			$pic_first='<tr><td rowspan="2"><img style="width:360px;height:400px;padding:1px;border:1px solid #000000";  src="'.$pic.'"></td>';
		}
        }
	$body.=$pic_first.$pic_sec.$pic_set.'</tr></tbody></table>';
}
        
	$body.='</div>';
?>
	</body>
</html>
