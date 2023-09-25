<?php
// get_collection.php

require 'config.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM UserCollections WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $collection = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($collection);
    exit;
}

// Return error response if user is not logged in
http_response_code(400);
echo json_encode(['error' => 'User not logged in']);
