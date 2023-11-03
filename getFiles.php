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
