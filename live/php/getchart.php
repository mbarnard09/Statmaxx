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

		if ($q === "DAY") {     
		      $start = (new \DateTime())->modify('-24 hours');
    			$end = new DateTime('now');
    			$data = [];

    
        		$sql = "SELECT timestamp(date, date_format(time, '%H:00:00')) as date, SUM(mentions) as mentions, SUM(positive) as positive, 
        SUM(neutral) as neutral, SUM(negative) as negative 
        FROM maindata WHERE timestamp(date,time) between '" . $start->format("Y-m-d H:i:s") ."' and '" . $end->format("Y-m-d H:i:s") . 
        "' group by date(date), hour(time)";
        	$result = mysqli_query($conn, $sql);

        	while($row = mysqli_fetch_array($result)) {
            	$temp = [];
            	$temp["d"] = $row["date"];
            	$temp["m"] = $row["mentions"];
            	$temp["p"] = $row["positive"];
            	$temp["n"] = $row["negative"];
            	$temp["nu"] = $row["neutral"];
            
            	array_push($data, $temp);
        	}
                
                     
    echo json_encode($data);	

                  };

		if ($q === "WEEK") {
			$data = [];
			$start = (new \DateTime())->modify('-1 week');
        		$start->setTime(00,00);
    			$end = new DateTime('now');
    			$sql = "SELECT timestamp(date, date_format(time, '%H:00:00')) as date, SUM(mentions) as mentions, SUM(positive) as positive, 
        SUM(neutral) as neutral, SUM(negative) as negative 
        FROM maindata WHERE timestamp(date,time) between '" . $start->format("Y-m-d H:i:s") ."' and '" . $end->format("Y-m-d H:i:s") . 
        "' group by date(date), floor(hour(time)/6)";
        	$result = mysqli_query($conn, $sql);

        	while($row = mysqli_fetch_array($result)) {
            	$temp = [];
            	$temp["d"] = $row["date"];
            	$temp["m"] = $row["mentions"];
            	$temp["p"] = $row["positive"];
            	$temp["n"] = $row["negative"];
            	$temp["nu"] = $row["neutral"];
            
            array_push($data, $temp);
        }
                
                     
    echo json_encode($data);
};
		if ($q === "MONTH") {

                   	$start = (new \DateTime())->modify('-1 month');
    			$end = new DateTime('now');
    
			$data = [];
			$sql = "SELECT timestamp(date, date_format(time, '%H:00:00')) as date, SUM(mentions) as mentions, SUM(positive) as positive, 
    SUM(neutral) as neutral, SUM(negative) as negative 
    FROM maindata WHERE timestamp(date,time) between '" . $start->format("Y-m-d H:i:s") ."' and '" . $end->format("Y-m-d H:i:s") . 
    "' group by date(date)";
    			$result = mysqli_query($conn, $sql);

    			while($row = mysqli_fetch_array($result)) {
        			$temp = [];
        			$temp["d"] = $row["date"];
        			$temp["m"] = $row["mentions"];
        			$temp["p"] = $row["positive"];
        			$temp["n"] = $row["negative"];
        			$temp["nu"] = $row["neutral"];
        
        			array_push($data, $temp);
    		}
            
                 
		echo json_encode($data);
          };
                mysqli_close($conn);
?>
        
