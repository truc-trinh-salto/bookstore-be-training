<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../../vendor/autoload.php';

    require_once('../../database.php');

    session_start();

    $db = DBConfig::getDB();

    if (isset($_POST['btn'])) {
        $username = $_POST['username'];
        $user = check_username_existence($db, $username);

        if($user){
            send_otp_to_email($user['email'], $username);
        } else {
            header("Location: ../../views/user/forgot_password.php");
        }
    }

    function check_username_existence($conn, $username) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username =?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        return $user;
    }

    function send_otp_to_email($email, $username) {
        $mail = new PHPMailer();

        try{
            $password = file_get_contents('../../secret.txt');
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'trungtruc201563@gmail.com';
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
    
            $mail->setFrom('trungtruc201563@gmail.com', 'Admin');
            $mail->addAddress($email, 'Customer');
    
            $mail->isHTML(true);                                  
            $mail->Subject = 'Here is the subject';
            $five_minutes = time() + (10 * 60);
            $url = 'http://localhost:8080/views/user/reset_password.php?username='. $username. '&time='.$five_minutes;
            $mail->Body    = 'This is the link for reset your password <br>'.$url.'  </br>';
    
            $mail->send();
            
            $_SESSION['message'] = "OTP has been sent to your email. Please check your inbox.";

            header("Location: forgot_password.php");
    
    
        } catch (Exception $e){
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
