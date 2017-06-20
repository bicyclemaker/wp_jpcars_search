<?php 

$site_url = site_url();

$body = '

<div class="detail-top-row">
	<div class="row">
		<div class="column large-2 detail-top-link">
			<a class="bid_history" href="'.$site_url.'/my-bid-history/" target="_blank">My Bid History</a>
		</div>
		<div class="column large-2 detail-top-link">
        		<a class="watch_list" href="'.$site_url.'/my-watch-list/" target="_blank">Watch List</a>
		</div>
		<div class="column large-2 detail-top-link">
        		<a class="purchased_vehicles" href="'.$site_url.'/my-purchased-vehicles/" target="_blank">My Purchased Vehicles </a>
		</div>
		<div class="column large-2 detail-top-link">
        		<a class="update_profile" href="'.$site_url.'/update-profile/" target="_blank">Update Profile</a>
		</div>
		<div class="column large-3 detail-top-link">	
			<a class="trans_auct_sheets" href="'.$site_url.'/translated-auction-sheets/" target="_blank" >Translated Auction Sheets</a>
		</div>
	</div>
</div>

<div class="row">
        <div class="column large-7">
                <h1 class="page-header">'.$card->mark.' '.$card->model.'</h1>
        </div>';

	if(empty($this->user_profile['bid_allow'])){
       
		$body.='<div class="column large-3">
                	<div class="row">
				<div class="column large-12" style="padding:2px;">
                                	<a align="center" style="font-size:18; line-height:33px;">Start Price : <span style="color:white;"> '.number_format($card->start_price).'</span></a>    
                        	</div>
                	</div>
                	<div class="row">
                        	<div class="column large-12" style="padding:2px;">
					<a align="center" style="font-size:18">Get subscription, which give you access to placing 3 bids per day until winning auction.</a>  
                        	</div>
                 	</div>
        		</div>
        		<div class="column large-2">
                		<div class="detail-paypal">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="LQDFQKNNCMMF4">
						<input type="hidden" name="custom" value="51"/>
						<input type="image" src="http://japan-direct.eu/wp-content/uploads/2017/05/Subscribe-Paypal-Button2.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
                			</div>
        			</div>
			</div>';

	}elseif(!empty($this->user_profile['bid_day_access']) && !empty($this->user_profile['bid_left'])){
	
		$body.='<div class="column large-3">
                		<div class="row">
                        		<div class="column large-12" style="padding:2px;">
                                		<a align="center" style="font-size:18; line-height:33px;">Start Price : <span style="color:white;"> '.number_format($card->start_price).'</span></a>    
                        		</div>
				</div>
				<div class="row">
                        		<div class="column large-12" style="padding:2px;">
                                		<a align="center" style="font-size:18; line-height:33px; color:#cccc86;">Today you are able to do '.$this->user_profile['bid_left'].' bids </span></a>    
                        		</div>
                		</div>
			</div>';
	}else{
	 
		$body.='<div class="column large-5">
                		<div class="row">
                        		<div class="column large-12" style="padding:2px;">
                                		<a align="center" style="font-size:18; line-height:33px;">Start Price : <span style="color:white;"> '.number_format($card->start_price).'</span></a>    
                        		</div>
                		</div>
                		<div class="row">
                        		<div class="column large-12" style="padding:2px;">
                                		<a align="center" style="font-size:18; color:#cccc86;">Today you are used all allowed bids. You can update bids or make new ones on next day.</span></a>    
                        		</div>
                		</div>
			</div>';
	}

$body.='</div>

<div class="row">
	<div class="column large-6">
		<div class="row">
			<div id="dpd-main" class="column large-12" data-stock="'.$card->stock_id.'" data-lotid="'.$card->lot_number.'">
			<table class="detail-panel-default" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody><tr>
              		<td align="center">                                     
                                        <div class="detail-preview">';

//$pic=preg_replace("/(http:\/\/)(?!japan-direct)()/", "$0img.japan-direct.eu/$2", $card->photo_url);
//$pic.='?p1='.$card->stock_id;
$pic='http://1.ajes.com/ban/';
					 $body.='<img id="large_img" src="'.(!empty($pic) ? $pic : '').'" style="width:500px;height:375px;padding:1px;border:1px solid #000000">
                                        </div>
                                   </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">

                                        <ul style="padding:0;list-style:none; max-width:500px;>';


