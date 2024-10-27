<?php
require_once __DIR__ . '../../../../config/db.php';

$bookId = isset($_GET['book_id']) ? (int)$_GET['book_id'] : null;

if ($bookId === null) {
    echo "Book ID tidak ditemukan.";
    exit;
}



try {
    $database = new Database();
    $pdo = $database->connect();
    
    $query = "SELECT * FROM books WHERE id = :book_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo "Buku tidak ditemukan.";
        exit;
    }
} catch (PDOException $e) {
    die("Gagal mengambil data buku: " . $e->getMessage());
}
$query = "SELECT * FROM categories";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


$bahanList = explode(", ", $book['bahan']);
$bahanWithNumbers = [];
foreach ($bahanList as $index => $bahanItem) {
    $bahanWithNumbers[] = ($index + 1) . ". " . $bahanItem;
}
$bahanText = implode("\n", $bahanWithNumbers);

// Ambil data langkah pembuatan dari database dan tambahkan nomor urut
$langkahList = explode(", ", $book['langkah_pembuatan']);
$langkahWithNumbers = [];
foreach ($langkahList as $index => $langkahItem) {
    $langkahWithNumbers[] = ($index + 1) . ". " . $langkahItem;
}
$langkahText = implode("\n", $langkahWithNumbers);


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['description']);
    $quantity = (int)$_POST['quantity'];
    $cover = $book['cover'];
    $pdf = $book['pdf'];
    $bahan = htmlspecialchars($_POST['bahan']);
    $langkah_pembuatan = htmlspecialchars($_POST['langkah_pembuatan']);

    // Menggabungkan bahan dan langkah pembuatan menjadi string
    $bahanList = explode("\n", trim($bahan)); // Memisahkan bahan
    $langkahPembuatanList = explode("\n", trim($langkah_pembuatan)); // Memisahkan langkah

    // Menggabungkan bahan dan langkah pembuatan menjadi string
    $bahan = implode(", ", $bahanList); // Misalnya, menggabungkan dengan koma
    $langkah_pembuatan = implode(", ", $langkahPembuatanList); // Misalnya, menggabungkan dengan koma


    // Handle cover image upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/covers/';
        $coverFile = basename($_FILES['cover']['name']);
        $uploadFile = $uploadDir . $coverFile;

        if (move_uploaded_file($_FILES['cover']['tmp_name'], $uploadFile)) {
            $cover = $coverFile;
        } else {
            echo "Gagal meng-upload file cover.<br>";
        }
    }

    // Handle PDF upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/pdfs/';
        $pdfFile = basename($_FILES['pdf']['name']);
        $uploadFile = $uploadDir . $pdfFile;

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
            $pdf = $pdfFile;
        } else {
            echo "Gagal meng-upload file PDF.<br>";
        }
    }

    // Update data in the database
    try {
        $query = "UPDATE books SET judul = ?, kategori = ?, deskripsi = ?, jumlah = ?, cover = ?, pdf = ?, bahan = ?, langkah_pembuatan = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        
        // Debugging: Cek nilai yang akan dimasukkan
        var_dump([$title, $category, $description, $quantity, $cover, $pdf, $bahan, $langkah_pembuatan, $bookId]);

        // Pastikan jumlah parameter sesuai
        if (count([$title, $category, $description, $quantity, $cover, $pdf, $bahan, $langkah_pembuatan, $bookId]) !== 9) {
            echo "Jumlah parameter tidak sesuai.";
            exit;
        }

        // Eksekusi query
        $stmt->execute([$title, $category, $description, $quantity, $cover, $pdf, $bahan, $langkah_pembuatan, $bookId]);

        echo "Buku berhasil diperbarui!";
        header("Location: /public/admin/books");
        exit;
    } catch (PDOException $e) {
        echo "Gagal memperbarui buku di database: " . $e->getMessage() . "<br>";
    }
}
?>

<link rel="stylesheet" href="../../../../css/tailwind.css">
<?php include "../src/views/dashboard/sidebar.php" ?>

