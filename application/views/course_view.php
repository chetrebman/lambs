<?php 
$this->load->helper('url');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lambs course</title>
	
   <link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Lambs Edit course</h1>
     <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p>course information record.</p>
   

    <?php    
    	echo form_open( base_url().'index.php/course');
    	echo form_hidden('id', $course['id']);
    	echo "<table>";
    	$tempcourse = $course;
    	unset( $tempcourse['id']);
    	
    	foreach ( $tempcourse as $key => $value)
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
    		
    	if ( $key == 'Instructor_Id' )
    	{
    		echo "<td>Instructor<td>".form_dropdown('Instructor_Id', $instructors, $instructor, 'id="instructor"' )."</td>";
    	}
    	else
    	{
    		echo "<td>".$key."</td><td>".form_input($data)."</td>";
    	}
    	
    		echo "</tr>";
    	} // foreach
    	echo "</table><p>";
    	echo form_submit('mysubmit', 'Save');
    	echo "<br>Only Administrators can remove a class type.";
    	echo form_close();
    ?>
 
	</div>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
</body>
</html>