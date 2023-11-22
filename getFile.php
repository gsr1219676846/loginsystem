<?php
if(isset($_GET['file']) && isset($_GET['username'])) {
    $fileName = $_GET['file'];
    $username = $_GET['username'];

    //Define the basic path for user file storage
    $basePath = "D:/GSR/Study/Master/CP5047/Storage/";

    // Build the complete file path (including username subdirectory)
    $filePath = $basePath . $username . '/' . $fileName;

    // Check if the file exists
    if(file_exists($filePath)) {
        // Get file extension
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        switch ($fileExtension) {
            case 'pdf':
                header('Content-Type: application/pdf');
                $file = fopen($filePath, "rb");
                fpassthru($file);
                fclose($file);
                break;

            case 'html':
                // for HTML files
                header('Content-Type: text/html');
                echo file_get_contents($filePath);
                break;

            case 'txt':
                // for text files
                header('Content-Type: text/plain');
                echo file_get_contents($filePath);
                break;

            // You can add more file type processing as needed

            default:
                echo "Unsupported file type.";
                break;
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "Username or file parameter is missing.";
}
?>
