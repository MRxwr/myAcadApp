<?php
function mySubscriptions($type){
    $userId = getLoginStatusResponse();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Subscriptions&userId={$userId}&type={$type}",
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
    return json_decode($response,true);
}

if( isset($_GET["cancel"]) && !empty($_GET["cancel"]) ){
    $userId = getLoginStatusResponse();
    $orderId = selectDB2("`id`","orders","`gatewayId` = '{$_GET["cancel"]}'");
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Cancel&userId={$userId}&orderId={$orderId[0]["id"]}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'myacadheader: myAcadAppCreate',
        'Cookie: CREATEkwLANG=EN'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
    if( $response["error"] == 1 ){
        ?>
        <script>
        window.onload = function() {
            alert("<?php echo direction("Error happened while try to cancel your subscription, please try again.","حدث خطأ أثناء محاولة إلغاء حجزك، الرجاء المحاولة مجدداً") ?>");
            window.location.href = "?v=Subscriptions" ;
        };
        </script>
        <?php
    }else{
        ?>
        <script>
        window.onload = function() {
            alert("<?php echo direction("Subscription has been cancelled successfully.","تم إلغاء الإشتراك بنجاح") ?>");
            window.location.href = "?v=Subscriptions" ;
        };
        </script>
        <?php
    }
}
?>
<div class="subsicription_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <ul class="nav nav-tabs" >
                    <li class="nav-item">
                        <button class="nav-link active" data-toggle="tab" data-target="#sub">My Subsicriptions</button>
                    </li>
                    <li class="nav-item" >
                        <button class="nav-link" data-toggle="tab" data-target="#history" type="button">History</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#cancelled" type="button">Cancelled</button>
                    </li>
                </ul>

                <div class="tab-content">

                <?php
                $TabType = [1,4,3];
                $TabTitle = ["sub","history","cancelled"];
                for( $y = 0; $y < sizeof($TabType); $y++ ){
                    $active = ($y == 0) ? "active" : "" ;
                ?>
                <div class="tab-pane fade show <?php echo $active ?>" id="<?php echo $TabTitle[$y] ?>">
                <div class="row">
                <?php
                if( $result = mySubscriptions($TabType[$y]) ){
                    if( isset($result["data"][0]) ){
                        for( $i = 0; $i < sizeof($result["data"]); $i++){
                            ?>
                            <div class="col-lg-4 mt_30 col-sm-6">
                                <div class="subsic_box">
                                <div class="subsi_wap">
                                    <img src="logos/<?php echo $result["data"][$i]["academyLogo"] ?>" alt="">
                                    <div class="text-center">
                                        <h2 class="title<?php echo $result["data"][$i]["id"] ?>"><?php echo direction($result["data"][$i]["enTitle"],$result["data"][$i]["arTitle"]) ?></h2>
                                        <h3><?php echo direction($result["data"][$i]["enArea"],$result["data"][$i]["arArea"]) ?></h3>
                                    </div>
                                    <img src="logos/<?php echo $result["data"][$i]["sportLogo"] ?>" alt="">
                                </div>
                                <div class="subsi_bott">
                                    <a href="<?php echo $result["data"][$i]["location"] ?>" class="item_sub">
                                        <img src="img/loc.svg" alt="">
                                        <h4><?php echo direction("Location","الموقع") ?></h4>
                                    </a>
                                    <a href ="#" id="<?php echo $result["data"][$i]["id"] ?>"  class="share item_sub">
                                        <img src="img/sub_4.svg" alt="">
                                        <h4><?php echo direction("Share","مشاركة") ?></h4>
                                    </a>
                                    <a href="?v=Success&OrderID=<?php echo $result["data"][$i]["orderId"] ?>" class="item_sub">
                                        <img src="img/sub_5.svg" alt="">
                                        <h4><?php echo direction("Invoice","الفاتورة") ?></h4>
                                        <h4 style="display:none" class="invoice<?php echo $result["data"][$i]["id"] ?>"><?php echo $result["data"][$i]["orderId"] ?></h4>
                                    </a>
                                    <?php
                                    if( date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime("+2 days", strtotime($result["data"][$i]["date"]))) ){
                                        ?>
                                        <a href="?v=Subscriptions&id==<?php echo $result["data"][$i]["orderId"] ?>" class="item_sub">
                                        <img src="img/sub_6.svg" alt="">
                                        <h4><?php echo direction("Cancel","إلغاء") ?></h4>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                </div>
                </div>
                <?php
                }
                ?>
            
                </div>
            </div>
        </div>
    </div>
</div>
