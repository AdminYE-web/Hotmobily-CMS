<?php
	session_start();
	require('../db_connect.php');
	 if(!isset($_SESSION['username'])){
        header("Location: //hotstrapthai.com/enroll/index.php");
        exit();
    }else{
    	$sql0 = "SELECT * FROM `user`,enroll WHERE `user`.`user_id` = enroll.user_id and enroll.user_id = ".$_GET['id'] ." group by enroll.user_id";
    	if ($result0 = $con->query($sql0)) {
			/* fetch associative array */
			while ($row0 = $result0->fetch_assoc()) {
				echo "<tr><td colspan='4'>".$row0['user_name']." Date:".$_GET['date_f']."-".$_GET['date_l']."</td></tr>";
			}
			/* free result set */
			$result0->free();
		}
    	$sql = "SELECT * FROM `enroll` where user_id = ".$_GET['id']." AND `date_time` BETWEEN CAST('".$_GET['date_f']."' as datetime) AND CAST('".$_GET['date_l']." 23:59:59:999' as datetime) and status not like 'delete%'";
		if ($result = $con->query($sql)) {
			/* fetch associative array */
			$i = 0;
			$cur_date = "";
			echo "<tr>";
			while ($row = $result->fetch_assoc()) {
				if($cur_date==""){
					$cur_date = $row['date_time'];
					$r = 0;
				}else{
					$r = date_compare($cur_date,$row['date_time']);
					$cur_date = $row['date_time'];
				}				
				if($i % 4 === 0 || $r == 1){
					$i = 0;
					echo "</tr><tr>";
					if(date_time($row['date_time'])){
						echo "<td width='24%'>".$row['date_time']."</td>";
					}else{
						
						echo "<td width='24%'><span style='color:red;'>".$row['date_time']."</span></td>";

					}
					
				}else{
					echo "<td width='24%'>".$row['date_time']."</td>";
				}
				$i++; 
			}
			echo "</tr>";
			/* free result set */
			$result->free();
		}else{
			echo "<tr>
					<td colspan='2'>none</td>
			      </tr>";
		}
		// echo $sql;
    }
    function date_compare($d1,$d2)
    {
    	$date_1 = new DateTime($d1);
    	$date_2 = new DateTime($d2);
    	if ($date_1->format('d') == $date_2->format('d')) {
    		return 0;
    	}else{
    		return 1;
    	}
    }
    function date_time($time)
    {
    	$d1 = new DateTime($time);
    	$time_start = $d1->format('H:i:s');

    	$d2 = new DateTime('08:30:00');
    	$time_check = $d2->format('H:i:s');
    	if($time_start>$time_check)
    	{
    		return false;
    	}else{
    		return true;
    	}
    }
?>