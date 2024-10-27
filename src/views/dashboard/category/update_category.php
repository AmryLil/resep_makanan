
Insert Code
Edit
Copy code
<?php
require_once __DIR__ . '../../../../config/db.php';

// Mendapatkan category_id dari query string
$categoryId = isset($_GET['category_id_222263']) ? (int)$_GET['category_id_222263'] : null;

// Memastikan category_id ditemukan
if ($categoryId === null) {
    echo "Category ID tidak ditemukan.";
    exit;
}

try {
    // Menghubungkan ke database
    $database = new Database();
    $pdo = $database->connect();

    // Mengambil detail kategori berdasarkan category_id
    $query = "SELECT * FROM categories_222263 WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    // Memastikan kategori ditemukan
    if (!$category) {
        echo "Kategori tidak ditemukan.";
        exit;
    }

    // Menangani operasi pembaruan
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
        $name = htmlspecialchars($_POST['name_222263']);

        // Memperbarui kategori di database
        $query = "UPDATE categories_222263 SET name_222263 = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $categoryId]);

        // Redirect setelah pembaruan
        header("Location: /public/admin/category");
        exit;
    }

} catch (PDOException $e) {
    echo "Gagal mengambil data kategori: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="../../../../css/tailwind.css">
<?php include "../src/views/dashboard/sidebar.php" ?>

<div class="p-4 sm:ml-64 h-full">
    <div class="p-3 py-0 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="container mx-auto p-6 mt-10 flex flex-wrap">
            <div class="w-full md:w-1/2 pr-4">
                <h1 class="text-3xl font-bold w-full bg-slate-950 text-white p-5 rounded-lg">Update Category</h1>

                <form method="POST" class="space-y-4 w-full p-4">
                    <div>
                        <label for="name_222263" class="block text-gray-700 text-sm font-bold mb-2">Category Name:</label>
                        <input type="text" id="name_222263" name="name_222263" required value="<?php echo htmlspecialchars($category['name_222263']); ?>"
                               class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
                    </div>

                    <input type="hidden" name="category_id_222263" value="<?php echo htmlspecialchars($categoryId); ?>">

                    <div>
                        <button type="submit" class="bg-yellow-600 text-white rounded-md py-2 px-4 font-bold">Update Category</button>
                    </div>
                </form>
            </div>
            <div class="hidden md:flex w-full md:w-1/2 bg-gray-100 ">
                <img src="../../public/images/banner2.jpg" alt="Placeholder Image" class="rounded-md shadow-md h-[160vh] w-full object-center">
            </div>
        </div>
    </div>
</div>
