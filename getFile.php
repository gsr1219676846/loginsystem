<?php
/*
getFile.php
- Serves the purpose of fetching and displaying user-specific files from the server based on file type.
- Key operations include:
  1. Receiving GET request parameters: 'file' (file name) and 'username' to locate the specific file.
  2. Constructing the file path using a predefined base path and the provided username and filename.
  3. Verifying if the requested file exists in the user's directory.
  4. Determining the file's type and serving it with the appropriate content type header.
     - Handles different file types like PDF, HTML, and TXT, with the possibility to extend support for more formats.
     - For PDFs, it reads and outputs the file in a binary stream format.
     - For HTML and TXT files, it fetches and echoes the file contents directly.
  5. If the file does not exist, returning an error message indicating so.
  6. Handling cases where either the username or file parameter is missing by returning an error message.
- This script is crucial for the file retrieval functionality of the extension, allowing users to access and view their stored files directly in the browser.
*/
?>




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
