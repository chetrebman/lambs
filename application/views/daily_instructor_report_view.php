<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<meta charset="utf-8">
	<title>Daily Instructor Report</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">




	</head>
<body>

<script type="text/javascript">


function setup_change(){
	// If #instructor or #section dropdown is changed, then call submitForm()
	$('#instructor').change(instructor_change);
	$('#section').change(section_change);
}

function instructor_change(){
	$('#section').val('1');
	submitForm();
}
function section_change(){
	submitForm();
}

function submitForm()
{
  $('#reportForm').submit();
}

$(document).ready(setup_change);


</script>

<div id="container">
	<h1>Daily Instructor Report</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<?php echo "<strong>For date = $date </strong>"?>
		<?php 
		$attributes = array( 'class' => 'email', 'id' => 'reportForm');
		
		echo form_open( base_url().'index.php/daily_instructor_report', $attributes );	
      	echo form_dropdown('instructor', $instructors, $instructor, 'id="instructor"' ).'&nbsp;';
		$sections = array('1'  => 'section one','2'  => 'section two', '3'  => 'section three', '4'  => 'section four', '5'  => 'section five' );
      	echo form_dropdown('section', $sections, $section, 'id="section"'  ).'&nbsp;';
      	?>
	
		
		<table border="1" >
			<tr ><th >Student<br>(homework)</th><th>Time in</th><th>Time out</th><th>Total time In Hours <br><em>in 30 minute increments</em></th><th colspan="2">Content<br>course / class #</th></tr>
		 	<?php foreach ($students->result() as $row)
    		{
    			if ( isset( $existingTime[ $row->id ]) ) 
    			{
    				$existingTimeIn    = $existingTime[  $row->id ][ 'Time_In' ];
					$existingTimeOut   = $existingTime[  $row->id ][ 'Time_Out' ];
					$existingTotalTime = $existingTime[  $row->id ][ 'Total_Time' ];
    				$existingCourse         = $existingTime[  $row->id ][ 'Course_Code' ];
    				$existingClassNumber = $existingTime[  $row->id ][ 'Class_Number' ];
    			}
    			else {
    				$existingTimeIn      = "";
    				$existingTimeOut     = "";
    				$existingTotalTime   = "";
    				$existingCourse      = null;
    				$existingClassNumber = "";
    			}
    			
    			$studentIdMark = '_'.$row->id;
    			echo '<tr><td>&nbsp;';
         		
    		
    			if ( strpos( $instructor, EMPTY_SELECT_OPTION) ===false && ! is_null( $instructor ) )
    			{
    				echo '<a target="homework" href="'.base_url()."index.php/homework?studentId=$row->id&date=$date&instructorId=$instructor&section=$section\">$row->First_Name $row->Last_Name</a> &nbsp;</td>";
    			}
        		         		
         		echo '<td><input type="text" name="timeIn'.$studentIdMark.'" id="timeIn'.$studentIdMark.'" value="'.$existingTimeIn.'" maxlength="10" size="10" style="width:100%" /></td>';
         		echo '<td><input type="text" name="timeOut'.$studentIdMark.'" id="timeOut'.$studentIdMark.'" value="'.$existingTimeOut.'" maxlength="10" size="10" style="width:100%" /></td>';
         		echo '<td><input type="text" name="totalTime'.$studentIdMark.'" id="totalTime'.$studentIdMark.'" value="'.$existingTotalTime.'" maxlength="10" size="10" style="width:100%" /></td>';
         	echo '<td>'.form_dropdown('courseAllowEmpty'.$studentIdMark,    $courses, $existingCourse ).'</td>'; 
         	echo '<td><input type="text" name="classNumber'.$studentIdMark.'" id="classNumber'.$studentIdMark.'" value="'.$existingClassNumber.'" maxlength="10" size="10" style="width:100%" /></td>';
         		  
         		
         		echo '</tr>';
    		}?>
		</table>
      	<?php  
      		echo "<input type=\"hidden\" name=\"date\" id=\"date\" value=\"$date\" />";
      		echo form_dropdown('course', $courses,  $course, 'id="course"'  ).'&nbsp;';
      		echo form_submit('mysubmit', 'Save'); 
      		echo form_close();
      		echo "<b>All fields are required.</b><br>";
      		echo "<b>Set classNumber=0 to delete</b>";
      	?>
	</div>
	
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
</body>
</html>