<?php

if (!isset($_GET['id'])) {
    header('location: index.php');
    die();
}

require_once "model/database.php";

$db = new Database();

$sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, c.image, k.id as katid, a.id as autid  
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie
        where c.id = :id";

$params = [
    'id' => $_GET['id'],
];
$article = $db->selectOne($sql, $params);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$selected = '';
require_once "header.php"
?>

<main>

    <h2><?= $article['tittle'] ?></h2>

    <div class="subheader">
    <span class="date"><?php $date = new DateTime($article['datum']);
        echo date_format($date, 'd.m.Y H:i'); ?></span>
        <a href="index.php?autor=<?=$article['autid']?>" class="autor"><?= $article['autorName']?></a>
        <a href="index.php?kategorie=<?=$article['katid']?>" class="kategorie"><?= $article['name'] ?></a>
    </div>
    <p><?= $article['text'] ?></p>
    <picture class="article_img">
        <img  src="<?= $article['image'] ?>" alt="">
    </picture>

</main>
</body>
</html>
