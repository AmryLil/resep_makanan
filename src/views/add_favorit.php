<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? null;
    $recipeId = $_POST['recipeId'] ?? null;

    if ($userId && $recipeId) {
        try {
            $database = new Database();
            $pdo = $database->connect();

            // Validasi untuk mengecek apakah resep sudah ada di favorit
            $checkQuery = 'SELECT COUNT(*) FROM favorites_222263 WHERE user_id_222263 = ? AND resep_id_222263 = ?';
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([$userId, $recipeId]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                echo 'Resep sudah ada di daftar favorit.';
            } else {
                $query = 'INSERT INTO favorites_222263 (user_id_222263, resep_id_222263) VALUES (?, ?)';
                $stmt = $pdo->prepare($query);
                $stmt->execute([$userId, $recipeId]);

                header('Location: detail.php?id=' . $recipeId);
                exit;
            }
        } catch (PDOException $e) {
            echo 'Gagal menambahkan resep ke favorit: ' . $e->getMessage();
        }
    } else {
        echo 'User ID atau Recipe ID tidak valid.';
    }
} else {
    echo 'Metode request tidak valid.';
}
