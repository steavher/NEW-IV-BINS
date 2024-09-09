<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $code = $_POST['verify_code'];

    
    $stmt = $pdo->prepare("SELECT * FROM account WHERE email = ? AND verify_code = ?");
    $stmt->execute([$email, $code]);
    if ($stmt->rowCount() > 0) {
        
        $stmt = $pdo->prepare("UPDATE account SET verify = 1 WHERE email = ?");
        if ($stmt->execute([$email])) {
            echo "Email verified successfully!";
            
        } else {
            echo "Verification failed!";
        }
    } else {
        echo "Invalid verification code!";
    }
}
?>

<form method="post" action="verify.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="verify_code" placeholder="Verification Code" required><br>
    <input type="submit" value="Verify">
</form>
