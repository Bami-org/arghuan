<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once ("config.php");
// Handle form submission
$id = $_COOKIE['arghona'];
$expiration_time = time() - 3600;
// Remove the cookie
setcookie('arghona', '', $expiration_time, '/');
header("Location: login.php");