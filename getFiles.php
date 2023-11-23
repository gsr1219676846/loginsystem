<?php
/*
getFiles.php
- Facilitates the retrieval of a list of files specific to a user.
- Key functionalities include:
  1. Checking for a POST request with 'username' to identify the relevant user.
  2. Building the path to the user-specific directory using a predefined base path and the username.
  3. Verifying the existence of the user's directory.
  4. Scanning the directory and compiling a list of files, excluding system directories like '.' and '..'.
  5. Returning the list of files in JSON format, making it easy to process on the client side.
  6. Handling error scenarios, such as the absence of the 'username' parameter or the user's directory not being found, by returning appropriate error messages in JSON format.
- This script is essential for the file management aspect of the extension, allowing users to view the list of their stored files in the extension's interface.
*/
?>


<?php

if(isset($_POST['username'])) {
    $username = $_POST['username'];

    // Define the user's directory path
    $userDirectory = 'D:/GSR/Study/Master/CP5047/Storage/' . $username;

    // Check if the directory exists
    if(is_dir($userDirectory)) {
        // Scan the directory to get the list of files
        $files = array_values(array_diff(scandir($userDirectory), array('.', '..')));


        // Return the list of files in JSON format
        echo json_encode($files);
    } else {
        echo json_encode(array('error' => 'Directory not found.'));
    }
} else {
    echo json_encode(array('error' => 'Username not provided.'));
}

?>
