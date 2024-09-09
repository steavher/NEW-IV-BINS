<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <style>

body {
	height: 100vh;
	align-items: center;
	justify-content: center;
	display: flex;
}

        form {
            width: 90%; 
            max-width: 500px;
            border: 5px solid #ccc;
            padding: 30px;
            background: #fff;
            border-radius: 30px;
            border-color: #4fa2ed;
            background: rgba(225, 225, 225, 0.8);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        input {
	background: rgba(225, 225, 225, 0.5);
	display: block;
	width: 100%; 
	padding: 10px;
	margin: 10px auto;
	border-radius: 10px;
}
    </style>
</head>
<body>
    
</body>
</html>
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if account exists
    $stmt = $pdo->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            if ($user['verify'] == 1) {
                echo "Login successful!";
                // Add session or redirect here
            } else {
                echo "Please verify your email first.";
            }
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
<!-- Simple Login Form -->
<form method="post" action="login.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Login">
</form>
