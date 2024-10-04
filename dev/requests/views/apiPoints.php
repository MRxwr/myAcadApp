<?php 
if( $user = selectDB2("`points`,`wallet`","users","`id` = '{$_GET["userId"]}' " ) ){
    $settings = selectDB("settings","`id` = 1");
    $points = $user[0]["points"];
    var_dump("{$settings[0]["pointsRedeemMin"]} > {$points}" . $settings[0]["pointsRedeemMin"] > $points);
    if( $settings[0]["pointsRedeemMin"] > $points ){
        $error["msg"] = popupMsg($requestLang,"Not enough points to redeem","ليس لديك نقاط كافية لتحويلها");
        echo outputError($error);die();
    }else{
        $wallet = $points + $user[0]["wallet"];
        updateDB("users",array("wallet"=>$wallet,"points"=>0),"`id` = '{$_GET["userId"]}'");
        $error["msg"] = popupMsg($requestLang,"Points transferred successfully","تم تحويل النقاط بنجاح");
	    echo outputData($error);die();
    }
}else{
	$error["msg"] = popupMsg($requestLang,"No user with this id","لا يوجد مستخدم بهذا الرقم");
	echo outputError($error);die();
}
?>