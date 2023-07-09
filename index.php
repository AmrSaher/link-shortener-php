<?php
    include 'db.php';

    $db = new Database();

    if (isset($_GET['l'])) {
        $db->query('SELECT * FROM links WHERE slug = ?;');
        $link = $db->fetchOne([
            $_GET['l']
        ]);

        $db->query('UPDATE links SET clicks = ? WHERE slug = ?;');
        $db->execute([
            $link['clicks'] + 1,
            $link['slug']
        ]);

        header('Location: ' . $link['url']);
        exit;
    }

    $db->query('SELECT * FROM links ORDER BY `id`;');
    $links = $db->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <title>Link Shortener</title>
</head>
<body>
    <div class="container">
        <form action="/add_link.php" method="post">
            <div class="field">
                <i class="material-symbols-outlined">link</i>
                <input type="url" name="url" placeholder="Enter or paste a long url" class="inp" required />
                <input type="submit" name="add_link" value="Shorten" class="btn" />
            </div>
        </form>
        <?php if (!empty($links)): ?>
            <table>
                <thead>
                    <th>#</th>
                    <th>Shorten Link</th>
                    <th>Original Link</th>
                    <th>Clicks</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach($links as $link): ?>
                        <?php $link['surl'] = 'http://' . $_SERVER['HTTP_HOST'] . '/?l=' . $link['slug'] ?>
                        <tr>
                            <td><?= $link['id'] ?></td>
                            <td>
                                <a href="<?= $link['surl'] ?>"><?= $link['surl'] ?></a>
                            </td>
                            <td>
                                <a href="<?= $link['url'] ?>"><?= $link['url'] ?></a>
                            </td>
                            <td><?= $link['clicks'] ?></td>
                            <td>
                                <form id="delete-link-form-<?= $link['id'] ?>" action="delete_link.php?id=<?= $link['id'] ?>" method="post"></form>
                                <a href="#" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-link-form-<?= $link['id'] ?>').submit()">
                                    <i class="material-symbols-outlined">delete</i>
                                </a>
                            </td>
                        </tr>    
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>