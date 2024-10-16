<?php
session_start();
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to index.php
exit();
?>