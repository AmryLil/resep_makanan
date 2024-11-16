<?php
require_once __DIR__ . '/../config/db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_222263'])) {
    header('Location: login.php');  // Arahkan ke halaman login jika belum login
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($favorites)): ?>
            <p class="text-gray-500">Anda belum memiliki resep favorit.</p>
        <?php else: ?>
            <?php foreach ($favorites as $recipe): ?>
                <div class="card shadow-lg bg-white rounded-lg overflow-hidden">
                    <figure>
                        <img src="/src/views/uploads/covers/<?php echo htmlspecialchars($recipe['cover_222263']); ?>" alt="Cover" class="w-full h-56 object-cover">
                    </figure>
                    <div class="card-body p-4">
                        <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($recipe['judul_222263']); ?></h2>
                        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($recipe['deskripsi_222263']); ?></p>
                        <p>
                            <strong>Kategori:</strong> <?php echo htmlspecialchars($recipe['nama_kategori']); ?>
                        </p>
                       
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
   
</div>
</body>
</html>
