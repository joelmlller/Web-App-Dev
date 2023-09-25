<?php
// remove_from_collection.php

require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $_SESSION['user_id'];
    $itemId = $data['id'];

    $sql = "DELETE FROM UserCollections WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$itemId, $userId]);
    exit; // Return success response
}

// Return error response if user is not logged in or invalid request method
http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