$body.='<li style="float:left; width:125px; text-align:center;"> <li style="float:left; width:125px; text-align:center;">
        <a href="'.$pic.'" class="highslide" onclick="return hs.expand(this)">
        <img style="width:111px;height:90px;border:1px solid #000000;padding:1px" onmouseover="javascript:document.getElementById(\'large_img\').src = \''.$pic.'\'" src="'.$pic.'">
        </a></li>';

if(!empty($this->image)){
	foreach($this->image as $key=>$im){
	
	//$pic=preg_replace("/(http:\/\/)()/", "$0japan-direct.eu:8081/$2", $im->photo_url);
	//$pic=preg_replace("/(http:\/\/)(?!japan-direct)()/", "$0img.japan-direct.eu/$2", $im->photo_url);
	//$pic.='?p2='.$card->stock_id;
	$pic='http://1.ajes.com/ban/';

	$body.='<li style="float:left; width:125px; text-align:center;"> <li style="float:left; width:125px; text-align:center;">
	<a href="'.$pic.'" class="highslide" onclick="return hs.expand(this)">
	<img style="width:111px;height:90px;border:1px solid #000000;padding:1px" onmouseover="javascript:document.getElementById(\'large_img\').src = \''.$pic.'\'" src="'.$pic.'">
        </a></li>';
	}
}
         $body.='<div style="clear:both"></div>
                                        </ul>	
                                    </td>
				</tr>
				</tbody></table>
			</div>
		</div>
		
		
		<div class="row detail-btn-func">

<div class="column large-3">';
	$body.='<a aria-expanded="true" href="#" data-toggle="tab"><button id="add-to-watch" type="submit" class="detail-btn" data-chk="'.(!empty($this->chk_watch) ? 'done': 'empty').'">'.(!empty($this->chk_watch) ? 'ON YOUR WATCH LIST' : 'ADD TO WATCH LIST' ).'</button></a>
</div>
<div class="column large-3">
        <a href="./market_price_data.php?marka_name=*markaN*&model_name=*modelN*&year=*yearN*"><button type="submit" class="detail-btn">MARKET PRICE</button></a>
</div>
<div class="column large-3">
       	<a href="'.$site_url.'/search-auction-detail/printview/?stockid='.$card->stock_id.'&auction='.urlencode($card->auction_hall).'&lot='.$card->lot_number.'"><button type="submit" class="detail-btn">PRINT PAGE</button></a>
</div>	
<div class="column large-3">
        <a href="#"><button type="submit" class="detail-btn">SAVE AS PDF</button></a>
</div>
		</div>
	
	</div>
											    
	<div class="column large-6">
	
	<table class="detail-panel-default" border="0" cellpadding="0" cellspacing="1" width="100%">
            <tbody><tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Auction Date</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->date.'            </td>
        </tr>
                                        <tr>
                                    <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                                        <font class="list_heading_text" style="font-weight:normal;">Time</font>
                                    </td>
                                    <td class="td_left_padding smallred_inq" align="left">
                                '.$card->auction_time.'                                    </td>
                                </tr>
                                        <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Lot Number</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->lot_number.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Auction Hall</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->auction_hall.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Year</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->year.'           </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Make</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->make.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Model</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->model;
		$body.=(!empty($card->model_grade) ? ' '.$card->model_grade : '').'</td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Auction Grade</font>
            </td>
            <td class="td_left_padding" align="left">
        '.(!empty($card->auction_grade) ? $card->auction_grade : '-').'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Transmission</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->transmission.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Engine CC</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->engine_cc.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Mileage (Km)</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->mileage.',000            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Color</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->color.'             </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Chassis Model</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->chassis_and_accecories.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Start Price</font>
            </td>
            <td class="td_left_padding" align="left">
        '.number_format($card->start_price).'          </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Result</font>
            </td>
            <td class="td_left_padding" align="left">
        '.number_format($card->result).'           </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Status</font>
            </td>
            <td class="td_left_padding" align="left">
        -            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Auction Grade</font>
            </td>
            <td class="td_left_padding" align="left">
        '.$card->auction_grade.'            </td>
        </tr>
                <tr>
            <td class="caption_list_heading" align="left" height="30" valign="middle" width="50%">
                <font class="list_heading_text" style="font-weight:normal;">Accessories</font>
            </td>
            <td class="td_left_padding" align="left">
        -            </td>
        </tr>
        					
                            </tbody></table>
			    
	</div>
</div><!-- end row-->	

