<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db.php';
require 'vendor/autoload.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $verify_code = rand(100000, 999999); 
    $verify = 0; 

    
    $stmt = $pdo->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "Email already exists!";
    } else {
        
        $sql = "INSERT INTO account (email, password, verify_code, verify) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$email, $password, $verify_code, $verify])) {
            
            $mail = new PHPMailer(true);
            try {
                
                $mail->isSMTP();
                $mail->Host       = 'smtp.example.com'; // Set your SMTP server here
                $mail->SMTPAuth   = true;
                $mail->Username   = 'your_email@example.com'; // SMTP username
                $mail->Password   = 'your_email_password'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                
                $mail->setFrom('your_email@example.com', 'Your Website');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email Address';
                $mail->Body    = "Please verify your email by using this code: <b>$verify_code</b>";

                $mail->send();
                echo 'Signup successful! Please check your email for verification.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error during signup.";
        }
    }
}
?>

<form method="post" action="signup.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Sign Up">
</form>
