<?php 
require("template/bannersSlider.php");
if( isset($_POST) && !empty($_POST) ){
	$sport = ( isset($_POST["sport"]) && !empty($_POST["sport"]) ) ? $_POST["sport"] : "0" ;
	$gender = ( isset($_POST["gender"]) && !empty($_POST["gender"]) ) ? $_POST["gender"] : "0" ;
	$governate = ( isset($_POST["governate"]) && !empty($_POST["governate"]) ) ? $_POST["governate"] : "0" ;
	$area = ( isset($_POST["area"]) && !empty($_POST["area"]) ) ? $_POST["area"] : "0" ;
	
	if( $sports = selectDB("sports","`id` LIKE '{$sport}'") ){
		$sportTitle = direction($sports[0]["enTitle"],$sports[0]["arTitle"]);
	}else{
		$sportTitle = direction("Unknown Sport","رياضة غير معروفة");
	}
	
	if( !empty($gender) ){
		if( $gender == 1 ){
			$userGender = direction("Man","رجل");
		}elseif( $gender == 2 ){
			$userGender = direction("Woman","أنثى");
		}elseif( $gender == 3 ){
			$userGender = direction("Boy","ولد");
		}elseif( $gender == 4 ){
			$userGender = direction("Girl","بنت");
		}
	}else{
		$userGender = direction("Not submitted","لا يوجد");
	}
	
	if( $governate = selectDB("governates","`id` LIKE '{$governate}'") ){
		$governate = direction($governate[0]["enTitle"],$governate[0]["arTitle"]);
	}else{
		$governate = direction("Unknown Governate","محافظة غير معروفة");
	}
	
	if( $area = selectDB("countries","`id` LIKE '{$area}'") ){
		$area = direction($area[0]["areaEnTitle"],$area[0]["areaArTitle"]);
	}else{
		$area = direction("Unknown Area","مدينة غير معروفة");
	}
}
?>
<div class="s_football_area">
    <div class="container">
        <h5><?php echo $sportTitle ?></h5>
        <div class="row">
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box">
                    <div class="promotion_box">
                        <p>Promotion<span>30%</span></p>
                    </div>
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_2.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>1</span>
                            <div class="kuwat_items">
                                <img src="img/kut_1.png" alt="">
                                <div>
                                    <h2>Dynamo Kuwait</h2>
                                    <h3>Sabah Al Salem</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>5.2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box foot_cust">
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_1.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>2</span>
                            <div class="kuwat_items">
                                <img src="img/kut_2.png" alt="">
                                <div>
                                    <h2>VAMOS Academy</h2>
                                    <h3>Kifan</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>4.1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box foot_cust">
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_1.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>2</span>
                            <div class="kuwat_items">
                                <img src="img/kut_2.png" alt="">
                                <div>
                                    <h2>VAMOS Academy</h2>
                                    <h3>Kifan</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>4.1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box">
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_2.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>1</span>
                            <div class="kuwat_items">
                                <img src="img/kut_1.png" alt="">
                                <div>
                                    <h2>Dynamo Kuwait</h2>
                                    <h3>Sabah Al Salem</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>5.2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box foot_cust">
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_1.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>2</span>
                            <div class="kuwat_items">
                                <img src="img/kut_2.png" alt="">
                                <div>
                                    <h2>VAMOS Academy</h2>
                                    <h3>Kifan</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>4.1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box foot_cust">
                    <a href="#" class="s_foot_img">
                        <img src="img/ca_1.jpg" alt="" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span>2</span>
                            <div class="kuwat_items">
                                <img src="img/kut_2.png" alt="">
                                <div>
                                    <h2>VAMOS Academy</h2>
                                    <h3>Kifan</h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4>Rate</h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span>4.1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>