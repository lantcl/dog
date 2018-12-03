<?php

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$date = date("Y-m-d");

$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `date` = '$date'");
$stmt->execute();
$walk = $stmt->fetch();

// echo($walk["id"]);
// echo($date);
?>