<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'ls-dd4af8cf955490fff21b5b6a14b67d56a90ae3eb.cfp0h459lz09.a$
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', '12345678');
define('DB_NAME', 'inspirecloud');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

