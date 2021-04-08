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
	<script type="text/javascript">
    window._mNHandle = window._mNHandle || {};
    window._mNHandle.queue = window._mNHandle.queue || [];
    medianet_versionId = "3121199";
</script>
<script src="https://contextual.media.net/dmedianet.js?cid=8CUC8N9L6" async="async"></script>
    <script data-ad-client="ca-pub-2936727461410103" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <title>StatMaxx</title>
    <meta name="description" content="StatMaxx is a web based trading tool that scans all of the internets top
        trading forums and analyzes the data. This allows our users to quickly see what stocks
	are garnering the attention of their fellow investors. Check the sidebar
  for the stocks getting the most mentions today, or use the search bar to get more in-depth mentions data on a stock."/>
    <link rel="stylesheet" type="text/css"   href="index.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <link rel="icon" type="image/png" href="screenshot3.png"/>
    <script src="https://d3js.org/d3.v5.js"></script>
    <script src="chart.js"></script>
    <meta name="propeller" content="626f51e6bb1a1a47bd3f0e105779842f">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
	<?php echo include_once (dirname(__FILE__) . '/pa_antiadblock_3575950.php');?>
    <body onload="chart()">
        <header>
	    <a class="logo biglogo"href="index.php"><img src="screenshot2.png" alt="logo"width=200></a>
	    <a class="logo smalllogo"href="index.php"><img src="screenshot1.png" alt="logo"></a>

            <form action="/stock.php" method="get" autocomplete="off">
                <input type="search" class="search" name="search" autocomplete="off" placeholder="Type a Symbol"></input>
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
                <li><a href="support.php">Support</a></li>
                <li><a href= "donate.php" style="text-decoration: none; color: black">Donate</a></li>
            </ul>
        </header>
	<div class="SBtooltip"id="tooltip"><strong>How to Read</strong><span id="toolclose" style="font-size: 1rem;cursor: pointer; position: absolute;right: 1em;">close</span><br><div>-Position (e.g. 1.)<br> -Symbol (e.g. MSFT)<br> -Percent Change in mentions today as compared to yesterday, adjusted for time. (e.g. +5%)<br> -Total mentions of this symbol since 12AM EST.(e.g. 1500 mentions).</div></div>
	<aside>

    <div class="sidebarID">Today's Top 300<div class="tool"id="tool">How to Read</div></div>
	 <script src="tooltip.js"></script>
		<div class="textsize">
            <?php
            $date = date("Y-m-d");
            $servername = "localhost";
            $username = "admin";
            $password = "Pizza1212";
            $dbname = "statmaxx";

            $conn = mysqli_connect($servername, $username, $password, $dbname);


            if (!$conn) {
		echo mysqli_connect_error();    
		die("Connection failed: " . mysqli_connect_error());
            }


            $query = "SELECT sym, SUM(mentions) as sum FROM maindata WHERE date='" . $date . "' GROUP BY sym ORDER BY SUM(mentions) DESC";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result)){
               $rows[] = $row;

            }

            $dateC = date_create();
            $dateC = date_modify($dateC, "-1 days");
            $dateC = date_format($dateC, "Y-m-d");
            $time = date("H:i:s");
            #getting mentions from day before
            $qquery = "SELECT sym, SUM(mentions) as sum FROM maindata WHERE date= '" . $dateC . "' AND time BETWEEN '00:00:00' and '" . $time . "' GROUP BY sym ORDER BY SUM(mentions) DESC";
            $qresult = mysqli_query($conn, $qquery);
            while($qrow = mysqli_fetch_array($qresult)){
              $qrows[] = $qrow;
            }
            $i = 0;
            foreach($rows as $row) {
                #calculating percent change in Mentions
                foreach($qrows as $qrow){
                  if($row['sym'] == $qrow['sym']){
                    $originalNumber = (int)$qrow['sum'];
                    $newNumber = $row['sum'];
                    if ($originalNumber == 0){
                      $percentage = $newNumber;
                    }else{
                      $change = $newNumber - $originalNumber;
                      $percentage = ($change / $originalNumber) * 100;
                      $percentage = round($percentage, 1);
                    }
                    break;
                  }else{
                    $newNumber = $row['sum'];
                    $percentage = $newNumber;
                    continue;
                  }
                }
		
                if($i == 300){
                  break;
                }
                $i++;
		if(($i % 2) == 0){
			echo "<form id='sidebarform". $row['sym'] ."' action='/stock.php' method='get'>";
			echo "<input type='hidden' name='search'  value= '" . strtoupper($row['sym']) ."'>";
			echo "<div class = 'sidebarLine' onclick=\"document.getElementById('sidebarform".$row['sym']."').submit()\">";

			echo "<div class='textsize'>". $i .". ". strtoupper($row['sym']). "</div>";                     
			
			if($percentage >= 0){
                       echo "<div class = 'green textsize'>" . "+" . $percentage . "%" . "</div>";
                     }else{
                       echo "<div class = 'red textsize'>" . $percentage . "%" . "</div>";
                     }
                     echo "<div class='textsize'>" . $row['sum'] . " Mentions</div>";
                     echo "</div> </form>";
		}else {
			echo "<form id='sidebarform". $row['sym'] ."' action='/stock.php' method='get'>";			echo "<input type='hidden' name='search'  value= '" . strtoupper($row['sym']) ."'>";
			echo "<div class = 'sidebarLine' onclick=\"document.getElementById('sidebarform".$row['sym']."').submit()\">";                    
			echo "<div class='textsize'>". $i .". ". strtoupper($row['sym']). "</div>";
                      if($percentage >= 0){
                        echo "<div class = 'green textsize'>" . "+" . $percentage . "%" . "</div>";
                      }else{
                        echo "<div class = 'red textsize'>" . $percentage . "%" . "</div>";
                      }
                     echo "<div class='textsize'>" . $row['sum'] . " Mentions</div>";
                     echo "</div> </form>";
                }

           }

           mysqli_close($conn);
            ?>

	</div>
	</aside>
	<div class="xyz">
		<div class ="info" id="infoz">
          <div class="zzz">
            <div id="info" style="background: rgb(210,210,210);">Info</div>
            <div style="border-left: 1px solid  rgb(177, 177, 177);border-right: 1px solid  rgb(177, 177, 177);" id="use">
              How to Use
            </div>
            <div id="soon">What's New</div>

          </div>
          <div id="welcome">
            <div class="xxx">Welcome to StatMaxx</div>
          <div class="yyy">StatMaxx is a web based trading tool that scans all of the internets top trading forums and analyzes
             the data. This allows our users to quickly see what stocks are garnering the attention of their fellow 
             investors. Check the sidebar for the stocks getting the most mentions today, or use the search bar to get
              more in-depth mentions data on a stock.</div>
          </div>
          
        </div>
	<div class="leaderboard" id="leaderboard">
                <div class="sidebarID"> <strong>Alltime Accuracy Leaderboard      </strong> <div id="algoopen" class="tool">Algorithm</div> </div>
                <?php
                  $date = date("Y-m-d");
                  $servername = "localhost";
                  $username = "admin";
                  $password = "Pizza1212";
                  $dbname = "statmaxx";

                  $conn = mysqli_connect($servername, $username, $password, $dbname);


                  if (!$conn) {
                      die("Connection failed: " . mysqli_connect_error());
                  }

                  $zquery = "SELECT source, sum(points) as sum FROM leaderboard GROUP BY source ORDER BY sum(points) desc";
                  $zresult = mysqli_query($conn, $zquery);
                  while($zrow = mysqli_fetch_array($zresult)){
                    $zrows[] = $zrow;
                  }
                  $i = 0;
                  foreach($zrows as $zrow) {
                    $i++;
                    echo "<div class='sidebarLine'>";
                        echo "<div class='lineContainer'>" . $i . "." . " /r/" . strtoupper($zrow['source']) . "</div>";
                        echo "<div class='lineContainer'>" . "POINTS: " . $zrow['sum'] . "</div>";
                    echo "</div>";
                  }

                  mysqli_close($conn);
                ?>
                </div>
	</div>
	</div>
		<script src ="switch.js"></script>
	        <div class="fig">
            <figure>
                <div class="chartID">
		    <div class="bigText"><strong>Market Comment Totals (CT)</strong></div>
			<form id="formChart">
				<select id="selectTime" onchange="chart()">
					<option value="DAY" selected>Day</option>
					<option value="WEEK">Week</option>
					<option value="MONTH">Month</option>
				</select>
			</form>
		    <div class="stats">
			<div id="mentions">Mentions: 0</div>
                        <div class="green" id="positive">Positive: 0</div>
                        <div class="red" id="negative">Negative: 0</div>
                        <div class="gray" id="neutral">Neutral: 0</div>
                    </div>
                </div>
                <div id="chart"><div class="lds-ellipsis" id="loader"><div></div><div></div><div></div><div></div></div></div>
            </figure>
            
	<div id="181510871">
    <script type="text/javascript">
        try {
            window._mNHandle.queue.push(function (){
                window._mNDetails.loadTag("181510871", "728x90", "181510871");
            });
        }
        catch (error) {}
    </script>
