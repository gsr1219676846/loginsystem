<?php
// deleteFile.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and filename from POST request
    $username = $_POST['username'];
    $fileName = $_POST['file'];


    //Define the basic path for user file storage
    $basePath = "D:/GSR/Study/Master/CP5047/Storage/";

    // Build the complete file path (including username subdirectory)
    $filePath = $basePath . $username . '/' . $fileName;



    // Check if the file exists
    if (file_exists($filePath)) {
        // Delete Files
        if (unlink($filePath)) {
            //Return successful response
            echo json_encode(array("success" => true, "message" => "File deleted successfully"));
        } else {
            //Return failed response
            echo json_encode(array("success" => false, "message" => "Error deleting file"));
        }
    } else {
        // Error message that the file does not exist
        echo json_encode(array("success" => false, "message" => "File does not exist"));
    }
} else {
    // Error message for non-POST requests
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
