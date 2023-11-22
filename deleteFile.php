<?php
// deleteFile.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 从POST请求中获取用户名和文件名
    $username = $_POST['username'];
    $fileName = $_POST['file'];


    // 定义用户文件存储的基本路径
    $basePath = "D:/GSR/Study/Master/CP5047/Storage/";

    // 构建完整的文件路径（包括用户名子目录）
    $filePath = $basePath . $username . '/' . $fileName;



    // 检查文件是否存在
    if (file_exists($filePath)) {
        // 删除文件
        if (unlink($filePath)) {
            // 返回成功的响应
            echo json_encode(array("success" => true, "message" => "File deleted successfully"));
        } else {
            // 返回失败的响应
            echo json_encode(array("success" => false, "message" => "Error deleting file"));
        }
    } else {
        // 文件不存在的错误信息
        echo json_encode(array("success" => false, "message" => "File does not exist"));
    }
} else {
    // 非POST请求的错误信息
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
