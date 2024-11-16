<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$recipeId = $data['recipeId'];

try {
    $database = new Database();
    $pdo = $database->connect();

    $query = 'DELETE FROM favorites_222263 WHERE user_id = ? AND recipe_id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId, $recipeId]);

    echo json_encode(['success' => true, 'message' => 'Recipe removed from favorites']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to remove favorite: ' . $e->getMessage()]);
}
?>
