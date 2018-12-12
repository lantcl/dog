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

$stat = $pdo->prepare("SELECT * FROM `status` WHERE `feature` = 1");
$stat->execute();
$currentstatus = $stat->fetch();

$walk = $pdo->prepare("SELECT `walks`.`pee`,`walks`.`poo`, `walks`.`walktime`, `walks`.`date`, `walks`.`notes`, `walklength`.`length`, `walks`.`lengthid`, `users`.`firstname`, `walks`.`userid`, `walklength`.`badge` FROM `walks` INNER JOIN `users` ON `walks`.`userid` = `users`.`id` INNER JOIN `walklength` ON `walks`.`lengthid` = `walklength`.`id` WHERE `walks`.`id` = '$id'");

$walk->execute();


?>

<!doctype html>
<html>
    <head>
        <title>Edit Record</title>
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
            <section class="mobileNav">
                <nav class="">
                    <ul>
                    <li><a href = "pack.php">My Pack</a></li>
                    <li><a href = "add-walk.php">Add Walk</a></li>
                    <li><a href = "status.php">Update Status</a></li>
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
        <h1>Walk Record for <?php echo($row["date"]);?></h1>
        <img id="usericon" src="assets/<?php echo($row["badge"]);?>" alt="badge icon">
            <form action="edit-walk-process.php" method="POST">
                <input type = "hidden" name="walkid" value="<?php echo($id);?>"/>
                <p><input type = "time" name="walktime" required value="<?php echo($row["walktime"]);?>"></p>
                <p><select name="lengthid">
                        <option <?php if ($row["lengthid"] == 1){ ?>selected="selected"<?php }?> value="1">5-10 minutes</option >
                        <option <?php if ($row["lengthid"] == 2){ ?>selected="selected"<?php }?> value="2">10-20 minutes</option>
                        <option <?php if ($row["lengthid"] == 3){ ?>selected="selected"<?php }?>value="3">20-30 minutes</option>
                        <option <?php if ($row["lengthid"] == 4){ ?>selected="selected"<?php }?> value="4">40+ minutes</option >
                        <option <?php if ($row["lengthid"] == 5){ ?>selected="selected"<?php }?> value="5">Dog Park</option >
                </select></p>
                <div class="checkboxes">
                <p>pee</p><input type="checkbox" name="pee" value="1" <?php if($row["pee"] == 1 ){ ?> 
                    checked <?php } ?>/>
                <p>poo</p><input type="checkbox" name="poo" value="1" <?php if($row["poo"] == 1 ){ ?> 
                    checked <?php } ?>/>
                </div><br>
                <p><textarea name="notes" placeholder="notes" value="<?php echo($row["notes"]);?>"></textarea></p>
                <p><input class="button" type="submit" value="submit"/></p>
            </form>
           </div>
            <?php } } else { ?>
        <h1>You must be logged in to update a walk record</h1>
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