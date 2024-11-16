<?php
require_once __DIR__ . '/../config/db.php';

// Get the selected category from the query string
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Create a database connection
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}

// Fetch distinct categories for the filter
$categoryQuery = 'SELECT DISTINCT categories_222263.id, categories_222263.name_222263 AS nama_kategori 
                  FROM categories_222263
                  JOIN reseps_222263 ON categories_222263.id = reseps_222263.kategori_222263';
$categories = $pdo->query($categoryQuery)->fetchAll(PDO::FETCH_ASSOC);

// Prepare the query to fetch books with a join to get the category name
$query = 'SELECT reseps_222263.*, categories_222263.name_222263 AS nama_kategori
          FROM reseps_222263
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id';
if ($selectedCategory) {
    $query .= ' WHERE categories_222263.id = ?';
}
$stmt = $pdo->prepare($query);

if ($selectedCategory) {
    $stmt->execute([$selectedCategory]);
} else {
    $stmt->execute();
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Resep</title>
    <link href="../../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4 mt-16">
    <!-- Filter Form -->
    <form method="GET" action="" class="mb-4 rounded-md flex justify-between bg-slate-900 p-2">
        <h1 class="text-2xl font-bold text-white rounded-md">Daftar Resep</h1>
        <div>
            <select id="category" name="category" onchange="this.form.submit()"
                    class="form-select block w-full mt-1 bg-slate-900 text-white shadow-sm">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>"
                        <?php if ($selectedCategory === (string) $category['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <!-- Books List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php if ($books): ?>
    <?php foreach ($books as $book): ?>
        <div class="bg-slate-900  hover:bg-slate-950 hover:scale-105 duration-150 transition-all p-2 rounded-lg shadow-md text-slate-50">
            <a href="../src/views/detail.php?id=<?php echo $book['id']; ?>">
                <div class="h-72">
                    <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($book['cover_222263']); ?>" alt="Cover"
                         class="w-full h-full object-cover rounded-lg mb-2">
                </div>
                <div class="py-4 px-2">
                    <h2 class="text-lg font-bold mb-1"><?php echo htmlspecialchars($book['judul_222263']); ?></h2>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($book['deskripsi_222263']); ?></p>
                    <span class="block text-gray-100 mt-2"><?php echo htmlspecialchars($book['nama_kategori']); ?></span>
                    
                    <!-- Bagian Rating dengan Data Dummy -->
                    <!-- <div class="flex items-center mt-2">
                        <?php
                        // Data dummy rating
                        $dummyRating = 4;  // Ganti dengan nilai lain untuk testing
                        $maxRating = 5;  // Maksimal rating
                        ?>
                        <?php for ($i = 1; $i <= $maxRating; $i++): ?>
                            <svg class="w-5 h-5 <?php echo $i <= $dummyRating ? 'text-yellow-400' : 'text-gray-400'; ?>" 
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 15l-5.878 3.09 1.121-6.532L0 6.29l6.596-.577L10 0l2.404 5.712L20 6.29l-5.243 5.268 1.121 6.532z"/>
                            </svg>
                        <?php endfor; ?>
                    </div> -->
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center col-span-full text-gray-600">Tidak ada buku ditemukan.</p>
<?php endif; ?>

    </div>
</div>
</body>
</html>
