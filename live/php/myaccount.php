<?php
session_start()

?>
<!DOCTYPE html/>
<html>
    <head>
    <title>StatMaxx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="index.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
	<script src="https://d3js.org/d3.v5.js"></script>
	<script src="chart.js"></script>
    </head>
    <body>
        <header>
            <a href = "index.php" style="text-decoration: none" <div class="logo"><strong class="green logoFontFormatter">XX</strong><span class="logoText">StatMaxx</span></div> </a>


            <ul>
              <?php
                if(isset($_SESSION['name'])){
                  echo '<li><a href= "myaccount.php" style="text-decoration: none">' . $_SESSION['name'] . '</a></li>';
                }else{
                  echo '<li><a href= "reg.php" style="text-decoration: none">Account</a></li>';
                }

               ?>
                <li><a href= "discuss.php" style="text-decoration: none; color: black">Discuss</a></li>
		<li><a href="support.php" style="text-decoration: none; color: black">Support</a></li>
		<li><a href="donate.php" style="text-decoration: none; color: black">Donate</a></li>
                            </ul>
        </header>
        <div class="account">
          <form action="myaccount.php" method = "post">
            <div class="signinlogo">
	      <strong class="green logoFontFormatter">My</strong><span class="logoText">Account</span>
		
	    </div>
		<div style="text-align: center;margin:1em;">Head over to discuss to post comments! More features coming soon..</div>
            <div class="logoutButton">
              <input type="submit" name="create" id="register" type="button" value="LOGOUT" >
            </div>
            <?php
              if(isset($_POST['create'])){
                session_unset();
                session_destroy();
                echo 'Logging out. Redirecting to homepage...';
                header("refresh:1;url= index.php");
              }

            ?>
        </div>


      </form>

      <div>
      </div>
    </body>
</html>
