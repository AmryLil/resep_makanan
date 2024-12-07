<?php
require_once __DIR__ . '/../config/db.php';

// Get the selected category from the query string
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$userId = 1;  // Ganti dengan ID pengguna yang login (bisa diambil dari sesi login)

// Create a database connection
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Gagal terhubung ke database: ' . $e->getMessage());
}

// Handle like request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id'])) {
    $recipeId = $_POST['recipe_id'];

    // Ambil data user_likes untuk memeriksa apakah user sudah memberi like
    $checkQuery = 'SELECT likes, user_likes FROM reseps_222263 WHERE id = ?';
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([$recipeId]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) {
        $userLikes = $recipe['user_likes'] ? explode(',', $recipe['user_likes']) : [];
        if (!in_array($userId, $userLikes)) {
            // Tambahkan like
            $userLikes[] = $userId;
            $newUserLikes = implode(',', $userLikes);
            $updateQuery = 'UPDATE reseps_222263 SET likes = likes + 1, user_likes = ? WHERE id = ?';
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([$newUserLikes, $recipeId]);
        } else {
            // Hapus like
            $userLikes = array_diff($userLikes, [$userId]);
            $newUserLikes = implode(',', $userLikes);
            $updateQuery = 'UPDATE reseps_222263 SET likes = likes - 1, user_likes = ? WHERE id = ?';
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([$newUserLikes, $recipeId]);
        }
    }

    // Redirect untuk mencegah refresh mengirim ulang form
    header('Location: /public/list-resep' . $selectedCategory);
    exit;
}

// Fetch distinct categories for the filter
$categoryQuery = 'SELECT DISTINCT categories_222263.id, categories_222263.name_222263 AS nama_kategori 
                  FROM categories_222263
                  JOIN reseps_222263 ON categories_222263.id = reseps_222263.kategori_222263';
$categories = $pdo->query($categoryQuery)->fetchAll(PDO::FETCH_ASSOC);

// Prepare the query to fetch recipes
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

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <!-- Recipes List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php if ($recipes): ?>
        <?php foreach ($recipes as $recipe): ?>
            <div class="bg-slate-900 hover:bg-slate-950 hover:scale-105 duration-150 transition-all p-2 rounded-lg shadow-md text-slate-50">
                <a href="../src/views/detail.php?id=<?php echo $recipe['id']; ?>">
                    <div class="h-72">
                        <img src="/../src/views/uploads/covers/<?php echo htmlspecialchars($recipe['cover_222263']); ?>" alt="Cover"
                             class="w-full h-full object-cover rounded-lg mb-2">
                    </div>
                </a>
                <div class="py-4 px-2">
                    <h2 class="text-lg font-bold mb-1"><?php echo htmlspecialchars($recipe['judul_222263']); ?></h2>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($recipe['deskripsi_222263']); ?></p>
                    <span class="block text-gray-100 mt-2"><?php echo htmlspecialchars($recipe['nama_kategori']); ?></span>

                    <!-- Like Button -->
                    <form method="POST" action="" onsubmit="setTimeout(() => { location.reload(); }, 50);">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm py-1 px-3 rounded">
        <?php
        $userLikes = $recipe['user_likes'] ? explode(',', $recipe['user_likes']) : [];
        if (in_array($userId, $userLikes)) {
            echo "Unlike ({$recipe['likes']})";
        } else {
            echo "Like ({$recipe['likes']})";
        }
        ?>
    </button>
</form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center col-span-full text-gray-600">Tidak ada resep ditemukan.</p>
    <?php endif; ?>
    </div>
</div>

</body>
</html>
