<?php
require_once __DIR__ . '/../config/db.php';

// Pastikan user sudah login
$user_id = isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;

if ($user_id === null) {
    echo 'User ID tidak ditemukan. Pastikan Anda sudah login.';
    exit;
}

?>

<div class="container mx-auto p-6 mt-16 h-screen justify-center items-center">
    <div class="text-5xl font-bold w-full h-screen text-center">Kategori Page SOON.....</div>
</div>
