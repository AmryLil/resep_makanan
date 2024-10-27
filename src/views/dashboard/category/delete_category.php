<?php
require_once __DIR__ . '../../../../config/db.php';

// Mendapatkan category_id dari query string
$categoryId = isset($_GET['category_id_222263']) ? (int)$_GET['category_id_222263'] : null;

// Memastikan category_id ditemukan
if ($categoryId === null) {
    echo "Category ID tidak ditemukan.";
    exit;
}

try {
    // Menghubungkan ke database
    $database = new Database();
    $pdo = $database->connect();

    // Menyiapkan query untuk menghapus kategori
    $query = "DELETE FROM categories_222263 WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    // Memeriksa apakah ada baris yang dihapus
    if ($stmt->rowCount() > 0) {
        echo "Kategori berhasil dihapus.";
        header("Location: /public/admin/category"); // Redirect setelah penghapusan
        exit;
    } else {
        echo "Gagal menghapus kategori atau kategori tidak ditemukan.";
    }
} catch (PDOException $e) {
    echo "Gagal menghapus kategori: " . $e->getMessage();
}
?>