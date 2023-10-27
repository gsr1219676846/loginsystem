<?php
session_start();

// Get the username from POST data
$username = $_POST['username'];

// Check if username is not empty
if(empty($username)){
    echo "Username is missing!";
    exit();
}

if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["file"]["tmp_name"];

    // Set the directory path based on the username
    $userDirectory = "D:/GSR/Study/Master/CP5047/Storage/" . $username;

    // Check if the directory exists; if not, create it
    if (!file_exists($userDirectory)) {
        $created = mkdir($userDirectory, 0777, true);
        if (!$created) {
            echo "Failed to create directory: " . $userDirectory;
            exit();
        }
    }

    if (!is_writable($userDirectory)) {
        echo "Directory is not writable: " . $userDirectory;
        exit();
    }

    // Move the uploaded file to the user's directory
    $destination = "$userDirectory/" . basename($_FILES["file"]["name"]);
    if (move_uploaded_file($tmp_name, $destination)) {
        echo "File uploaded successfully!";
    } else {
        echo "Failed to move uploaded file. Check file and directory permissions.";
    }
} else {
    echo "File upload error: " . $_FILES["file"]["error"];
}
?>




