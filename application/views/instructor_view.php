<?php 
$this->load->helper('url');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lambs instructor</title>
	
   <link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Lambs Edit Instructor</h1>
     <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p>instructor information record.</p>
   

    <?php    
    	echo form_open( base_url().'index.php/instructor');
    	echo form_hidden('id', $instructor['id']);
    	echo "<table>";
    	$tempinstructor = $instructor;
    	unset( $tempinstructor['id']);
    	
    	foreach ( $tempinstructor as $key => $value)
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
    	
    	echo "<td>".$key."</td><td>".form_input($data)."</td>";
    		echo "</tr>";
    	} // foreach
    	echo "</table><p>";
   
    	echo form_submit('mysubmit', 'Save');
    	echo "<br>Only Administrators can remove an instructor.";
    	echo form_close();
    ?>
    
   
	</div>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>