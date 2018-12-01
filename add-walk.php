<?php session_start();

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

$date = new DateTime($lastwalk["time"]);
$tt = "AM";
if ($date > '12:00:00'){$tt = "PM";} 

$last = $date->format('H:i');

?>

<html>
    <head>
        <title>Add Walk</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/base.css">
        <link rel="stylesheet" type="text/css" href="css/mobile.css">
    </head>
    <body onload="startTime()">
        <header>       
            <h1><a id="logo" href = "main.php">Walky Talky</a></h1>
            <h1>Last Walk <?php echo($last . ' ' . $tt);?></h1>
            <?php if($_SESSION['logged-in'] == true){?>
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
                    <li><a id = "notice" href = "notice.php">Update Notice</a></li>
                    </ul>
                </nav>          
            </section>            
            <h2>Notice Goes here</h2>
            <h2><span id="datetime"></span></h2>
        </section>
        <section>
            <div id="daynav">
            <h2 id="today"></h2>
            </div>
        </section>

        <section class="main"> 
            <section class="form">        
     		<form action="add-walk-process.php" method="POST"><br>
     			<input type = "hidden" name="dogid" value="1"/><br>
     			<input type = "date" autocomplete="on" name="date" required><br> 
				<input type = "time" autocomplete="on" name="time" required><br> 
				Walk Length:<select name="lengthid">
                        <option value="1">quick pee - 5 minutes</option>
                        <option value="2">around the block - 10 minutes</option>
                        <option value="3">normal walk - 15-20 minutes</option>
                        <option value="4">long walk - 25-40 minutes</option>
                        <option value="5">gold star walk - 25-40 minutes</option>
                    </select><br>

				Pee <input type="checkbox" name="pee" value="1" />
				Poop <input type="checkbox" name="poo" value="1" />
				
				Notes:<textarea name="notes"></textarea><br>
				<input type = "submit"/><br>
     		</form>
            </section>
        </section>

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

