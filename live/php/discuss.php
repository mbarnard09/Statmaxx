<?php
session_start()

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
                <li><a href= "discuss.php" style="text-decoration: none; color: black;">Discuss</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>
        <div class ="discuss">
          <div class ="discusshead"><div class="logo"><strong class="green logoFontFormatter">XX</strong><span class="logoText">Discussion</span></div> </div>
          <div class ="discusslog">
            <?php
              $servername = "localhost";
              $username = "admin";
              $password = "Pizza1212";
              $dbname = "statmaxx";

              $conn = mysqli_connect($servername, $username, $password, $dbname);


              if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
              }
              $uquery = "SELECT * FROM discuss ORDER BY date, time DESC ";
              $uresult = mysqli_query($conn, $uquery);
              while($urow = mysqli_fetch_array($uresult)){
                $urows[] = $urow;
              }
              foreach($urows as $urow){
                echo "<div class = 'commentbox'>";
                  echo "<div class ='commentname'>" . $urow['name'] ." - ". $urow['date']."</div>";
                                    echo "<div class ='comment'>" . $urow['comment'] . "</div>";
                  echo "</div>";
              }



            ?>




          </div>
          <div class ="discusspost">
            <form action="discuss.php" method = "post" class="discussform" >
              <input type="text" placeholder="Enter discussion post..." id= "discusspost" name="discusspost" required>
              <input type="submit" name="postsubmit" id="discusspost" type="button" value="Post" >
            </form>
            <?php
              if(isset($_POST['postsubmit'])){
                if(isset($_SESSION['name'])){
                  $name = $_SESSION['name'];
                  $comment = $_POST['discusspost'];

                  $date = date("Y-m-d");
                  $time = date("H:i:s");
                  $servername = "localhost";
                  $username = "admin";
                  $password = "Pizza1212";
                  $dbname = "statmaxx";

                  $conn = mysqli_connect($servername, $username, $password, $dbname);


                  if (!$conn) {
                      die("Connection failed: " . mysqli_connect_error());
                  }
                  $dquery = "INSERT into discuss (name, comment, date, time) VALUES ('$name', '$comment', '$date', '$time')";
                  $dresult = mysqli_query($conn, $dquery);
                  echo 'Thanks for your post!';
                  header("refresh:1;url= discuss.php");

                }else{
                  echo "You must be signed in to post on the discussion forum.";
                }
            }

            ?>



          </div>
        </div>


      <div>
      </div>
    </body>
</html>
