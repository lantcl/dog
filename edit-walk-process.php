<?php

session_start();

if($_SESSION['logged-in'] == true){

$userid = $_SESSION['id'];
$lengthid = $_POST['lengthid'];
$time = $_POST['walktime'];
$pee = $_POST['pee'];
$poo = $_POST['poo'];
$notes = $_POST['notes'];
$walkid = $_POST['walkid'];


$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$stmt = $pdo->prepare("UPDATE `walks` SET `lengthid` = '$lengthid', `walktime` = '$time', `pee` = '$pee', `poo` = '$poo', `notes` = '$notes' WHERE `id` = '$walkid'");

$stmt->execute();

header("Location: main.php");

}else{
echo('walk was not updated');
}
?>