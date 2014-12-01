<?php 
$this->load->helper('url');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lambs Student</title>
	
   <link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Lambs Edit Student</h1>
     <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p>Student information record.</p>
   

    <?php    
    
    	echo form_open( base_url().'index.php/student');
    	echo form_hidden('id', $student['id']);
    	echo "<table>";
    	$tempStudent = $student;
    	unset( $tempStudent['id']);
    	
    	foreach ( $tempStudent as $key => $value)
    	{
    		echo "<tr>";
    		$data = array(
              'name'        => $key,
              'id'          => $key,
              'value'       => $value,
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:100%',
            );
    	
    			// added 12-1-14
    		if( $key == 'Status' )
    		{
    			echo "<td>";
    			echo form_dropdown('status', $statusMap, $student['Status'], 'id="studentStatus"'  ).'&nbsp;';
    			echo "</td>";
    		}
    		else {
    			echo "<td>".$key."</td><td>".form_input($data)."</td>";
    		}
    		echo "</tr>";
    	} // foreach
    	echo "</table>";
    	echo "<p>";
    	echo form_submit('mysubmit', 'Save');
    	echo "<br>Only Administrators can remove a student.";
    	echo form_close();
    ?>
    
   <br>
   <a href="<?php echo base_url()?>index.php/payment_all?studentId=<?php echo$student['id']?>"> View Payments</a>
   
	</div>
		<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>