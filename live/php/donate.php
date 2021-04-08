<?php
session_start();
?>
<!DOCTYPE html/>
<html>
    <head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177522188-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-177522188-1');
</script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="index.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <title>Donate</title>
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
		<li><a href= "discuss.php" style="text-decoration: none; color: black">Discuss</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>

        <div class= "account">
         <div class="donatetext"> StatMaxx is free to use, but not to run. If StatMaxx helps you in your trading endeavors, consider donating to help us stay operational.</div>
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"class="donatebutton">
            <input type="hidden" name="cmd" value="_donations" />
            <input type="hidden" name="business" value="NXAFJPVXU6GUN" />
            <input type="hidden" name="item_name" value="Statmaxx is free to use, but not to run. If statmaxx helps you in your trading endeavors, consider donating to help us stay operational." />
            <input type="hidden" name="currency_code" value="USD" />
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
	  </form>
	<img src="screenshot3.png"/>
        </div>
    </body>
</html>
