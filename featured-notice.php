
<?php 

$dsn = "mysql:host=localhost; dbname=lantc_dog; charset=utf8mb4";
$dbusername = "lantc";
$dbpassword = "thisisapassword!";

$pdo = new PDO($dsn, $dbusername, $dbpassword); 

$stmt = $pdo->prepare("SELECT * FROM `notices`");

$stmt->execute();
?>


<!doctype html>
<html>
    <head>
        <title>Featured Notice</title>
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
        <h1>Set featured Notice on Home Page</h1>
        <form action="featured-notice-process.php" method="POST">         
            <select name="noticeid">
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo($row["noticeid"]);?>"><?php echo($row["notice"]); ?>
                </option>
                <?php } ?>
                <input type="submit" /> 
            </select>         
        </form>


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

