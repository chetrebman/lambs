<?php 
$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('lambs');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Daily Homework Report</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Daily Homework Report</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<?php echo form_open( base_url().'index.php/homework');?>
		<?php echo "<strong>Homework for $date - Section $section - <em>$studentName</em>  &nbsp;&nbsp;Instructor:<em>&nbsp;$instructorName</em> </strong>"?>
		<table border="1" >
			<tr ><th colspan="3">Course Work</th><th >Points</th></tr>
		 	<?php for ( $i=0; $i<15; $i++ )
    		{
    			if ( count( $existingHomework ) > $i )
    			{
    				$existingPoints = $existingHomework[ $i ][ 'Points' ];
    				$existingHomeworkNumber = $existingHomework[ $i ][ 'Homework_Number' ];
    				$existingHomeworkType   = $existingHomework[ $i ][ 'Homework_Type' ];
    				$existingCourse         = $existingHomework[ $i ][ 'Course_Code' ];
    			}
    			else {
    				$existingCourse = EMPTY_SELECT_OPTION;
    				$existingHomeworkType   = EMPTY_SELECT_OPTION;
    				$existingHomeworkNumber = "";
    				$existingPoints = "";
    			}
    			
    			echo '<tr>';
         	
         	echo '<td>'.form_dropdown("course_$i", $course, $existingCourse ).'</td>'; 
         
         	echo '<td>'.form_dropdown("homeworkType_$i", $homeworkType, $existingHomeworkType ).'</td>'; 
         	echo "<td><input type=\"text\" name=\"homeworkNumber_$i\" id=\"homeworkNumber_$i\" value=\"$existingHomeworkNumber\" maxlength=\"10\" size=\"10\" style=\"width:100%\" /></td>";
         	echo "<td><input type=\"text\" name=\"points_$i\" id=\"points_$i\" value=\"$existingPoints\" maxlength=\"5\" size=\"5\" style=\"width:100%\" /></td>";
         
         	echo "<input type=\"hidden\" name=\"studentId\" id=\"studentId\" value=\"$studentId\" />";
         	echo "<input type=\"hidden\" name=\"date\" id=\"date\" value=\"$date\" />";
         	echo "<input type=\"hidden\" name=\"section\" id=\"section\" value=\"$section\" />";
         	echo "<input type=\"hidden\" name=\"instructorId\" id=\"date\" value=\"$instructorId\" />";
         	
         		echo '</tr>';
    		}?>
		</table>
		<br>
      	<?php 
      		 
      		echo form_submit('mysubmit', 'Save'); echo form_close();
      		echo "<b>Set points to 0 to delete an assignment.";
      	?>
	</div>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>