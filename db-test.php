<?php
$host = "mysql";
$username = "root";
$password = "password";
$conn;
do {
    try {
        $conn = mysqli_connect($host, $username, $password);
    } catch (Exception $e) {
        echo "Waiting for MySQL\n";
    }
} while (mysqli_connect_errno());
mysqli_close($conn);
echo "MySQL is Live\n";
