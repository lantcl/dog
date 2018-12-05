<?php 
session_start();

$userid = $_SESSION['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

// $row = $pdo->prepare("SELECT * FROM `users` WHERE `id` = $userid");
$row = $pdo->prepare("SELECT `users`.`firstname`, `users`.`profilepic`, `dog`.`id`, `dog`.`name`, `dog`.`photo` FROM `users` INNER JOIN `dog` ON `users`.`dogid` = `dog`.`id` WHERE `users`.`id` = '$userid'");
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

// $date = new DateTime($lastwalk["time"]);
// $tt = "AM";
// if ($date > '12:00:00'){$tt = "PM";} 

// $last = $date->format('H:i');
//the above worked with the phpmyadmin datetime data type, but couldn't submit it in that exact format with html so had to make date and time columns 

?>

<!doctype html>
<html>
    <head>
        <title>Walky-Talky</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/base.css">
        <link rel="stylesheet" type="text/css" href="css/mobile.css">
    </head>
    <body>
        <header>       
            <h1><a id="logo" href = "main.php">Walky Talky</a></h1>
            <h1>Last Walk <?php echo($last . ' ' . $tt);?></h1>
            <?php if($_SESSION['logged-in'] == true){?>
            <a href = "logout.php"><h2>Log Out</h2></a>
            <a href = "profile.php"><img id="usericon" src="assets/<?php echo($user["profilepic"]);?>" alt="profile icon"></a>
        <?php } else {?>
            <h1><a href = "login.php">Log In</a></h1>
        <?php } ?>
        </header>

        <section id="subhead">         
            <section class="dropdown">
                <img id="menubutton" class= "arrowbutton" src="assets/menubutton.svg" alt="menuicon">
                <nav class="dropdown-content">
                    <ul>
                    <li><a href = "main.php">Home</a></li>
                    <li><a id = "newWalk" href = "add-walk.php">Add Walk</a></li>
                    <li><a id = "notice" href = "status.php">Update Dog Status</a></li>
                    </ul>
                </nav>          
            </section>            
            <?php if($_SESSION['logged-in'] == true){ ?>            
            <h2><?php echo($user["name"].' '.$currentstatus["status"]);?></h2>
        <?php } ?>
            <h2><span id="datetime"></span></h2>
        </section>
        
        <section>
            <div id="daynav">
            <img id="goback" class= "arrowbutton" src="assets/backbutton.svg" alt="backbutton">
            <h2 id="today"></h2>
            <img id="goforward" class= "arrowbutton" src="assets/forwardbutton.svg" alt="forwardbutton">
            </div>
        </section>
        <section id="main">
            <div id ="chart">
                <div id="timeline"></div>
                <div id="timenumbers">
                    <p>1 AM</p>
                    <p>6 AM</p>
                    <p>12 PM</p>
                    <p>6 PM</p>
                    <p>12 AM</p>
                </div>
                <div id = "popbox">
                <a href="add-walk.php"><img class= "icon" id="add" src="assets/clockadd.svg" alt="paw icon"></a>
                <span class="hovertext">Add Walk</span>
                </div>
            </div>
        </section>
        <footer>
            <nav>
                <ul id="footernav">
                <li><a href = "#">About Walky Talky</a></li> 
                <li><a href = "#">Contribute</a></li>
                <li><a href = "#">Privacy Policy</a></li>  
                </ul>
            </nav>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>

