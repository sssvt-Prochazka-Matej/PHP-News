<?php
session_start();

if (isset($_POST['email'], $_POST['password'])) {
    require_once 'model/database.php';

    $db = new Database();

    $sql = 'select * from autor where email = :email';

    $params =([
        ':email' => $_POST['email'],
    ]);

    $user = $db->selectOne($sql,$params);

    if ($user === false) {
        header('Location: Login.php?e=Nespávné jméno nebo heslo');
        die('Nespávné jméno nebo heslo');
    }

    $passwoerdCorrect = password_verify($_POST['password'], $user['password']);

    if (!$passwoerdCorrect) {
        header('Location: Login.php?e=Nespávné jméno nebo heslo');
        die('Nespávné jméno nebo heslo');
    }

    //prihlasen
    unset($user['password'], $user[2]);
    $_SESSION['user'] = $user;
    header("location: index.php");
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
    <title>Web s přihlášením</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$selected = 'login';
require_once "header.php";
?>





<form method="post">
    <?php if(isset($_GET['e'])): ?>

        <span class="error"><?=$_GET['e']?></span>

    <?php endif;?>
    <label>
        Email
        <input type="email" name="email" placeholder="Zadejte email">
    </label>

    <label>
        Password
        <input type="password" name="password" placeholder="Zadejte heslo">
    </label>

    <button class="button">
        Login
    </button>

</form>

</body>
</html>