<div class="row">
	<div class="column large-8">
		<div class="row">
			<div class="column large-6">
	
			
		<div class="panel detail-panel-default">
		<div class="panel-heading">Make Bid</div>
		<div class="panel-heading">Starting bid : '.number_format($card->start_price).'</div>	
		<div>
		<form name="forms" id="form-make-bid" action=""  enctype="multipart/form-data">
			<div class="form-group">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Bid</label>
							<input id="inp-bid" class="form-control" min="'.$card->start_price.'" required  data-tooltip data-options="disable-for-touch: true" title="Bid should be equal or bigger than initial" name="bid">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Currency</label>
							<select class="form-control currency" name="currency">
								<option selected="selected">JPY</option>
								<option>USD</option>
							</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Messages</label>
					<textarea class="form-control" rows="3" name="messages"></textarea>
					<p class="help-block">Input your message here.</p>
			</div>
			<button id="btn-make-bid" type="submit" class="btn btn-default">Submit</button>
			<div id="detail-bid-answ" class="form-group"></div>
		</form>
		</div>
		</div>
	
		<div class="panel detail-panel-default">
               		<div class="panel-heading">Inquiry</div>
                    	<div>
                        <form name="forms" id="forms" action="API/inquiry.php" method="GET" enctype="multipart/form-data">
                        	<div class="form-group">
                                                <label>Messages</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                                <p class="help-block">Input your message here.</p>
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                         </form>
                        </div>
                </div>


			</div>
	
	
		<div class="column large-6">
			
			<div class="panel detail-panel-default">
				<div class="panel-heading">
					AUCTION FOB PRICE
				</div>
			<div>
				
				<table id="detail-table-fob">
					
					<tbody><tr style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" height="25"><th width="70%">Description</th><th align="right" width="30%">JPY&nbsp;</th></tr>
						<tr>
							<td class="td_padding">Your Bidding Amount </td>
							<td class="td_padding" align="right">
								<input style="width:80px; text-align:right" id="bidding_amount_calc" value="5,000" class="format_money" onkeyup="calculate_fob();" align="right" type="text">
							</td>
						</tr>
						
						<tr><td colspan="2" class="td_padding" style="padding-left:20px">
							Choose Vehicle: <br>
							<input name="charges_type" id="car" value="1" style="margin:5px;" onclick="change_shipping_charge(this.value);" checked="checked" type="radio">&nbsp;Passenger Car, SUV and Van
							<br>
							<input name="charges_type" id="truck" value="2" style="margin:5px;" onclick="change_shipping_charge(this.value);" type="radio">&nbsp;Truck, Big Truck and Big Van
						</td></tr>	
						<tr>	
							<td class="td_padding" width="70%">Domestic Transportation Fee</td>
							<td class="td_padding" align="right" width="30%"><input style="width:80px; text-align:right" id="domestic" value="10,000" onkeyup="calculate_fob();" class="format_money" align="right" type="text">
								<input id="auc_hall_car_value" value="10,000" type="hidden">
								<input id="auc_hall_truck_value" value="20,000" type="hidden">
							</td>
						</tr>
						<tr>
							<td class="td_padding">Custom Clearance</td>
							<td class="td_padding" align="right"><input style="width:80px; text-align:right" id="custom" value="20,000" onkeyup="calculate_fob();" class="format_money" align="right" type="text">
								<input id="CarCharges" value="20,000" type="hidden">
								<input id="TruckCharges" value="50,000" type="hidden">
							</td>
						</tr>
						<tr>
							<td class="td_padding">Service Charge</td>
							<td class="td_padding" align="right">
							20,000						</td>
							</tr><input id="service_charge" value="20,000" type="hidden"><tr>
							<td class="td_padding">Handling Fee</td>
							<td class="td_padding" align="right">
							10,000						</td>
							</tr><input id="handling_fee" value="10,000" type="hidden"><tr>
							<td class="td_padding">Auction Fee</td>
							<td class="td_padding" align="right">
								30,000							
							</td>
							</tr><input id="auction_fee" value="30,000" type="hidden"><tr><td class="td_padding">Inspection
								<select name="inspection_charge" id="inspection_charge" style="width:80px" onchange="ChangeInspectionCharge(this);">
								<option selected="selected" value="">None</option><option value="26000">JAAI</option><option value="26000">JEVIC</option></select>
							</td><td class="td_padding" id="inpsection_chrg" align="right">0</td></tr><tr>
							<td class="td_padding">Service Charge</td>
							<td class="td_padding" align="right">30,000</td>
						</tr><input id="otc" value="30000" type="hidden">
						<tr style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"><td class="td_padding">FOB Cost : </td><td class="td_padding" align="right"><label id="total_fob">125,000</label></td></tr>
						<!--<tr  style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"><td colspan="2" class="td_padding smallred_inq">NOTE - Special price if paid with in 5 days. </td></tr>-->
					</tbody>
				</table>
				
			</div>
		</div>
	</div>

	</div>
        
