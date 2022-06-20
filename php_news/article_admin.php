<?php

session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

require_once "model/database.php";

$db = new Database();

if($_SESSION['user']['admin'] == 1){
    $sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, k.id as katid, a.id as autid, c.public  
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie
        order by c.tittle asc";

    $articles = $db->select($sql);
}
else{
    $sql = "select c.id, k.name, Concat(a.name, ' ', a.surname) as autorName, c.tittle, c.text, c.datum, k.id as katid, a.id as autid, c.public  
        from clanek c inner join autor a on c.id_autor = a.id inner join kategorie k on k.id = c.id_kategorie where a.id = :id
        order by c.tittle asc";
    $params = ([
       "id" => $_SESSION['user']['id']
    ]);
    $articles = $db->select($sql,$params);
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
<style>
    #green{
        background-color: lawngreen;
    }
    #red{
        background-color: red;
    }
</style>


<?php
$selected = 'admin';
require_once "header.php"
?>

<main>
    <?php if(Count($articles) < 1): ?>
    <h1>Nenapsali jste žádné články</h1>
    <?php else: ?>
    <div class="admin_table">
        <table>
            <tr>
                <td></td>
                <th>Tittle</th>
                <th>Autor</th>
                <th>Kategorie</th>
                <th>Datum</th>
            </tr>
            <?php foreach ($articles as $a): ?>
                <?php
                if ($a['public'] == 1)
                {
                    $color = 'green';
                }
                else
                {
                    $color = 'red';
                } ?>
                <tr>
                    <td id="<?=$color?>"></td>
                    <td><?= $a['tittle'] ?></td>
                    <td><?= $a['autorName'] ?></td>
                    <td><?= $a['name'] ?></td>
                    <td><?php $date = new DateTime($a['datum']);
                        echo date_format($date, 'd.m.Y H:i'); ?></td>
                    <td><a href="article_delete.php?id=<?=$a['id']?>" class="delete">delete</a></td>
                    <td><a href="article_edit.php?id=<?=$a['id']?>">edit</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif;?>
</main>

</body>
</html>
