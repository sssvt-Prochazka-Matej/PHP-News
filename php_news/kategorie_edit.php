<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

if(!isset($_GET['id'])){
    header('location: kategorie_admin.php');
    die();
}

require_once "model/database.php";

$db = new Database();

$sql = "select * from kategorie where id = :id";
$params = [
  ":id" => $_GET['id']
];

$kat = $db->selectOne($sql,$params);

if(isset($_POST['name'], $_POST['image'])){

    if(strlen($_POST['name']) > 0) {
        $sql = "update kategorie set name = :name, image = :image where id = :id";
        $params = [
            ":name" => $_POST['name'],
            ":image" => $_POST['image'],
            ":id" => $_GET['id']
        ];

        $db->executeSql($sql, $params);

        header("location: kategorie_admin.php");
    }
    else{
        $error = "Zadej název kategorie!";
    }
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
        <?php if(isset($error)){
            echo "<span class='error'> $error</span>";
        }?>
        <label>
            Name
            <input type="text" name="name" value="<?=$kat['name']?>">
        </label>
        <label>
            Image link
            <textarea name="image" placeholder="link..."><?=$kat['image']?></textarea>
        </label>
        <button class="button">
            Edit
        </button>
    </form>
</main>

</body>
</html>
