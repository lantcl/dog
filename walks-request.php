<?php

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$testing = $_POST['curDate'];
//$testing = "2018-12-08T23:31:08.000Z";

$dateRequest = substr($testing, 0,10);
//echo($dateRequest);

// $test = strtotime($dateRequest);
// $date = date("Y-m-d", $test);


$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `date` = '$dateRequest'");
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);
echo($json);

?>