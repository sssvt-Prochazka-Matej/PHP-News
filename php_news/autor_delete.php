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
    header('location: autor_admin.php');
    die();
}

require_once "model/database.php";

$db = new Database();

$sql = "select * from clanek c inner join autor a on c.id_autor = a.id where a.id = :id limit 1";
$params = [
    ':id' => $_GET['id']
];

$output = $db->select($sql,$params);

if(Count($output) > 0){
    header('location: autor_admin.php?error=1');
}
else{
    $sql = "delete from autor where id = :id";

    $db->executeSql($sql, $params);

    header('location: autor_admin.php');
}



