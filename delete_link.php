<?php

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    
    $db->query('DELETE FROM links WHERE `id` = ?;');
    $db->execute([
        $id
    ]);

    header('Location: index.php');
    exit;
}