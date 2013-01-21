<?php 
$this->load->helper('form');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>User Administration</title>

<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">

</head>
<body>

<div id="container">
	<h1>Welcome to Lambs!</h1>
 	<?php $this->load->view('includes/header', "howdy" );	?>
	<div id="body">
		<h2>User Administration</h2>

		<?php 
			echo form_open( base_url().'index.php/user_admin');
			
			echo "<table><tr><td>UserName</td><td align=\"center\">Role</td><td align=\"center\">Delete user</td></tr>";
			$count = 1;
			foreach ($all_users->result() as $row) 
			{
				
				echo "<tr>";
				echo "<td>".$row->username."</td>";
				echo "<td>".form_dropdown( "role_$count", $all_roles, $row->role )."</td>";
				echo "<td>".form_checkbox( "deleteUser_$count", $row->username, FALSE );
				echo "</tr>";
				echo form_hidden('username_'.$count++, $row->username);
			}
			echo "</table>";
			
			echo form_submit('update_user_submit', 'Submit'); echo form_close();
		?>
		
		<?php 
		if ( isset( $error_msg ) ) {
			echo "<p><br><br><FONT color=\"red\">ERROR $error_msg</FONT></p>";
		}
		else {
			echo "<p><br><br></p>";
		}

		echo form_open( base_url().'index.php/user_admin');
		echo '<br><br><b>New user &nbsp;&nbsp;</b><input type="text" name="newUser" id="newUser" value="" maxlength="20" size="20"  />&nbsp;';
		echo '<b>New Password </b><input type="password" name="newPwd_1" id="newPwd_1" value="" maxlength="20" size="20"  />&nbsp;';
		echo '<b>New Again &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="password" name="newPwd_2" id="newPwd_2" value="" maxlength="20" size="20"  />&nbsp;';
		echo form_dropdown( 'newRole', $all_roles, 'read' );
		echo form_submit('add_user_submit', 'Submit'); echo form_close();
      		
      	?>
	</div>

	 <?php $this->load->view('includes/footer', "byebye" );	?>
</div>

</body>
</html>