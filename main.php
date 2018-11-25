<?php 
session_start();

$userid = $_SESSION['id'];

$dsn = "mysql:host=localhost;dbname=lantc_dog;charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "NkXHus3h!6V";
 
$pdo = new PDO($dsn, $dbusername, $dbpassword);

$row = $pdo->prepare("SELECT * FROM `users` WHERE id = $userid");
$row->execute();

$stmt = $pdo->prepare("SELECT `id`, MAX(`time`) AS most_recent_walk FROM `walks` GROUP BY id");
$stmt->execute();

$lastwalk = $stmt->fetch();
$user = $row->fetch();

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
        <section id="head">        
            <a href = "main.php"><img id= "logo" src="assets/logo.svg" alt="walky talky logo"></a>
            <h1>Last Walk <?php echo($lastwalk["most_recent_walk"]);?></h1>
            <?php if($_SESSION['logged-in'] == true){?>
            <a href = "user-profile.php"><img id="usericon" src="assets/<?php echo($user["profilepic"]);?>" alt="profile icon"></a>
        <?php } else {?>
            <h2><a href = "login.php"></a>Log In</h2>
        <?php } ?>
        </section>
        </header>
        <section id="nav">
            <nav>
                <ul>
                <li><a href = "main.html">Home</a></li>
                <li><a href = "walk-history.html">Walk History</a></li>
                <li><a href = "login.html">Log in</a></li>
                <li><a href = "signup.html">Sign up</a></li>
                <li><a href = "featured-notice.html">Set Featured Notice</a></li>
                </ul>
            </nav>            
        </section>

        <section id="subhead">         
            <h3>Notice Goes here</h3>
            <h3><span id="datetime"></span></h3>
        </section>

        <section id ="main">
            <h3><span id="today"></span></h3>
            <p>Clock goes here</p>
        </section>

        <section id="side">
            <p>Ad</p>
        </section>

        <footer>
            <nav>
                <ul>
                <li><a href = "#">About Dog</a></li> 
                <li><a href = "#">Contribute</a></li>
                <li><a href = "#">Privacy Policy</a></li>  
                </ul>
            </nav>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>