<div class="row">
        <div class="column large-12">
                <div class="panel detail-panel-default detail-table-sheet">
                        <div class="row">
                                <div class="column large-12">
                                        <div class="panel-heading">
                                                <font class="list_heading_text">Auction Inspection Sheet Description</font>
                                        </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="column large-6">
                                        <div style="margin:auto; width: 96%;">
                                                <table>
                                                        <tbody>
                                <tr>
                                        <td valign="top" width="5%"><strong>A1</strong></td>
                                        <td valign="top" width="40%">Small Scratch</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>A2</strong></td>
                                        <td valign="top" width="40%">Scratch</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>A3</strong></td>
                                        <td valign="top" width="40%">Big Scratch</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>E1</strong></td>
                                        <td valign="top" width="40%">Few Dimples</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>E2</strong></td>
                                        <td valign="top" width="40%">Several Dimples</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>E3</strong></td>
                                        <td valign="top" width="40%">Many Dimples</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>U1</strong></td>
                                        <td valign="top" width="40%">Small Dent</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>U2</strong></td>
                                        <td valign="top" width="40%">Dent</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>U3</strong></td>
                                        <td valign="top" width="40%">Big Dent</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr><td valign="top" width="5%"><strong>B2</strong></td>
                                        <td valign="top" width="40%">Big Distortion on (radiator) core support or back panel</td></tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>Y1</strong></td> 
                                        <td valign="top" width="40%">Small Hole or Crack</td></tr>
                                        <tr><td height="5"></td>
                                </tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>Y2</strong></td>
                                        <td valign="top" width="40%">Hole or Crack</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>Y3</strong></td>
                                        <td valign="top" width="40%">Big Hole or Crack</td>
                                </tr>
                                <tr><td height="5"></td></tr>                                                 
                                <tr>
                                        <td valign="top" width="5%"><strong>X</strong></td>
                                        <td valign="top" width="40%">Crack on Windshield (needs to be replaced)</td>
                                </tr>
                        </tbody>
                </table>
        </div>
        </div>
        
        <div class="column large-6">
                <table class="normaltext_gr td_padding" border="0" cellpadding="0" cellspacing="0" width="96%">
                        <tbody><tr></tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>W1</strong></td>
                                        <td width="40%"> Repair Mark/Wave (hardly detectable)</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>W2</strong></td>
                                        <td valign="top" width="40%">Repair Mark/Wave</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>S1</strong></td>
                                        <td valign="top" width="40%">Rust</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>S2</strong></td>
                                        <td valign="top" width="40%">Heavy Rust</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>C1</strong></td>
                                        <td valign="top" width="40%">Corrosion</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>C2</strong></td>
                                        <td valign="top" width="40%">Heavy Corrosion</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>X</strong></td>
                                        <td valign="top" width="40%">Need to be replaced</td>
                                </tr>
                                        <tr><td height="5"></td>
                                </tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>XX</strong></td>
                                        <td valign="top" width="40%">Replaced</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>B1</strong></td>
                                        <td valign="top" width="40%">Distortion on (radiator) core support or back panel (approximately size of a thumb)</td></tr>          
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>X1</strong></td>
                                        <td valign="top" width="40%">Small Crack on Windshield (approximately 1cm)</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>R</strong></td>
                                        <td valign="top" width="40%">Repaired Crack on Windshield</td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                        <td valign="top" width="5%"><strong>RX</strong></td>
                                        <td valign="top" width="40%">Repaired Crack on Windshield (needs to be replaced)</td>
                                </tr>
                        </tbody>
                </table>
                                                        
                                                 
        </div>                                                         
                </div>
        </div>
</div>

