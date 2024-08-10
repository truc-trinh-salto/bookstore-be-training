<?php 
    session_start();
    require_once('database.php');
    if(isset($_POST['submit'])){
        $user_id = $_SESSION['user_id'];

        $fullname = $_POST['fullname'];
        $phonenumber = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];

        $db = DBConfig::getDB();
        
        $stmt = $db->prepare("UPDATE users SET fullname =?, phonenumber =?, birthday =?, email =? WHERE id =?");
        $stmt->bind_param("ssssi", $fullname, $phonenumber, $birthday, $email, $user_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $_SESSION['message'] = "Profile updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update profile!";
        }

        header("Location: profile.php");

    }
?>