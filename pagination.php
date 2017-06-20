<?php

function jpcars_pagintaion_count($carstotal, $pg_current, $pg_limit){
	
	$pg_total=ceil($carstotal / $pg_limit);

        if($pg_current>1){
                $offset = ( $pg_current - 1 ) * $pg_limit;
        }else{
                $offset = 0;
        }
	return array('offset'=>$offset, 'pg_limit'=>$pg_limit, 'pg_total'=>$pg_total); 
	//using for sql page limitation 'LIMIT '.$offset.','.$pg_limit;
}


function jpcars_pagintaion_html($car_total, $pg_current,  $pg_total, $pg_limit){
                
		$mid=($pg_limit/2);
                $shift=$mid+1;
                if($pg_current>$shift && $pg_total>$pg_limit){
                        $start=($pg_current-$mid);
                        $end=($pg_current+$mid);
                        if(($pg_total-$pg_current)<$mid){
                                $start=$pg_total-$pg_limit;
                                $end=$pg_total+1;
                        }
                }else if($pg_current<=$shift && $pg_total>$pg_limit) {
                        $start=1;
                        $end=$pg_limit+1;
                }else{
                        $start=1;
                        $end=$pg_total+1;
                }

        $pagin='';
        if($pg_total>1){
                if($shift<$pg_current){
                        if($pg_current<=$pg_limit){
                                $prev_ofst=1;
                        }else{
                                $prev_ofst=$pg_current-$pg_limit;
                        }
                        $pagin.='<li><a href="#" aria-label="Previous" data-page='.$prev_ofst.'><span aria-hidden="true">&laquo; '.$prev_ofst. ' </span></a></li>';
                }
                for($i=$start;$i<$end;$i++){
                        if($i==$pg_current){
                                $pagin.='<li class="active"><a href="#" data-page='.$i.'><span class="sr-only">( '.$i.' )</span></a></li>';
                        }else{
                                $pagin.='<li><a href="#" data-page='.$i.'>'.$i.'</a></li>';
                        }

                }
                        $end_range=$pg_total-$pg_current+$mid;
                        if($end_range>$pg_limit){
                                if(($pg_total-$pg_current)>=$pg_limit){
                                        $next_ofst=$pg_current+$pg_limit;
                                }else{
                                        $next_ofst=$pg_total;
                                }

                                $pagin.='<li><a href="#" aria-label="Next" data-page='.$next_ofst.'><span aria-hidden="true">'.$next_ofst.' &raquo;</span></a></li>';
                        }
        }else{
                $pagin.='<li><a href="#">1</a></li>';
        }

        $output['pagin']=$pagin;
        $output['pg_total']=$pg_total;
        $output['car_total']=$car_total;
	$output['pg_limit']=$pg_limit;
        return $output;
}
?>
