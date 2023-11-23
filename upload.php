<?php
/*
upload.php
- Handles the file upload process for the extension.
- Key operations include:
  1. Starting a new session and retrieving the username from POST data.
  2. Validating the presence of the username and handling any errors related to missing usernames.
  3. Processing the file upload:
     - Checking for upload errors and handling them appropriately.
     - Setting the destination directory for uploads based on the username.
     - Creating the user's directory if it doesn't exist, with appropriate permissions.
     - Verifying write permissions for the directory.
     - Moving the uploaded file to the designated directory.
  4. Providing feedback on the success or failure of the file upload, including detailed error messages if necessary.
- This script is crucial for enabling users to upload files to their specific user directory, ensuring a smooth and secure file management experience within the extension.
*/
?>



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




