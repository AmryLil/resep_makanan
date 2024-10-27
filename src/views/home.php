<?php
require_once __DIR__ . '/../config/db.php';

try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die("Gagal terhubung ke database: " . $e->getMessage());
}

// Query untuk mendapatkan kategori dan jumlah buku
$query = "SELECT c.id, c.name_222263, COUNT(b.id) AS jumlah_buku
          FROM categories_222263 c
          LEFT JOIN reseps_222263 b ON c.id = b.kategori_222263
          GROUP BY c.id, c.name_222263";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-slate-950 py-4 ">
  <div class="flex w-full justify-center">
    <div class="h-1 font-bold bg-white w-24 rounded-lg mb-2"></div>
  </div>
  <h1 class="text-slate-50 font-bold text-3xl text-center ">Categori Resep</h1>
  <div class="rounded-lg shadow-secondary-1 dark:bg-surface-dark container mx-auto p-4 flex-wrap flex gap-4 justify-center">
    <?php foreach ($categories as $categorie): ?>
      <div class="relative overflow-hidden bg-cover bg-no-repeat w-96" data-twe-ripple-init data-twe-ripple-color="light">
        <img class="rounded-t-lg w-full" src="<?php echo htmlspecialchars($categorie['image_url']); ?>" alt="" />
        <a href="#!">
          <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-[hsla(0,0%,98%,0.15)] bg-fixed opacity-0 transition duration-300 ease-in-out hover:opacity-100"></div>
        </a>
        <div class="p-6 text-surface dark:text-white">
          <h5 class="mb-2 text-xl font-medium leading-tight"><?php echo htmlspecialchars($categorie['name_222263']); ?></h5>
          <p class="mb-4 text-base">
            Jumlah Buku: <?php echo htmlspecialchars($categorie['jumlah_buku']); ?>
          </p>
          <button type="button" class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong" data-twe-ripple-init data-twe-ripple-color="light">
            Button
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>