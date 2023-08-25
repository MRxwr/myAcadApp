<div class="modal fade" id="profile" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered profile_modal">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <h2><?php echo direction("Personal Information","المعلومات الشخصية") ?></h2>
                <form action="?v=Profile" class="profile_form">
                    <div class="row">
                        <div class="col-lg-6 mt_15">
                            <label for="nam"><?php echo direction("First Name","الإسم الأول") ?></label>
                            <input type="text" name="firstName" id="nam">
                        </div>
                        <div class="col-lg-6 mt_15">
                            <label for="nam2"><?php echo direction("Email","البريد الإلكتروني") ?></label>
                            <input type="email" name="email" id="nam2">
                        </div>
                        <div class="col-lg-6 mt_20">
                            <label for="nam"><?php echo direction("Last Name","الإسم الأخير") ?></label>
                            <input type="name" name="lastName" id="nam" >
                        </div>
                        <div class="col-lg-6 mt_20">
                            <label for="nam"><?php echo direction("Phone Number","رقم الهاتف") ?></label>
                            <input type="tel" name="phone" id="nam">
                        </div>
                        <div class="col-lg-6 mt_20">
                            <label for="nam"><?php echo direction("Gender","الجنس") ?></label>
                            <div class="radio_wapp">
                                <div class="profile_radio">
                                    <input type="radio" checked="" value='0' name="gender" id="us7">
                                    <label for="us7"><img src="img/male.svg" alt=""><?php echo direction("Male","ذكر") ?></label>
                                </div>
                                <div class="profile_radio">
                                    <input type="radio" name="gender" value='1' id="us8">
                                    <label for="us8"><img src="img/female.svg" alt=""><?php echo direction("Female","أنثى") ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt_20">
                            <button class="button" type="submit"><?php echo direction("UPDATE","تحديث") ?></button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>