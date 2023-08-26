<?php
if( isset($_POST["firstName"]) && !empty($_POST["firstName"]) ){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://www.createkwservers.com/myacad1/requests?a=User&type=register',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('firstName' => 'anas','lastName' => 'alkandari','phone' => '96556544444','email' => 'ana.kandari@kockw.com','password' => '90949089','confirmPassword' => '90949089','firebase' => '123132132132dsadsadas'),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'myacadheader: myAcadAppCreate'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo 'cURL Error: ' . curl_error($curl);
}

// Output the response
echo "Response: " . $response;
}
?>

<div class="home_area">
    <div class="left_side">
        <div class="hero_input sign_form">
            <h2><?php echo direction("SIGNUP","تسجيل") ?></h2>
            <form action="?v=Register" method="POST" class="wapper_form">
                <div class="input_wapp">
                    <img src="img/img_3.svg" alt="">
                    <input type="text" name="firstName" placeholder="<?php echo direction("First Name","الإسم الأول") ?>">
                </div>
                <div class="input_wapp">
                    <img src="img/img_3.svg" alt="">
                    <input type="text" name="lastName" placeholder="<?php echo direction("Last Name","الإسم الأخير") ?>">
                </div>
                <div class="input_wapp">
                    <img src="img/img_1.svg" alt="">
                    <input type="email" name="email" placeholder="<?php echo direction("Email Address","البريد الإلكتروني") ?>">
                </div>
                <div class="input_wapp bor_style">
                    <img src="img/img_4.svg" alt="">
                    <input type="tel" id="phn" name="phone" value="+965" placeholder="<?php echo direction("Phone Number","رقم الهاتف") ?>">
                </div>
                <div class="input_wapp">
                    <img src="img/img_2.svg" alt="">
                    <input type="password" name="password" placeholder="<?php echo direction("Password","كلمة المرور") ?>">
                </div>
                <div class="input_wapp">
                    <img src="img/img_2.svg" alt="">
                    <input type="password" name="confirmPassword" placeholder="<?php echo direction("Re-Type Password","تأكيد كلمة المرور") ?>">
                </div>
                <button class="button mt_40" type="submit"><?php echo direction("SIGNUP","تسجيل") ?></button>
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