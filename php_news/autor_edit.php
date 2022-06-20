<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
elseif (isset($_SESSION['user'])){
    $id = $_SESSION['user']['id'];
}
else{
    header('location: index.php');
    die();
}

require_once "model/database.php";

$db = new Database();

$sql = "select * from autor where id = :id";
$params = [
    ":id" => $id
];

$aut = $db->selectOne($sql,$params);

if(isset($_POST['name'],$_POST['surname'],$_POST['description'], $_POST['image'])){

    if(strlen($_POST['name']) > 0 && strlen($_POST['surname']) > 0) {
        $sql = $sql = "update autor set name = :name,surname = :surname,description = :description,image = :image, email = :email where id = :id";
        $params = [
            ":id" => $id,
            ":name" => $_POST['name'],
            ":surname" => $_POST['surname'],
            ":description" => $_POST['description'],
            ":email" => $_POST['email'],
            ":image" => $_POST['image']
        ];

        $db->executeSql($sql, $params);

        header("location: index.php");

        if($id == $_SESSION['user']['id']){
            $_SESSION['user']['name'] =  $_POST['name'];
            $_SESSION['user']['surname'] =  $_POST['surname'];
        }
    }
    else{
        $error = "Zadej jméno autora!";
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
$selected = 'login';
require_once "header.php";
if($id !== $_SESSION['user']['id'] && $_SESSION['user']['admin'] == 0){
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
            <input type="text" name="name" value="<?=$aut['name']?>" required>
        </label>
        <label>
            Surname
            <input type="text" name="surname" value="<?=$aut['surname']?>" required>
        </label>
        <label>
            Email
            <input type="email" name="email" value="<?=$aut['email']?>" required>
        </label>
        <label>
            Description
            <textarea name="description" placeholder="popis..." rows="8"><?=$aut['description']?></textarea>
        </label>
        <label>
            Image link
            <textarea name="image" placeholder="link..."><?=$aut['image']?></textarea>
        </label>
        <label id="passwd">
            Password
            <a href="password_change.php?id=<?=$id?>">Change password</a>
        </label>
        <button class="button">
            Save
        </button>
    </form>
</main>

</body>
</html>