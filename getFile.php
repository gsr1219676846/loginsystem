<?php
if(isset($_GET['file']) && isset($_GET['username'])) {
    $fileName = $_GET['file'];
    $username = $_GET['username'];

    // 定义用户文件存储的基本路径
    $basePath = "D:/GSR/Study/Master/CP5047/Storage/";

    // 构建完整的文件路径（包括用户名子目录）
    $filePath = $basePath . $username . '/' . $fileName;

    // 检查文件是否存在
    if(file_exists($filePath)) {
        // 获取文件扩展名
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        switch ($fileExtension) {
            case 'pdf':
                header('Content-Type: application/pdf');
                $file = fopen($filePath, "rb");
                fpassthru($file);
                fclose($file);
                break;

            case 'html':
                // 对于 HTML 文件
                header('Content-Type: text/html');
                echo file_get_contents($filePath);
                break;

            case 'txt':
                // 对于文本文件
                header('Content-Type: text/plain');
                echo file_get_contents($filePath);
                break;

            // 可以根据需要添加更多文件类型的处理

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