</div>	
 
<div id="algotext"class="algo"><div id="algoclose" style="text-align: right; padding: 0.5rem; cursor:pointer;">
Close</div>Positive Sentiment Percentage = x<br>

Or<br>

Negative Sentiment Percentage = -x<br>

 

Daily Stock Percentage change (if positive) = y

Or <br>

Daily Stock Percentage change (if negative) = -y<br>

 

X or -X value for sentiment on subreddit (per symbol):<br>

Sentiment 50-55% = 1 or -1<br>

Sentiment 55-60% = 2 or -2<br>

Sentiment 60-70% = 3 or -3<br>

Sentiment 70-80% = 4 or -4<br>

Sentiment 80-100% = 5 or -5 <br><br>

 

Y or -Y value for daily price change (per symbol):<br>

Change 0-5% = 1 or -1<br>

Change 5-10% = 2 or -2<br>

Change 10-25% = 3 or -3<br>

Change 25-50% = 4 or -4<br>

Change >50% = 5 or -5 <br>

 

1-Multiply X and Y for every symbol<br>

2-The mean of all the symbol scores per forum group is taken <br>

3-Mean score is then added to the total (scores accumulated from Aug 1st) </div>
<script src="index.js"></script>
<script src="tooltip.js"></script>

<script type="text/javascript">
    var vglnk = {key: '732e7eb652365156835dbe54464370b8'};
    (function(d, t) {
        var s = d.createElement(t);
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//cdn.viglink.com/api/vglnk.js';
        var r = d.getElementsByTagName(t)[0];
            r.parentNode.insertBefore(s, r);
    }(document, 'script'));
</script>
    </body>

</html>
