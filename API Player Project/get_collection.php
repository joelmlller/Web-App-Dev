<?php
// get_collection.php

require 'config.php';

$sql = "
    SELECT Users.name as username, UserCollections.player_name, UserCollections.date_added
    FROM UserCollections
    JOIN Users ON UserCollections.user_id = Users.id
    ORDER BY Users.name ASC, UserCollections.date_added DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$collection = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($collection);
