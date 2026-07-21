<?php
require ("admin/includes/config.php");
require ("admin/includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Academy</title>
    <link rel="shortcut icon" href="logos/logoNew.png" />
    <style>
        body {
            background-color: #011133;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: white;
        }
        .logo-container {
            text-align: center;
        }
        .logo-container img {
            width: 180px;
            height: auto;
            margin-bottom: 20px;
        }
        .logo-container h1 {
            font-size: 32px;
            font-weight: 600;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="logos/logoNew.png" alt="My Academy Logo" />
        <h1>My Academy</h1>
    </div>
</body>
</html>
