<?php 
require("template/bannersSlider.php");

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Search&sportId={$_POST["sport"]}&genderId={$_POST["gender"]}&governateId={$_POST["governate"]}&areaId={$_POST["area"]}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'myacadheader: myAcadAppCreate'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response,true);
print_r($response);

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
            
        </div>
    </div>
</div>