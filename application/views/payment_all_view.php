<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Student Payment</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1><?php echo $name?> Payments</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	<table>
    <?php foreach ($payment->result() as $row)
    {
         echo '<tr><td><a href="'.base_url().'index.php/payment?id='.$row->id.'&studentId='.$row->Student_Id.'"> '.$row->Date.'</a></td><td>'.$row->Amount.'<td></td><td>'.$row->Type.'</td></tr>';
    }?>
	</table>
    <?php
    	echo "<br><br>";
    	
    ?>
    </table>
	</div>
	<br>
	
	<a href="<?php echo base_url()?>index.php/payment?studentId=<?php echo $studentId?>&makePayment=1">Make payment</a>
	
	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>