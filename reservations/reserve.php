

<html>
<body>
	<head>


	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	</head>

	<?php include('../includes/h.php') ?>
		  
	<div class="container">
	  <h1>Auditorium details!</h1>
	  <div class="row">

		<?php include('../includes/connection.php') ?>
	<?php 
	$events = 'SELECT * FROM tempevents WHERE status="confirmed" ' ;//ORDER BY date' ; //Selecting all data from events table 
	$query = mysqli_query($connection, $events); //Passing SQL
	//$row = mysqli_fetch_assoc($query);

	while ($row = mysqli_fetch_assoc($query)){
		//print_r($row['date']);
		$edats[] = $row['date'];
		$ename[] = $row['name'];
		$eref[] = $row['refNo'];
		 //print_r($edats);
		 
	}
	print_r($ename);
	print_r($edats);
	$l = count($edats);
	echo $l;
	//echo $edats;
	// foreach($edats as $Eventdate){
	//     $Eventdate = $row['date'];
	//        echo $Eventdate;
	// }


	?>

	<?php
	$yes = 0;
	// Set your timezone
	date_default_timezone_set('Asia/Colombo');
	// Get prev & next month
	if (isset($_GET['ym'])) {
		$ym = $_GET['ym'];
	} else {
		// This month
		$ym = date('Y-m');
	}
	// Check format
	$timestamp = strtotime($ym . '-01');
	if ($timestamp === false) {
		$ym = date('Y-m');
		$timestamp = strtotime($ym . '-01');
	}
	// Today
	$today = date('Y-m-j', time());
	// For H3 title
	$html_title = date('Y / m', $timestamp);
	// Create prev & next month link     mktime(hour,minute,second,month,day,year)
	$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
	$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
	// You can also use strtotime!
	// $prev = date('Y-m', strtotime('-1 month', $timestamp));
	// $next = date('Y-m', strtotime('+1 month', $timestamp));
	// Number of days in the month
	$day_count = date('t', $timestamp);
	 
	// 0:Sun 1:Mon 2:Tue ...
	$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
	//$str = date('w', $timestamp);
	// Create Calendar!!
	$weeks = array();
	$week = '';
	// Add empty cell
	$week .= str_repeat('<td></td>', $str);
	$i=0;
	for ( $day = 1; $day <= $day_count; $day++, $str++) {
		$yes = false; 
		$date = $ym . '-' . $day;
		 
		
		for ($i=0; $i<$l; $i ++ ){
			if($date == $edats[$i] ){
				// echo $edats[$i] . '  ';
				// echo $today. '<br>';
				$week .= '<td class="Eventday"><a href="../event/index.php?ref='.$eref[$i].'">' . $day .'<br><font color:black>'.$ename[$i]. '</font></a>';
				//$day = $day +1;
				//$str = $str +1;
				//unset($edats['$i']);
				$yes = true;
		
				break;
			}
		}
		
		

		if ($today == $date && !$yes) {
			$week .= '<td class="today otherday">' . $day;
		} 
		elseif(!$yes) {
			$week .= '<td>' . $day;
		}
		//$week .= '<td>' . $day;
		$week .= '</td>';
		 
		// End of the week OR End of the month
		if ($str % 7 == 6 || $day == $day_count) {
			if ($day == $day_count) {
				// Add empty cell
				$week .= str_repeat('<td></td>', 6 - ($str % 7));
			}
			$weeks[] = '<tr>' . $week . '</tr>';
			// Prepare for new week
			$week = '';
		}
	}
	
	
	
	// $l = count($edats);
	// for ($i=0; $i<$l; $i ++ ){
	//     if($today != $edats[$i]){
	//         echo $edats[$i] . '  ';
	//         echo $today. '<br>';
	//     }

	// }
	print_r($edats);
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
    <meta charset="utf-8">
    <title>PHP Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <style>
        .container {
            font-family: 'Noto Sans', sans-serif;
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 10px 
            text-align: center;
			font-size:12px;
        }
        td {
            height: 50px !important;
            width :50px !important;
            font-size:10px;
        }
        .today {
            background: orange;
        }

        .Eventday {
            background:#551262 ;
            
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
        a:visited {
            color: #D7E7EC  ;
        }

        a:link{
            color:#D7E7EC  ; 
        }
        a:hover{
            color:black;
            text-decoration: none !important;

        }


        }
        
    </style>
</head>
<body>


    <div class="container">
	<div class="col-lg-7">
	</div>
	
	<div class="col-lg-5">
	
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>S</th>
                <th>M</th>
                <th>T</th>
                <th>W</th>
                <th>T</th>
                <th>F</th>
                <th>S</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
		
		</div>
    </div>
</body>

</html>



