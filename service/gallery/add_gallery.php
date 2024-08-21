<?php
session_start();
require_once('../../database.php');
$db = DBConfig::getDB();

$book_id = $_POST['book_id'];

if (isset($_POST['submit'])) {
    $target_dir = "public/assets/img/";
    $index = 0;
    for($i = 0;$i < count($_FILES['profile_image']['name']); $i++) {
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"][$i]);

        echo $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Kiểm tra file có phải là hình ảnh thật hay không
        $check = getimagesize($_FILES["profile_image"]["tmp_name"][$i]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Kiểm tra nếu file đã tồn tại
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            // $uploadOk = 0;
        } else {
            move_uploaded_file($_FILES["profile_image"]["tmp_name"][$i], $target_dir);
        }

        // Giới hạn kích thước file
        if ($_FILES["profile_image"]["size"][$i] > 500000) {
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
            $_SESSION['message'] .= ($index > 0?"<br>" : ""). "Thêm hình ảnh ".basename($_FILES["profile_image"]["name"][$i])." thất bại";
            header("Location: ". $_SERVER['HTTP_REFERER']);
        } else {
                echo "The file ". basename( $_FILES["profile_image"]["name"][$i]). " has been uploaded.";

                // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
                $stmt = $db->prepare("INSERT INTO gallery_image(address,book_id,isShow) values (?,?,0)");
                $stmt->bind_param("si", $target_file, $book_id);
                $stmt->execute();
                // echo "Profile image has been updated in the database.";

                $_SESSION['message'] .= ($index > 0?"<br>" : ""). "Thêm hình ảnh ".basename($_FILES["profile_image"]["name"][$i])." Thành công";
                header("Location: ". $_SERVER['HTTP_REFERER']);
        }
        $index++;
    }
}
