<?php

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$date = date("Y-m-d");

$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `date` = '$date'");
$stmt->execute();

$data = "[";
while($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($data != "[") {$data .= ",";}
    $data .= '{"walktime":"'  . $rs["walktime"] . '",';  ///w3 schools
    $data .= '"poo":"'   . $rs["poo"]   . '",';
    $data .= '"lengthid":"'. $rs["lengthid"]     . '"}'; 
}
$data .="]";


echo($data);

// $date = new DateTime($lastwalk["time"]);
// $tt = "AM";
// if ($date > '12:00:00'){$tt = "PM";} 

// $last = $date->format('H:i');


// echo($walk["id"]);

?>