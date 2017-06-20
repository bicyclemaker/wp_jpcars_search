<div class="search-listing" id="search-listing">
	<div class="row">
	<div class="column large-12 small-12 small-centered large-uncentered main-search">
		
		<form accept-charset="utf-8" id="search-listing-form" class="custom" method="post" action="">
			<div class="row search-listing-form">
				<div class="column large-10 small-12 large-uncentered small-centered">

<div class="row search-listing-form">

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="manufacturer_level1">Make</label>
		<select class="select-dark hidden-field" name="manufacturer_level1" id="manufacturer_level1">
			<option selected="selected" value="any">Any</option>
			<?php 
			if(!empty($make=$this->getCarMark())){
				foreach($make as $key=>$mk){
                        		echo '<option value="'.$mk->id.'">'.$mk->mark.'</option>';
                		}
			}
			?>
		</select>
		<div class="custom dropdown select-dark">
			<a class="current" href="#">Any</a>
			<a class="selector" href="#"></a>
			<ul>
				<li class="selected">Any</li>
			</ul>
		</div>
</div>

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="manufacturer_level2">Model</label>
		<select class="select-dark hidden-field" name="manufacturer_level2" id="manufacturer_level2">
			<option selected="selected" value="any">Any</option>
		</select>
		<div class="custom dropdown select-dark">
			<a class="current" href="#">Any</a>
			<a class="selector" href="#"></a>
			<ul>
				<li class="selected">Any</li>
			</ul>
		</div>
</div>

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="property_mileagesize">Mileage
		<span id="min_mileagesize_text" class="price-text text-min"></span>
		<span id="max_mileagesize_text" class="price-text text-max"></span>
	</label>
	<div class="price-slider-wrapper"> 
		 <div id="mileagesize-slider-range" class="range-slider" data-type="mileagesize" data-step="5000" data-min="0" data-max="500000">
		</div>	
		<div class="row">
			<div class="column large-6">
				<input id="min_mileagesize" type="hidden" value="" name="min_mileagesize">
			</div>
			<div class="column large-6">
				<input id="max_mileagesize" type="hidden" value="" name="max_mileagesize">
			</div>

		</div>

	</div>
</div>

</div>
<div class="row search-listing-form">

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="property_pricesize">Price Range
		<span id="min_pricesize_text" class="price-text text-min"></span>
		<span id="max_pricesize_text" class="price-text text-max"></span>
	</label>
	
	<div class="price-slider-wrapper">
		<div id="pricesize-slider-range" class="range-slider" data-type="pricesize" data-step="1000" data-min="0" data-max="20000000"> 
		</div>
		<div class="row">
			<div class="column large-6">
				<input id="min_pricesize" type="hidden" value="0" name="min_pricesize">
			</div>
			<div class="column large-6">
				<input id="max_pricesize" type="hidden" value="20000000" name="max_pricesize">
			</div>
		</div>
	</div>
</div>

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="transmission">Transmission</label>
		<select class="select-dark hidden-field" name="transmission" id="transmission">
			<option selected="selected" value="any">Any</option>
			<?php
			if(!empty($trans=$this->getTransmission())){	
				foreach($trans as $tr){
					echo '<option value="'.$tr->id.'">'.$tr->trm.'</option>';
                		}
			}
			?>
		</select>
	<div class="custom dropdown select-dark">
		<a class="current" href="#">Any</a>
		<a class="selector" href="#"></a>
		<ul>
			<li class="selected">Any</li>
		</ul>
	</div>
</div>

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="auction_hall">Auction</label>
	<select class="select-dark hidden-field" name="auction_hall" id="auction_hall">
		<option selected="selected" value="any">Any</option>
		<?php
		if(!empty($auction=$this->getAuctionHall())){
			foreach($auction as $au){
				echo '<option value="'.$au->id.'">'.$au->auction_hall.'</option>';
			}
		}	
		?>	
	</select>
	<div class="custom dropdown select-dark">
		<a class="current" href="#">Any</a>
		<a class="selector" href="#"></a>
			<ul>
				<li class="selected">Any</li>
			</ul>
	</div>
</div>
</div>

<div class="row search-listing-form">

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="color">Color</label>
	<select class="no-mbot select-dark hidden-field" name="color" id="color">
		<option selected="selected" value="any">Any</option>
		<?php
		if(!empty($color=$this->getColor())){
			foreach($color as $col){
                       		echo '<option value="'.$col->id.'">'.$col->car_color.'</option>';
               		}
		}
		?>
	</select>
	<div class="custom dropdown no-mbot select-dark">
		<a class="current" href="#">Any</a>
		<a class="selector" href="#"></a>
			<ul>
				<li class="selected">Any</li>
			</ul>
	</div>
</div>


