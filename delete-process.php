<?php

session_start();

if($_SESSION['logged-in'] = true){

$id = $_GET['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$row = $pdo->prepare("DELETE FROM `walks` WHERE `id` = $id");
$row->execute();

header("Location: main.php");

}else{
echo('walk was not deleted');
}

?>