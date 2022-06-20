<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$z = '';
$k = '';
$a = '';
$admin = '';
$p = '';
$l = '';
$r = '';

switch ($selected) {
    case 'zpravy':
        $z = 'selected';
        break;
    case 'kategorie':
        $k = 'selected';
        break;
    case 'autor':
        $a = 'selected';
        break;
    case 'admin':
        $admin = 'selected';
        break;
    case 'add':
        $p = 'selected';
        break;
    case 'login':
        $l = 'selected';
        break;
    case 'register':
        $r = 'selected';
        break;
}



echo "<div class='header'>";


echo "<div class='links'>";
echo "<span class='header_item' ><a id='$z' href='index.php'>Zprávy</a></span>";
echo "<span class='header_item' ><a id='$k' href='kategorie.php'>Kategorie</a></span>";
echo "<span class='header_item' ><a id='$a' href='autor.php'>Autoři</a></span>";
echo "<span class='header_item' ><a id='$admin' href='article_admin.php'>Administrace článků</a></span>";
echo "<span class='header_item' ><a id='$p' href='article_add.php'>Přidat článek</a></span>";
echo "</div>";

echo "<div class='links_right'>";
if(!isset($_SESSION['user'])){
    echo "<span class='header_item' ><a id='$l' href='Login.php'>Login</a></span>";
    echo "<span class='header_item' ><a id='$r' href='autor_add.php'>Register</a></span>";
}
else{
    $name = $_SESSION['user']['name']." ".$_SESSION['user']['surname'];
    echo "<span class='header_item' ><a id='$l' href='autor_edit.php'>$name</a></span>";
    echo "<span class='header_item' ><a id='$r' href='logout.php'>Logout</a></span>";
}
echo "</div>";

echo "</div>";
