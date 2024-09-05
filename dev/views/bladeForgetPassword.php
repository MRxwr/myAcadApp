<?php
if( isset($_POST["email"]) AND !empty($_POST["email"]) ){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://myacad.app/requests?a=User&type=forgetPassword&email={$_POST["email"]}",
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
    $response = json_decode($response,true);
    if( $response["error"] == 1 ){
        ?><script>alert("<?php echo direction($response["data"]["msg"],"لا يوجد بريد إلكتروني مسجل لدينا كهذا، الرجاء التأكد من كتابته بشكل صحيح") ?>")</script><?php
    }else{
        ?><script>alert("<?php echo direction($response["data"]["msg"],"تم إرسال كلمة مرور جديدة إلى بريدك الإلكتروني") ?>")</script><?php
    }
}
?>

<div class="home_area">
    <div class="left_side">
        <div class="hero_input sign_form">
            <h2><?php echo direction("FORGET PASSWORD", "نسيان كلمة المرور") ?></h2>
            <form action="?v=ForgetPassword" method="POST" class="wapper_form mt_100">
                <div class="input_wapp">
                    <img src="img/img_1.svg" alt="">
                    <input type="email" name="email" placeholder="<?php echo direction("Email Address", "البريد الإلكتروني") ?>">
                </div>
                <button class="button mt_40" type="submit"><?php echo direction("RESET PASSWORD", "إستعادة كلمة المرور") ?></button>
            </form>
            <ul>
                <li><a href="?v=Login"><?php echo direction("Already have an account? Login.","لديك حساب من قبل، سجل دخولك") ?></a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>