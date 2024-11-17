<?php
require_once __DIR__ . '/../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_222263'])) {
    $recipeId = filter_var($_POST['recipe_id'], FILTER_VALIDATE_INT);
    $userId = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
    $commentText = trim(filter_var($_POST['comment_text'], FILTER_SANITIZE_STRING));
    $commentImage = null;

    if ($recipeId && $userId && !empty($commentText)) {
        if (isset($_FILES['comment_image']) && $_FILES['comment_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/coment/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileTmpPath = $_FILES['comment_image']['tmp_name'];
            $fileExtension = pathinfo($_FILES['comment_image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('comment_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $fileName;

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($fileTmpPath);
            $maxFileSize = 2 * 1024 * 1024;

            if (in_array($fileType, $allowedTypes) && $_FILES['comment_image']['size'] <= $maxFileSize) {
                if (move_uploaded_file($fileTmpPath, $destination)) {
                    chmod($destination, 0644);
                    $commentImage = $fileName;
                } else {
                    $_SESSION['message'] = 'Gagal mengunggah foto.';
                    header('Location: detail.php?id=' . $recipeId);
                    exit;
                }
            } else {
                $_SESSION['message'] = 'Format atau ukuran file tidak valid.';
                header('Location: detail.php?id=' . $recipeId);
                exit;
            }
        }

        try {
            $database = new Database();
            $pdo = $database->connect();

            $insertQuery = 'INSERT INTO comments_222263 (resep_id_222263, user_id_222263, comment_text_222263, comment_image_222263) VALUES (?, ?, ?, ?)';
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute([$recipeId, $userId, $commentText, $commentImage]);

            $_SESSION['message'] = 'Komentar berhasil ditambahkan.';
            header('Location: detail.php?id=' . $recipeId);
            exit;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            $_SESSION['message'] = 'Terjadi kesalahan, coba lagi nanti.';
            header('Location: detail.php?id=' . $recipeId);
            exit;
        }
    } else {
        $_SESSION['message'] = 'Komentar tidak boleh kosong atau input tidak valid.';
        header('Location: detail.php?id=' . $recipeId);
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
