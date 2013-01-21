<?php

   $this->load->helper('url');
   
   if ( ! isset( $asPdf ) )
   {
	   echo '<a href="'.base_url().'/index.php/welcome">Home</a>';
	   echo '&nbsp;|&nbsp;';
	
	   echo '<a href="'.base_url().'index.php/student_all">Students</a>';
	   echo '&nbsp;|&nbsp;';
	   echo '<a href="'.base_url().'index.php/student?studentId=-1"> Add Student </a><br/>';
	   echo '<br>';
   }
