<?php if(isset($cardata)){ ?>
	
<div class="column large-12 small-12 large-centered small-centered">
	<div class="column large-9" style="text-align:center">
		<?php if($pagination['pg_total'] < $pagination['pg_limit']){
			$margin_right=round(34-(2.5* $pagination['pg_total']));
		}else{
			$margin_right=0;
		}?>

		<div class="center-block" style="display: table; margin:0 <?php echo $margin_right.'%'; ?> 0 auto; ">
		<nav>
			<ul class="pagination" id="jpcars-pagin-top" style="text-align: center; ">
				<?php  echo $pagination['pagin']; ?>
			</ul>
		</nav>
		</div>
	</div>	
	<div class="column large-3 large-uncentered small-12 small-centered ">	
		<p style="float:left; clear:left; margin-left:12px;">Total pages: <?php echo $pagination['pg_total']; ?>&nbsp; &nbsp;<br>Total Records Found: <?php echo $pagination['car_total']; ?></p>
	</div>
</div>


<div class="column large-12">
<div class="row">
<div class="column large-12 large-uncentered small-11 small-centered bon-builder-element-carlistings">
<div id="listings-container" class="row">
<div class="column large-12 large-uncentered ">
	<ul class="listings small-block-grid-1 large-block-grid-4">
<?php

$tile='';
$siteurl=get_site_url();

foreach($cardata as $key=>$rec){
	//if($user_profile['user_status']=='guest' || $user_profile['user_status']=='none' || $user_profile['user_status']=='admin'){
	//if($user_status=='guest' || $user_status=='none'){
			$url=' href="'.$siteurl.'/search-auction-detail/?stockid='.$rec->stock_id.'&auction='.$rec->auction_hall.'&lot='.$rec->lot_number.'"';
             //   }else{
	//		$url=' href="'.$siteurl.'/my-profile/login/"';
                	//$url='';
	//	}
	
	switch ($rec->auction_grade){
                case '***':
                        $blok_color='badge-red';
                        break;
                case ((preg_match('/R/i', $rec->auction_grade) ? true : false ) ||  ($rec->auction_grade<3)) :
                        $blok_color='badge-orange';
                        break;
                case ($rec->auction_grade>=3 && $rec->auction_grade<4) :
                        $blok_color='badge-yellow';
                        break;
                case ($rec->auction_grade==4 || $rec->auction_grade==4.5) :
                        $blok_color='badge-blue';
                        break;
                case ('S' || '5' || '6'):
                        $blok_color='badge-green';
                        break;
		case ('99'):
                        $blok_color='red';
                        break;
		case ('-'):
			$blok_color='badge-gray';
                        break;

        }
	//$pic=$rec->photo_url;	
	//$pic=preg_replace("/(http:\/\/)(?!japan-direct)()/", "$0img.japan-direct.eu/$2", $rec->photo_url);
        //$pic.='?p1='.$rec->stock_id;	
	 $pic='http://1.ajes.com/ban/';
	//$pic=json_encode(htmlentities( $rec->photo_url, ENT_QUOTES));
	$pict=json_encode(htmlentities( 'src":"'.$rec->photo_url, ENT_QUOTES));
	$carmark=$rec->make.' '.$rec->model.' '.$rec->model_grade;	

	$tile.='<li class="hentry car-listing publish post-1 odd author-admin '.$blok_color.'">	
<header class="entry-header img-prv">
	
<div id="preview-popup-link-'.$rec->ids.'">
	<a class="preview-popup-link" title=\''.$carmark.'\' href="#">
		<img class="thumbnail-preview" id="'.$rec->stock_id.'" data-ids="'.$rec->ids.'" alt=\''.$carmark.'\' src=\''.$pic.'\' itemprop="image" data-imgset="">
	</a>
</div>
	<div class="badge '.$blok_color.'">
		<span style="font-size:16px; margin-top: -35%; margin-left: 26%;">AUCTION </span>
		<span style="font-size:16px; margin-top: -18%; margin-left: 30%;">GRADE </span>
		<span style="font-size:16px; margin-top: 0px; margin-left: 37%;">'.$rec->auction_grade.'</span>
	</div>
</header>
	<div class="entry-summary">
				<h1 class="entry-title" itemprop="name"><a title="'.$carmark.'" '.$url.' target="_blank">'.$carmark.'</a>
				</h1>
		<div class="entry-meta">
			<div class="icon engine">
				<i class="sha-engine"></i>
				<span>'; 
				$tile.=number_format($rec->engine_cc);
				$tile.='</span>
			</div>
			<div class="icon ic-transmission">
				<i class="sha-gear-shifter"></i>
				<span>'.$rec->transmission.'</span>
			</div>
			<div class="icon ic-year">
                                <i class="sha-calendar"></i>
                                <span>'.$rec->year.'</span>
                        </div>
			<div class="icon ic-mileage">
				<i class="sha-tire"></i>
				<span>'.$rec->mileage.',000</span>
			</div>
			<div class="icon ic-lot-number">
                                <i class="sha-info"></i>
                                <span>Lot Number: '.$rec->lot_number.'</span>
                        </div>
			<div class="icon ic-auction-grade">
                                <i class="sha-car-front"></i>
                                <span>Auction Grade: '.$rec->auction_grade.'</span>
                        </div>	
			<div class="icon ic-auction-time">
                                <i class="sha-clock-2"></i>
                                <span>Auction Date: '.$rec->auction_time.'</span>
                        </div>';
			
			if($user_profile['user_status']=='admin'){ //additional checkbox for posting on facebook page
                        	$tile.='<br><div class="icon" style="margin-bottom: 0.8em; margin-top:0.5em">
						<label id="post-to-fb" ><i class="sha-facebook">Post to Facebook</i>
							<input type="checkbox" value="'.$rec->ids.'" name="selected[]" 
								style="vertical-align: text-bottom;">
						</label>
					</div>';
			
			}
		$tile.='</div>
	</div>
	<footer class="entry-footer">
		<div class="property-price">
			<a title="'.$carmark.'" '.$url.' target="_blank">
				<span itemtype="http://schema.org/Offer" itemscope="" itemprop="offers">
					<span itemprop="price">Submit Bid</span>
					<meta content="$" itemprop="priceCurrency">
				</span>
			</a>
		</div>
	</footer>';
	$tile.='</li>';
}
echo $tile;
?>
	</ul>
</div></div></div></div></div>

<div class="column large-12 small-12 large-centered small-centered">
	<div class="column large-9" style="text-align:center">
		<div class="center-block" style="display: table; margin:0 <?php echo $margin_right; ?>% 0 auto; ">
			<nav>
			<ul class="pagination" id="jpcars-pagin-bottom" style="text-align: center;  ">
				<?php  echo $pagination['pagin']; ?>
			</ul>
			</nav>
		</div>
	</div> 
</div>

</div>


<?php 

if($user_profile['user_status']=='admin'){  //additional buttons for posting on facebook page
                $buttons='<div class="column large-12"><div class="row entry-row">';
                $buttons.='<div class="column large-5 large-uncentered small-11 small-right"><p align="right"><button id="select-all" type="submit" value="select-all" class="button small flat green radius">Select all</button></a></p></div> ';
                $buttons.='<div class="column large-2 large-uncentered small-11 small-centered"><p align="right" style="margin-right:25px;"><button id="save-selected" value="save-selected" class="button small flat blue radius" type="submit">Save Selected</button></p></div>';
                $buttons.='<div class="column large-3 large-uncentered small-11 small-centered"><p align="right" style="margin-right:25px;"><button id="postfb" type="submit" value="postfb" class="button small flat red radius">Post \'one\' of the selected RightNow!</button></a></p></div>';
                $buttons.='</div></div>';

                echo $buttons;
}
?>



<script>

jQuery(document).ready(function(){

	jQuery("a.preview-popup-link img").click(function(evt){
		evt.preventDefault();
		var fimg=jQuery(this);
		var flink=fimg.attr('src');
		var imgid=fimg.attr('id');
		var ids=fimg.attr('data-ids');
		var imgset =fimg.attr('data-imgset');
		var spinner;
		if (imgset == null || imgset =='' ) {
        	
			jQuery.ajax({
				xhr: function(){		
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
					spinner=progressbar(ids);		  
				}
				}, false);
			return xhr;
			},
			type: 'POST',
                        cache: false,
                        url: jpcar.ajax_url,
                        dataType: 'json',
                        data: '&action=jpcar&getimg='+imgid+'&ids='+ids+'&nonce='+jpcar.nonce,
  			success: function(data){
				spinner.stop();
				if(data.success==true){
                                        var arr=data.data.getimg;
                                        arr=jQuery.parseJSON(arr);
                                        links=[];
                                        links.push({"src" : flink});
                                        for(var i=0; arr.length>i; i++){
                                                links.push(arr[i]);
                                        }
                                        var links_txt=JSON.stringify(links);
                                        fimg.attr('data-imgset', links_txt);
                                        magnific(links);
                         	}
			}
		});

		}
		if(imgset != undefined && imgset != null && imgset !=''){ 
			var links_obj=JSON.parse(imgset);	
			magnific(links_obj);	
		
		
		
		}

		});

