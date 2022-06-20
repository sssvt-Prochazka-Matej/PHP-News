<?php
session_start();

require_once "model/database.php";

$db = new Database();

$sql = "select * from kategorie";

$kategorie = $db->select($sql);

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

    <?php for ($i = 0; $i < Count($kategorie); $i++ ):?>

    <?='#'.str_replace(' ','',$kategorie[$i]['name'])?>
    {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("<?=$kategorie[$i]['image']?>")
    ;
        background-repeat: no-repeat
    ;
        background-size: cover
    ;
        background-position: center
    ;
        margin: 10px
    ;
    }

    <?='#'.str_replace(' ','',$kategorie[$i]['name']).':hover'?>
    {
        background: url("<?=$kategorie[$i]['image']?>")
    ;
        background-repeat: no-repeat
    ;
        background-size: cover
    ;
        background-position: center
    ;
    }


    <?php endfor;?>

</style>


<?php
$selected = 'kategorie';
require_once "header.php";
?>

<main>

    <?php
    for ($i = 0; $i < Count($kategorie); $i += 3) {
        echo "<div class='category_grid'>";

        for ($ii = 0; $ii < 3; $ii++) {
            if ($i + $ii < Count($kategorie)) {
                $id = str_replace(' ', '', $kategorie[$i + $ii]['name']);
                $name = $kategorie[$ii + $i]['name'];
                $katid = $kategorie[$ii + $i]['id'];

                echo "<a id='$id' href='index.php?kategorie=$katid'>";
                echo "<span class='bold'>$name</span>";
                echo "</a>";
            }
        }

        echo "</div>";
    }

    ?>
    <hr>
    <?php if (isset($_SESSION['user'])): ?>
        <?php if ($_SESSION['user']['admin'] == 1): ?>
            <div class="button_box">
                <a class="button" href="kategorie_admin.php">Administrace kategorie</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>


</body>
</html>
