<?php
session_start();

require_once "model/database.php";

$db = new Database();

$sql = "select a.id, Concat(a.name, ' ', a.surname) as autorName, a.description, a.image from autor a";

$autors = $db->select($sql);

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
$selected = 'autor';
require_once "header.php"
?>

<main>

    <?php
    for ($i = 0; $i < Count($autors); $i += 2) {
        echo "<div class='autors_grid'>";

        for ($ii = 0; $ii < 2; $ii++) {
            if ($i + $ii < Count($autors)) {
                $autid = $autors[$i + $ii]['id'];

                echo "<a href='index.php?autor=$autid' class='autors_item'>";
                $img = $autors[$i + $ii]['image'];
                $name = $autors[$i + $ii]['autorName'];
                $description = $autors[$i + $ii]['description'];

                echo "<img src='$img'>";

                echo "<div>";

                echo "<h3>$name</h3>";
                echo "<p>$description</p>";

                echo "</div>";

                echo "</a class='autors_item'>";

            }
        }

        echo "</div>";
    }

    ?>
    <hr>
    <?php if (isset($_SESSION['user'])): ?>
        <?php if ($_SESSION['user']['admin'] == 1): ?>
            <div class="button_box">
                <a class="button" href="autor_admin.php">Administrace autorů</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

</body>
</html>