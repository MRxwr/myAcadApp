<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("admin/includes/config.php");
require_once("admin/includes/translate.php");
require_once("admin/includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo $directionHTML ?>">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="app, landing, corporate, Creative, Html Template, Template">
    <meta name="author" content="web-themes">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- title -->
    <title>MY ACAD</title>

    <!-- favicon -->
    <link href="img/favicon.png" type="image/png" rel="icon">

    <!-- all css here -->
    <link href="css/<?php echo strtolower($directionHTML) ?>bootstrap.min.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/fontawesome.min.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/owl.carousel.min.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" /> 
    <link href="css/helper.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/select2bs.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet">
    <link href="css/nice-select.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
	<link href="css/intlTelInput.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/magnific-popup.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/srcollbar.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/style.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css?<?php echo randLetter() . "=" . rand(0000,9999) ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<!--
<div id="preloader">
    <div class="loader3">
        <span></span>
        <span></span>
    </div>
</div>
-->
<style>
    label, span, body, h2, h3{
        font-weight: 500 !important;
    }
</style>