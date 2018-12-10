<?php

session_start();

if($_SESSION['logged-in'] == true){

$id = $_SESSION['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$uploaddir = 'assets/';
$uploadfile = $uploaddir . basename($_FILES['profilepic']['name']);
$profilepic = $_FILES['profilepic']['name'];

if (move_uploaded_file($_FILES['profilepic']['tmp_name'], $uploadfile)) {
    	//header("Location: add-article-confirm.php");
	}

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$stmt = $pdo->prepare("UPDATE `users` SET `firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email', `phone` = '$phone', `profilepic` = '$profilepic' WHERE `id` = '$id';");

$stmt->execute();

header("Location: profile.php");

}else{
echo('profile was not updated');
}
?>