</div>
</div>	
	<div class="column large-4">
	    	<div>
			<div class="panel detail-panel-default">
				<div class="panel-heading"> EXCISE DUTY CALCULATOR </div>
				<div>
					<table id="tbl-calc-choose">
						<tbody>
						    <tr>
							    <td>
								    Choose Vehicle:
								    <br>
								    <input value="passenger" type="radio" checked="checked" onclick="edCalc.changeTblCalc(this.value)" name="change_vehicle">
								        Passenger Car
								    <br>
								    <input value="double-cabin" type="radio" onclick="edCalc.changeTblCalc(this.value)" name="change_vehicle">
								        Van, Double Cabin
								    <br>
								    <input value="motorcycle" type="radio" onclick="edCalc.changeTblCalc(this.value)" name="change_vehicle">
								        Motorcycles
								    <br>
								    <input value="license" type="radio" onclick="edCalc.changeTblCalc(this.value)" name="change_vehicle">
								        License 2014
							    </td>
							    <td id="view-mode" style="display:none">
							        View mode:
							        <br>
							        <input value="full" type="radio" onclick="edCalc.viewMode(this.value)" name="view_mode">
								        Full
								    <br>
								    <input value="minimal" type="radio" onclick="edCalc.viewMode(this.value)" name="view_mode">
								        Minimal
								    <br>

							    </td>
						    </tr>
						</tbody>
					</table>
				</div>
				<div>
					<table id="tbl-calc-passenger" style="display: none">
						<tbody>
							<caption style="text-align:center">EXCISE DUTY PAYABLE FOR PASSENGER VEHICLE</caption>
							<tr>
							    <td class="td_padding td-colspan" style="border-top:2px solid #73ba5d" colspan="2">PART A: NEW OR USED PASSENGER VEHICLE</td>
							</tr>
							<tr>
                                <td>Body type of vehicle:</td>
                                <td>
                                    <select onchange="edCalc.redBalance()" id="body-type-vehicle">
                                        <option value="" selected="selected">#CHOICES#</option>
                                        <option value="1">CABRIO</option>
                                        <option value="2">COUPE</option>
                                        <option value="3">H/BACK - VAN</option>
                                        <option value="4">SEDAN</option
                                        <option value="5">ESTATE</option>
                                        <option value="6">ALL TERRAIN VEHICLE - SUV</option>
                                    </select>
                                </td>
							</tr>
							<tr>
							    <td>Engine Displacement (c.c):</td>
							    <td>
								    <input id="tbl-engine-disp" onkeyup="edCalc.additionalED()" value="'.$card->engine_cc.'" type="text">
							    </td>
							</tr>
							<tr>
							    <td>CO2 Emission (combined cycle):</td>
							    <td><input onkeyup="edCalc.initialED()" value="0" id="tbl-co2-em" type="text"></td>
							</tr>
							<tr style="display:none">
							    <td>Initial Excise Duty:</td>
							    <td id="tbl-initial-ed">0,00</td>
							</tr>
							<tr style="display:none">
							    <td>Additional Excise Duty (0,02/c.c):</td>
							    <td id="tbl-additional-ed">0.00</td>
							</tr>
							<tr>
							    <td>FINAL EXCISE DUTY LIABILITY FOR NEW VEHICLE</td>
							    <td id="tbl-final-new-vehicle">0.00 &euro;</td>
							</tr>
							<tr>
							    <td colspan="2" class="td-colspan">PART B: REDUCTIONS OF EXCISE DUTY FOR USED VEHICLE</td>
							</tr>
							<tr>
							    <td colspan="2" style="text-align:center">Vehicle Age Calculator</td></tr>
							<tr>';

