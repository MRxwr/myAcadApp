<?php

if( $order = selectDB("orders","`id` = '{$_GET["id"]}'") ){

}else{
    ?>
    <script>
        window.onload = function() {
            alert("<?php echo direction("Wrong order number","رقم طلب خاطئ") ?>");
            window.location.href = "?v=Invoices";
        }
    </script>
    <?php
}

?>