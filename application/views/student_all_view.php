<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>All Lambs Students</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<div id="container">
	<h1>Lambs Student List</h1>
    <?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
	<table>
    <?php foreach ($students->result() as $row)
    {
         echo '<tr><td><a href="'.base_url().'index.php/student?studentId='.$row->id.'"> '.$row->First_Name.'</a></td><td>'.$row->Last_Name.'<td></td><td>'.$row->Cell.'</td>';
         foreach ($courseCodes as $code)
         {
         	echo '<td>&nbsp;';
         	echo '<a href="'.base_url().'index.php/courseAttendance?studentId='.$row->id.'&courseCode='.$code.'">'.$code.'</a>';
         	echo '&nbsp';
         	echo '<a href="'.base_url().'index.php/courseTally?studentId='.$row->id.'&courseCode='.$code.'">#</a>';
         	echo '&nbsp;</td>';
         }
         echo '<td>&nbsp;<a href="'.base_url().'index.php/monthlyReport?studentId='.$row->id.'"> Monthly Report</a> &nbsp;</td>';
         echo "<td>for $row->First_Name</td>";
         echo '<td>&nbsp;<a href="'.base_url()."index.php/monthlyReport?studentId=".$row->id."&asPdf=1"."\">"."<img src=\"".base_url()."images/pdf_sm.png\" alt=\"\"></a> &nbsp;</td>";
         echo '</tr>';
    }?>
	</table>
    <?php
    	echo "<br><br>";
    	
    ?>
    </table>
	</div>

	<?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>