<?php
require_once 'db.php';

// Get form data
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$address = $_POST['address'] ?? '';
$sex = $_POST['sex'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($firstname) || empty($lastname) || empty($address) || empty($sex) || empty($email) || empty($password)) {
    http_response_code(400);
    exit('All fields are required');
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Invalid email format');
}

try {
    // Check if email already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        http_response_code(400);
        exit('Email already registered');
    }
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $db->prepare("INSERT INTO users (firstname, lastname, address, sex, email, password) 
                         VALUES (:firstname, :lastname, :address, :sex, :email, :password)");
    
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo 'Registration successful';
    } else {
        http_response_code(400);
        exit('Registration failed');
    }
    
} catch (PDOException $e) {
    http_response_code(400);
    exit('Database error: ' . $e->getMessage());
}
?>
