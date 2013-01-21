<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {


	public function index()
	{	
		$userdata = null;
		if( ! logged_in( $this, $userdata, array('write', 'admin') ) )
		{
			return;
		}
			
		$this->load->helper('url');
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') // this is a get from the course_all_view page.
		{	
			$url = parse_url($_SERVER['REQUEST_URI']);
			parse_str($url['query'], $params);
			$studentId = $params[ 'studentId' ];
			
			if ( isset($params[ 'id' ]) )
			{
				$id        = $params[ 'id' ];
			}
			
			// get student name for view page

			$query = $this->db->get('student');
			foreach ($query->result() as $row)
			{
				$tempId = $row->id;
				if ( $tempId == $studentId ){
					$data[ 'name' ] = $row->First_Name." ".$row->Last_Name;
					break;
				}
			}
		
		
			// create empty form
			if ( isset($params[ 'makePayment' ])){  
				$payment['Student_Id'] =  $studentId;
				$payment['Date'] = "";
				
				$payment['Amount'] = "";
				$payment['Type'] = "";
				
				$data[ 'payments' ] = $payment;
				
			}
			else {                           
				$where['id'] = $id;                                                                      
				$query = $this->db->get_where( 'payment', $where );
				$data[ 'payments' ] = $query->row_array();
				
				
				
			}
			
						
			$this->load->view('payment_view', $data );
		}
		else { // this is a from submit from the course_view page.
			foreach($_POST as $key=>$value){
				if ( $key != 'id' && $key != 'mysubmit' ){
					$data[ $key ] = $value;
				}
			}
			
			if ( $data['Amount'] == 0 )
			{
				$where[ 'id' ] = $_POST[ 'id' ];
				$result = $this->db->get_where(	'payment',  $where );	
				if ( $result->num_rows() > 0 )
				{
						$this->db->delete( 'payment',$where );
				}
			}
			else {
				if ( strlen( $data['Date'] ) > 0 && strlen( $data['Amount'] ) > 0 && strlen( $data['Type'] ) > 0 ) {
					$this->db->insert( 'payment', $data );
				}		
			}
			
			
		//	$query = $this->db->get('payment');
			
	//		$data[ 'payment' ] = $query;
	//		$this->load->view('payment_all_view', $data );
			redirect("payment_all?studentId=$data[Student_Id]");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */