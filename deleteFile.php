<?php
/*
deleteFile.php
- Handles the deletion of user-specific files from the server.
- Key operations include:
  1. Receiving a POST request with the username and filename to identify which file to delete.
  2. Constructing the full file path based on a predefined base path and the provided username and filename.
  3. Checking if the specified file exists in the user's directory.
  4. If the file exists, attempting to delete it using the unlink() function.
     - If the deletion is successful, returning a JSON response indicating success.
     - If the deletion fails, returning a JSON response indicating the failure along with an error message.
  5. If the file does not exist, returning an error message indicating so.
  6. Handling non-POST requests by returning an error message, ensuring the script responds only to valid deletion requests.
- This script is essential for managing file deletion in the extension, providing a secure and efficient way to remove user files from the server.
*/
?>

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
