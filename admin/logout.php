<?php
session_start();
session_destroy();
setcookie("remember_me", "", time() - 3600, "/"); // Expire the "Remember Me" cookie

header("Location: login.php");
exit;
?>
