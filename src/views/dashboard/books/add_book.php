<?php
require_once __DIR__ . '../../../../config/db.php';
$userId = isset($_SESSION['user_222263']['id']) ? (int)$_SESSION['user_222263']['id'] : null;

if ($userId === null) {
    echo "User ID tidak ditemukan. Pastikan Anda sudah login.";
    exit;
}
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die("Gagal terhubung ke database: " . $e->getMessage());
}
$query = "SELECT * FROM categories_222263";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['description']);
    $quantity = (int)$_POST['quantity'];
    $cover = null; // Pastikan cover di-set
    $userId = isset($userId) ? $userId : null; // Pastikan userId di-set
    $bahan = htmlspecialchars($_POST['bahan']);
    $langkah_pembuatan = htmlspecialchars($_POST['langkah_pembuatan']);

    $bahanList = explode("\n", trim($bahan));
    $langkahPembuatanList = explode("\n", trim($langkah_pembuatan));

    // Menggabungkan bahan dan langkah pembuatan menjadi string
    $bahan = implode(", ", $bahanList); // Misalnya, menggabungkan dengan koma
    $langkah_pembuatan = implode(", ", $langkahPembuatanList); // Misalnya, menggabungkan dengan koma

    if (isset($_FILES['cover'])) {
        echo "File uploaded: " . $_FILES['cover']['name'] . "<br>";
        echo "Error code: " . $_FILES['cover']['error'] . "<br>";
    
        if ($_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/covers/';
    
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
                echo "Folder created: " . $uploadDir . "<br>";
            } else {
                echo "Folder exists: " . $uploadDir . "<br>";
            }
    
            $coverFile = basename($_FILES['cover']['name']);
            $uploadFile = $uploadDir . $coverFile;
    
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $uploadFile)) {
                $cover = $coverFile;
                echo "File uploaded successfully: " . $coverFile . "<br>";
            } else {
                echo "Gagal meng-upload file cover.<br>";
            }
        } else {
            echo "Error uploading file: " . $_FILES['cover']['error'] . "<br>";
        }
    }

   
    try {
        $query = "INSERT INTO reseps_222263 (judul_222263, kategori_222263, deskripsi_222263, jumlah_222263, cover_222263, user_id_222263, bahan_222263, langkah_pembuatan_222263) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $category, $description, $quantity, $cover, $userId, $bahan, $langkah_pembuatan]);
        
        // Redirect setelah berhasil menambahkan
        header("Location: /public/admin/books");
        exit(); // Pastikan untuk menghentikan eksekusi script
    } catch (PDOException $e) {
        echo "Gagal menambahkan buku ke database: " . $e->getMessage() . "<br>";
    }
}
?>
<link rel="stylesheet" href="../../../../css/tailwind.css">
<?php include "../src/views/dashboard/sidebar.php" ?>
<div class="p-4 sm:ml-64 h-full">
    <div class="p-3 py-0 border-2  border-gray-200   border-dashed rounded-lg dark:border-gray-700">
    <div class="flex h-full container mx-auto p-4 ">
    <!-- Form Container -->
    <div class="w-full md:w-1/2 bg-white pr-6 flex flex-col ">
        <h1 class="text-3xl font-bold mb-6 w-full bg-slate-950 text-white p-5 rounded-lg">Tambah Resep Baru</h1>
        <form id="bookForm" method="POST" enctype="multipart/form-data" class="space-y-4 px-5">
            <div>
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" id="title" name="title" required
                       class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
            </div>
            <div>
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <select id="category" name="category" required
            class="form-select block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name_222263']) ?></option>
        <?php endforeach; ?>
    </select>
            </div>

            <div>
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="4" required
                          class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"></textarea>
        </div>
            <div>
                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Waktu maks:</label>
                <input type="number" id="quantity" name="quantity" required min="1"
                       class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
            </div>
            <div>
    <label for="bahan" class="block text-gray-700 text-sm font-bold mb-2">Bahan:</label>
    <textarea id="bahan" name="bahan" rows="4" required
              class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"
              placeholder="Masukkan bahan satu per satu, tekan Enter untuk menambah bahan baru."></textarea>
</div>

<div>
    <label for="langkah_pembuatan" class="block text-gray-700 text-sm font-bold mb-2">Langkah Pembuatan:</label>
    <textarea id="langkah_pembuatan" name="langkah_pembuatan" rows="4" required
              class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"
              placeholder="Masukkan langkah satu per satu, tekan Enter untuk menambah langkah baru."></textarea>
