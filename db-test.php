<?php
$host = "mysql";
$username = "root";
$password = "password";
$connect = false;
do {
    echo "Waiting for MySQL\n";
    sleep(2);
    try {
        mysqli_connect($host, $username, $password);
        $connect = true;
    } catch (Exception $e) {
        $connect = false;
    }
} while (!$connect);

echo "MySQL is Live\n";
