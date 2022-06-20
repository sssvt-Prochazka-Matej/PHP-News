<?php

require_once "model/database.php";

$db = new Database();

if (isset($_POST['name'], $_POST['surname'], $_POST['description'], $_POST['image'])) {

    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = $sql = "insert into autor values (default ,:name, :surname, :description, :image, 0, :email, :password)";
    $params = [
        ":name" => $_POST['name'],
        ":surname" => $_POST['surname'],
        ":description" => $_POST['description'],
        ":image" => $_POST['image'],
        ":email" => $_POST['email'],
        ":password" => $password_hash
    ];

    $db->executeSql($sql, $params);

    header("location: Login.php");
    die();
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
$selected = 'register';
require_once "header.php";
?>


<main>

    <form action="" method="post">
        <label>
            Name
            <input type="text" name="name" required>
        </label>
        <label>
            Surname
            <input type="text" name="surname" required>
        </label>
        <label>
            Email
            <input type="email" name="email" required>
        </label>
        <label>
            Password
            <input type="password" name="password" required>
        </label>
        <label>
            Description
            <textarea name="description" placeholder="popis..." rows="8"></textarea>
        </label>
        <label>
            Image link
            <textarea name="image" placeholder="link..."></textarea>
        </label>
        <button class="button">
            Register
        </button>
    </form>
</main>

</body>
</html>