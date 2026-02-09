<?php
require_once 'db.php';

// Get form data
$email = $_POST['username'] ?? '';  // username field contains email
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($email) || empty($password)) {
    http_response_code(401);
    exit('Email and password are required');
}

try {
    // Find user by email
    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        http_response_code(401);
        exit('Invalid login credentials');
    }
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Generate session token
        $sessionToken = hash('sha256', $email . ':' . time());
        http_response_code(200);
        echo $sessionToken;
    } else {
        http_response_code(401);
        exit('Invalid login credentials');
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database error');
}
?>
