<?php 
$this->load->helper('url');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lambs payment</title>
	
   <link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1><?php  echo $name?> Payment</h1>
     <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p>Student payment record.</p>
   

    <?php    
    	echo form_open( base_url().'index.php/payment');
    	echo form_hidden('Student_Id', $payments['Student_Id']);
    	echo "<table>";
    	$tempPayment = $payments;
    	unset( $tempPayment['id']);
    	unset( $tempPayment['Student_Id']);
    	
    	foreach ( $tempPayment as $key => $value)
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
    	echo "</table>";
    	
    	if ( isset( $payments['id'] ) )
    	{
    		echo form_hidden('id', $payments['id']);
    	}
    	
    	echo form_submit('mysubmit', 'Save');
    	echo form_close();
    ?> 
   
  
    <br>
    <font color="red">Dates MUST BE of type yyyy-mm-dd</font> <br><br>
    Enter an amount of 0 to delete.
   
	</div>
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>