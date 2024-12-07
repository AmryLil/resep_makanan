<?php
require_once __DIR__ . '../../../../config/db.php';
require_once __DIR__ . '../../../../../vendor/autoload.php';  // Autoload dependencies for FPDF

// Make sure no output is sent before this point

try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}

// Ambil filter tanggal
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Query data berdasarkan filter tanggal
$query = 'SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori 
          FROM reseps_222263 
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id';

if (!empty($startDate) && !empty($endDate)) {
    $query .= ' WHERE reseps_222263.created_at_222263 BETWEEN :start_date AND :end_date';
}

$stmt = $pdo->prepare($query);

if (!empty($startDate) && !empty($endDate)) {
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
}

$stmt->execute();
$reseps = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Logika untuk unduh PDF

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Resep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
<div class="container mx-auto p-4">
    <div class="flex justify-between bg-black items-center p-4 rounded-lg mb-3">
        <h1 class="text-3xl font-bold text-white">Kelola Resep</h1>
        <a href="/public/admin/add-book">
            <button class="bg-white rounded-lg shadow-sm p-1 px-4 text-slate-950 font-bold text-lg">Tambah Resep</button>
        </a>
    </div>

    <!-- Form Filter -->
    <!-- <form method="GET" class="flex items-center space-x-4 mb-4">
        <div>
            <label for="start_date" class="block text-sm font-medium">Tanggal Mulai:</label>
            <input type="date" id="start_date" name="start_date" class="border rounded-md p-1" value="<?php echo htmlspecialchars($startDate); ?>">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium">Tanggal Akhir:</label>
            <input type="date" id="end_date" name="end_date" class="border rounded-md p-1" value="<?php echo htmlspecialchars($endDate); ?>">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-md font-semibold">Filter</button>
        </div>
        <div>
            <button type="submit" name="download_pdf" class="bg-green-600 text-white p-2 rounded-md font-semibold"> <a href="/../src/views/downloadpdf.php" >Unduh Pdf

            </a></button>
        </div>
    </form> -->

    <!-- Tabel Data -->
    <ul class="list-none space-y-4">
        <?php foreach ($reseps as $resep): ?>
            <li class="bg-white shadow-md p-3 flex items-start space-x-4 border border-slate-400 rounded-lg">
                <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($resep['cover_222263']); ?>" alt="Cover" class="w-32 h-48 object-cover rounded-md">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($resep['judul_222263']); ?></h2>
                    <p class="mb-2"><strong>Kategori:</strong> <?php echo htmlspecialchars($resep['nama_kategori']); ?></p>
                    <p class="mb-4"><?php echo htmlspecialchars($resep['deskripsi_222263']); ?></p>
                    <p><strong>Durasi memasak:</strong> <?php echo htmlspecialchars($resep['jumlah_222263']); ?> Menit</p>
                </div>
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
</body>
</html>
