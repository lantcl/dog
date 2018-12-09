<?php 
session_start();

$userid = $_GET['userid'];
$loggedInUser = $_SESSION['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$userInfo = $pdo->prepare("SELECT * FROM `users` WHERE `id` = $userid");
$userInfo->execute();

$row = $pdo->prepare("SELECT `users`.`firstname`, `users`.`profilepic`, `dog`.`id`, `dog`.`name`, `dog`.`photo` FROM `users` INNER JOIN `dog` ON `users`.`dogid` = `dog`.`id` WHERE `users`.`id` = '$loggedInUser'");
$row->execute();
$user = $row->fetch();

$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `id` IN (SELECT MAX(`id`) FROM `walks`)");
$stmt->execute();
$lastwalk = $stmt->fetch();

$last = $lastwalk["walktime"];
$tt = "AM";
if ($last > '12:00'){$last = $last - '12'; $tt = "PM";} 

$stat = $pdo->prepare("SELECT * FROM `status` WHERE `feature` = 1");
$stat->execute();
$currentstatus = $stat->fetch();


?>
<!doctype html>
<html>
    <head>
        <title>Walk History</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/base.css">
        <link rel="stylesheet" type="text/css" href="css/mobile.css">
    </head>
    <body>
        <header>   
            <h1 style="z-index: 10"><a id="logo" href = "main.php">Walky Talky</a></h1>
                <div id="lastWalkTime">
                    <h2>Last Walk <?php echo($last . ' ' . $tt);?></h2>
                </div> 
            <?php if($_SESSION['logged-in'] == true){?>
                <a href = "profile.php" style="z-index: 10"><img id="usericon" src="assets/<?php echo($user["profilepic"]);?>" alt="profile icon"></a>
        <?php } else {?>
            <h2 style="z-index: 10"><a href = "login.php" class="logInOut">Log In</a></h2>
        <?php } ?>
        </header>

        <section id="subhead">         
            <section class="dropdown">
                <img id="menubutton" class= "arrowbutton" src="assets/menubutton.svg" alt="menuicon" style="z-index: 10">
                <nav class="dropdown-content">
                    <ul>
                    <li><a href = "main.php">Home</a></li>
                    <li><a href = "pack.php">My Pack</a></li>
                    <li><a id = "newWalk" href = "add-walk.php">Add Walk</a></li>
                    <li><a id = "notice" href = "status.php">Update Dog Status</a></li>
                    </ul>
                </nav>          
            </section>            
            <?php if($_SESSION['logged-in'] == true){ ?>            
            <div id="statusBar"> 
                <h2><?php echo($user["name"].' '.$currentstatus["status"]);?></h2>
            </div>
        <?php } ?>
            <h2><span id="datetime"></span></h2>
        </section>      
            <section id="main">
            <?php while($row2 = $userInfo->fetch()){ ?>    
                <h1><?php echo($row2["firstname"]);?>'s Profile </h1>
            </section>
                <div class="mainContent">
                
                    <img id="usericon" src="assets/<?php echo($row2["profilepic"]);?>" alt="profile icon">
                    <h2><?php echo($row2["firstname"].' '.$row2["lastname"]);?></h2>
                    <h2><?php echo($row2["phone"]);?></h2>
                    <h2><?php echo($row2["email"]);?></h2>
               <?php } ?>
            </div>
        
        <footer id="footernav">
                <h2>Keep track with your pack</h2>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>

