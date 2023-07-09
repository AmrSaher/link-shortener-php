<?php

include 'db.php';

if (isset($_POST['add_link'])) {
    $url = $_POST['url'];

    $db = new Database();
    
    $db->query('INSERT INTO links (`url`, slug) VALUES (?, ?);');
    $db->execute([
        $url,
        time()
    ]);

    header('Location: index.php');
    exit;
}