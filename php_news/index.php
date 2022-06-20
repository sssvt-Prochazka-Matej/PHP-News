<?php

require_once "model/database.php";

$db = new Database();

if(isset($_GET['kategorie'])){
    $sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, k.id as katid, a.id as autid 
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie
        where c.public = 1 and k.id = :id ";
    $params = [
        ':id' => $_GET['kategorie'],
    ];
    $articles = $db->select($sql,$params);
    if(Count($articles)>0){
        $subhead = $articles[0]['name'];
    }
    else{
        $subhead = "žádné články v této kategorie.";
    }

}
elseif (isset($_GET['autor'])){
    $sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, k.id as katid, a.id as autid 
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie
        where c.public = 1 and a.id = :id ";
    $params = [
        ':id' => $_GET['autor'],
    ];
    $articles = $db->select($sql,$params);
    if(Count($articles)>0){
        $subhead = $articles[0]['autorName'];
    }
    else{
        $subhead = "žádné články od tohoto autora.";
    }

}
else{
    $sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, k.id as katid, a.id as autid  
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie
        where c.public = 1 order by c.datum desc limit 5";

    $articles = $db->select($sql);
    $subhead= "To nejnovější z IT";
}

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
$selected = 'zpravy';
require_once 'header.php';
?>
<main>

    <h1>Články</h1>
    <span class="subhead"><?=$subhead?></span>


    <?php foreach ($articles as $a): ?>

    <div class="article">
        <a href="ArticleDetail.php?id=<?= $a['id']?>"><h2><?= $a['tittle'] ?></h2></a>

        <span class="date"><?php $date = new DateTime($a['datum']);
            echo date_format($date, 'd.m.Y H:i'); ?></span>
        <a href="index.php?autor=<?=$a['autid']?>" class="autor"><?= $a['autorName'] ?></a>
        <a href="index.php?kategorie=<?=$a['katid']?>" class="kategorie"><?=$a['name']?></a>

        <?php
            $str = strip_tags($a['text']);
        ?>

        <p class="paragraph"><?=$str?></p>
        <div class="continue_reading">
        <a href="ArticleDetail.php?id=<?= $a['id']?>">číst dále &rArr;</a>
        </div>
    </div>
        <hr>
    <?php endforeach; ?>

</main>

</body>
</html>