<div class="p-4 sm:ml-64 h-full">
    <div class="p-3 py-0 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="container mx-auto p-6 mt-10 flex flex-wrap">
            <div class="w-full md:w-1/2 pr-4">
                <h1 class="text-3xl font-bold w-full bg-slate-950 text-white p-5 rounded-lg">Update Book</h1>

                <form method="POST" enctype="multipart/form-data" class="space-y-4 w-full p-4">
                    <div>
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($book['judul']); ?>"
                               class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
                    </div>

                    <div>
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <select id="category" name="category" required
            class="form-select block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>

                    <div>
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                        <textarea id="description" name="description" rows="4" required
                                  class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"><?php echo htmlspecialchars($book['deskripsi']); ?></textarea>
                    </div>


                    <div>
                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Waktu maks:</label>
                <input type="number" id="quantity" name="quantity" required min="1" value="<?php echo htmlspecialchars($book['jumlah']); ?>"
                       class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
            </div>
            <div>
    <label for="bahan" class="block text-gray-700 text-sm font-bold mb-2">Bahan:</label>
    <textarea id="bahan" name="bahan" rows="4" required
              class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"
              placeholder="Masukkan bahan satu per satu, tekan Enter untuk menambah bahan baru."><?php
        echo htmlspecialchars($bahanText); // Tampilkan bahan dengan nomor urut
    ?></textarea>
</div>

<div>
    <label for="langkah_pembuatan" class="block text-gray-700 text-sm font-bold mb-2">Langkah Pembuatan:</label>
    <textarea id="langkah_pembuatan" name="langkah_pembuatan" rows="4" required
              class="form-textarea block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3"
              placeholder="Masukkan langkah satu per satu, tekan Enter untuk menambah langkah baru."><?php
        echo htmlspecialchars($langkahText); // Tampilkan langkah pembuatan dengan nomor urut
    ?></textarea>
</div>
                    <div>
                        <label for="cover" class="block text-gray-700 text-sm font-bold mb-2">Cover Image:</label>
                        <input type="file" id="cover" name="cover" accept="image/*"
                               class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
                        <?php if ($book['cover']): ?>
                            <img src="/uploads/covers/<?php echo htmlspecialchars($book['cover']); ?>" alt="Cover"
                                 class="w-32 h-48 object-cover mt-3 rounded-md">
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="pdf" class="block text-gray-700 text-sm font-bold mb-2">PDF:</label>
                        <input type="file" id="pdf" name="pdf" accept=".pdf"
                               class="form-input block w-full border border-slate-500 rounded-md shadow-sm py-2 px-3">
                        <?php if ($book['pdf']): ?>
                            <p class="mt-2">Current PDF: <a href="/uploads/pdfs/<?php echo htmlspecialchars($book['pdf']); ?>" class="text-blue-500 underline"><?php echo htmlspecialchars($book['pdf']); ?></a></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <button type="submit"
                                class="bg-yellow-600 text-white rounded-md py-2 px-4 font-bold">Update Book</button>
                    </div>
                </form>
            </div>
            <div class="hidden md:flex w-full md:w-1/2 bg-gray-100 ">
                <img src="../../public/images/banner2.jpg" alt="Placeholder Image" class="rounded-md shadow-md h-[160vh] w-full object-center">
            </div>
        </div>
    </div>
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
    const lastLine = currentValue.trim().split('\n').slice(-1)[0];
    const lastNumber = parseInt(lastLine.split('.')[0]);

    // Pastikan `lastNumber` adalah angka valid atau setel ke counter jika parsing gagal
    if (isNaN(lastNumber)) {
        counter = getNextAvailableNumber(usedNumbers, counter);
    } else {
        counter = lastNumber + 1;
    }

    inputElement.value = currentValue + '\n' + counter + '. ';
    usedNumbers.push(counter);
    return counter;
}

// Fungsi untuk mengatur ulang input ketika teks dihapus
function resetCounter(inputElement, usedNumbers, counter) {
    if (inputElement.value.trim() === '') {
        usedNumbers.length = 0;
        return 1;
    }

    const currentValue = inputElement.value.trim();
    const lines = currentValue.split('\n').filter(line => line.trim() !== '');

    usedNumbers.length = 0;
    lines.forEach(line => {
        const lineNumber = parseInt(line.split('.')[0]);
        
        // Jika parsing angka gagal, abaikan baris tersebut
        if (!isNaN(lineNumber)) {
            usedNumbers.push(lineNumber);
            counter = Math.max(counter, lineNumber); // Ambil nilai counter tertinggi
        }
    });

    return counter + 1;
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