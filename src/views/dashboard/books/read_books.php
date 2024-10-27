<?php
require_once __DIR__ . '../../../../config/db.php';

try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die("Gagal terhubung ke database: " . $e->getMessage());
}

$query = "SELECT * FROM reseps_222263";
$stmt = $pdo->prepare($query);
$stmt->execute();
$reseps = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-2 h-full">
    <div class="flex justify-between bg-black items-center p-4 rounded-lg mb-3">
        <h1 class="text-3xl font-bold text-white">Kelola Resep</h1>
        <a href="/public/admin/add-book">
            <button class="bg-white rounded-lg shadow-sm p-1 px-4 text-slate-950 font-bold text-lg">Add Book</button>
        </a>
    </div>
    <ul class="list-none space-y-4">
    <?php foreach ($reseps as $resep): ?>
        <li class="bg-white shadow-md p-3 flex items-start space-x-4 border border-slate-400 rounded-lg hover:bg-gray-950 hover:text-white transition-all duration-200">
            <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($resep['cover_222263']); ?>" alt="Cover" class="w-32 h-48 object-cover rounded-md">
            <div class="flex-1">
                <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($resep['judul_222263']); ?></h2>
                <p class="mb-2"><strong>Kategori:</strong> <?php echo htmlspecialchars($resep['kategori_222263']); ?></p>
                <p class="mb-4"><?php echo htmlspecialchars($resep['deskripsi_222263']); ?></p>
                <p><strong>Durasi memasak:</strong> <?php echo htmlspecialchars($resep['jumlah_222263']); ?> Menit</p>
            </div>

            <!-- Tombol Update -->
            <form action="/public/admin/update-book" method="GET" class="inline-block">
                <input type="hidden" name="book_id_222263" value="<?php echo $resep['id']; ?>">
                <button type="submit" class="bg-yellow-600 p-1 px-3 text-base rounded-lg text-white font-bold">Update</button>
            </form>

            <!-- Tombol Delete -->
            <form action="/public/admin/delete-book" method="GET" class="inline-block">
                <input type="hidden" name="book_id_222263" value="<?php echo $resep['id']; ?>">
                <button type="submit" class="bg-red-600 p-1 px-3 text-base rounded-lg text-white font-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Delete</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
</div>
