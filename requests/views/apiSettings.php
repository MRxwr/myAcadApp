<?php 
$settings = selectDB2("`version`, `enTerms`, `arTerms`, `enPolicy`, `arPolicy`","settings","`id` = '1'" );
$social = selectDB2("`whatsapp`, `instagram`, `tiktok`, `snapchat`, `location`, `email`","social_media","`id` = '1'");
$response["settings"] = $settings;
$response["social"] = $social[0];
echo outputData($response);
?>