<div class="large-4 column form-column small-11 small-centered large-uncentered">
        <label for="engine_displacement">Engine displacement</label>
        <select class="select-dark hidden-field" name="engine_displacement" id="engine_displacement">
      			<option selected="selected" value="any">Any</option>
                        <option value="0-1000">0-1000cc</option>
                        <option value="1001-1500">1001-1500cc</option>
                        <option value="1501-2000">1501-2000cc</option>
                        <option value="2001-2500">2001-2500cc</option> 
			<option value="2501-3000">2501-3000cc</option>
			<option value="3001-3500">3001-3500cc</option>	
			<option value="3501-4000">3501-4000cc</option> 		
			<option value="4001-4500">4001-4500cc</option>	
			<option value="4501-0">4500cc Over</option>		
		 
	</select>
        <div class="custom dropdown select-dark">
                <a class="current" href="#">Any</a>
                <a class="selector" href="#"></a>
                        <ul>
                                <li class="selected">Any</li>
			</ul>
        </div>
</div>


<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="property_yearsize">Year
        	<span id="min_yearsize_text" class="price-text text-min"></span>
		<span id="max_yearsize_text" class="price-text text-max"></span>
	</label>
	<div class="price-slider-wrapper">
		<div id="yearsize-slider-range" class="range-slider" data-type="yearsize" data-step="1" data-min="1986" data-max="<?php echo date("Y");?>">
		</div>
		<div class="row">	
			<div class="column large-6">
				<input id="min_yearsize" type="hidden" value="" name="min_yearsize">
			</div>
			<div class="column large-6">		
				<input id="max_yearsize" type="hidden" value="" name="max_yearsize">
			</div>
		</div>
	</div>
</div>
</div>

<div class="row search-listing-form">
<?php  
        function getWeekDate($days){
                global $wpdb;
                $nowday=date('l');
                $dat=date("Y-m-d",strtotime("$days"));
                $output=' value="'.$dat.'" ';
		return $output;
        }
?>   


<div class="large-8 column form-column small-11 small-centered large-uncentered">
	 <div id="search-auction-day">
		<ul>
                        <li class=""><input type="checkbox" id="mon" <?php echo getWeekDate('Monday'); ?>  name="auction_date_1" onchange="//filter_auction(this.form);" /><label for="mon">Monday</label></li>
                        <li class=""><input type="checkbox" id="tue" <?php echo getWeekDate('Tuesday'); ?> name="auction_date_2" onchange="//filter_auction(this.form);"  /><label for="tue">Tuesday</label></li>
                        <li class=""><input type="checkbox" id="wed" <?php echo getWeekDate('Wednesday'); ?> name="auction_date_3" onchange="//filter_auction(this.form);"  /><label for="wed"> Wednesday</label></li>
                        <li class=""><input type="checkbox" id="thur" <?php echo getWeekDate('Thursday'); ?> name="auction_date_4" onchange="//filter_auction(this.form);"  /><label for="thur">Thursday</label></li>
                        <li class=""><input type="checkbox" id="fri" <?php echo getWeekDate('Friday'); ?> name="auction_date_5" onchange="//filter_auction(this.form);"  /><label for="fri">Friday</label></li>
                        <li class=""><input type="checkbox" id="sat" <?php echo getWeekDate('Saturday'); ?> name="auction_date_6" onchange="//filter_auction(this.form);"  /><label for="sat">Saturday</label></li>
                </ul>
	</div>
</div>	

<div class="large-4 column form-column small-11 small-centered large-uncentered">
	<label for="auction_grade">Auction grade</label>
		<select class="select-dark hidden-field" name="auction_grade" id="auction_grade">
                        <option selected="selected" value="any">Any</option>
                        <option value="-">-</option>
                        <option value="*">*</option>
                        <option value="***">***</option>
                        <option value="///">///</option>
                        <option value="000">000</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="99">99</option>
                        <option value="G">G</option>
                        <option value="R">R</option>
                        <option value="R1">R1</option>
                        <option value="R2">R2</option>
                        <option value="RA">RA</option>
                        <option value="RA2">RA2</option>
                        <option value="RB">RB</option>
                        <option value="RC">RC</option>
                        <option value="Ri">Ri</option>
                        <option value="RS">RS</option>
                        <option value="S">S</option>
                        <option value="W">W</option>
                        <option value="WR">WR</option>
                        <option value="X">X</option>
        	</select>
        <div class="custom dropdown select-dark">
                <a class="current" href="#">Any</a>
                <a class="selector" href="#"></a>
                        <ul>
                                <li class="selected">Any</li>
                        </ul>
        </div>
</div>

</div>



</div>


<div class="column large-2 small-12 large-uncentered small-centered">

<!--div class="column large-1 show-for-medium-up" id="zoom-icon-find"-->
	<div class="row">
		<div class="column large-12 small-11 show-for-medium-up">
			 <label for="search-lot-number">Lot Number</label>
			<input type="text" id="search-lot-number" name="search-lot-number" value="">
			
		</div>
	</div>
	<div class="row">
		<div class="column large-12 small-11 show-for-medium-up" id="zoom-icon-find">
			<i class="sha-zoom search-icon"></i>
		</div>
	</div>

	<div class=row>
		<div id="submit-button" class="column large-12 small-11 large-uncentered small-centered">
			<!--input type="hidden" value="fc907148f7" name="search_nonce" id="search_nonce">
			<input type="hidden" value="/used-cars-2/" name="_wp_http_referer"-->
			<input type="submit" class="button expand small flat blue radius" value="Find Car" name="">
		</div>
	</div>

</div>





</div>
</form>		
</div>
</div>
</div>

