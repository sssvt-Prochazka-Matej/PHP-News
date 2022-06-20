<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}

require_once "model/database.php";

$db = new Database();

if (isset($_POST['tittle'], $_POST['kategorie'], $_POST['autor'],$_POST['text'] ,$_POST['image'], $_POST['public'])) {

    if($_POST['autor'] != $_SESSION['user']['id'] && $_SESSION['user']['admin'] == 0){
        die("nehrabat se v konzoli dik");
    }

    $sql = $sql = "insert into clanek values (default ,:kategorie, :autor, :tittle, :text, now(), :image, :public )";
    $params = [
        ":kategorie" => $_POST['kategorie'],
        ":autor" => $_POST['autor'],
        ":tittle" => $_POST['tittle'],
        ":text" => $_POST['text'],
        ":image" => $_POST['image'],
        ":public" => $_POST['public']
    ];

    $db->executeSql($sql, $params);

    header("location: index.php");

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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
</head>
<body>

<?php
$selected = 'add';
require_once "header.php";
?>


<main>

    <form action="" method="post">
        <label>
            Tittle
            <input type="text" name="tittle" required >
        </label>
        <?php
        $sql = "select * from autor";
        $autors = $db->select($sql);
        ?>

        <label>
            Autor
            <select name="autor" id="">

                <?php if ($_SESSION['user']['admin'] == 1): ?>
                    <?php foreach ($autors as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= $a['name'] ?> <?= $a['surname'] ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="<?= $_SESSION['user']['id'] ?>"><?= $_SESSION['user']['name'] ?> <?= $_SESSION['user']['surname'] ?></option>
                <?php endif; ?>

            </select>
        </label>
        <?php
        $sql = "select * from kategorie";
        $kategorie = $db->select($sql);
        ?>
        <label>
            Kategorie
            <select name="kategorie" id="">
                <?php foreach ($kategorie as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Text
            <textarea id="mytextarea" name="text" placeholder="My awesome article" ></textarea>
        </label>
        <label>
            Image link
            <textarea name="image" placeholder="link..."></textarea>
        </label>
        <label>
            public
            <input type="hidden" value="0" name="public">
            <input type="checkbox" name="public" value="1" checked>
        </label>
        <button class="button">
            Add
        </button>
    </form>
</main>

</body>
</html>
