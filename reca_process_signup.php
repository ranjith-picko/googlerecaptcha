<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['g-recaptcha-response'];

    if (!$captcha) {
        $_SESSION['error'] = 'Please complete the CAPTCHA.';
        header("Location: reca_signup.php");
        exit();
    }

   
    $secretKey = '6Le5yBMqAAAAAIveRGh08s_z3F5Y1gYr2QuRrB_B';
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys
    = json_decode($response, true);

    if(intval($responseKeys["success"]) !== 1) {
        $_SESSION['error'] = 'CAPTCHA validation failed. Please try again.';
        header("Location: reca_signup.php");
        exit();
    }

  
    echo "CAPTCHA validation successful!<br>";
    echo "Username: " . htmlspecialchars($username) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";
    
    
} else {
    echo "Invalid request.";
}
