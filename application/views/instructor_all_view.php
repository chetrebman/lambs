<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>All Lambs Instructors</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Lambs Instructor List</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	<table>
    <?php foreach ($instructor->result() as $row)
    {
         echo '<tr><td><a href="'.base_url().'index.php/instructor?instructorId='.$row->id.'"> '.$row->First_Name.'</a></td><td>'.$row->Last_Name.'<td></td><td>'.$row->Cell.'</td></tr>';
    }?>

    <?php
    	echo "<br><br>";
    	
    ?>
    </table>
    <br>
    <br>
    <?php echo '<a href="'.base_url().'index.php/instructor?instructorId=-1"> Add Instructor </a><br/>';?>
	</div>

	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>