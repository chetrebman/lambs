<?php 
$this->load->helper('form');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to LAMBS</title>

<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Welcome to Lambs!</h1>
 	<?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p><strong>This is the main admin page for the Lambs Database.</strong></p>

		<p>Code by <em>Chet<em></em><br><br>
		<a href="<?php echo base_url()?>index.php/student_all">Students and Monthly Reports</a><br><br>
		<a href="<?php echo base_url()?>index.php/instructor_all">Instructors</a><br><br>
		<a href="<?php echo base_url()?>index.php/course_all">Courses</a><br><br>
		<a href="<?php echo base_url()?>index.php/dailyInstructorReport_all">Daily Instructor Reports</a><br><br>
		<?php 
      		if ( strcmp( $userdata['role'], 'admin' ) == 0)
			{
				echo "<a href=\"".base_url()."index.php/user_admin\">User Administration</a><br><br>";
			}
		    $attributes = array( 'target' => 'monthlyReport' );
			echo form_open( base_url().'index.php/daily_instructor_report', $attributes );
      		echo '<br><br><input type="text" name="date" id="date" value="yyyy-mm-dd" maxlength="10" size="10"  />&nbsp;'; 
      		echo form_submit('mysubmit', 'New Daily Instructor Report'); echo form_close();
      		
      	?>
	</div>

	 <?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>