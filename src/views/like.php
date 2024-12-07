<?php
require_once __DIR__ . '/../config/db.php';

session_start();
if (!isset($_SESSION['user_222263'])) {
    die('Harus login terlebih dahulu');
}

$userId = $_SESSION['user_222263']['id'];
$recipeId = isset($_POST['recipeId']) ? (int) $_POST['recipeId'] : 0;

// Koneksi ke database
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}

// Query untuk mendapatkan data resep
$query = 'SELECT user_likes FROM reseps_222263 WHERE id = ?';
$stmt = $pdo->prepare($query);
$stmt->execute([$recipeId]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo json_encode(['status' => 'error', 'message' => 'Resep tidak ditemukan']);
    exit;
}

// Mendapatkan daftar user yang telah memberi like
$userLikes = explode(',', $recipe['user_likes'] ?? '');

if (in_array($userId, $userLikes)) {
    // Jika user sudah memberi like, hapus like
    $userLikes = array_diff($userLikes, [$userId]);
} else {
    // Jika user belum memberi like, tambahkan like
    $userLikes[] = $userId;
}

// Update jumlah like dan daftar user yang memberi like
$userLikesStr = implode(',', $userLikes);
$likesCount = count($userLikes);

// Update database
$updateQuery = 'UPDATE reseps_222263 SET user_likes = ?, likes = ? WHERE id = ?';
$stmt = $pdo->prepare($updateQuery);
$stmt->execute([$userLikesStr, $likesCount, $recipeId]);

echo json_encode([
    'status' => 'success',
    'likes' => $likesCount,
    'liked' => in_array($userId, $userLikes)
]);
?>
