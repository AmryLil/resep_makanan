<?php
// Assuming you have a Database connection class
require_once __DIR__ . '../../../../config/db.php';

try {
    $database = new Database();
    $pdo = $database->connect();

    $query = "SELECT c.id, c.name_222263, COUNT(b.id) AS jumlah_categorie
    FROM categories_222263 c
    LEFT JOIN reseps_222263 b ON c.id = b.kategori_222263
    GROUP BY c.id, c.name_222263";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Failed to fetch categories: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="../../../../css/tailwind.css">
<?php include "../src/views/dashboard/sidebar.php" ?>

<div class="p-4 sm:ml-64 h-full">
    <div class="p-3 py-0 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="container mx-auto p-2 h-full">
            <div class="flex justify-between bg-gradient-to-r from-slate-900 to-gray-800 items-center p-4 rounded-lg mb-3">
                <h1 class="text-3xl font-bold text-white">List Categories</h1>
                <a href="/public/admin/add-category">
                    <button class="bg-gradient-to-r from-green-500 to-green-700 rounded-lg shadow-md p-2 px-5 text-white font-bold text-lg hover:from-green-700 hover:to-green-900 transition-colors duration-300">
                        Add Category
                    </button>
                </a>
            </div>

            <ul class="list-none space-y-6">
    <?php foreach ($categories as $category): ?>
        <li class="bg-white shadow-lg p-4 flex items-start space-x-6 border border-slate-300 rounded-lg transform hover:scale-105 transition-transform duration-300">
            <div class="flex-1">
                <h2 class="text-2xl font-semibold mb-3 text-gray-800">
                    <?php echo htmlspecialchars($category['name_222263']); ?>
                </h2>
                <p class="text-gray-600"><strong>Jumlah:</strong> <?php echo htmlspecialchars($category['jumlah_categorie']); ?> Resep</p>
            </div>
            <div class="flex space-x-3">
            <form action="/public/admin/update-category" method="GET" class="inline-block">
                <input type="hidden" name="category_id_222263" value="<?php echo $category['id']; ?>">
                <button type="submit" class="bg-yellow-600 p-1 px-3 text-base rounded-lg text-white font-bold">Update</button>
            </form>

            <!-- Tombol Delete -->
            <form action="/public/admin/delete-category" method="GET" class="inline-block">
                <input type="hidden" name="category_id_222263" value="<?php echo $category['id']; ?>">
                <button type="submit" class="bg-red-600 p-1 px-3 text-base rounded-lg text-white font-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Delete</button>
            </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

        </div>
    </div>
</div>
