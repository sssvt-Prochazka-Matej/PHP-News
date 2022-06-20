<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

require "model/database.php";

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


<?php
$selected = 'kategorie';
require_once "header.php";
if($_SESSION['user']['admin'] == 0){
    echo "<main>";
    echo "<br>";
    echo "<span class='error'> Nedostatek oprávnění </span>";
    echo "</main>";
    die();
}
?>
<main>
    <?php
    if(isset($_GET['error'])){
        echo '<div class="error_box">';
        echo "<span class='error'> Nelze smazat kategorie ve které je článek</span>";
        echo "</div>";
    }
    ?>
    <div class="admin_table">
        <table>

            <tr>
                <th>id</th>
                <th>name</th>
            </tr>
            <?php foreach ($kategorie as $k): ?>
                <tr>
                    <td><?= $k['id'] ?></td>
                    <td><?= $k['name'] ?></td>
                    <td><a href="kategorie_delete.php?id=<?=$k['id']?>"class="delete">delete</a></td>
                    <td><a href="kategorie_edit.php?id=<?=$k['id']?>" >edit</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
    <div class="button_box">
        <a class="button" href="kategorie_add.php">Přidat kategorii</a>
    </div>

</main>
</body>
</html>