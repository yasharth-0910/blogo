<?php

session_start();
define('ROOT_URL', 'http://localhost/test/');
define('DB_HOST', 'localhost');
define('DB_USER', 'yasharth');
define('DB_PASS', 'admin');
define('DB_NAME', 'blogosphere');

if (!isset($_SESSION['user-id'])) {
    header("location: " . ROOT_URL . "logout.php");
    //destroy all sessions and redirect user to login page
    session_destroy();
    die();
    header("location: " . ROOT_URL . "signin.php");
}