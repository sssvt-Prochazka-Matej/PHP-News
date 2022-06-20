<?php

session_start();

if(!isset($_GET['id'])){
    header('location: index.php');
}
require_once 'model/database.php';

$db = new Database();

$sql = "select id, password from autor where id = :id";
$params = ([
   ":id" => $_GET['id']
]);

$passwd = $db->selectOne($sql,$params);

if(isset($_POST['passwd_old'], $_POST['passwd_new'])){

    $passwd_check = password_verify($_POST['passwd_old'],$passwd['password']);

    if(!$passwd_check){
        $error = "chybné staré heslo";
    }
    else{
        $sql = "update autor set password = :password where id = :id ";
        $password_hash = password_hash($_POST['passwd_new'],PASSWORD_DEFAULT);
        $params = ([
            ":password" => $password_hash,
            ":id" => $_GET['id']
        ]);
        $db->executeSql($sql, $params);
        header('location: index.php');
    }
}
elseif(isset($_POST['passwd_new']) && $_SESSION['user']['admin'] == 1){
    $sql = "update autor set password = :password where id = :id ";
    $password_hash = password_hash($_POST['passwd_new'],PASSWORD_DEFAULT);
    $params = ([
        ":password" => $password_hash,
        ":id" => $_GET['id']
    ]);
    $db->executeSql($sql, $params);
    header('location: autor_admin.php');
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
?>

<main>

    <form action="" method="post">
        <?php if(isset($error)){
            echo "<span class='error'> $error</span>";
        }?>
        <?php if($_SESSION['user']['admin'] == 0):?>
        <label>
            Old password
            <input type="password" name="passwd_old" required>
        </label>
        <?php endif; ?>
        <label>
            New password
            <input type="password" name="passwd_new" required>
        </label>
        <button class="button">
            Save
        </button>
    </form>
</main>

</body>
</html>

