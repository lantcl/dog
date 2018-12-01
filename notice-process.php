<?php

session_start();

if($_SESSION['roleid'] == 1){

$noticeid = $_POST['noticeid'];

$dsn = "mysql:host=localhost; dbname=lantc_imm_news_network; charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "qwerty";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$reset = $pdo->prepare("UPDATE `notices` SET `featurenotice`= '0' WHERE `featurenotice`= '1'");
$stmt = $pdo->prepare("UPDATE `notcies` SET `featurenotice`= '1' WHERE `noticeid` = '$noticeid'");

$reset->execute();
$stmt->execute();

header("Location: main.html");

}else{
	echo('notice not updated');
}
?>