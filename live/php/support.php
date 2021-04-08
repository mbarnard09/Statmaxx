<?php
session_start();
?>
<!DOCTYPE html/>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="support.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <title>Support</title>
    <script src="https://d3js.org/d3.v5.js"></script>
    <script src="support.js"></script>
    </head>
    <body>
        <header>
        <a class="logo biglogo"href="index.php"><img src="screenshot2.png" alt="logo"width=200></a>
            <a class="logo smalllogo"href="index.php"><img src="screenshot1.png" alt="logo"></a>
       
            <ul>
            <?php
                if(isset($_SESSION['name'])){
                  echo '<li><a href= "myaccount.php" style="text-decoration: none; color: black">' . $_SESSION['name'] . '</a></li>';
                }else{
                  echo '<li><a href= "reg.php" style="text-decoration: none; color: black">Account</a></li>';
                }

                 ?>
                <li><a href= "discuss.php" style="text-decoration: none; color: black">Discuss</a></li>
                <li><a href = "support.php" style="text-decoration: none; color: black">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>
        <article>
        <div class="supportInfo">
            <div class="suppCategory" id="support" onclick="support()">Support</div>
            <div class="suppCategory" id ="philosophy" onclick="philosophy()">Philosophy</div>
            <div class="suppCategory" id="comingsoon" onclick="comingsoon()">Coming Soon</div>
            <div class="suppCategory" id="changelog" onclick="changelog()">Change Log</div>
            <div class="suppCategory noborder" id="other" onclick="other()">Other</div>
        </div>
        <div id="maintext" class="maintext">
        For any questions, comments, concerns or suggestions do not hesitate to email us.. We actually love feedback.<br><br>
        <a href = "mailto: statmaxxad@gmail.com" class="maintext">Statmaxxad@gmail.com</a><br><br>
        Thanks, <br><br>
        StatMaxx Team
        </div>
        </article>
    </body>
</html>
