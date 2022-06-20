<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}
if (!isset($_GET['id'])) {
    header('location: article_admin.php');
    die();
}
require_once "model/database.php";

$db = new Database();

$sql = "select * from clanek where id = :id";
$params = [
    ':id' => $_GET['id']
];
$article = $db->selectOne($sql, $params);

if($article['id_autor'] !== $_SESSION['user']['id'] && $_SESSION['user']['admin'] == 0){
    die('nedostatek opravnění');
}

$sql = "delete from clanek where id = :id";
$params = [
    ':id' => $_GET['id']
];

$db->executeSql($sql, $params);

header('location: article_admin.php');
