<?php require_once __DIR__ . '/../config.php';
unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_type']);
session_regenerate_id(true);
header('Location: login.php');
exit;
