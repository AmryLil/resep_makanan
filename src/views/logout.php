<?php
session_start();

// Hancurkan semua sesi
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: /public/login");
exit;
?>