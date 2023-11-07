<div class="carousel_area">
    <div class="container">
        <div class="owl-carousel <?php echo $sliderDirection ?>">
		<?php
		if( $banners = selectDB("banners","`status` = '0' AND `hidden` = '0' ORDER BY `order` ASC") ){
			for( $i = 0; $i < sizeof($banners) ; $i++ ){
				$banners[$i]["link"] = ( empty($banners[$i]["link"]) || $banners[$i]["link"] == "#" ) ? "?v=Home" : $banners[$i]["link"] ;
				if( $banners[$i]["type"] == 0 ){
					echo "<div class='item'><a href='{$banners[$i]["link"]}' target='_blank' alt='Link-{$banners[$i]["title"]}'><img src='logos/{$banners[$i]["imageurl600"]}' alt='{$banners[$i]["title"]}'></a></div>";
				}else{
					echo "<div class='item'><div class='play_video' style='background-image: url(logos/{$banners[$i]["imageurl600"]});background-size: fill;'><a href='{$banners[$i]["link"]}' class='watch_btn'><i class='fal fa-play-circle'></i></a></div>";
				}
			}
		}
		?>
        </div>
    </div>
</div> 