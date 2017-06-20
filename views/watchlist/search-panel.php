<div id="watch-listing" class="search-listing">
<div class="watchlist_header">
	<div class="row">
		<div class="large-3 column form-column small-11 small-centered large-centered">
			<p class="watchlist_title">My Watch List</p>
		</div>
	</div>
</div>


<form accept-charset="utf-8" id="watch-search-form" class="custom" method="post" action="">
<div class="row search-listing-form">
	<div class="large-3 column form-column small-11 small-centered large-uncentered">
        	<label for="manufacturer_make">Make</label>
                	<select class="select-dark hidden-field" name="manufacturer_make" id="manufacturer_make">
                        	<option selected="selected" value="any">Any</option>
                        <?php	if(!empty($mark=$this->db_get_mark())){
				foreach($mark as $key=>$mark){ ?>
					<option value="<?php echo $mark['mark']; ?>"><?php echo $mark['mark'];?></option>				<?php 	}} ?>
                	</select>
                	<div class="custom dropdown select-dark">
                        	<a class="current" href="#">Any</a>
                        	<a class="selector" href="#"></a>
                        	<ul>
                                	<li class="selected">Any</li>
                        	</ul>
                	</div>
	</div>

	<div class="large-3 column form-column small-11 small-centered large-uncentered">
        	<label for="manufacturer_model">Model</label>
                	<select class="select-dark hidden-field" name="manufacturer_model" id="manufacturer_model">
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
	<div class="large-3 column form-column small-11 small-centered large-uncentered">
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
	<div class="large-3 column form-column small-11 small-centered large-uncentered">
        	<label for="auction_hall">Auction</label>
        	<select class="select-dark hidden-field" name="auction_hall" id="auction_hall">
                	<option selected="selected" value="any">Any</option>
                
		<?php   if(!empty($auction=$this->db_get_auction())){	
			foreach($result as $key=>$auction){ ?>
				<option value="<?php echo $auction['auction_hall']; ?>"><?php echo $auction['auction_hall']; ?></option>';
		<?php  }} ?>
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
	<div class="column large-3 small-11 show-for-medium-up">
                <label for="create-start">Create Date</label>
		<div class="watch-date-range">
			<input type="text" id="create-start" name="create-start" value="">
			<span class="watch-sim">&sim;</span>
			<input type="text" id="create-end" name="create-end" value="">
		</div>
        </div>
	<div class="column large-3 small-11 show-for-medium-up">
		<label for="search-lot-number">Lot Number</label>
		<input type="text" id="search-lot-number" name="search-lot-number" value="">
	</div>
	<div class="column large-offset-6 hide-for-small show-for-medium-up">
        </div>
</div>

<div class="row">
	<div class="column large-4 large-centered small-11 small-right wrap-watch-but">
		<div class="row">
			<div class="column large-6 small-12 large-uncentered small-centered">
				<input id="watch-search" type="submit" class="button expand small flat blue radius" value="Search" name="">
			</div>
        		<div class="column large-6 small-12 large-uncentered small-centered">
              			<input id="watch-reset" type="submit" class="button expand small flat blue radius" value="Reset" name="">
        		</div>
		</div>
</div>



</div>
</form>

</div>
<div id="watch-cars-table">
<?php 

include_once('result-table.php');

?>
</div>
