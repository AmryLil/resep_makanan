<?php
require_once __DIR__ . '/../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_222263'])) {
    $recipeId = (int) $_POST['recipe_id'];
    $userId = (int) $_POST['user_id'];
    $commentText = trim($_POST['comment_text']);

    if (!empty($commentText)) {
        try {
            $database = new Database();
            $pdo = $database->connect();
            $insertQuery = 'INSERT INTO comments_222263 (resep_id_222263, user_id_222263, comment_text_222263) VALUES (?, ?, ?)';
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute([$recipeId, $userId, $commentText]);
            header('Location: detail.php?id=' . $recipeId);
            exit;
        } catch (PDOException $e) {
            die('Gagal menyimpan komentar: ' . $e->getMessage());
        }
    } else {
        echo 'Komentar tidak boleh kosong.';
    }
} else {
    header('Location: login.php');
    exit;
}
?>
