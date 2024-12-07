<?php
require_once __DIR__ . '../../../../config/db.php';  // Path ke konfigurasi database Anda
require_once __DIR__ . '../../../../../vendor/autoload.php';  // Autoload dependencies jika diperlukan

// Inisialisasi koneksi ke database
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
$query = 'SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori, 
(SELECT COUNT(*) FROM comments_222263 WHERE comments_222263.resep_id_222263 = reseps_222263.id) AS jumlah_komentar
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Resep</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <!-- Tambahkan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="../../../../dist/output.css">

</head>
<body>
<?php include '../src/views/dashboard/sidebar.php' ?>

<div class="container mt-5 pl-72">
    <h1 class="mb-4 font-bold text-3xl">Laporan Resep</h1>

    <!-- Form Filter -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Tanggal Mulai:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Tanggal Akhir:</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="/../src/views/downloadpdf.php" class="btn btn-secondary w-100 text-white text-decoration-none">Unduh PDF</a>
        </div>
    </form>

    <!-- Display the total number of recipes -->
    <p class="mb-4">Jumlah Resep: <strong><?php echo count($reseps); ?></strong></p>

    <!-- Tabel Data -->
    <table id="dataTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Cover</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Durasi Memasak</th>
            <th>Jumlah Like</th>
            <th>Jumlah Komentar</th> <!-- Kolom baru untuk Jumlah Komentar -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reseps as $resep): ?>
            <tr>
                <td>
                    <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($resep['cover_222263']); ?>" alt="Cover" class="img-thumbnail" style="width: 100px; height: auto;">
                </td>
                <td><?php echo htmlspecialchars($resep['judul_222263']); ?></td>
                <td><?php echo htmlspecialchars($resep['nama_kategori']); ?></td>
                <td><?php echo htmlspecialchars($resep['jumlah_222263']); ?> Menit</td>
                <td><?php echo htmlspecialchars($resep['likes']); ?></td>
                <td><?php echo htmlspecialchars($resep['jumlah_komentar']); ?></td> <!-- Tampilkan Jumlah Komentar -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<!-- Tambahkan Bootstrap dan DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Inisialisasi DataTables dengan konfigurasi yang lengkap
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "lengthMenu": [5, 10, 25, 50],
            "pageLength": 5,
            dom: 'Bfrtip', // menambahkan tombol ekspor
            buttons: [
                'copy', 
                'excel', 
                'pdf', 
                'colvis' // tombol untuk mengatur visibilitas kolom
            ]
        });
    });
</script>

</body>
</html>
