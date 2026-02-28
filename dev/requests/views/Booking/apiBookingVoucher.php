<?php 
$numberOfTimesAvalability = false;
$fieldAprroved = false;
$dateApproved = false;
if( isset($_POST["code"]) && !empty($_POST["code"]) && $voucher = selectDBNew("vouchers",[$_POST["code"]],"`code` = ? AND `typeOfVoucher` = '3' AND `hidden` = '0' AND `status` = '0'","") ) {
    if( !isset($_POST["fieldId"]) || empty($_POST["fieldId"]) ){
        $response = array(
            "msg" => 'field is required.',
            "msgAr" => 'يجب إدخال الملعب',
        );
        echo outputError($response);die();
    }
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
        if( $orders = selectDB("fields_booking","`voucher` = '{$voucher[0]["code"]}'")){
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
    
    if( !empty($voucher[0]["fieldIds"]) ){
        $voucher[0]["fieldIds"] = json_decode($voucher[0]["fieldIds"],true);
        if( in_array($_POST["fieldId"],$voucher[0]["fieldIds"]) ){
            $fieldAprroved = true;
        }else{
            $fieldAprroved = false;
            $response = array(
                "msg" => 'voucher is not valid for this field.',
                "msgAr" => 'لا يمكن تطبيق هذا الكود على هذا الملعب',
            );
            echo outputError($response);die();
        }
    }elseif( $voucher[0]["fieldIds"] == 0 ){
        $fieldAprroved = true;
    }
    
    if( $numberOfTimesAvalability && $fieldAprroved && $dateApproved ){
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