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

$stmt = $pdo->prepare("SELECT * FROM `walks` WHERE `id` IN (SELECT MAX(`id`) FROM `walks`)");

$stmt->execute();
$lastwalk = $stmt->fetch();

$last = $lastwalk["walktime"];
$tt = "AM";
if ($last > '12:00'){$last = $last - '12'; $tt = "PM";} 

// $date = new DateTime($lastwalk["time"]);
// $tt = "AM";
// if ($date > '12:00:00'){$tt = "PM";} 

// $last = $date->format('H:i');
//the above worked with the phpmyadmin datetime data type, but couldn't submit it in that exact format with html so had to make date and time columns 
?>
<!doctype html>
<html>
    <head>
        <title>Walk History</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>        
            <a href = "#"><img src="#" alt="Dog Logo" style="width:100px"></a>
            <nav>
                <ul>
                <li><a href = "main.html">Home</a></li>
                <li><a href = "walk-history.html">Walk History</a></li>
                <li><a href = "login.html">Log in</a></li>
                <li><a href = "signup.html">Sign up</a></li>
                <li><a href = "featured-notice.html">Set Featured Notice</a></li>
                </ul>
            </nav>
        </header>

        <section>         
            <?php
            while($row = $stmt->fetch()) {     
                ?>
                    <div>
                    <p>Day: <?php echo($row["walkday"]);?></p>
                    <p>time: <?php echo($row["walktime"]);?></p>
                    <p>length: <?php echo($row["walklength"]);?></p>
                    <p>Pee: <?php echo($row["pee"]);?></p>
                    <p>poo: <?php echo($row["poo"]);?></p>
                    <p>notes: <?php echo($row["notes"]);?></p>
                </div>
            <?php }
            ?>
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
    </body>
</html>

