<div class="modal fade" id="changePassword" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered profile_modal">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <h2><?php echo direction("Change Password","تغيير كلمة المرور") ?></h2>
                <form action="?v=Profile" method="POST" class="profile_form">
                    <div class="row">
                        <div class="col-lg-12 mt_15">
                            <label for="nam"><?php echo direction("Old Password","كلمة المرور القديمة") ?></label>
                            <input type="password" name="oldPassword" id="nam" value="" required>
                        </div>
                        <div class="col-lg-12 mt_15">
                            <label for="nam2"><?php echo direction("New Password","كلمة المرور الجديدة") ?></label>
                            <input type="password" name="newPassword" id="nam2" value="" required>
                        </div>
                        <div class="col-lg-12 mt_20">
                            <label for="nam3"><?php echo direction("Confirm Password","تأكيد كلمة المرور") ?></label>
                            <input type="password" name="confirmPassword" id="nam3" value="" required>
                        </div>
                        <div class="col-lg-6 mt_20">
                            <button class="button" type="submit"><?php echo direction("UPDATE","تحديث") ?></button>
                            <input type="hidden" name="changePass" value="1" required>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>