<?php
session_start();
require_once('../../database.php');
$db = DBConfig::getDB();

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $target_dir = "public/assets/img/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

    echo $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Kiểm tra file có phải là hình ảnh thật hay không
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Giới hạn kích thước file
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Giới hạn loại file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk là 0 do có lỗi
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // Nếu mọi thứ đều ổn, thử upload file
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir)) {
            echo "The file ". basename( $_FILES["profile_image"]["name"]). " has been uploaded.";

            // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
            $stmt = $db->prepare("UPDATE users SET image = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            echo "Profile image has been updated in the database.";

            $_SESSION['message'] = "Profile image has been updated successfully.";
            header("Location: profile.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
            $_SESSION['message'] = "Profile image has been updated successfully.";
            header("Location: ../../views/user/profile.php");
        }
    }
}
