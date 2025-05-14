<?php
$email = 'admin@example.com';
$password = 'admin@123';
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo 'Hashed Password: ' . $hashed;
