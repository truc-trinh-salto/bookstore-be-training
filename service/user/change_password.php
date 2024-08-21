<?php 
    session_start();

    require_once('../../database.php');

    if(isset($_POST['submit']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $user_id = $_SESSION['user_id'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? and password = ?");
        $stmt->bind_param("is", $user_id, $old_password);
        $stmt->execute();

        $count = $stmt->affected_rows;
        if($count < 0) {
            $_SESSION['message'] = 'Invalid old password';
            header("Location: ../../views/user/profile.php");
        }

        if($new_password!= $confirm_password) {
            $_SESSION['message'] = 'Passwords do not match';
            header("Location: ../../views/user/profile.php");
        }

        $stmt = $db->prepare("UPDATE users SET password =? WHERE id =?");
        $stmt->bind_param("si", $new_password, $user_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $_SESSION['message'] = 'Password changed successfully!';
        } else {
            $_SESSION['message'] = 'Failed to change password!';
        }

        header("Location:../../views/user/profile.php");
    }

    if(isset($_POST['btn']) && isset($_POST['pwd']) && isset($_POST['pwd2'])) {
        $db = DBConfig::getDB();
        $username = $_POST['username'];
        $new_password = $_POST['pwd'];
        $confirm_password = $_POST['pwd2'];

        if($new_password!= $confirm_password) {
            $_SESSION['message'] = 'Passwords do not match';
            header("Location: reset_password?username=".$username.".php");
        } else {
            $stmt = $db->prepare("UPDATE users SET password =? WHERE username =?");
            $stmt->bind_param("ss", $new_password, $username);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                $_SESSION['message'] = 'Password changed successfully!';
            } else {
                $_SESSION['message'] = 'Failed to change password!';
            }

            header("Location: ../../index.php");
            }
    }

?>