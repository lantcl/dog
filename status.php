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


$stats = $pdo->prepare("SELECT * FROM `status`");
$stats->execute();

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
        <section id = "main">
<?php if($_SESSION['logged-in'] == true){?>
        <h1>Update featured dog status</h1>
        <form action="status-process.php" method="POST">         
            <select name="id">
                <?php while($statList = $stats->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo($statList["id"]);?>"><?php echo($statList["status"]); ?>
                </option>
                <?php } ?>
                <input type="submit" /> 
            </select>         
        </form>
    <?php } else { ?>
        <h1>You must be logged in to update the dog status</h1>
        <a href = "login.php"><img src="assets/poopaw.svg" alt="paw icon" style="width: 50px"></a>
    <?php } ?>
    </section>
        <footer id="footernav">
                <h2>Keep track with your pack</h2>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>

