<?php

session_start();

if($_SESSION['logged-in'] == true){

//var_dump($_POST);

$userid = $_SESSION['id'];
$dogid = $_POST['dogid'];
$lengthid = $_POST['lengthid'];
$time = $_POST['walktime'];
$date = $_POST['date'];
$pee = $_POST['pee'];
$poo = $_POST['poo'];
$notes = $_POST['notes'];



$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$stmt = $pdo->prepare("INSERT INTO `walks` (`id`, `dogid`, `userid`, `lengthid`, `walktime`, `date`, `pee`, `poo`, `notes`) VALUES (NULL, '$dogid', '$userid', '$lengthid', '$time', '$date', '$pee', '$poo', '$notes');");

$stmt->execute();

header("Location: main.php");

}else{
echo('walk was not added');
}
?>