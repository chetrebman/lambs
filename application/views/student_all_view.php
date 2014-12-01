<?php 
$this->load->helper('form');
$this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	
	<title>All Lambs Students</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	</head>
<body>

<script>
	$(document).ready(setup_change);

	function setup_change(){
		$('#statusSelect').change(updateForm);
	}

	function updateForm(){	 
		$('#statusForm').submit();
	};
	
</script>

<div id="container">
	<h1>Lambs Student List</h1>
    <?php // 12-1-14
    	$this->load->view('includes/header', "howdy" );	
    ?>
	<div id="body">

	<?php 
		$attributes = array( 'id' => 'statusForm');
		echo form_open( base_url().'index.php/student_all', $attributes );
		echo form_dropdown('status', $statusMap, $statusSelect, 'id="statusSelect" '  ).'&nbsp;'; 
		echo form_close();
	?>
		
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