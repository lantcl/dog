<?php

session_start();

if($_SESSION['logged-in'] = true){

$id = $_POST['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$reset = $pdo->prepare("UPDATE `status` SET `feature`= '0' WHERE `feature`= '1'");
$stmt = $pdo->prepare("UPDATE `status` SET `feature`= '1' WHERE `id` = '$id'");

$reset->execute();
$stmt->execute();

header("Location: main.php");

}else{
	echo('status not updated');
}
?>