<?php

/**
 * Contains functions unique to the nation web site.
 *
 * Author: Chet Rebman
 * July 2012
 */

define( 'EMPTY_SELECT_OPTION', '-----' );

define( 'TUITION_PER_HOUR', 20 );


/**
 * This doesn't appear to work (catch the duplicate record error).
 */
if ( ! function_exists('db_error_handler') )
{
	function db_error_handler( REST $rest, $pid, $dsId )
	{
		echo "Uncaught exception: " , $exception->getMessage(), "\n";
		throw new Exception( "db exception" );
	}
}

if ( ! function_exists('logged_in') )
{
	/**
	 * 
	 * @param unknown_type $caller pointer to the calling object so that we can get it's session object
	 * @param unknown_type $data username and password will be saved here
	 * @param unknown_type $roles if null the user just needs to be logged in
	 * @return boolean
	 */
	function logged_in( $caller, &$data, $roles )
	{
		if($caller->session->userdata('logged_in') )
		{
			$session_data = $caller->session->userdata('logged_in');
			
			if ( $roles == null || in_array( $session_data['role'], $roles, true ) )
			{
				$data['username'] = $session_data['username'];
				$data['role'] = $session_data['role'];
				return true;
			}
			else 
			{
				redirect('login', 'refresh');
				return false;
			}
			
		}
		else
		{
			redirect('login', 'refresh');
			return false;
		}
	}
}
