<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: Login.php");
    die();
}


if($_SESSION['user']['admin'] == 0){
    die('nedostatek opravnění');
}


if(!isset($_GET['id'])){
    header('location: kategorie_admin.php');
    die();
}

require_once "model/database.php";

$db = new Database();

$sql = "select * from clanek c inner join kategorie k on c.id_kategorie = k.id where k.id = :id limit 1";
$params = [
    ':id' => $_GET['id']
];

$output = $db->select($sql,$params);

if(Count($output) > 0){
    header('location: kategorie_admin.php?error=1');
}
else{
    $sql = "delete from kategorie where id = :id";


    $db->executeSql($sql, $params);

    header('location: kategorie_admin.php');
}



