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
    <link rel="stylesheet" type="text/css"   href="stock.css">
    <link href='https://fonts.googleapis.com/css?family=Monoton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Gothic A1' rel='stylesheet'>
    <script src="getstock.js"></script>
    <script src="https://d3js.org/d3.v5.js"></script>
    <script>var query = "<?PHP echo $_GET['search'];?>"</script>
    <title>StatMaxx: <?=strtoupper($_GET["search"]);?></title>
    </head>
    <body>
	
        <header>
             <a class="logo biglogo"href="index.php"><img src="screenshot2.png" alt="logo"width="200"></a>
            <a class="logo smalllogo"href="index.php"><img src="screenshot1.png" alt="logo"></a>
        	<form>
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
                <li><a href="support.php" style="text-decoration: none; color: black;">Support</a></li>
                <li><a href="donate.php"style="text-decoration: none; color: black;">Donate</a></li>
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

            $q = $_GET['search'];
            $dateMonth = date('Y-m-d', strtotime("-1 month"));
            $date = new DateTime();

            $stockQuery = "SELECT date_format(date, '%Y-%m-%d') as date, SUM(mentions) as mentions, SUM(positive) as 
            positive, SUM(negative) as negative, SUM(neutral) as neutral from maindata where date between '" . 
            $dateMonth . "' and '" . ($date->format("Y-m-d")) ."' and sym = '" . $q . "' group by date_format(date, '%d') order by date desc";

            $allQuery = "SELECT sum(mentions) as sumMentions from maindata where date between '" . 
            $dateMonth . "' and '" . ($date->format("Y-m-d")) ."' group by date_format(date, '%d') order by date desc";

            $resultStock = mysqli_query($conn, $stockQuery);
            $resultAll = mysqli_query($conn, $allQuery);

            $data = [];
            $x = 0;
            while($row = mysqli_fetch_array($resultStock)) {
                $temp = [];
                $temp["total"] = $row["mentions"];
                $temp["positive"] = $row["positive"];
                $temp["negative"] = $row["negative"];
                $temp["neutral"] = $row["neutral"];
                $dateTemp = $x;
                $data[$dateTemp] = $temp;
                $x += 1;

            }
            $totals = [];
            $x2 = 0;
            while($row = mysqli_fetch_array($resultAll)) {
                $totals[$x2] = $row["sumMentions"];
                $x2 += 1;
            }
            /*
            temp = ["total": 234, "positive": 345]
            dateTemp = "2020-10-27"
            data = {["2020-10-27":  ["total": 234, "positive": 345]],["2020-10-28":  ["total": 234, "positive": 345]] }
            */
            $allDay = 0;
            $allWeek = 0;
            $allMonth = 0;

            $dayTotal = 0;
            $dayPositive = 0;
            $dayNeg = 0;
            $dayNu = 0;

            $weekTotal = 0;
            $weekPositive = 0;
            $weekNeg = 0;
            $weekNu = 0;

            $monthTotal = 0;
            $monthPositive = 0;
            $monthNeg = 0;
            $monthNu = 0;

            for($i=0;$i<30;$i++) {
                if ($i == 0) {
                    $dayTotal = $data[$i]["total"];
                    $dayPositive = $data[$i]["positive"];
                    $dayNeg = $data[$i]["negative"];
                    $dayNu = $data[$i]["neutral"];
                    $allDay = $totals[$i];
                }
                if($i < 7) {
                    $weekTotal += $data[$i]["total"];
                    $weekPositive += $data[$i]["positive"];
                    $weekNeg += $data[$i]["negative"];
                    $weekNu += $data[$i]["neutral"];
                    $allWeek += $totals[$i];
                }
                $monthTotal += $data[$i]["total"];
                $monthPositive += $data[$i]["positive"];
                $monthNeg += $data[$i]["negative"];
                $monthNu += $data[$i]["neutral"];
                $allMonth += $totals[$i];
            }
            
        ?>
        
        <aside>
            <div class="asideTitle">
                <?= strtoupper($_GET["search"]);?>
                
                <span class="price">
                    
                </span>
            </div>
            <div class="asideSubTitle bottomBorder">Totals <span class="stockDesc">Mentions</span></div>
            <div class="asideFlex bottomBorder2">
                <div class="lineTitle">Day</div>
                <div id="dayTotal">Total: <?php echo $dayTotal;?></div>
                <div id="dayPos"class="green">Positive: <?php echo $dayPositive;?> </div>
                <div id="dayNeg"class="red">Negative: <?php echo $dayNeg;?></div>
                <div id="dayNu"class="gray">Neutral: <?php echo $dayNu;?></div>
                <div id="dayMarket">% of Total Comments: <?php echo round(($dayTotal/$allDay)*100,2);?>%</div>
                
            </div>
            <div class="asideFlex bottomBorder2">
                <div class="lineTitle ">Week</div>
                <div id="weekTotal">Total: <?php echo $weekTotal;?></div>
                <div id="weekPos"class="green">Positive: <?php echo $weekPositive;?></div>
                <div id="weekNeg"class="red">Negative: <?php echo $weekNeg;?></div>
                <div id="weekNu"class="gray">Neutral: <?php echo $weekNu;?></div>
                <div id="weekMarket">% of Total Comments: <?php echo round(($weekTotal/$allWeek)*100,2);?>%</div>
                
            </div>
            <div class="asideFlex">
                <div class="lineTitle">Month</div>
                <div id="monthTotal">Total: <?php echo $monthTotal;?></div>
                <div id="monthPos"class="green">Positive: <?php echo $monthPositive;?></div>
                <div id="monthNeg"class="red">Negative: <?php echo $monthNeg;?></div>
                <div id="monthNu"class="gray">Neutral: <?php echo $monthNu;?></div>
                <div id="monthMarket">% of Total Comments: <?php echo round(($monthTotal/$allMonth)*100,2);?>%</div>
                
            </div>
            
        </aside>
	<figure>
		<form id="formChart">
			<div class="graphTitle">
				<div class="graphText"><?= strtoupper($_GET["search"]);?></div>
                                <select id="selectTime" onchange="chart(window.query)">
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
		<div id="chart"class="chart"></div>
        </figure>
    </body>
</html>
