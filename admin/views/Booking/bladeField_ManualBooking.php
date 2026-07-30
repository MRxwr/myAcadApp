<?php
if( !isset($_GET["code"]) || empty($_GET["code"]) || !is_numeric($_GET["code"])  ){
    echo "<script>window.location='?v=Fields_List'</script>";
    die();
}else{
    $fieldDetails = selectDBNew("fields_list",[$_GET["code"]],"`id` = ?","");
    if (!$fieldDetails) {
        echo "<script>window.location='?v=Fields_List'</script>";
        die();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manualBooking'])) {
    $error = "";
    $bookingDate = $_POST['bookingDate'];
    $periodId = $_POST['periodId'];
    $timeSlot = $_POST['timeSlot']; // "startTime-endTime"
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $ageId = $_POST['ageId'];
    $levelId = $_POST['levelId'];
    $notes = $_POST['notes'];

    if (empty($timeSlot)) {
        $error = direction("Please select a time slot", "يرجى اختيار فترة زمنية");
    } else {
        list($startTime, $endTime) = explode('|', $timeSlot);
        
        // Check if already booked (Double check)
        $checkBooking = selectDB("fields_booking", "`fieldId` = '{$_GET["code"]}' AND `bookingDate` = '{$bookingDate}' AND `startTime` = '{$startTime}' AND `status` IN ('0','1','2') AND `hidden` = '0'");
        
        if ($checkBooking) {
            $error = direction("This slot is already booked", "هذه الفترة محجوزة بالفعل");
        } else {
            $orderId = "MAN-" . time();
            $insertData = array(
                "gatewayId" => $orderId,
                "name" => $name,
                "phone" => $phone,
                "email" => "manual@booking.com",
                "userId" => 0,
                "fieldId" => $_GET["code"],
                "periodId" => $periodId,
                "bookingDate" => $bookingDate,
                "startTime" => $startTime,
                "endTime" => $endTime,
                "levels" => $levelId,
                "ages" => $ageId,
                "notes" => $notes,
                "total" => $fieldDetails[0]["price"],
                "paymentMethod" => 5, // Cash
                "status" => 2, // Fully Paid
                "date" => date("Y-m-d H:i:s")
            );
            
            if (insertDB("fields_booking", $insertData)) {
                echo "<script>alert('" . direction("Booking successful", "تم الحجز بنجاح") . "'); window.location='?v=Field_ManualBooking&code=" . $_GET["code"] . "';</script>";
                die();
            } else {
                $error = direction("Error while booking", "خطأ أثناء الحجز");
            }
        }
    }
}
?>

<div class="col-sm-12">
    <div class="panel panel-default card-view">
        <div class="panel-heading">
            <div class="pull-left">
                <h6 class="panel-title txt-dark"><?php echo direction("Manual Booking", "حجز يدوي") ?></h6>
            </div>
            <div class="pull-right">
                <h6 class="panel-title txt-dark"><?php echo direction($fieldDetails[0]["enTitle"], $fieldDetails[0]["arTitle"]) ?></h6>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <?php if (isset($error) && !empty($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="row m-0">
                        <div class="col-md-4">
                            <label><?php echo direction("Name", "الإسم") ?></label>
                            <input type="text" name="name" class="form-control" required placeholder="Walk-in Customer">
                        </div>
                        <div class="col-md-4">
                            <label><?php echo direction("Phone", "الهاتف") ?></label>
                            <input type="text" name="phone" class="form-control" required placeholder="00000000">
                        </div>
                        <div class="col-md-4">
                            <label><?php echo direction("Booking Date", "تاريخ الحجز") ?></label>
                            <input type="date" name="bookingDate" id="bookingDate" class="form-control" required min="<?php echo date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-4">
                            <label><?php echo direction("Age Range", "الفئة العمرية") ?></label>
                            <select name="ageId" class="form-control" required>
                                <?php
                                if ($ages = selectDB("field_ages", "`status` = '0' AND `hidden` = '0' ORDER BY `id` ASC")) {
                                    foreach ($ages as $age) {
                                        echo "<option value='{$age["id"]}'>" . direction($age["enTitle"], $age["arTitle"]) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><?php echo direction("Level", "المستوى") ?></label>
                            <select name="levelId" class="form-control" required>
                                <?php
                                if ($levels = selectDB("field_levels", "`status` = '0' AND `hidden` = '0' ORDER BY `id` ASC")) {
                                    foreach ($levels as $level) {
                                        echo "<option value='{$level["id"]}'>" . direction($level["enTitle"], $level["arTitle"]) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><?php echo direction("Period", "الفترة") ?></label>
                            <select name="periodId" id="periodId" class="form-control" required>
                                <option value=""><?php echo direction("Select Period", "اختر فترة") ?></option>
                                <?php
                                if ($periods = selectDB("field_periods", "`fieldId` = '{$_GET["code"]}' AND `status` = '0' AND `hidden` = '0' ORDER BY `id` ASC")) {
                                    foreach ($periods as $period) {
                                        echo "<option value='{$period["id"]}'>" . direction($period["enTitle"], $period["arTitle"]) . " ({$period["period"]} " . direction("Min", "دقيقة") . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-12 mt-20" id="slotsContainer" style="display:none;">
                            <label><?php echo direction("Available Slots", "الفترات المتاحة") ?></label>
                            <div id="slotsList" class="row">
                                <!-- Slots will be loaded here via JS -->
                            </div>
                        </div>

                        <div class="col-md-12 mt-20">
                            <label><?php echo direction("Notes", "ملاحظات") ?></label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12" style="margin-top:20px">
                            <input type="submit" name="manualBooking" class="btn btn-primary" value="<?php echo direction("Confirm Booking", "تأكيد الحجز") ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function loadSlots() {
        var date = $('#bookingDate').val();
        var periodId = $('#periodId').val();
        var fieldId = '<?php echo $_GET["code"] ?>';
        
        if (date && periodId) {
            $('#slotsContainer').show();
            $('#slotsList').html('<div class="col-md-12">Loading...</div>');
            
            $.ajax({
                url: '../requests/index.php?a=BookingTimes',
                type: 'GET',
                headers: {
                    "myacadheader": "myAcadAppCreate"
                },
                data: {
                    fieldId: fieldId,
                    date: date,
                    periodId: periodId,
                    admin: 1,
                    currentTime: Math.floor(Date.now() / 1000)
                },
                success: function(response) {
                    var data = (typeof response === 'object') ? response : JSON.parse(response);
                    if (data.ok && data.data && data.data.timeSlots) {
                        var html = '';
                        var slots = data.data.timeSlots;
                        if (slots.length > 0) {
                            slots.forEach(function(slot) {
                                if (slot.isAvailable) {
                                    html += '<div class="col-md-3 mb-10">';
                                    html += '<div class="radio radio-info">';
                                    html += '<input type="radio" name="timeSlot" id="slot_' + slot.startTime + '" value="' + slot.startTime + '|' + slot.endTime + '" required>';
                                    html += '<label for="slot_' + slot.startTime + '">' + slot.startTime + ' - ' + slot.endTime + '</label>';
                                    html += '</div></div>';
                                }
                            });
                        } else {
                            html = '<div class="col-md-12 text-danger"><?php echo direction("No available slots for this date/period", "لا توجد فترات متاحة لهذا التاريخ/الفترة") ?></div>';
                        }
                        $('#slotsList').html(html || '<div class="col-md-12 text-danger"><?php echo direction("No available slots for this date/period", "لا توجد فترات متاحة لهذا التاريخ/الفترة") ?></div>');
                    } else {
                        var errorMsg = 'Error loading slots';
                        if (data.data && data.data.msg) errorMsg = data.data.msg;
                        else if (data.status) errorMsg = data.status;
                        $('#slotsList').html('<div class="col-md-12 text-danger">' + errorMsg + '</div>');
                    }
                },
                error: function() {
                    $('#slotsList').html('<div class="col-md-12 text-danger">Connection error</div>');
                }
            });
        } else {
            $('#slotsContainer').hide();
        }
    }

    $('#bookingDate, #periodId').on('change', function() {
        loadSlots();
    });
});
</script>
