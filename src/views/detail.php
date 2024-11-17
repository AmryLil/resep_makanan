<?php
require_once __DIR__ . '/../config/db.php';

// Ambil ID dari query string
session_start();
$isLoggedIn = isset($_SESSION['user_222263']);
$role = $_SESSION['role'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Koneksi ke database
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}
// Query untuk mengambil komentar yang terkait dengan resep
$commentQuery = 'SELECT comments_222263.comment_text_222263, 
                        comments_222263.comment_image_222263, 
                        comments_222263.created_at_222263, 
                        users_222263.fullname_222263
                 FROM comments_222263
                 JOIN users_222263 ON comments_222263.user_id_222263 = users_222263.id
                 WHERE comments_222263.resep_id_222263 = ?
                 ORDER BY comments_222263.created_at_222263 DESC';
$commentStmt = $pdo->prepare($commentQuery);
$commentStmt->execute([$id]);
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mendapatkan data resep berdasarkan ID
$query = 'SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori
          FROM reseps_222263
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id
          WHERE reseps_222263.id = ?';
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo 'Resep tidak ditemukan.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resep</title>
    <link href="../../dist/output.css" rel="stylesheet">
    <style>
    .loved {
        color: red; /* Merah untuk loved */
    }

    /* Efek transisi */
    #loveIcon {
        transition: color 0.3s ease, transform 0.3s ease;
        color: white; /* Warna default ikon adalah putih */
    }

    /* Animasi skala */
    .scale-up {
        transform: scale(1.2);
    }
</style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto ">
    <div class="card lg:card-side shadow-xl h-screen text-slate-800">
        <figure class="w-1/2">
            <img
                class="h-full object-cover w-full"
                src="/../src/views/uploads/covers/<?php echo htmlspecialchars($recipe['cover_222263']); ?>"
                alt="Cover" />
        </figure>
        <div class="card-body overflow-auto">
            <h2 class="card-title text-2xl font-bold mb-4"><?php echo htmlspecialchars($recipe['judul_222263']); ?></h2>
            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($recipe['deskripsi_222263']); ?></p>

            <p>
                <strong class="mb-2">Kategori:</strong><br>
                <?php echo htmlspecialchars($recipe['nama_kategori']); ?>
            </p>

            <p>
                <strong class="mb-2">Waktu Pembuatan:</strong><br>
                <?php echo htmlspecialchars($recipe['jumlah_222263']); ?> menit
            </p>

            <p class="">
            <strong class="mb-2">Bahan:</strong><br>
            <?php
                // Menghapus semua angka yang diikuti titik
                $bahan = preg_replace('/\d+\./', '', $recipe['bahan_222263']);  // Menghilangkan angka dan titik di seluruh teks
                $bahan_array = array_filter(array_map('trim', explode(',', $bahan)));

                // Membuat list dengan bullet points
                echo '<ul style="padding-left:40px; list-style-type: disc;">';  // Menambahkan style untuk memastikan bullet points
                foreach ($bahan_array as $item) {
                    if (!empty(trim($item))) {
                        echo '<li>' . htmlspecialchars($item) . '</li>';  // Menampilkan bahan dalam list dengan bullet point
                    }
                }
                echo '</ul>';
            ?>



            </p>

            <p class=""> 
                <strong class="mb-2">Cara Membuat:</strong><br>
                <?php
                    // Menghapus angka diikuti titik pada awal setiap langkah
                    $langkah = preg_replace('/\d+\./', '', $recipe['langkah_pembuatan_222263']);  // Menghilangkan angka dan titik di awal langkah
                    $langkah_array = array_filter(array_map('trim', explode(',', $langkah)));

                    // Membuat list dengan bullet points
                    echo '<ul style="padding-left:40px; list-style-type: disc;">';
                    foreach ($langkah_array as $item) {
                        if (!empty(trim($item))) {
                            echo '<li>' . htmlspecialchars($item) . '</li>';  // Menampilkan langkah dalam list dengan bullet point
                        }
                    }
                    echo '</ul>';
                ?>

            </p>
            <div class="card-actions justify-end mt-6">
                <?php if ($isLoggedIn): ?>
                <form action="/../src/views/add_favorit.php" method="post">
                    <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_SESSION['user_222263']['id']); ?>">
                    <input type="hidden" name="recipeId" value="<?php echo htmlspecialchars($recipe['id']); ?>">
                    <button type="submit" class="btn btn-accent">
                    <span id="loveIcon" style="color: white;">❤️</span> Tambah ke Favorit
                    </button>
                </form>
                <?php endif; ?>

                <a href="javascript:history.back()" class="">
                    <button class="btn btn-error">
                    Kembali
                    </button>
                </a>
            </div>
            <img src="/../uploads/coment/comment_673894a596195_op1.png" alt="foto">
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-3">Komentar</h3>
                
                <?php if (empty($comments)): ?>
                    <p class="text-gray-500">Belum ada komentar.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
    <div class="border-b border-gray-300 py-2">
        <div class="text-gray-800 font-bold text-lg flex items-center gap-1">
            <div class="avatar">
                <div class="w-8 rounded-full">
                    <img src="https://i.pinimg.com/736x/44/84/b6/4484b675ec3d56549907807fccf75b81.jpg" />
                </div>
            </div>    
            <span class="font-bold text-l"><?php echo htmlspecialchars($comment['fullname_222263']); ?> </span>
        </div>
        <p class="text-gray-600"><?php echo htmlspecialchars($comment['comment_text_222263']); ?></p>
 

<?php if (!empty($comment['comment_image_222263'])): ?>
    <img src="/../uploads/coment/<?php echo htmlspecialchars($comment['comment_image_222263']); ?> " 
         alt="Komentar Gambar"
         class="mt-2 w-32 h-32 object-cover rounded">
<?php else: ?>
    <p class="text-sm text-gray-500">Tidak ada gambar.</p>
<?php endif; ?>
        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($comment['created_at_222263']); ?></p>
    </div>
<?php endforeach; ?>

                <?php endif; ?>
            </div>

            <?php if ($isLoggedIn): ?>
                <form action="/../src/views/add_commen.php" method="post" enctype="multipart/form-data" class="mt-4">
    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($id); ?>">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_222263']['id']); ?>">
    <textarea name="comment_text" class="w-full p-2 border rounded" placeholder="Tulis komentar Anda..." required></textarea>
    <input type="file" name="comment_image" accept="image/*" class="mt-2">
    <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
</form>

            <?php endif; ?>

        </div>
    </div>
</div>
<script>
    function toggleLove() {
        const loveButton = document.getElementById('loveButton');
        const loveIcon = document.getElementById('loveIcon');

        // Toggle loved class and color
        if (loveButton.classList.contains('loved')) {
            loveButton.classList.remove('loved');
            loveIcon.style.color = 'white'; // Reset color to white
            loveIcon.classList.remove('scale-up'); // Menghapus efek skala
        } else {
            loveButton.classList.add('loved');
            loveIcon.style.color = 'red'; // Set color to red
            loveIcon.classList.add('scale-up'); // Menambahkan efek skala
        }

        // Hapus kelas skala setelah animasi selesai
        setTimeout(() => {
            loveIcon.classList.remove('scale-up');
        }, 300); // 300 ms sesuai durasi transisi
    }
</script>

</body>
</html>