$date_first_reg='15/06/'.$card->year;
$date_taxation = new DateTime($card->auction_time);
$date_taxation->modify('+3 month');
$date_tax=$date_taxation->format('d/m/Y');
							   $body.='<td>Date of first Registration</td><td><input id="tbl-calc-date1" autocomplete="off"  onkeyup="edCalc.diffDays()" size="20" maxlength="10" type="text" placeholder="12/25/2001" value="'.$date_first_reg.'">DD/MM/YYYY</td></tr>
							<tr>
							<td>Date of taxation</td><td><input id="tbl-calc-date2" autocomplete="off"  onkeyup="edCalc.diffDays()" maxlength="10"  type="text" placeholder="12/25/2002" value="'.$date_tax.'">DD/MM/YYYY</td></tr>
							<tr style="display:none">
							    <td>Vehicle age (in days)</td><td id="tbl-calc-vehage">0.00</td></tr>
							<tr style="display:none">
							    <td>Reduction % on excise duty balance</td><td id="tbl-calc-redbal">0.00</td></tr>
							<tr style="display:none">
							    <td>Reduction according to vehicle age and body type</td><td id="tbl-reduction-according">0.00</td></tr>
							<tr>
							    <td>Fuel</td>
                                <td>
                                    <select id="tbl-fuel" onchange="edCalc.fuel()">
                                        <option value="" selected="selected">#CHOICES#</option>
                                        <option value="1">Petrol</option>
                                        <option value="2">Diesel</option>
                                    </select>
                                </td>
                            </tr>
							<tr>
							    <td>Distance covered (km)</td><td><input onkeyup="edCalc.fuel()" autocomplete="off" id="tbl-dist-covered" value="'.$card->mileage.'000" type="text"></td></tr>
							<tr style="display:none">
							    <td>% reduction of E.D. for high mileage</td><td id="tbl-high-mileage">0.00</td></tr>
							<tr style="display:none">
							    <td>Amount of reduction</td><td id="tbl-amount-reduction">0.00</td></tr>
							<tr style="display:none">
							    <td>Total km on common use</td><td id="tbl-total-km">0.00</td></tr>
							<tr style="display:none">
							    <td>Maximum authorised amount of reduction for high mileage</td><td id="tbl-maximum-hm">0.00</td></tr>
							<tr>
							    <td>FINAL EXCISE DUTY LIABILITY FOR USED PASSENGER CARS</td><td id="tbl-final-used">0.00 &euro;</td></tr>
							<tr style="display:none">
							    <td colspan="2" id="tbl-analysis" class="td-colspan" style="text-align:center">ANALYSIS OF EXCISE DUTY PAYABLE</td></tr>
							<tr style="display:none">
							    <td>Initial Excise Duty</td><td id="tbl-final-initial-ed">0.00</td></tr>
							<tr style="display:none">
							    <td>Reduction according to vehicle age and body type:</td><td id="tbl-final-according">0.00</td></tr>
							<tr style="display:none">
							    <td>Reduction amount for high mileage:</td><td id="tbl-final-red-hm">0.00</td></tr>
							<tr style="display:none">
							    <td>Excise Duty Balance</td><td id="tbl-final-edb">0.00</td></tr>
							<tr style="display:none">
							    <td>Additional Exc. Duty (0,02/c.c)</td>
							    <td id="tbl-final-add-ed">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>FINAL EXCISE DUTY LIABILITY</td>
							    <td id="tbl-final">0.00 &euro;</td>
							</tr>
						</tbody>
					</table>
					<table id="tbl-calc-double-cabin" style="display: none">
						<tbody>
						    <caption>EXCISE DUTY PAYABLE ON DOUBLE CABIN</caption>
						    <tr>
							    <td class="td_padding td-colspan" colspan="2" style="border-top:2px solid #73ba5d">PART A: NEW DOUBLE CABIN OR VAN VEHICLE</td>
							</tr>
							<tr>
                                <td>Body type of vehicle:</td>
                                <td>
                                    <select onchange="edCalc.edRate()" id="tbl2-body-vehtype">
                                        <option value="" selected="selected">#CHOICES#</option>
                                        <option value="1">DOUBLE CABIN</option>
                                        <option value="2">VAN</option>
                                    </select>
                                </td>
							</tr>
							<tr>
							    <td>Engine Displacement (c.c):</td>
							    <td>
								    <input id="tbl2-engine-disp" onkeyup="edCalc.edRate()" value="'.$card->engine_cc.'" type="text">
							    </td>
							</tr>
							<tr style="display:none">
							    <td>Excise Duty Rate €/cc</td>
							    <td id="tbl2-ed-rate">0,00</td>
							</tr>
							<tr style="display:none">
							    <td>Initial Excise Duty:</td>
							    <td id="tbl2-initial-ed">0,00</td>
							</tr>
							<tr style="display:none">
							    <td>Additional Excise Duty (0,02/c.c):</td>
							    <td id="tbl2-additional-ed">0.00</td>
							</tr>
							<tr>
							    <td>FINAL EXCISE DUTY LIABILITY FOR NEW CAR</td>
							    <td id="tbl2-final-new-car">0.00 &euro;</td>
							</tr>
							<tr>
							    <td colspan="2" class="td-colspan">PART B: REDUCTIONS OF EXCISE DUTY FOR USED  VEHICLE</td>
							</tr>
							<tr>
							    <td colspan="2">Vehicle Age Calculator</td>
							</tr>
							<tr>
							    <td>Date of first Registration</td>
							    <td><input id="tbl2-calc-date1" autocomplete="off"  onkeyup="edCalc.diffDays2()" maxlength="10" placeholder="12/25/2001" type="text" value="'.$date_first_reg.'" ><BR>MM/DD/YYYY</td>
							</tr>
							<tr>
							    <td>Date of taxation</td><td><input id="tbl2-calc-date2" autocomplete="off"  onkeyup="edCalc.diffDays2()" maxlength="10" placeholder="12/25/2002" value="'.$date_tax.'" type="text"><BR>MM/DD/YYYY</td>
							</tr>
							<tr style="display:none">
							    <td>Vehicle age (in days)</td><td id="tbl2-calc-vehage">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction % on excise duty balance</td>
							    <td id="tbl2-calc-redbal">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction according to vehicle age and body type</td>
							    <td id="tbl2-reduction-according">0.00</td>
							</tr>
							<tr>
							    <td>Fuel</td>
                                <td>
                                    <select id="tbl2-fuel" onchange="edCalc.fuel2()">
                                        <option value="" selected="selected">#CHOICES#</option>
                                        <option value="1">Petrol</option>
                                        <option value="2">Diesel</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
							    <td>Distance covered (km)</td>
							    <td><input onkeyup="edCalc.fuel2()" autocomplete="off" id="tbl2-dist-covered" value="'.$card->mileage.'000" type="text"></td>
							</tr>
							<tr style="display:none">
							    <td>% reduction of E.D. for high mileage</td>
							    <td id="tbl2-high-mileage">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Amount of reduction</td>
							    <td id="tbl2-amount-reduction">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Total km on common use</td>
							    <td id="tbl2-total-km">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Maximum authorised amount of reduction for high mileage</td>
							    <td id="tbl2-maximum-hm">0.00</td>
							</tr>
							<tr>
							    <td>FINAL EXCISE DUTY LIABILITY FOR USED CAR</td>
							    <td id="tbl2-final-used">0.00 &euro;</td>
							</tr>
							<tr style="display:none">
							    <td colspan="2" id="analysis2" class="td-colspan" style="text-align: center">ANALYSIS OF EXCISE DUTY PAYABLE</td>
							</tr>
							<tr style="display:none">
							    <td>Initial Excise Duty</td>
							    <td id="tbl2-final-initial-ed">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction according to vehicle age and body type:</td>
							    <td id="tbl2-final-according">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction amount for high mileage:</td>
							    <td id="tbl2-final-red-hm">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Excise Duty Balance</td>
							    <td id="tbl2-final-edb">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Additional Exc. Duty (0,02/c.c)</td>
							    <td id="tbl2-final-add-ed">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>FINAL EXCISE DUTY LIABILITY</td>
							    <td id="tbl2-final">0.00 &euro;</td>
							</tr>

                        </tbody>
					</table>
					<table id="tbl-calc-motorcycle" style="display: none">
						<tbody>
						    <caption>EXCISE DUTY PAYABLE FOR MOTORCYCLE</caption>
						    <tr>
							    <td class="td_padding td-colspan" colspan="2" style="border-top:2px solid #73ba5d">PART A: NEW OR USED MOTORCYCLES</td>
							</tr>
							<tr>
							    <td>Engine Displacement (c.c):</td>
							    <td>
								    <input id="tbl3-engine-disp" onkeyup="edCalc.edRate3()" value="'.$card->engine_cc.'" type="text">
							    </td>
							</tr>
							<tr style="display:none">
							    <td>Excise Duty Rate €/cc</td>
							    <td id="tbl3-ed-rate">0,00</td>
							</tr>
							<tr style="display:none">
							    <td>Initial Excise Duty:</td>
							    <td id="tbl3-initial-ed">0,00</td>
							</tr>
							<tr>
							    <td>FINAL EXCISE DUTY LIABILITY FOR NEW MOTORCYCLES:</td>
							    <td id="tbl3-final-new-mcycles">0.00 &euro;</td>
							</tr>
							<tr>
							    <td colspan="2" class="td-colspan">PART Β: REDUCTIONS ON USED MOTORCYCLES</td>
							</tr>
							<tr>
							    <td colspan="2">Age Calculator</td>
							</tr>
							<tr>
							    <td>Date of first Registration</td>
							    <td><input id="tbl3-calc-date1" autocomplete="off"  onkeyup="edCalc.diffDays3()" maxlength="10" placeholder="12/25/2001" value="'.$date_first_reg.'" type="text"><BR>MM/DD/YYYY</td>
							</tr>
							<tr>
							    <td>Date of taxation</td>
							    <td><input id="tbl3-calc-date2" autocomplete="off"  onkeyup="edCalc.diffDays3()" maxlength="10" placeholder="12/25/2002" value="'.$date_tax.'" type="text"><BR>MM/DD/YYYY</td>
							</tr>
							<tr style="display:none">
							    <td>Total number of days:</td>
							    <td id="tbl3-calc-vehage">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction % </td>
							    <td id="tbl3-calc-red-percent">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction </td>
							    <td id="tbl3-calc-reduction">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Excise Duty Balance </td>
							    <td id="tbl3-calc-edbalance">0.00</td>
							</tr>
							<tr>
							    <td>Distance covered (km)</td>
							    <td><input onkeyup="edCalc.highMileage()" autocomplete="off" id="tbl3-dist-covered" value="'.$card->mileage.'000" type="text"></td>
							</tr>
							<tr style="display:none">
							    <td>Total km on common use</td>
							    <td id="tbl3-total-km">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>% reduction of E.D. for high mileage</td>
							    <td id="tbl3-high-mileage">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Amount of reduction</td>
							    <td id="tbl3-amount-reduction">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Maximum authorised amount of reduction for high mileage</td>
							    <td id="tbl3-maximum-hm">0.00</td>
							</tr>
							<tr>
							    <td>TOTAL EXCISE DUTY LIABILITY FOR USED MOTORCYCLES</td>
							    <td id="tbl3-final-used">0.00 &euro;</td>
							</tr>
							<tr style="display:none">
							    <td colspan="2" id="analysis3" class="td-colspan" style="text-align:center">ANALYSIS OF EXCISE DUTY PAYABLE</td>
							</tr>
							<tr style="display:none">
							    <td>Initial Excise Duty</td>
							    <td id="tbl3-final-initial-ed">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction according to motorcycle age</td>
							    <td id="tbl3-final-according">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>Reduction amount for high mileage:</td>
							    <td id="tbl3-final-red-hm">0.00</td>
							</tr>
							<tr style="display:none">
							    <td>FINAL EXCISE DUTY LIABILITY</td>
							    <td id="tbl3-final">0.00 &euro;</td>
							</tr>
                        </tbody>
                    </table>
                    <table id="tbl-calc-license" style="display: none">
                        <tbody>
                            <caption>Calculation End Traffic for class M1 or N1 * vehicle * vehicle derived from M1 category vehicle and ranks in light VAN type truck category, with recording date from 01/01/2014 onwards</caption>
                            <tr><td colspan="2" class="td-colspan" style="border-top:1px solid #252525"></tr>
                            <tr style="border-top:2px solid #73ba5d">
                                <td>Enter emissions (CO2) your vehicle:</td>
                                <td><input id="tbl4-co2" onkeyup="edCalc.license()" value="0" type="text"></td>
                            </tr>
                            <tr>
                                <td>Annual Marketing Authorisation Amount:</td>
                                <td id="tbl4-annual">72 &euro;</td>
                            </tr>
                            <tr>
                                <td>Amount six-month Marketing Authorisation</td>
                                <td id="tbl4-sixmonth">39 &euro;</td>
                            </tr>
                            <tr>
							    <td colspan="2" class="td-colspan" style="text-align:center">INFORMATION TABLE</td>
							</tr>
							<tr>
							    <td>Part of carbon - dioxide CO2 emitted mass (Combined) in grams per kilometer (gr / Km)
