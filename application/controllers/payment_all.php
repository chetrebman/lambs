<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_all extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
			
		$this->load->helper('url');
		
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);
		$studentId = $params[ 'studentId' ];
		
			// get student name for view page
		$query = $this->db->get('student');
		foreach ($query->result() as $row)
		{
			$id = $row->id;
			if ( $id == $studentId ){
				$data[ 'name' ] = $row->First_Name." ".$row->Last_Name;
				break;
			}
		}
		
		
		$where[ 'Student_Id' ]   = $studentId;
		
		$this->db->order_by("Date", "ASC");
		$query = $this->db->get_where('payment',$where );
		
		$data[ 'studentId' ] = $studentId;
		$data[ 'payment' ]   = $query;
		
		$this->load->view( 'payment_all_view', $data );
	}
}
