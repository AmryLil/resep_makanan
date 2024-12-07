<?php
require_once __DIR__ . '/../config/db.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_222263'])) {
    header('Location: login.php');
    exit;
}

// Ambil ID pengguna dari session
$userId = $_SESSION['user_222263']['id'];

// Koneksi ke database
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}

// Logika untuk menghapus resep favorit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id'])) {
    $recipeId = (int) $_POST['recipe_id'];
    if ($recipeId > 0) {
        try {
            $query = 'DELETE FROM favorites_222263 WHERE user_id_222263 = ? AND resep_id_222263 = ?';
            $stmt = $pdo->prepare($query);
            $stmt->execute([$userId, $recipeId]);
            $message = 'Resep favorit berhasil dihapus.';
        } catch (PDOException $e) {
            $message = 'Terjadi kesalahan saat menghapus resep favorit: ' . $e->getMessage();
        }
    } else {
        $message = 'Data resep tidak valid.';
    }
}

// Query untuk mendapatkan resep favorit pengguna
$query = 'SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori
          FROM favorites_222263
          JOIN reseps_222263 ON favorites_222263.resep_id_222263 = reseps_222263.id
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id
          WHERE favorites_222263.user_id_222263 = ?';
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Favorit</title>
    <link href="../../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-slate-900">
<div class="px-14 pt-20 pb-20">
    <!-- Notifikasi -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-success mb-4">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Grid Resep -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($favorites)): ?>
            <p class="text-gray-500">Anda belum memiliki resep favorit.</p>
        <?php else: ?>
            <?php foreach ($favorites as $recipe): ?>
                <a href="../src/views/detail.php?id=<?php echo $recipe['id']; ?>" class="card shadow-lg bg-white rounded-lg overflow-hidden">
                    <figure>
                        <img src="/src/views/uploads/covers/<?php echo htmlspecialchars($recipe['cover_222263']); ?>" alt="Cover" class="w-full h-56 object-cover">
                    </figure>
                    <div class="card-body p-4">
                        <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($recipe['judul_222263']); ?></h2>
                        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($recipe['deskripsi_222263']); ?></p>
                        <div class="flex justify-center items-center">
                            <p>
                                <strong>Kategori:</strong> <?php echo htmlspecialchars($recipe['nama_kategori']); ?>
                            </p>
                            <form method="post" class="mt-2">
                                <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['id']); ?>">
                                <button type="submit" class="btn btn-error">Hapus</button>
                            </form>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

