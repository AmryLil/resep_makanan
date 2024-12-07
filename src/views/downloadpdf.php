<?php
require_once __DIR__ . '../../config/db.php';
require_once __DIR__ . '/../../vendor/autoload.php';  // Assuming FPDF is included via Composer or external library

try {
    $database = new Database();
    $pdo = $database->connect();
} catch (PDOException $e) {
    die('Failed to connect to database: ' . $e->getMessage());
}

// Query to get recipe data with comment count and likes
$query = 'SELECT reseps_222263.*, 
                 categories_222263.name_222263 AS nama_kategori, 
                 (SELECT COUNT(*) FROM comments_222263 WHERE comments_222263.resep_id_222263 = reseps_222263.id) AS jumlah_komentar
          FROM reseps_222263 
          JOIN categories_222263 ON reseps_222263.kategori_222263 = categories_222263.id';
$stmt = $pdo->prepare($query);
$stmt->execute();
$reseps = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if data is available
if (empty($reseps)) {
    die('No data available for the report.');
}

// Initialize FPDF for PDF generation
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Add title to PDF
$pdf->Cell(200, 10, 'ResepCakeKu', 0, 1, 'C');
$pdf->Ln(10);  // Spacing after title

// Add report title
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, 'Daftar Resep', 0, 1, 'C');
$pdf->Ln(5);  // Spacing after table title

// Add table headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Judul', 1, 0, 'C');
$pdf->Cell(40, 10, 'Kategori', 1, 0, 'C');
$pdf->Cell(30, 10, 'Durasi Memasak', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumlah Komentar', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumlah Likes', 1, 1, 'C');

// Add recipe data to PDF
$pdf->SetFont('Arial', '', 10);
foreach ($reseps as $resep) {
    $pdf->Cell(40, 10, $resep['judul_222263'], 1, 0, 'L');
    $pdf->Cell(40, 10, $resep['nama_kategori'], 1, 0, 'L');
    $pdf->Cell(30, 10, $resep['jumlah_222263'], 1, 0, 'L');
    $pdf->Cell(30, 10, $resep['jumlah_komentar'], 1, 0, 'C');
    $pdf->Cell(30, 10, $resep['likes'], 1, 1, 'C');
}

// Output PDF (download as 'daftar_resep.pdf')
$pdf->Output('D', 'daftar_resep.pdf');
?>