the motor vehicle:</td>
							    <td>Coefficient<br>(Euro per gram/per kilometer (gr/Km))</td>
							</tr>
							<tr>
							    <td>For mass of less than or equal to 120 (gr / Km)</td>
							    <td>0.5</td>
							</tr>
							<tr>
							    <td>For mass of more than 120 (gr / Km) and less than or equal to 150 (gr / Km)</td>
							    <td>3</td>
							</tr>
							<tr>
							    <td>For mass of more than 150 (gr / Km)
and less than or equal to 180 (gr / Km)</td>
							    <td>3</td>
							</tr>
							<tr>
							    <td>For mass of more than 180 (gr / Km)</td>
							    <td>8</td>
							</tr>
							<tr>
							    <td colspan="2" class="td-colspan"></td>
							</tr>
							<tr>
							    <td>* Category</td>
							    <td>Description</td>
							</tr>
							<tr>
							    <td>M1</td>
							    <td>Vehicles designed and constructed for the carriage of passengers and comprising more than eight seating positions in addition to the drivers seat</td>
							</tr>
							<tr>
							    <td>N1</td>
							    <td>Vehicles designed and constructed for the carriage of goods and having a maximum mass not exceeding 3.5 tonnes</td>
							</tr>

                        </tbody>
                    </table>
				</div>
			</div>
		</div>

	</div>

	</div>
</div><!--end row-->
	
</div>
'; ?>
