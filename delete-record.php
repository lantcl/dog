<?php

session_start();

$userid = $_SESSION['id'];
$id = $_GET['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$row = $pdo->prepare("SELECT * FROM `users` WHERE `id` = $userid");
$row->execute();
$user = $row->fetch();

$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `id` IN (SELECT MAX(`id`) FROM `walks`)");

$stmt->execute();
$lastwalk = $stmt->fetch();

$last = $lastwalk["walktime"];
$tt = "AM";
if ($last > '12:00'){
    $fix1 = substr($last, 0, 2) - 12; 
    $fix2 = substr($last, 2, 5);
    $last = $fix1.$fix2;
    $tt = "PM";
} 

$walk = $pdo->prepare("SELECT `walks`.`pee`,`walks`.`poo`, `walks`.`walktime`, `walks`.`date`, `walks`.`userid`, `walklength`.`length`, `walks`.`lengthid` FROM `walks` INNER JOIN `walklength` ON `walks`.`lengthid` = `walklength`.`id` WHERE `walks`.`id` = '$id'");

$walk = $pdo->prepare("SELECT `walks`.`pee`,`walks`.`poo`, `walks`.`walktime`, `walks`.`date`, `walks`.`notes`, `walklength`.`length`, `walks`.`lengthid`, `users`.`firstname`, `walks`.`userid`, `walklength`.`badge` FROM `walks` INNER JOIN `users` ON `walks`.`userid` = `users`.`id` INNER JOIN `walklength` ON `walks`.`lengthid` = `walklength`.`id` WHERE `walks`.`id` = '$id'");

$walk->execute();


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
                    <li><a href = "walk-history.php">Walk History</a></li>
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
            <div class="mainContent">
        <?php if($_SESSION['logged-in'] == true){ ?>  
        <?php
            while($row = $walk->fetch()) {     
                ?>  
        <h1 id="heading">Do you really want to delete this record?</h1>
            <div id="recordColumns">
                <div id="leftColumn">
                    <h2>Date</h2>
                    <h2>Time</h2>
                    <h2>Walked by</h2>
                    <h2>length</h2>
                    <h2>Business</h2>
                    <h2>notes</h2>
                </div>
                <div id="rightColumn">
                    <h2><?php echo($row["date"]);?></h2>
                    <h2><?php echo($row["walktime"]);?></h2>
                    <h2><?php echo($row["firstname"]);?></h2>
                    <h2><?php echo($row["length"]);?></h2>
                    <?php if($row["pee"] == 1 && $row["poo"] == 0){ ?><h2>Pee</h2><?php } 
                    else if($row["poo"] == 1 && $row["pee"] == 0){ ?><h2>Poo</h2><?php }
                    else { ?> <h2>Pee & Poo</h2> <?php } ?>
                    <h2><?php echo($row["notes"]);?></h2>
               </div> 
           </div>
           <br>
            <p id="destroyRecord"class="logInOut">Yes, destroy it</p>
            <a style="display: none" href="delete-process.php?id=<?php echo($id);?>" id="kill"><p>
            Yes, do it</p></a>
            <a style="display: none" href="main.php" id="nvm"><class="logInOut"p>
            Nevermind</p></a>
            <?php } } else { ?>
            <h1>You must be logged in to delete a record</h1>
        <a href = "login.php"><img src="assets/poopaw.svg" alt="paw icon" class="noticePaws"></a>
        <?php } ?>
        </div>
         </section> 
        <footer id="footernav">
                <h2>Keep track with your pack</h2>
        </footer>
        <script src="js/delete.js"></script>
    </body>
</html>