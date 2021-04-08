<?php
session_start()
?>

<!DOCTYPE html/>
<html>
    <head>

    <title>StatMaxx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"   href="post.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <link rel="icon" type="image/png" href="screenshot3.png"/>
    
    <script>
        var id = "<?= $_GET["post_id"];?>"
        var login = "<?=$_SESSION["email"];?>"
    </script>
    
    

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
            
                
        
            <?php
            $servername = "localhost";
            $username = "admin";
            $password = "Pizza1212";
            $dbname = "statmaxx";

            $conn = mysqli_connect($servername, $username, $password, $dbname);


            if (!$conn) {
              echo("Connection failed: " . mysqli_connect_error());
            }
            if (isset($_SESSION["email"])) {
                $votecheck = "select * from user_tracking where id_post='" . $_GET["post_id"] . "' and user='" .
                $_SESSION["email"] ."' limit 1";
                $voteQuery = mysqli_query($conn, $votecheck);
                if (mysqli_num_rows($voteQuery) > 0) {
                    while($row = mysqli_fetch_assoc($voteQuery)) {
                        if ($row["type_of"]=="u") {
                            $buttonHTML = '<div id="votes">
                            <div style = "background: rgba(1, 158, 1, 0.637);border-radius:5px;cursor:default;">⇧</div>
                            <div id="downvote">⇩</div>
                        </div>';
                        }
                        if ($row["type_of"]=="d") {
                            $buttonHTML = '<div id="votes">
                            <div id="update">⇧</div>
                            <div style="background: rgba(250, 30, 30, 0.753);border-radius:5px;cursor:default;">⇩</div>
                        </div>';
                        }
                    }
                } else {
                    $buttonHTML = '<div id="votes">
                    <div id="update">⇧</div>
                    <div id="downvote">⇩</div>
                </div>';
                }
                
            } else {
                $buttonHTML = '<div id="votes">
                    <div id="update">⇧</div>
                    <div id="downvote">⇩</div>
                </div>';
            }
            $comquery = "SELECT * FROM post_comments WHERE post_id = '" . $_GET["post_id"] . "' ORDER BY date_created desc";
            $comresult = mysqli_query($conn, $comquery);

            $query = "select * from posts where id ='" . $_GET["post_id"] . "'";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) {
            if ($row["opinion"]=="bull") {
                $divTop = '<div style="color: green;">Bullish</div>';
            }
            if ($row["opinion"]=="bear") {
                $divTop = '<div style="color: red;">Bearish</div>';
            }
    		echo '
            
        <div class="post">
            <div class="trade">
                <div id="sym"><strong>'.$row["symbol"].'</strong></div>'
                .$divTop.
                '<div>'.$row["votes"].' votes</div>'
                .$buttonHTML.
            '</div>
            <div class="contentTitle">'.$row["title"].'</div>
            <div class="details">
                <h1>Trade Details</h1>
                <div>Type of Trade: '.$row["trade_type"].'</div>
                <div style="border: none;">Duration: '.$row["duration"].'</div>
            </div>
            <div class="analysis">
                <h1>Analysis</h1>
                <div>'.$row["analysis"]. '</div>
            </div>';
        }
            ?>
            <div class="comAlt">
                <div class="altTop">
                    <div class="altTopTitle">Comments</div>
                    <?php
                        while($comrow = mysqli_fetch_assoc($comresult)) {

                            if($comrow["opinion"]=="bull") {
                                $opinDiv = '<h1 style="color:green;">Bullish</h1>';
                            }
        
                            if($comrow["opinion"]=="bear") {
                                $opinDiv = '<h1 style="color:red;">Bearish</h1>';
                            }
        
                            $date = date_create($comrow["date_created"]);
                            $datef = date_format($date,"M d, g:i");
        
                            echo '<div class="comBox">
                            <div class="comTLine">
                                <h2>'. $comrow["user"] . ' - '.$datef.'</h2>'.
                                $opinDiv
                            .'</div>
                            <div class="commentT">'.$comrow["comment"].'</div>
                        </div>';
                        }
                    ?>
                </div>
                <div class="altForm">
                    <form class="comForm" action="#" method="post">
                        <textarea rows="6" id="comText" name="comText" required></textarea>
                        <select id="opinion" name="opinion">
                            <option value="bull"selected>Bullish</option>
                            <option value="bear">Bearish</option>
                        </select>
                        <input type="submit" value="Submit" id="postComment" name="comSubmit">
                </form>
                </div>
            </div>
        </div>;
    
    
    
    <div class="comContainer">
        <div class="commentTop">
            <div class="comTitle">Comments</div>
            <?php
                $comquery = "SELECT * FROM post_comments WHERE post_id = '" . $_GET["post_id"] . "' ORDER BY date_created desc";
                $comresult = mysqli_query($conn, $comquery);
                while($comrow = mysqli_fetch_assoc($comresult)) {

                    if($comrow["opinion"]=="bull") {
                        $opinDiv = '<h1 style="color:green;">Bullish</h1>';
                    }

                    if($comrow["opinion"]=="bear") {
                        $opinDiv = '<h1 style="color:red;">Bearish</h1>';
                    }

                    $date = date_create($comrow["date_created"]);
                    $datef = date_format($date,"M d, g:i");

                    echo '<div class="comBox">
                    <div class="comTLine">
                        <h2>'. $comrow["user"] . ' - '.$datef.'</h2>'.
                        $opinDiv
                    .'</div>
                    <div class="commentT">'.$comrow["comment"].'</div>
                </div>';
                }
            ?>
            
        </div>
            <div class="commentForm">
                <form class="comForm" action="#" method="post">
                    <textarea rows="6" id="comText" name="comText" required></textarea>
                    <select id="opinion" name="opinion">
                        <option value="bull"selected>Bullish</option>
                        <option value="bear">Bearish</option>
                    </select>
                    <input type="submit" value="Submit" id="postComment" name="comSubmit">
                </form>
            </div>
        
    </div>  
    <?php
        if($_SESSION["email"] == "joshrudesill@gmail.com" || $_SESSION["email"] == "barnardm09@gmail.com") {
            echo "<div class='admin'>Administration Panel</div>";
        }
    ?>
    <?php
        if (isset($_POST["comSubmit"])) {
            if (isset($_SESSION["email"])) {
            $servername = "localhost";
            $username = "admin";
            $password = "Pizza1212";
            $dbname = "statmaxx";
            $id = $_GET['post_id'];
            $text = $_POST['comText'];
            $opinion = $_POST['opinion'];
            $user = $_SESSION["name"];
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
            echo("Connection failed: " . mysqli_connect_error());
            }
            $qquery = "INSERT INTO post_comments (post_id, comment, opinion, user) values ('$id', '$text', '$opinion',
            '$user')";
            $countQuery = "UPDATE posts SET num_comments = num_comments + 1 WHERE id ='$id';";
            mysqli_query($conn, $countQuery);
            $fin = mysqli_query($conn, $qquery);
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo '<script>alert("You must be logged in to do that")</script>';
        }
    }
?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="postAPI.js"></script>
        
        </body>
</html>