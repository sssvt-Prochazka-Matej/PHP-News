<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

require_once "model/database.php";

$db = new Database();

if (isset($_POST['name'], $_POST['image'])) {


    $sql = $sql = "insert into kategorie values (default ,:name, :image)";
    $params = [
        ":name" => $_POST['name'],
        ":image" => $_POST['image']
    ];

    $db->executeSql($sql, $params);

    header("location: kategorie_admin.php");


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

    <form action="" method="post">
        <label>
            Name
            <input type="text" name="name" required>
        </label>
        <label>
            Image link
            <textarea name="image" placeholder="link..."></textarea>
        </label>
        <button class="button">
            Add
        </button>
    </form>
</main>

</body>
</html>
