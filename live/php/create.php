<!DOCTYPE html/>
<html>
    <head>

    <title>StatMaxx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="create.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <link rel="icon" type="image/png" href="screenshot3.png"/>
    <script src="https://d3js.org/d3.v5.js"></script>
    

    </head>

    <body>
        <header>
            <a class="logo biglogo"href="index.php"><img src="screenshot2.png" alt="logo"width=200></a>
            <a class="logo smalllogo"href="index.php"><img src="screenshot1.png" alt="logo"></a>

            <form action="/stock.php" method="get">
                <input type="search" class="search" name="search" placeholder="Type a Symbol"></input>
            </form>
            <ul>
              <?php
                if(isset($_SESSION['name'])){
                  echo '<li><a href= "myaccount.php" style="text-decoration: none; color: black">' . $_SESSION['name'] . '</a></li>';
                }else{
                  echo '<li><a href= "reg.php" style="text-decoration: none; color: black">Account</a></li>';
                }

                 ?>

                <li><a href= "discuss.php" style="text-decoration: none; color: black;">Discuss</a></li>
                <li><a href="support.php" style="text-decoration: none; color: black">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>
    

        <div class="create">
            <div class="title">
                Create a Post
            </div>
            <form action="/create.php" method="post">
            <div class="contain">
                <label for="title">Choose a Title</label><br>
                <textarea id="title" name="title" rows="2"  required></textarea><br>
                <label for="sym">Symbol</label><br>
                <input type="text" maxlength="6" name="sym" id="sym" required><br>
                <label for="opinion">Opinion</label><br>
                <select name="opinion" id="opinion"> 
                    <option value="bull" selected>Bullish</option>
                    <option value="bear">Bearish</option>
                </select><br>
                <label for="trade">Specific Trade Details</label><br>
                <textarea id ="trade"name="trade" rows="2" cols="100" placeholder ="e.g. $325 strike price 09/10 exp calls @2.50"
                required></textarea><br>
                <label for="time">Desired length of time to be in this trade</label><br>
                <textarea id="time" name="time" rows="2" cols="100" required 
                placeholder="e.g. 3-5 days exit if down 20%"></textarea><br>
                <label for="analysis">Give your analysis of this trade</label><br>
                <textarea id="analysis" name="analysis" rows="15" cols="100" 
                placeholder="Provide detailed reasons why you like this trade" required></textarea><br>
                <input type="submit" name="submit_post">
            </div>
            </form>
            
        </div>
	<?php
		if (isset($_POST["submit_post"])){
			    $servername = "localhost";
                $username = "admin";
                $password = "Pizza1212";
                $dbname = "statmaxx";

            	$conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                
                $title = $_POST["title"];
                $symbol = $_POST["sym"];
                $opinion = $_POST["opinion"];
                $trade = $_POST["trade"];
                $time = $_POST["time"];
                $analysis = $_POST["analysis"];
                
                $query = "INSERT INTO posts (title, symbol, opinion, trade_type, duration, analysis) values ('$title',
                '$symbol', '$opinion','$trade','$time','$analysis')";

                $result = mysqli_query($conn, $query);

                header("refresh:1; url=forum.php");
		}
			
	?>

    </body>