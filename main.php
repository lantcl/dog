<?php 
session_start();

$userid = $_SESSION['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";
 
$pdo = new PDO($dsn, $dbusername, $dbpassword);

$row = $pdo->prepare("SELECT * FROM `users` WHERE id = $userid");
$row->execute();
$user = $row->fetch();

$stmt = $pdo->prepare("SELECT `id`, MAX(`time`) AS most_recent_walk FROM `walks` GROUP BY id");
$stmt->execute();

$lastwalk = $stmt->fetch();

$last = $lastwalk["most_recent_walk"];
$lastTime = date("H:m");

?>

<!doctype html>
<html>
    <head>
        <title>Walky-Talky</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/base.css">
        <link rel="stylesheet" type="text/css" href="css/mobile.css">
    </head>
    <body onload="startTime()">
        <header>       
            <h1><a id="logo" href = "main.php">Walky Talky</a></h1>
            <h1>Last Walk <?php echo($lastTime);?></h1>
            <?php if($_SESSION['logged-in'] == true){?>
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
                    <li><a href = "main.html">Home</a></li>
                    <li><a href = "walk-history.html">Walk History</a></li>
                    <li><a id = "newwalk" href = "#">Add Walk</a></li>
                    </ul>
                </nav>          
            </section>            
            <h3>Notice Goes here</h3>
            <h3><span id="datetime"></span></h3>

        </section>
        
        <section id ="main">
            <div id="daynav">
            <img id="goback" class= "arrowbutton" src="assets/backbutton.svg" alt="backbutton">
            <h3 id="today"></h3>
            <img id="goforward" class= "arrowbutton" src="assets/forwardbutton.svg" alt="forwardbutton">
            </div>
            <div class = "clock">
                <div class="middle">
                    <div class="circle"></div>
                </div>
<!--                 <img class= "circle" src="assets/clockborder.svg" alt="walky talky clocky">
                <img class= "middle" src="assets/clockcenter.svg" alt="walky talky clocky">
                <img id= "clockadd" src="assets/clockadd.svg" alt="walky talky clocky"> -->
            </div>
        </section>
        <footer>
            <nav>
                <ul id="footernav">
                <li><a href = "#">About Dog</a></li> 
                <li><a href = "#">Contribute</a></li>
                <li><a href = "#">Privacy Policy</a></li>  
                </ul>
            </nav>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>