<?php //if users go to detail page without success login, they will have cookie which contain id (stock_id) and lot number. ?>
		jQuery("div.property-price a").click(function(evt){
			var par_li=jQuery(this).parents("li.hentry.car-listing");
			var lot_num=par_li.find("div.icon.ic-lot-number span").text().match(/(\d{1,6})/g).toString();
			var id=par_li.find("img.thumbnail-preview").attr('id');
			jQuery.cookie('rd-data', 'lot_num='+lot_num+'&id='+id, { expires:1});
		});
});

function magnific(links){
	if(links.length>0){
		jQuery.magnificPopup.open({
			items: links,
			gallery: {
				enabled: true
			},
				type: 'image'
			});
        }
}


function progressbar(state){

if (state !='' && state != null){

var opts = {
	  lines: 9 // The number of lines to draw
	  , length: 0 // The length of each line
	  , width: 14 // The line thickness
	  , radius: 20 // The radius of the inner circle
	  , scale: 0.75 // Scales overall size of the spinner
	  , corners: 1 // Corner roundness (0..1)
	  , color: '#CCC' // #rgb or #rrggbb or array of colors
	  , opacity: 0.25 // Opacity of the lines
	  , rotate: 0 // The rotation offset
	  , direction: 1 // 1: clockwise, -1: counterclockwise
	  , speed: 1 // Rounds per second
	  , trail: 60 // Afterglow percentage
	  , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
	  , zIndex: 2e9 // The z-index (defaults to 2000000000)
	  , className: 'spinner' // The CSS class to assign to the spinner
	  , top: '50%' // Top position relative to parent
	  , left: '50%' // Left position relative to parent
	  , shadow: false // Whether to render a shadow
	  , hwaccel: false // Whether to use hardware acceleration
	  , position: 'absolute' // Element positioning
}

	var target = document.getElementById('preview-popup-link-'+state );
	var spinner = new Spinner(opts).spin(target);
	return spinner;
}
}

