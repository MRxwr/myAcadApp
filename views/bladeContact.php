<div class="contact_page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-4 order-lg-2 text-center">
                        <img src="img/cont_bg.png" alt="">
                    </div>
                    <div class="col-lg-4 order-lg-1">
                        <h2><?php echo direction("Join Us or Contact Us Now","سجل أو تواصل معنا") ?></h2>
                        <form action="#">
                            <label for="name"><?php echo direction("Title","العنوان") ?></label>
                            <input id="name" type="text">
                            <label for="eml"><?php echo direction("Email","البريد الإلكتروني") ?></label>
                            <input id="eml" type="email">
                            <label for="tel"><?php echo direction("Phone Number","رقم الهاتف") ?></label>
                            <input id="tel" type="tel">
                            <label for="text"><?php echo direction("Messege","الرسالة") ?></label>
                            <textarea></textarea>
                            <button type="submit" class="button mt_20"><?php echo direction("SEND","إرسال") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>