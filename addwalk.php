
<html>
    <head>
        <title>Add Walk</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>        
            <a href = "#"><img src="#" alt="Dog Logo" style="width:100px"></a>
            <nav>
                <ul>
                <li><a href = "main.html">Home</a></li>
                <li><a href = "#">Walk History</a></li>
                <li><a href = "login.html">Log in</a></li>
                <li><a href = "signup.html">Sign up</a></li>
                </ul>
            </nav>
        </header>

        <section>         
     		<form action="add-walk-process.php" method="POST">
     			<input type = "hidden" name="userid"/>
     			<input type = "date" name="walkday">
     			<input type = "time" name="walktime"/> 
				
				Walk Length:<select name="walklength">
                        <option value="5">quick pee - 5 minutes</option>
                        <option value="10">around the block - 10 minutes</option>
                        <option value="15">normal walk - 15-20 minutes</option>
                        <option value="20">long walk - 25-40 minutes</option>
                        <option value="60">gold star walk - 25-40 minutes</option>
                    </select>

				Pee <input type="checkbox" name="pee" value="yes" />
				Poop <input type="checkbox" name="poop" value="yes" />
				
				Notes:<textarea name="walk day"></textarea>

				<input type = "submit"/>
     		</form>
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

