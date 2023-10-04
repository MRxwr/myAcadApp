</main>
    <!-- footer -->
    <?php
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://createkwservers.com/myacad1/requests?a=Settings',
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
    $response = json_decode($response,true);
    $social = $response["data"]["social"];
    $settings = $response["data"]["settings"];
    curl_close($curl);
    ?>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-4 col-6 mt_40">
                    <h3><?=direction("Site Map","مخطط الموقع"); ?></h3>
                    <ul class="site_map">
                        <li><a href="?v=Home"><?=direction("Home","الرئيسية"); ?></a></li>
                        <li><a href="?v=Subscriptions"><?=direction("Subscriptions","الإشتراكات"); ?></a></li>
                        <li><a href="?v=Profile"><?=direction("Profile","الملف الشخصي"); ?></a></li>
                        <li><a data-toggle="modal" data-target="#policyModal"><?=direction("PRIVACY POLICY","سياسة الخصوصية"); ?></a></li>
                        <li><a data-toggle="modal" data-target="#termsModal"><?=direction("TERMS & CONDITIONS","الشروط والأحكام"); ?></a></li>
                    </ul>
               </div>
                <div class="col-lg-3 col-sm-4 col-6 mt_40">
                    <h3><?=direction("Social Media","التواصل الإجتماعي"); ?></h3>
                    <ul class="social_media">
                        <li><a href="https://wa.me/<?php echo $social["whatsapp"] ?>"><img src="img/what.svg" alt=""><?=direction("WhatsApp","الوتساب"); ?></a></li>
                        <li><a href="https://instagram.com/<?php echo $social["instagram"] ?>"><img src="img/ins.svg" alt=""></i><?=direction("Instagram","الانتجرام"); ?></a></li>
                        <li><a href="https://youtube.com/<?php echo $social["youtube"] ?>"><img src="img/you.svg" alt=""><?=direction("Youtube","اليوتيوب"); ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-4 col-12 mt_40">
                   <div class="foot_wapper">
                       <p><?php // © 2022-23 MY ACAD ?></p>
                       <a href="?v=Home" class="f_logo">
                           <img src="img/logo.png" alt="">
                       </a>
                   </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- back to top -->
    <a href="#" class="back-to-top"><i class="fal fa-angle-up"></i></a>
    
    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).on("click","input[type=radio]",function(){
            $("input[type=number]").val(0);
        })
        $(document).ready(function() {
            $('.share').on('click', function() {
                var id = $(this).attr("id");
                var title = $(".title"+id).html();
                var invoice = $(".invoice"+id).html();
                if (navigator.share) {
                    // Use the Web Share API
                    navigator.share({
                        title: 'MY ACAD',
                        text: title,
                        url: 'https://createkwservers.com/myacad1/?v=Success&OrderID=' + invoice
                    })
                    .then(() => {
                        console.log('Shared successfully');
                    })
                    .catch((error) => {
                        console.error('Error sharing:', error);
                    });
                } else {
                    // Fallback behavior for browsers that do not support the Web Share API
                    alert('Sharing is not supported on this device/browser.');
                }
            });
            $("input[type=number]").on("change",function(){
              $("input[type=number]").prop("required",false);
              $(this).prop("required",true);
            })
        });
    </script>

<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 15px !important;font-weight: 700;"><?php echo direction("TERMS & CONDITIONS","الشروط والأحكام") ?></h5>
      </div>
      <div class="modal-body" style="font-size: 12px !important;font-weight: 500;">
        <?php echo direction($settings["enTerms"],$settings["arTerms"]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 12px !important;font-weight: 700;"><?php echo direction("Close","إغلاق") ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 15px !important;font-weight: 700;"><?php echo direction("PRIVACY POLICY","سياسة الخصوصية") ?></h5>
      </div>
      <div class="modal-body" style="font-size: 12px !important;font-weight: 500;">
        <?php echo direction($settings["enPolicy"],$settings["arPolicy"]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 12px !important;font-weight: 700;"><?php echo direction("Close","إغلاق") ?></button>
      </div>
    </div>
  </div>
</div>

</body>
</html>