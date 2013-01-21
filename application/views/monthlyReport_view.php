<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Monthly Report</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Monthly Progress Report</h1>
	
    <?php $this->load->view('includes/header', "howdy" );	
    
   	 date_default_timezone_set('UTC');
   	 
    ?>
	<div id="body">
	<p><strong><?php echo "$student $email"?> </strong></p>
    <p><strong><?php echo date(' jS \of F Y');?>, <font color="blue"><em>&nbsp;payment due in 30 days.</em></font></strong></p>
    
    <br>
   
   <table border="5px" cellpadding="5px" >
   <thead align="center">
   <tr bordercolor="#000000">
   <td>Course</td>
   <td>Points toward completion</td>
   <td>Points to complete</td>
   <td>Hours toward completion</td>
   <td>Hours to complete</td>
   <td>Advanced study hours</td>
   <td>Course completion date</td>
   </tr>
   </thead>
   <tbody>
  
<?php 
// THIS DID NOT WORK FOR TRANSFORMING INTO A PDF
//
//     	foreach( $hoursNeededForClass as $classCode => $hoursToComplete )
//     	{
//     		echo "<td>$classCode</td>";
    		
//     		if ( isset ($pointsTowardCompletion[ $classCode ]) )
//     		{
//     			echo "<td>".$pointsTowardCompletion[ $classCode ]."</td>";
//     		}
//     		else {
//     			echo "<td>&nbsp;</td>";
//     		}
    		
//     		echo "<td>$pointsNeededForClass[$classCode]</td>";// points to complete
    		
//     		if ( isset ($hoursTowardCompletion[ $classCode ]) )
//     		{
//     			echo "<td>".($hoursTowardCompletion[ $classCode ])."</td>";
//     		}
//     		else {
//     			echo "<td>&nbsp;</td>";
//     		}
//     		echo "<td>$hoursNeededForClass[$classCode]</td>";
//     		echo "<td>&nbsp;TBD</td>";//Advanced study hours
//     		echo "<td>&nbsp;TBD</td>";//Course completion date
//     		echo "</tr>";
//     	}
?>

	<?php foreach( $hoursNeededForClass as $classCode => $hoursToComplete )
    	{ ?>
   		<tr>
   		    <td><?php echo $classCode ?>
   		    
   			<?php if ( isset ($pointsTowardCompletion[ $classCode ]) )
    		{
    			echo "<td>".$pointsTowardCompletion[ $classCode ]."</td>";
    		}
    		else {
    			echo "<td>&nbsp;</td>";
    		} ?>
   		
   		    <td><?php echo $pointsNeededForClass[$classCode] ?>
   		    
   			<?php if ( isset ($hoursTowardCompletion[ $classCode ]) )
    		{
    			echo "<td>".($hoursTowardCompletion[ $classCode ])."</td>";
    		}
    		else {
    			echo "<td>&nbsp;</td>";
    		} ?>
    		
   			<td><?php echo $hoursNeededForClass[$classCode] ?> </td>
   			
   			<td> &nbsp; </td>
   			
   			<td> &nbsp; </td>
   		</tr>
	<?php } ?>
    
   
   </tbody>
   </table>
  
   <p> <br>Total Cost of Program: $<?php echo $totalProgramHours * $tuitionPerHour ?>
   <p> Total Payments To date: $<?php echo "$totalPayment"; ?>
   <p> Payment Due: $<?php echo $totalHoursCompleted * $tuitionPerHour - $totalPayment?>
   <p> Total Hours Completed: <?php  echo $totalHoursCompleted ?>
   <p> Tuition per Hour: $<?php echo "$tuitionPerHour" ?>
   <p> Total Cost of completed Hours to Date: $<?php echo $totalHoursCompleted * $tuitionPerHour?>
   <p> Total Program Hours: <?php echo $totalProgramHours?>
   <br><br>
   
   <?php if ( ! isset($asPdf) ){ ?>
   	<p>   <a href="<?php echo base_url()?>index.php/payment_all?studentId=<?php echo$studentId?>"> View Payments</a>
   <?php } ?>
 	
	</div>	
	<?php echo "<a href=\"".base_url()."index.php/monthlyReport?studentId=$studentId&asPdf=1"."\">"."<img src=\"".base_url()."images/pdf.png\" alt=\"\"></a>"?>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>