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
if ($last > '12:00'){
    $fix1 = substr($last, 0, 2) - 12; 
    $fix2 = substr($last, 2, 5);
    $last = $fix1.$fix2;
    $tt = "PM";
} 

$stat = $pdo->prepare("SELECT * FROM `status` WHERE `feature` = 1");
$stat->execute();
$currentstatus = $stat->fetch();


?>
<!doctype html>
<html>
    <head>
        <title>Edit Profile</title>
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
            <?php if($_SESSION['logged-in'] == true){?>
            <h1> Edit My Profile</h1>
                <?php while($row2 = $userInfo->fetch()){ ?>
                <form action="update-profile.php" method="POST" enctype= 'multipart/form-data'>
                    <h2>First Name</h2>
                    <p><input name="firstname" type="text" value="<?php echo($row2["firstname"]);?>"></p>
                    <h2>Last Name</h2>
                    <p><input name="lastname" type="text" value="<?php echo($row2["lastname"]);?>"></p>
                    <h2>Phone Number</h2>
                    <p><input name="phone" type="text" value="<?php echo($row2["phone"]);?>"></p>
                    <h2>Email</h2>
                    <p><input name="email" type="email" value="<?php echo($row2["email"]);?>"></p>
                    <h2>Profile Icon</h2>
                    <p><input name="profilepic" type="file"></p>
                    <p><input class="button" type="submit" value="update"/></p>
                </form>
               <?php } } else { ?>
        	<h1>You must be logged in to edit a profile</h1>
        	<a href = "login.php"><img src="assets/poopaw.svg" alt="paw icon" class="noticePaws"></a>
    		<?php } ?>
            </div>
        </section>
        <footer id="footernav">
                <h2>Keep track with your pack</h2>
        </footer>
        <script src="js/sub-script.js"></script>
    </body>
</html>
