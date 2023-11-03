<?php
if(isset($_POST['file']) && isset($_POST['username'])) {
    $fileName = $_POST['file'];
    $username = $_POST['username'];

    // 定義用戶文件存儲的基本路徑
    $basePath = "D:/GSR/Study/Master/CP5047/Storage/";

    // 构建完整的文件路径（包括用户名子目录）
    $filePath = $basePath . $username . '/' . $fileName;

    // 检查文件是否存在
    if(file_exists($filePath)) {
        // 读取并返回文件内容
        $content = file_get_contents($filePath);
        echo $content;
    } else {
        echo "File not found.";
    }
} else {
    echo "File or username parameter is missing.";
}


?>
