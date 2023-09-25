<?php
// add_to_collection.php

// add_to_collection.php

require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $_SESSION['user_id'];

    $sql = "INSERT INTO UserCollections (user_id, player_id, player_name, date_added) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    foreach ($data as $item) {
        try {
            $stmt->execute([$userId, $item['player_id'], $item['player_name'], date('Y-m-d H:i:s')]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) { // Duplicate entry error number for MySQL
                continue; // Skip this player and continue with the next one
            } else {
                throw $e; // Re-throw the exception if it's not a duplicate entry error
            }
        }
    }

    exit; // Return success response
}

// Return error response if user is not logged in or invalid request method
http_response_code(400);
echo json_encode(['error' => 'Invalid request']);

