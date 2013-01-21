<?php 
$this->load->helper('form');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Change LAMBS Password</title>

<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Welcome to Lambs!</h1>
 	<?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<p><strong>Change LAMBS Password for <?php echo $userdata['username']?></strong></p>

		
		
		<?php 
		if ( isset( $error_msg ) ) {
			echo "<p><FONT color=\"red\">ERROR $error_msg</FONT></p>";
		}

		echo form_open( base_url().'index.php/change_pwd');
		echo '<br><br><b>Old  Password &nbsp;&nbsp;</b><input type="password" name="oldPwd" id="oldPwd" value="" maxlength="20" size="20"  />&nbsp;';
		echo '<br><br><b>New Password </b><input type="password" name="newPwd_1" id="newPwd_1" value="" maxlength="20" size="20"  />&nbsp;';
		echo '<br><br><b>New Again &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="password" name="newPwd_2" id="newPwd_2" value="" maxlength="20" size="20"  />&nbsp;';
		echo form_hidden('username', $userdata['username']);
		echo form_submit('mysubmit', 'Submit'); echo form_close();
      		
      	?>
	</div>

	 <?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>