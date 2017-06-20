
<?php if(!empty($bidcar) && array_key_exists('result_list', $bidcar)){

	if(!empty($pagin=$bidcar['pagin'])) {?>
	 <div class="column large-12 small-12 large-centered small-centered">
		<div class="column large-2"><p align="right">
                        <div class="watch-tab-l" style="text-align:center; display:inline-flex;" >
                                <p class="tab-select">><a id="bidtab-select">Select All</a></p>
                                <p class="tab-clear"><a id="bidtab-clear">Clear</a></p>
                                <input id="bidtab-btn-cancel" type="button"  value="Cancel My Bids" name="cancel_bids">
                        </div>
                </div>
		<div class="column large-8" style="text-align:center;z-index:1;">
			<div class="center-block" style="display: table; margin:0 auto;">
				<nav>
				<ul class="pagination" id="jpcars-pagin-bid" style="text-align: center;">
					<?php echo $pagin['pagin'];?>
				</ul>
				</nav>
			</div>
		</div>
		<div class="column large-2 large-uncentered small-12 small-centered ">
			<p class="tab-stat">Cars on your list: <?php 
			echo $pagin['car_total']; ?><br>Total pages: <?php echo $pagin['pg_total'];?></p>
		</div>
	</div>
	
	<?php } ?>

<table id="bidlist" style="width:1020px; margin: 20px auto;">
	<thead>
		<tr>
			<th>#</th>
			<th>Bid Order Date</th>
			<th style="width:90px;">Auction Date</th>
			<th>Lot No.<br>Auction</th>
			<th>Make/Model/Grade</th>
			<th>Engine cc</th>
			<th>Year</th>
			<th>Mileage</th>
			<th>Color</th>
			<th>Auction grade</th>
			<th>Bid Start Price (JPY)</th>
			<th>Your Bid Offer</th>
			<th style="width:120px;">Status</th>
		</tr>
	</thead>
	<tbody>
<?php
//$this->sort_option_list();
$ech='';
$siteurl=get_site_url();
$i=1;
foreach($bidcar['result_list'] as $car){
	$ech.='<tr>';
	$ech.='<td><input type="checkbox" value="'.$car['stock_id'].'" name="selected[]" style="vertical-align: text-bottom;"></td>
		<td>'.$car['date_create'].'</td>
		<td>'.$car['auction_time'].'</td>
		<td><a href="'.$siteurl.'/search-auction-detail/?stockid='.$car['stock_id'].'&auction='.$car['auction_hall'].'&lot='.$car['lot_number'].'" >'.$car['lot_number'].'</a> </td>
		<td>'.$car['mark'].' '.$car['model'].' '.$car['model_grade'] .'</td>
		<td>'.$car['engine_cc'].'</td>
		<td>'.$car['year'].'</td>
		<td>'.$car['mileage'].'</td>
		<td>'.$car['color'].'</td>
		<td>'.$car['auction_grade'].'</td>
		<td>'.number_format($car['start_price']).'</td>
		<td>'.number_format($car['bid']).'</td>';
		
		switch($car['bid_status']){
			case 1:
				$bid_status='Pending';
				break;
			case 2:
                                $bid_status='Sold';
                                break;
			case 3:
                                $bid_status='Cancelled';
                                break;
			case 4:
                                $bid_status='Purchased';
                                break;
			case 5:
                                $bid_status='Under Negotiation';
                                break;
			case 6:
                                $bid_status='Not Sold';
                                break;
			case 7:
                                $bid_status='Sold to Other';
                                break;
			case 8:
                                $bid_status='Pending for Cancel';
                                break;
	
		}

	$ech.='<td><span style="color:#144604;">'.$bid_status.'</span>
		<br>
			<input id="bidtab-btn-update" type="button" value="Update Bid Price" name="update-bid" data-ids="'.$car['stock_id'].'" data-lot="'.$car['lot_number'].'" data-sp="'.$car['start_price'].'" data-at="'.$car['auction_time'].'" data-hp="'.$car['bid'].'">
		</td>';

	$ech.='</tr>';
}
	echo $ech;
?>
	</tbody>
</table>
<?php 
	}elseif(empty($this->check_user())){
		echo '<a href="'.get_home_url().'/my-profile/login/" class="login-must">Please login</a>';
	}else{
		echo '<p style="color:#fff; text-align:center;">nothing in your list.</p>';
	}
?>
