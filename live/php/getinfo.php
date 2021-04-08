<?php 
    $servername = "localhost";
    $username = "admin";
    $password = "Pizza1212";
    $dbname = "statmaxx";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $q = $_GET['q'];
    
    if (!$conn) {
    	   echo("Connection failed: " . mysqli_connect_error());
    }

    $date = new DateTime();
    $dateWeek = date('Y-m-d', strtotime("-1 week"));
    $dateMonth = date('Y-m-d', strtotime("-1 month"));

    $sqlDay = "SELECT SUM(mentions) as mentions, SUM(positive) as positive, SUM(negative) as negative, SUM(neutral) as neutral from
    maindata where date = '" . ($date->format("Y-m-d")) . "' and sym = '" . $q . "'";

    $sqlWeek = "SELECT SUM(mentions) as mentions, SUM(positive) as positive, SUM(negative) as negative, SUM(neutral) as neutral from
    maindata where date between '" . $dateWeek . "' and '" . ($date->format("Y-m-d")) ."' and sym = '" . $q . "'"; 

    $sqlMonth = "SELECT SUM(mentions) as mentions, SUM(positive) as positive, SUM(negative) as negative, SUM(neutral) as neutral from
    maindata where date between '" . $dateMonth . "' and '".($date->format("Y-m-d"))."' AND sym = '" . $q . "'";
	 $sqlWeekAll = "SELECT SUM(mentions) as mentions from
    maindata where date between '" . $dateWeek . "' and '" . ($date->format("Y-m-d")) ."'";
    $sqlMonthAll = "SELECT SUM(mentions) as mentions from
    maindata where date between '" . $dateMonth . "' and '".($date->format("Y-m-d")). "'";
    $sqlDayAll = "SELECT SUM(mentions) as mentions from
    maindata where date = '" . ($date->format("Y-m-d")) . "'";
    $data = [];

    $resultDay = mysqli_query($conn, $sqlDay);

    while($row = mysqli_fetch_array($resultDay)) {
        $temp = [];
        $temp["total"] = $row["mentions"];
        $temp["positive"] = $row["positive"];
        $temp["negative"] = $row["negative"];
        $temp["neutral"] = $row["neutral"];
        $data["day"] = $temp;
    }

    $resultWeek = mysqli_query($conn, $sqlWeek);

    while($row = mysqli_fetch_array($resultWeek)) {
        $temp = [];
        $temp["total"] = $row["mentions"];
        $temp["positive"] = $row["positive"];
        $temp["negative"] = $row["negative"];
        $temp["neutral"] = $row["neutral"];
        $data["week"] = $temp;
    }

    $resultMonth = mysqli_query($conn, $sqlMonth);

    while($row = mysqli_fetch_array($resultMonth)) {
        $temp = [];
        $temp["total"] = $row["mentions"];
        $temp["positive"] = $row["positive"];
        $temp["negative"] = $row["negative"];
        $temp["neutral"] = $row["neutral"];
        $data["month"] = $temp;
    }
	 $resultMonthAll = mysqli_query($conn, $sqlMonthAll);
    while($row = mysqli_fetch_array($resultMonthAll)) {
             $data["totalsMonth"] = $row["mentions"];
    }
    $resultWeekAll = mysqli_query($conn, $sqlWeekAll);
    while($row = mysqli_fetch_array($resultWeekAll)) {
                        $data["totalsWeek"] = $row["mentions"];
    }
    $resultDayAll = mysqli_query($conn, $sqlDayAll);
    while($row = mysqli_fetch_array($resultDayAll)) {
                $data["totalsDay"] = $row["mentions"];
    }
    $data["symbol"] = $q;
    echo json_encode($data);

?>
