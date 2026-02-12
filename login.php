<?php
// Get form data
$email = $_POST['username'] ?? '';  // username field contains email
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($email) || empty($password)) {
    http_response_code(401);
    exit('Email and password are required');
}

// Only allow admin@gmail.com with password admin124
$adminEmail = 'admin@gmail.com';
$adminPassword = 'admin124';

if ($email === $adminEmail && $password === $adminPassword) {
    // Generate session token
    $sessionToken = hash('sha256', $email . ':' . time());
    http_response_code(200);
    echo $sessionToken;
} else {
    http_response_code(401);
    exit('Invalid login credentials');
}
?>
