<?php
require("includes/config.php");
require("includes/functions.php");
require("includes/translate.php");

$error = "";
$step = isset($_GET["step"]) ? $_GET["step"] : 0;
$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : "";

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    if ( $step == 0 ) {
        // Request OTP
        if ( !empty($email) ) {
            if ( $employee = selectDBNew("employees", [$email], "`email` = ? AND `status` = '0'", "") ) {
                $otp = rand(1000, 9999);
                if ( updateDB("employees", ["otp" => $otp], "`id` = '{$employee[0]["id"]}'") ) {
                    $phone = $employee[0]["phone"];
                    // Prepend country code if missing (assuming Kuwait 965 based on 8 digits)
                    if ( strlen($phone) == 8 ) {
                        $phone = "965" . $phone;
                    }
                    whatsappUltraMsgVerify($phone, $otp);
                    header("Location: forgot-password.php?step=1&email=" . urlencode($email));
                    exit();
                } else {
                    $error = direction("Failed to send OTP. Please try again.","فشل في إرسال رمز التحقق. الرجاء المحاولة مرة أخرى.");
                }
            } else {
                $error = direction("Email not found.","البريد الإلكتروني غير موجود.");
            }
        } else {
            $error = direction("Please enter your email.","الرجاء إدخال بريدك الإلكتروني.");
        }
    } elseif ( $step == 1 ) {
        // Verify OTP
        $otpForm = $_POST["otp"];
        if ( $employee = selectDBNew("employees", [$email, $otpForm], "`email` = ? AND `otp` = ? AND `status` = '0'", "") ) {
            header("Location: forgot-password.php?step=2&email=" . urlencode($email) . "&otp=" . urlencode($otpForm));
            exit();
        } else {
            $error = direction("Invalid OTP.","رمز التحقق غير صالح.");
        }
    } elseif ( $step == 2 ) {
        // Change Password
        $otpForm = $_POST["otp"];
        $newPassword = sha1($_POST["password"]);
        if ( $employee = selectDBNew("employees", [$email, $otpForm], "`email` = ? AND `otp` = ? AND `status` = '0'", "") ) {
            if ( updateDB("employees", ["password" => $newPassword, "otp" => ""], "`id` = '{$employee[0]["id"]}'") ) {
                header("Location: login.php?temp=updated");
                exit();
            } else {
                $error = "Failed to update password.";
            }
        } else {
            $error = "Authorization failed.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Forgot Password - My Academy</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../logos/logoNew.png" />
    <link rel="icon" href="../logos/logoNew.png" type="image/x-icon" />
    <!-- vector map CSS -->
    <link href="../vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Custom CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css" />
    <style>
      body {
        background-color: #011133 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      }
      .auth-page {
        background-color: #011133 !important;
      }
      .auth-form {
        max-width: 350px;
        width: 100%;
      }
      .brand-img-center {
        display: block;
        margin: 0 auto 30px;
        width: 120px;
        height: auto;
      }
      h3 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #ffffff;
        text-align: center;
      }
      h6 {
        font-size: 16px;
        color: #d1d1d1;
        margin-bottom: 40px;
        text-align: center;
      }
      .form-group label {
        font-weight: 400;
        font-size: 14px;
        margin-bottom: 8px;
        color: #ffffff;
      }
      .form-control {
        background-color: #ffffff !important;
        border: none !important;
        border-radius: 4px !important;
        height: 45px !important;
        color: #333 !important;
        font-size: 16px !important;
        padding: 10px 15px !important;
      }
      .btn-signin {
        background-color: #e65132 !important;
        border: none !important;
        border-radius: 25px !important;
        padding: 12px 0 !important;
        font-size: 18px !important;
        font-weight: 500 !important;
        width: 100%;
        margin-top: 20px;
        color: #ffffff !important;
        transition: background-color 0.3s;
      }
      .btn-signin:hover {
        background-color: #f05a3c !important;
      }
    </style>
</head>
<body>
    <div class="wrapper box-layout pa-0">
        <!-- Main Content -->
        <div class="page-wrapper pa-0 ma-0 auth-page">
            <div class="container-fluid">
                <!-- Row -->
                <div class="table-struct full-width full-height">
                    <div class="table-cell vertical-align-middle auth-form-wrap">
                        <div class="auth-form ml-auto mr-auto no-float">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="mb-30 text-center">
                                        <img class="brand-img-center" src="../logos/logoNew.png" alt="brand" />
                                        <?php if ( $step == 0 ) { ?>
                                            <h3 class="txt-light"><?php echo direction("Forgot Password","نسيت كلمة المرور"); ?></h3>
                                            <h6 class="txt-light"><?php echo direction("Enter your email and we'll send an OTP to your WhatsApp!","أدخل بريدك الإلكتروني وسنرسل رمز التحقق إلى WhatsApp الخاص بك!"); ?></h6>
                                        <?php } elseif ( $step == 1 ) { ?>
                                            <h3 class="txt-light"><?php echo direction("Verify OTP","تحقق من رمز التحقق"); ?></h3>
                                            <h6 class="txt-light"><?php echo direction("Enter the code sent to your mobile.","أدخل الرمز المرسل إلى هاتفك المحمول."); ?></h6>
                                        <?php } elseif ( $step == 2 ) { ?>
                                            <h3 class="txt-light"><?php echo direction("Reset Password","إعادة تعيين كلمة المرور"); ?></h3>
                                            <h6 class="txt-light"><?php echo direction("Choose a new password for your account.","اختر كلمة مرور جديدة لحسابك."); ?></h6>
                                        <?php } ?>
                                        
                                        <?php if ( !empty($error) ) { ?>
                                            <div style="color: #ff5252; margin-bottom: 10px;"><?php echo $error; ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-wrap">
                                        <form action="forgot-password.php?step=<?php echo $step; ?>" method="post">
                                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                            
                                            <?php if ( $step == 0 ) { ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputEmail_2"><?php echo direction("Email Address","البريد الإلكتروني"); ?></label>
                                                    <input type="email" name="email" class="form-control" required="" id="exampleInputEmail_2" placeholder="<?php echo direction("Enter Email","أدخل البريد الإلكتروني"); ?>" value="<?php echo htmlspecialchars($email); ?>" />
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-signin"><?php echo direction("Send OTP","إرسال رمز التحقق"); ?></button>
                                                </div>
                                            <?php } elseif ( $step == 1 ) { ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="otp_input"><?php echo direction("OTP Code","رمز التحقق"); ?></label>
                                                    <input type="text" name="otp" class="form-control" required="" id="otp_input" placeholder="<?php echo direction("Enter OTP","أدخل رمز التحقق"); ?>" />
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-signin"><?php echo direction("Verify OTP","تحقق من رمز التحقق"); ?></button>
                                                </div>
                                            <?php } elseif ( $step == 2 ) { ?>
                                                <input type="hidden" name="otp" value="<?php echo htmlspecialchars($_REQUEST["otp"]); ?>">
                                                <div class="form-group">
                                                    <label class="control-label" for="pwd_input"><?php echo direction("New Password","كلمة المرور الجديدة"); ?></label>
                                                    <input type="password" name="password" class="form-control" required="" id="pwd_input" placeholder="<?php echo direction("Enter New Password","أدخل كلمة المرور الجديدة"); ?>" />
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-signin"><?php echo direction("Update Password","تحديث كلمة المرور"); ?></button>
                                                </div>
                                            <?php } ?>
                                        </form>
                                        <div class="text-center mt-20">
                                            <a href="login" style="color: #d1d1d1; font-size: 14px;"><?php echo direction("Back to Sign In","العودة إلى تسجيل الدخول"); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
            </div>
        </div>
        <!-- /Main Content -->
    </div>
    <!-- JavaScript -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
