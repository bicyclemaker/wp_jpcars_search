<div id="bid-listing" class="search-listing">

<div class="bidhistory_header">
        <div class="row">
                <div class="large-3 column form-column small-11 small-centered large-centered">
                        <p class="bidhistory_title">My Bid History</p>
                </div>
        </div>
</div>

<form accept-charset="utf-8" id="bid-search-form" class="custom" method="post" action="">
<div class="row">
	<div class="large-3 column form-column small-11 small-centered large-uncentered">
        	<label for="manufacturer_make">Make</label>
                	<select class="select-dark hidden-field" name="manufacturer_make" id="manufacturer_make">
                        	<option selected="selected" value="any">Any</option>
               		<?php   if(!empty($mark=$this->db_get_mark())){
                                foreach($mark as $key=>$mark){ ?>
                                     <option value="<?php echo $mark['mark']; ?>"><?php echo $mark['mark'];?></option>                               <?php   }} ?>

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
        	 <?php if(!empty($auction=$this->db_get_auction())){
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

<div class="row">
	<div class="column large-3 small-11 show-for-medium-up">
                <label for="create-start">Bid Order Date</label>
		<div class="bid-date-range">
			<input type="text" id="create-start" name="create-start" value="">
			<span class="bid-sim">&sim;</span>
			<input type="text" id="create-end" name="create-end" value="">
		</div>
        </div>
	<div class="column large-3 small-11 show-for-medium-up">
                <label for="auction-start">Auction Date</label>
                <div class="bid-date-range">
                        <input type="text" id="auction-start" name="auction-start" value="">
                        <span class="bid-sim">&sim;</span>
                        <input type="text" id="auction-end" name="auction-end" value="">
                </div>
        </div>
	<div class="column large-3 small-11 show-for-medium-up">
		<label for="search-lot-number">Lot Number</label>
		<input type="text" id="search-lot-number" name="search-lot-number" value="">
	</div>
	<div class="large-3 column form-column small-11 small-centered large-uncentered">
                <label for="bid_status">Bid Status</label>
                <select class="select-dark hidden-field" name="bid_status" id="bid_status">
                        <option selected="selected" value="any">Any</option>
			<option value="1">Pending</option>
                        <option value="2">Sold</option>
                        <option value="3">Cancelled</option>
                        <option value="4">Purchased</option>
                        <option value="5">Under Negotiation</option>
                        <option value="6">Not Sold</option>
                        <option value="7">Sold to Other</option>
                        <option value="8">Pending for Cancel</option>
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

<div class="row">
	<div>


	</div>

	<div class="column large-4 large-centered small-11 small-right wrap-bid-but">
		<div class="row">
			<div class="column large-6 small-12 large-uncentered small-centered">
				<input id="bid-search" type="submit" class="button expand small flat blue radius" value="Search" name="">
			</div>
        		<div class="column large-6 small-12 large-uncentered small-centered">
              			<input id="bid-reset" type="submit" class="button expand small flat blue radius" value="Reset" name="">
        		</div>
		</div>
</div>



</div>
</form>

<div id="bidtab-dialog" title="Update Bid Price" style="display:none">
        <form name="bidtab-dialog" id="form-make-bid" action=""  enctype="multipart/form-data">
                <table id="bidtab-dialog-t" align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                                <tr><td>Start Price</td><td></td>
                                <tr><td>Bid Date</td><td></td>
                                <tr><td>Higher Bid Price</td><td></td>
                                <tr><td>Your Bid Price</td><td>:<input id="bidtab-dialog-in" class="form-control" required  data-tooltip data-options="disable-for-touch: true"  name="dialog-bid-upd"></td>
                                <tr><td></td><td><button id="dialog-make-bid-b" type="submit" class="btn btn-default">Update</button></td>
                        </tbody>
                </table>
        </form>
</div>
</div>



<div id="bid-cars-table">
<?php 

include_once('result-table.php');

?>
</div>


