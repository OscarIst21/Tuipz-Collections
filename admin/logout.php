<?php
session_start();
require_once __DIR__ . '/../config.php';
admin_logout();
header('Location: login.php');
exit;
