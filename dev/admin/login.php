<?php
require ("includes/config.php");
require("includes/functions.php");
require ("includes/translate.php");

if ( isset($_COOKIE[$cookieSession."A"]) && !empty($_COOKIE[$cookieSession."A"]) ){
	header("Location: index");
}

if ( isset ($_GET["error"]) ){
  if ( $_GET["error"] === "p" ) { 
    $errormsg = "Please enter details correctly.";
  }elseif ($_GET["error"] === "e" ) { 
    $errormsg = "Please enter email correctly."; 
  } 
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>My Academy - CP.</title>
    <meta name="description" content="Droopy is a Dashboard & Admin Site Responsive Template by hencework." />
    <meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Droopy Admin, Droopyadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
    <meta name="author" content="hencework" />
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
      }
      h6 {
        font-size: 16px;
        color: #d1d1d1;
        margin-bottom: 40px;
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
      .form-control::placeholder {
        color: #999 !important;
      }
      .checkbox label {
        color: #ffffff !important;
        font-size: 14px;
      }
      .btn-signin {
        background-color: #e65132 !important;
        border: none !important;
        border-radius: 25px !important;
        padding: 12px 0 !important;
        font-size: 18px !important;
        font-weight: 500 !important;
        width: 70%;
        margin-top: 20px;
        color: #ffffff !important;
        transition: background-color 0.3s;
      }
      .btn-signin:hover {
        background-color: #f05a3c !important;
      }
      .sp-header {
        display: none;
      }
    </style>
  </head>
  <body>
    <!--Preloader-->
    <div class="preloader-it">
      <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->

    <div class="wrapper box-layout pa-0">
      <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
          <a href="index">
            <img class="brand-img mr-10" src="../logos/logoNew.png" alt="brand" style="width:50px;height:50px"/>
            <span class="brand-text"><span style="font-size: 22px; color: white;">My Academy</span></span>
          </a>
        </div>
        <div class="clearfix"></div>
      </header>

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
                      <h3 class="txt-light">Sign in to My Academy Dashboard</h3>
                      <h6 class="txt-light">Enter your details below</h6>
                      <?php 
											if ( isset($_GET["temp"]) ){
                        echo "<div class='text-center' style='color: gold;'>".direction("Password updated successfully","تم تحديث كلمة المرور بنجاح")."</div>";
											}
											?>
                    </div>
                    <div class="form-wrap">
                      <form action="includes/logindb.php" method="post">
                        <div class="form-group">
                          <label class="control-label" for="exampleInputEmail_2">Email Address</label>
                          <?php 
                          if( isset($_GET["error"]) AND $_GET["error"] == "e" ){
                            echo "<div style='color: red;'>".direction("Invalid email","البريد الإلكتروني غير صالح")."</div>";
													}
													?>
                          <input type="email" name="email" class="form-control" required="" id="exampleInputEmail_2" placeholder="Enter Email" />
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="exampleInputpwd_2" >Password</label>
                          <a class="capitalize-font txt-danger block mb-10 pull-right font-12" href="forgot-password">forgot password?</a>
                          <div class="clearfix">
                          <?php 
                          if ( isset($_GET["error"]) AND $_GET["error"] == "p" ){
                              echo "<div style='color: red;'>".direction("Invalid password","كلمة المرور غير صالحة")."</div>";
													}
													?>
                          </div>
                          <input type="password" name="password" class="form-control" required="" id="exampleInputpwd_2" placeholder="Enter Pwd" />
                        </div>
                        <div class="form-group">
                          <div class="checkbox checkbox-primary pr-10 pull-left">
                            <input id="checkbox_2" type="checkbox"/>
                            <label for="checkbox_2"> Keep me logged in</label>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group text-center">
                          <button type="submit" class="btn btn-signin">Sign In</button>
                        </div>
                      </form>
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
    <!-- /#wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="dist/js/jquery.slimscroll.js"></script>

    <!-- Init JavaScript -->
    <script src="dist/js/init.js"></script>
  </body>
</html>
