<?php 
session_start();

$userid = $_SESSION['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";

$pdo = new PDO($dsn, $dbusername, $dbpassword);

$userInfo = $pdo->prepare("SELECT * FROM `users` WHERE `id` = $userid");
$userInfo->execute();

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
            <h1><a id="logo" href = "main.php">Walky Talky</a></h1>
            <h1>Last Walk <?php echo($last . ' ' . $tt);?></h1>
            <?php if($_SESSION['logged-in'] == true){?>
            <a href = "logout.php"><h2>Log Out</h2></a>
            <a href = "user-profile.php"><img id="usericon" src="assets/<?php echo($user["profilepic"]);?>" alt="profile icon"></a>
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
            <h2 id="today"></h2>
            </div>        
            <section id="main">
                <h1>My Profile </h1>
                <?php while($row2 = $userInfo->fetch()){ ?>
                    <img id="usericon" src="assets/<?php echo($row2["profilepic"]);?>" alt="profile icon">
                    <h2>Name <?php echo($row2["firstname"].' '.$row2["lastname"]);?></h2>
                    <h2>Phone number <?php echo($row2["number"]);?></h2>
                    <h2>Email <?php echo($row2["email"]);?></h2>
               <?php } ?>
               <h2 id="editProfile">Edit Profile information</h2>
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