<?php 
if($user_profile['user_status']=='admin'){ //additional buttons handling to posting on facebook page, visible only for logged users in wp-admin or for users with level 'admin' in plugin of authorization
?>

jQuery(document).ready(function(){
	jQuery("button#select-all").click(function(evt){
		evt.preventDefault();
		var button_select=jQuery(this);
		var button_txt=button_select.text();
		if(button_txt=='Select all'){
			jQuery("label#post-to-fb input").each(function() {
				jQuery(this).prop('checked', true);
			});
			button_select.text('Deselect all');
		}
		if(button_txt=='Deselect all'){
			jQuery("label#post-to-fb input").each(function(){
				jQuery(this).prop('checked', false);
		});
		button_select.text('Select all');
  		}
	});
	jQuery("button#save-selected").click(function(evt){
		evt.preventDefault();
		var checked=jQuery("label#post-to-fb input").serialize();
		jQuery.ajax({
			type: 'POST',
			cache: false,
			url: jpcar.ajax_url,
			data: checked+'&action=jpcar&nonce='+jpcar.nonce,
		success: function(data){
			console.log(data);
			if(data.success==true){
				alert('Cars were marked in database. They will be posted accordingly cron job');
			}else{
				alert('Somthing went wrong...');
			}
		},
		error: function (jXHR, textStatus, errorThrown) {
			console.log(errorThrown);
		}
		});
	});
	jQuery("button#postfb.button").click(function(evt){
		evt.preventDefault();
		jQuery.ajax({
			type: 'POST',
			cache: false,
			url: jpcar.ajax_url,
			data: 'action=jpcar&posttofb=posting&nonce='+jpcar.nonce,
		success: function(data){
			console.log('postfb ok');
		},
		error: function (jXHR, textStatus, errorThrown) {
			console.log(errorThrown);
		}
		});
	});
});
<?php } ?>

</script>
<?php }?>
