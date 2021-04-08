<?php
session_start()
?>


<!DOCTYPE html/>
<html>
    <head>

    <title>StatMaxx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="forum.css">
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

        <div class="contain">
          <div class="aaa">
            <div class="bbb">
              <div>TradeMaxx</div>
              <a href="/create.php"><button>Create a Post</button></a>
            </div>
              
            <div class="ddd">
              <div>A place to post and view trading ideas from your fellow trader!</div>
              
              
            </div>
          </div>

          
          <?php
            $servername = "localhost";
            $username = "admin";
            $password = "Pizza1212";
            $dbname = "statmaxx";

            $conn = mysqli_connect($servername, $username, $password, $dbname);


            if (!$conn) {
              echo("Connection failed: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM posts ORDER BY votes DESC ";
            $result = mysqli_query($conn, $query);
            
            while($row = mysqli_fetch_assoc($result)) {
		echo "<form action ='/post.php'  method='get' id='post" . $row["id"] . "'><input type='hidden' name='post_id' value='" . $row["id"] . "'></form>";
		if($row["opinion"] == 'bull') {
			echo "<div class='sub' style='border: 1px solid rgba(31, 191, 71, 0.7);' onclick=\"document.getElementById('post" . $row["id"] . "').submit()\"><div class='ccc'>";		} 
		if($row["opinion"] == 'bear') {
			echo "<div class='sub' style='border: 1px solid rgba(245, 32, 32, 0.6);' onclick=\"document.getElementById('post" . $row["id"] . "').submit()\"><div class='ccc'>";		} 

                
                echo "<div style='font-weight: bold;'>" . strtoupper($row["symbol"]) . "</div>";

		if($row["opinion"] == 'bull') {
			echo "<div style='color:green'>Bullish</div></div>";
		} 
		if($row["opinion"] == 'bear') {
			echo "<div style='color:red'>Bearish</div></div>";
		} 

		
                echo "<div class='dis'>" . $row["title"] . "</div>";
                echo "<div class='inf'>";
                echo "<div>" . $row["votes"] . " votes</div>";
                echo "<div>" . $row["num_comments"] . " comments</div>";
                echo "</div></div>";
            }
            mysqli_close($conn);
          ?>
          
        </div>

    </body>

</html>