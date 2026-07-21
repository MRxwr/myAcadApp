<?php
require_once("includes/config.php");
require_once("includes/functions.php");

header('Content-Type: application/json');

if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
    $directory = "../logos/";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
    
    $extension = getFileExtension($_FILES["file"]["name"]);
    $filename = date("d-m-y") . time() .  round(microtime(true)) . "H." . $extension;
    $targetPath = $directory . $filename;
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        echo json_encode(['status' => 'success', 'filename' => $filename]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or invalid request.']);
}
?>
