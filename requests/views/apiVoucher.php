<?php 
$numberOfTimesAvalability = false;
$academyAprroved = false;
$dateApproved = false;
if( isset($_POST["code"]) && !empty($_POST["code"]) && $voucher = selectDB("vouchers","`code` = '{$_POST["code"]}' AND `hidden` = '0' AND `status` = '0'")){
    $currentDate = date("Y-m-d");
    if( (substr($voucher[0]["startDate"],0,10) <= $currentDate) && (substr($voucher[0]["endDate"],0,10) >= $currentDate) ){
        $dateApproved = true;
    }else{
        $response = array(
            "msg" => 'voucher has been expired.',
            "msgAr" => 'كود خصم منتهي الصلاحية',
        );
        echo outputError($response);die();
    }

    if( $voucher[0]["numberOfTimes"] == 0 ){
        $numberOfTimesAvalability = true;
    }elseif( $voucher[0]["numberOfTimes"] != 0 ){
        if( $orders = selectDB("orders","`voucher` = '{$voucher[0]["id"]}'")){
            $numberOfUsage = sizeof($orders);
            if( $voucher[0]["numberOfTimes"] > $numberOfUsage ){
                $numberOfTimesAvalability = true;
            }else{
                $numberOfTimesAvalability = false;
                $response = array(
                    "msg" => 'voucher limit has been fully used.',
                    "msgAr" => 'إنتهت إستخدامات كود الخصم',
                );
                echo outputError($response);die();
            }
        }else{
            $numberOfTimesAvalability = true;
        }
    }
    
    if( $voucher[0]["academyId"] != 0 ){
        if( $voucher[0]["academyId"] == $_POST["academyId"] ){
            $academyAprroved = true;
        }else{
            $academyAprroved = false;
            $response = array(
                "msg" => 'voucher is not valid for this academy.',
                "msgAr" => 'لا يمكن تطبيق هذا الكود على هذه الأكادمية',
            );
            echo outputError($response);die();
        }
    }elseif( $voucher[0]["academyId"] == 0 ){
        $academyAprroved = true;
    }
    
    if( $numberOfTimesAvalability && $academyAprroved && $dateApproved ){
            $voucherType = ($voucher[0]["type"] == 0) ? 0 : 1;
            $voucherAmount = $voucher[0]["amount"];
            $newTotal = ( $voucherType == 0 ) ? ($_POST["total"]*(1-($voucherAmount/100))) : $_POST["total"] - $voucherAmount;
            $array = array(
                "msg" => "Voucher has been applied sucessfully",
                "msgAr" => "تم تطبيق كود الخصم بنجاح",
                "newTotal" => $newTotal,
            );
            echo outputData($array);die();
    }else{
        $response = array(
            "msg" => 'voucher is not valid anymore.',
            "msgAr" => 'لا يمكن إستخدام هذا الكود',
        );
        echo outputError($response);die();
    }
}else{
    $response = array(
        "msg" => 'voucher does not exist.',
        "msgAr" => 'لا يوجد كود مثل هذا',
    );
    echo outputError($response);die();
}
?>