</div>
            <div>
                <label for="cover" class="block text-gray-700 text-sm font-bold mb-2">Cover Image:</label>
                <input type="file" id="cover" name="cover" accept="image/*"
                       class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
            </div>

           

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Add Book
            </button>
        </form>
    </div>

    <!-- Image Placeholder -->
    <div class="hidden md:flex w-full md:w-1/2 bg-gray-100 ">
        <img src="../../public/images/banner2.jpg" alt="Placeholder Image" class="rounded-md shadow-md h-[120vh] w-full object-center">
    </div>
</div>
    </div>
</div>


<!-- Loading Spinner -->
<div id="loading" class="hidden fixed inset-0 bg-black bg-opacity-50 text-white  items-center justify-center">
    <div class="spinner-border animate-spin border-4 border-t-4 border-white rounded-full w-12 h-12"></div>
</div>

<script>
let bahanCounter = 1;
let langkahCounter = 1;
let bahanUsedNumbers = []; 
let langkahUsedNumbers = []; 

// Fungsi untuk mendapatkan nomor berikutnya
function getNextAvailableNumber(usedNumbers, counter) {
    while (usedNumbers.includes(counter)) {
        counter++;
    }
    return counter;
}

// Fungsi untuk menambahkan nomor dan baris baru
function addNumberAndNewLine(inputElement, usedNumbers, counter) {
    const currentValue = inputElement.value;

    // Mengambil nomor yang terakhir ditulis
    const lastLine = currentValue.trim().split('\n').slice(-1)[0];
    const lastNumber = lastLine ? parseInt(lastLine.split('.')[0]) : 0;

    // Jika input kosong, tambahkan nomor pertama
    if (currentValue.trim() === '') {
        counter = getNextAvailableNumber(usedNumbers, counter);
        inputElement.value = counter + '. '; // Menambahkan nomor
        usedNumbers.push(counter); // Menyimpan nomor yang digunakan
    } else {
        counter = lastNumber + 1; // Nomor selanjutnya berdasarkan nomor terakhir
        inputElement.value = currentValue + '\n' + counter + '. '; // Menambahkan baris baru dan nomor
        usedNumbers.push(counter); // Menyimpan nomor yang digunakan
    }
    return counter; // Kembalikan counter yang diperbarui
}

// Fungsi untuk mengatur ulang input ketika teks dihapus
function resetCounter(inputElement, usedNumbers, counter) {
    if (inputElement.value.trim() === '') {
        // Jika input kosong, reset nomor yang digunakan
        usedNumbers.length = 0; // Kosongkan array
        return 1; // Reset counter ke 1
    }

    // Reset nomor berdasarkan jumlah baris yang ada
    const currentValue = inputElement.value.trim();
    const lines = currentValue.split('\n').filter(line => line.trim() !== '');
    
    // Update usedNumbers dan counter sesuai dengan jumlah baris yang ada
    usedNumbers.length = 0; // Kosongkan array usedNumbers
    lines.forEach((line, index) => {
        const lineNumber = parseInt(line.split('.')[0]);
        usedNumbers.push(lineNumber);
        if (lineNumber > counter) {
            counter = lineNumber; // Memperbarui counter ke nomor terakhir
        }
    });

    return counter + 1; // Kembalikan counter yang diperbarui untuk nomor selanjutnya
}

// Event listener untuk input bahan
document.getElementById('bahan').addEventListener('focus', function() {
    if (this.value.trim() === '') {
        this.value = bahanCounter + '. '; // Menambahkan "Bahan 1. " saat fokus pertama kali
        bahanUsedNumbers.push(bahanCounter); // Menyimpan nomor yang digunakan
    }
});

document.getElementById('bahan').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Mencegah perilaku default Enter
        bahanCounter = addNumberAndNewLine(this, bahanUsedNumbers, bahanCounter);
    }
});

// Event listener untuk input langkah pembuatan
document.getElementById('langkah_pembuatan').addEventListener('focus', function() {
    if (this.value.trim() === '') {
        this.value = langkahCounter + '. '; // Menambahkan "Langkah 1. " saat fokus pertama kali
        langkahUsedNumbers.push(langkahCounter); // Menyimpan nomor yang digunakan
    }
});

document.getElementById('langkah_pembuatan').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Mencegah perilaku default Enter
        langkahCounter = addNumberAndNewLine(this, langkahUsedNumbers, langkahCounter);
    }
});

// Menambahkan event listener untuk mengatur ulang nomor jika teks dihapus
document.getElementById('bahan').addEventListener('input', function() {
    bahanCounter = resetCounter(this, bahanUsedNumbers, bahanCounter);
});

document.getElementById('langkah_pembuatan').addEventListener('input', function() {
    langkahCounter = resetCounter(this, langkahUsedNumbers, langkahCounter);
});

// Show loading spinner on form submit
document.getElementById('bookForm').addEventListener('submit', function() {
    document.getElementById('loading').classList.remove('hidden');
});
</script>