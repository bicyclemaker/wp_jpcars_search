<?php  if(!empty($wishcar) && array_key_exists('result_list', $wishcar)){

	if(!empty($pagin=$wishcar['pagin'])) {?>
	 <div class="column large-12 small-12 large-centered small-centered">
		<div class="column large-2">
                        <div class="watch-tab-l" style="text-align:center; display:inline-flex;" >
                                <p class="tab-select"><a id="watchtab-select">Select All</a></p>
                                <p class="tab-clear"><a id="watchtab-clear">Clear</a></p>
                	</div> 
		</div>
		<div class="column large-8" style="text-align:center">
		<div class="center-block" style="display: table; margin:0 auto; ">
			<nav>
			<ul class="pagination" id="jpcars-pagin-watch" style="text-align: center;  ">
			      <?php echo $pagin['pagin']; ?>
			</ul>
			</nav>
		</div>
		</div>
		<div class="column large-2 large-uncentered small-12 small-centered ">
			<p class="tab-stat">Cars on your list: <?php 
			echo $pagin['car_total']; ?><br>Total pages: <?php echo $pagin['pg_total'];?> </p>
		</div>
	</div>
<?php } ?>

<table id="watchlist" style="width:1020px; margin: 20px auto;">
	<thead>
		<tr>
			<th>#</th>
			<th>Auction Time</th>
			<th>Lot Number</th>
			<th>Make</th>
			<th>Model and Grade</th>
			<th>Engine cc</th>
			<th>Year</th>
			<th>Mileage</th>
			<th>Auction_grade</th>
		</tr>
	</thead>
	<tbody>
<?php
$ech='';
$siteurl=get_site_url();
foreach($wishcar['result_list'] as $car){
	$ech.='<tr>';
		$ech.='<td><input type="checkbox" value="'.$car['stock_id'].'" name="selected[]" style="vertical-align: text-bottom;"></td>';

	$ech.='<td>'.$car['auction_time'].'</td>
		<td><a href="'.$siteurl.'/search-auction-detail/?stockid='.$car['stock_id'].'&auction='.$car['auction_hall'].'&lot='.$car['lot_number'].'">'.$car['lot_number'].'</a> </td>
		<td>'.$car['mark'].'</td>
		<td>'.$car['model'].' '.$car['model_grade'] .'</td>
		<td>'.$car['engine_cc'].'</td>
		<td>'.$car['year'].'</td>
		<td>'.$car['mileage'].'</td>
		<td>'.$car['auction_grade'].'</td>';

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
