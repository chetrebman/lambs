<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Course Point Tally Sheet</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Lambs Point Tally Sheet</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	
    <br>
    <p><b>Course: <?php echo $courseCode?></p>
    <p><b>Student: <?php echo $student?></p>
    <p><b>Total Hours for course: <?php echo $totalHours?></p>
    <p><b>Main Instructor: <?php echo $instructor?></p>
    <br>
   <?php 

   //$totalEverything[] = array();
   if( ! is_null($homeworkReport) )
   {
	  
	   foreach ( $homeworkReport->result() as $row)
	   {
	   		if ( ! isset( $asPdf ) )
	   		{
	   			echo "<p><a href=\"".base_url()."index.php/daily_instructor_report?date=".$row->Date."&instructor=$row->Instructor_Id&course=".$courseCode."&section=".$row->Section_Number."\">".$row->Date."&nbsp;section&nbsp;".$row->Section_Number."</a>";	
	   		}
	   		else 
	   		{
	   			echo "<p><br>".$row->Date."&nbsp;section&nbsp;".$row->Section_Number;
	   		}
	   		
            echo "&nbsp;&nbsp;&nbsp;Type=".$row->Homework_Type."&nbsp&nbsp;&nbsp;Class Number=".$row->Homework_Number."&nbsp;&nbsp;&nbsp;Points=".$row->Points."&nbsp;&nbsp;&nbsp;Instructor=".$instructorMap[$row->Instructor_Id];	
 
            if  ( ! isset($totalEverything[ $row->Homework_Type ]) )
            {
            	$totalEverything[ $row->Homework_Type ] = $row->Points;
            }
            else {
            	$totalEverything[ $row->Homework_Type ] = $totalEverything[ $row->Homework_Type ] + $row->Points;
            } 
	   }
	   }	
	
	   echo "<p>";
	   
	   if ( isset( $totalEverything ) )
	   {
	 	  foreach( $totalEverything as $key => $value )
	 	  {
	  	 		echo "<br>Total $key = $value";
	  	 }
	   }
	   else 
	   {
	   		echo "No Points Yet";
	   }
	
   ?>
	</div>
	
	<?php echo "<a href=\"".base_url()."index.php/courseTally?studentId=$studentId&courseCode=$courseCode&asPdf=1"."\">"."<img src=\"".base_url()."images/pdf.png\" alt=\"\"></a>"?>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
</body>
</html>