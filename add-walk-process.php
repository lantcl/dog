<?php

session_start();

if($_SESSION['roleid'] == 1 || 2){

$walkday = $_POST['walkday'];
$walktime = $_POST['walktime'];
$walklength = $_POST['walklength'];
$articlesummary = $_POST['articlesummary'];
$industry = $_POST['articlecat-industry'];
$career = $_POST['articlecat-career'];
$technical = $_POST['articlecat-technical'];
$articledate = $_POST['articledate'];
$filename = $_FILES['articleimage']['name'];

if (move_uploaded_file($_FILES['articleimage']['tmp_name'], $uploadfile)) {
    	//header("Location: add-article-confirm.php");
	} else {
    	echo "Please select an image to upload\n";
	}


$dsn = "mysql:host=localhost; dbname=lantc_imm_news_network; charset=utf8mb4";
$dbusername = "lantc_imm";
$dbpassword = "thisisapassword!";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$stmt = $pdo->prepare("INSERT INTO `walkhistory` (`walkid`, `walkday`, `walktime`, `walklength`, `articleimage`, `articlecat-industry`, `articlecat-technical`, `articlecat-career`, `articledate`, `articlesummary`) VALUES (NULL, '$walkday', '$walktime', '$walklength', '$filename', '$industry', '$technical', '$career', '$articledate', '$articlesummary');");

$stmt->execute();

header("Location: main.php");

}else{
	echo('walk was not added');
}
?>

?>