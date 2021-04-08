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
	<li><a href= "reg.php" style="text-decoration: none">Account</a></li>
                <li><a href= "discuss.php" style="text-decoration: none; color: black">Discuss</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>
        <div class="account">
          <form action="reg.php" method = "post" onsubmit="function()">
            <div class="signinlogo">
             <div class="logo"> <strong class="green logoFontFormatter">XX</strong><span class="logoText">Sign In</span></div>
            </div>

              <label for="firstname"><b>First Name</b></label>
              <input type="text" placeholder="Enter First Name" id= "firstname" name="firstname" required>

              <label for="lastname"><b>Last Name</b></label>
              <input type="text" placeholder="Enter Last Name" id= "lastname" name="lastname" required>

              <label for="email"><b>Email</b></label>
              <input type="email" placeholder="Enter Email" id= "email" name="email" required>

              <label for="pwd"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" id= "pwd" name="pwd" minlength="8" required>


              <input type="submit" name="create" id="register" type="button" value="Sign Up" >

              <div>Already have an account? Click  <a href = "signin.php"class="textsize">here to sign in.</a></div>

              <div>
                <?php
                  if(isset($_POST['create'])){
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $pwd = $_POST['pwd'];
                    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $date = date("Y-m-d");
                    $servername = "localhost";
                    $username = "admin";
                    $password = "Pizza1212";
                    $dbname = "statmaxx";

                    $conn = mysqli_connect($servername, $username, $password, $dbname);


                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $tquery = "SELECT * FROM users where email ='" . $email ."'";
                    $tresult = mysqli_query($conn, $tquery);
                    if(mysqli_num_rows($tresult) > 0){
                      echo "An account with this email already exists!";
                      exit();
                    }
                    $mquery = "INSERT into users (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$hashed_pwd')";
                    if(mysqli_query($conn, $mquery)){
                      echo "Thank you " . $firstname . ", your account has been created!";
                      header("refresh:1;url= signin.php");
                    }
                    mysqli_close($conn);

                  }
                  ?>

              </div>
            </div>
          </form>
        </div>

    </body>
</html>
