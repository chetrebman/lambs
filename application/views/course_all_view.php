<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>All Courses</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Lambs course List</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	<table>
    <?php foreach ($course->result() as $row)
    {
        echo '<tr><td><a href="'.base_url().'index.php/course?courseId='.$row->id.'"> '.$row->Course_Code.'</a></td><td>'.$row->Name.'<td></td></tr>';
    }?>

    <?php
    	echo "<br><br>";
    	
    ?>
    </table>
    <br>
    <br>
     <?php echo '<a href="'.base_url().'index.php/course?courseId=-1"> Add Course </a><br/>';?>
	</div>

	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>
 
</body>
</html>