<?php
require_once __DIR__ . '../../../config/db.php';

try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die("Gagal terhubung ke database: " . $e->getMessage());
}

// Query dengan JOIN untuk menggabungkan tabel reseps dan categories
$query = "SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori 
          FROM reseps_222263 
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-2 h-full">
    <div class="flex justify-between bg-black items-center p-4 rounded-lg mb-3">
        <h1 class="text-3xl font-bold text-white">Daftar Resep</h1>
    </div>
    <ul class="list-none space-y-4 cursor-pointer">
        <?php foreach ($books as $book): ?>
            <li class="bg-white shadow-md p-3 flex items-start space-x-4 border border-slate-400 rounded-lg hover:bg-gray-950 hover:text-white transition-all duration-200">
                <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($book['cover_222263']); ?>" alt="Cover" class="w-32 h-48 object-cover rounded-md">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($book['judul_222263']); ?></h2>
                    <p class="mb-2"><strong>Kategori:</strong> <?php echo htmlspecialchars($book['nama_kategori']); ?></p>
                    <p class="mb-4"><?php echo htmlspecialchars($book['deskripsi_222263']); ?></p>
                    <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($book['jumlah_222263']); ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
