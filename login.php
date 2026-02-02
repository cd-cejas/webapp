<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$hashkey = hash('sha256', 'admin@gmail.com:admin124');

if ($hashkey !== hash('sha256', "$username:$password")) {
    http_response_code(401);
    exit('invalid');
}

echo $hashkey;

?>