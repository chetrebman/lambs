<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Course Attendance</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Lambs Attendance Tally Sheet</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	
    <br>
    <p><b>Course: <?php echo $courseCode?></p>
    <p><b>Student: <?php echo $student?></p>
    <p><b>Total Hours for course: <?php echo $totalHours?></p>
    <p><b>Main Instructor: <?php echo $instructor?></p>
    <br>
   <?php 
   $totalTime = 0;
   if( ! is_null($timeReport) )
   {	  
	   foreach ( $timeReport->result() as $row)
	   {
	   		if ( ! isset( $asPdf ) )
	   		{
	   			echo "<p><a href=\"".base_url()."index.php/daily_instructor_report?date=".$row->Date."&instructor=$row->Instructor_Id&course=".$courseCode."&section=".$row->Section_Number."\">".$row->Date."&nbsp;section&nbsp;".$row->Section_Number."</a>";
	   		}
	   		else {
				echo "<p>".$row->Date."&nbsp;section&nbsp;".$row->Section_Number;
			}
	   		
	   		echo "&nbsp;&nbsp;&nbsp;Present/Hours=".$row->Total_Time."&nbsp&nbsp;&nbsp;Class Number=".$row->Class_Number."&nbsp;&nbsp;&nbsp;Instructor=".$instructorMap[$row->Instructor_Id];
	   		$totalTime = $totalTime + $row->Total_Time;
	   }	   		
   }
   echo "<p><br>Total Time for $courseCode = ".($totalTime)." hours";
   ?>
	</div>

	<?php 
		if ( isset($studentId) ){
			echo "<a href=\"".base_url()."index.php/courseAttendance?studentId=$studentId&courseCode=$courseCode&asPdf=1"."\">"."<img src=\"".base_url()."images/pdf.png\" alt=\"\"></a>";
		}
	?>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
</body>
</html>