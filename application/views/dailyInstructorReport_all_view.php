<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>All Daily Instructor Reports</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>All Daily Instructor Reports</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	<table>
	<tr><td><b>Daily I.R.</b></td><td><b>Date</b></td><td><b>Section #&nbsp;&nbsp;&nbsp;</b></td><td><b>Instructor</b></tr>
	
    <?php 
    if ( isset($trDates) )
    {
  	  foreach ($trDates as $date)
  	  {
  	  	if ( isset($timeReport) && isset($timeReport[ $date ]) ){
    	foreach ( $timeReport[ $date ] as $row) 
			{ 
				foreach ( $row as $oneTimeReport ) {
					// attendance/time report
	       			$instuctorName = $instructors[ $oneTimeReport->Instructor_Id ];
	       			echo "<tr>";
	       			echo "<td>&nbsp;</td>";
	      			echo "<td>";
	    		    echo '<a target="monthlyReport" href="'.base_url()."index.php/daily_instructor_report?date=$date&instructor=$oneTimeReport->Instructor_Id&section=$oneTimeReport->Section_Number\">";
	    		    echo "$date</a>";
	    		    echo "</td><td align='center'>".$oneTimeReport->Section_Number."</td><td align='left'>".$instuctorName;
	       			echo "</tr>";  
				}
	  	  	} 
			echo "<tr><td>**************</td><td colspan='2'>&nbsp;</td></tr>";
    	}}

    	if ( isset($homeworkReport) && isset($homeworkReport[ $date ]) ){
    	echo "<tr><td><b>&nbsp;</b></td><td><b>&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;</b></tr>";
    	echo "<tr><td><b>Homework</b></td><td><b>&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;</b></tr>";
    	foreach ( $homeworkReport[ $date ] as $row)
    	{
    		foreach ( $row as $oneHomeworkReport ) {
    			// attendance/time report
    			$instuctorName = $instructors[ $oneHomeworkReport->Instructor_Id ];
    			echo "<tr>";
    			echo "<td>".$students[$oneHomeworkReport->Student_Id]."</td>";
    			echo "<td>";
    			echo '<a target="monthlyReport" href="'.base_url()."index.php/daily_instructor_report?date=$date&instructor=$oneHomeworkReport->Instructor_Id&section=$oneHomeworkReport->Section_Number\">";
    			echo "$date</a>";
    			echo "</td><td align='center'>".$oneHomeworkReport->Section_Number."</td><td align='left'>".$instuctorName;
    			echo "</tr>";
    		}
    		echo "<tr><td>**************</td><td colspan='2'>&nbsp;</td></tr>";
    	}}
    	
    }
    else 
    {
    	echo "<h2>No Reports!</h2>";
    }?>
	</table>
	</div>

	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
</body>
</html>