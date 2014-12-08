<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {


	public function index()
	{	
			// 12-1-14  get all student status codes	
		$query = $this->db->get('status');
		foreach ($query->result() as $row)
		{
			$statusMap[ $row->id ] = $row->studentStatus;
		}
    			
		$userdata = null;
		if( ! logged_in( $this, $userdata, array('write', 'admin') ) )
		{
			return;
		}
		
		$this->load->helper('url');
		$this->load->helper('lambs');
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			$url = parse_url($_SERVER['REQUEST_URI']);
			parse_str($url['query'], $params);
			$studentId = $params[ 'studentId' ];
			if ( $studentId == -1 ){
				$newStudent['id'] = $studentId;
				$newStudent['First_Name'] = "";
				$newStudent['Last_Name'] = "";
				$newStudent['Email'] = "";
				$newStudent['Start_Date'] = "";
				$newStudent['Completion_Date'] = "";
				$newStudent['Address'] = "";
				$newStudent['City'] = "";
				$newStudent['Zip'] = "";
				$newStudent['Cell'] = "";
				$newStudent['Tuition_Per_Hour'] = TUITION_PER_HOUR;
					//12-1-14
				$newStudent['Status'] = "1"; // 1 is actuve see table Status
				
				$data[ 'student' ] = $newStudent;
			}
			else {
				$where[ 'id' ] = $studentId;
				$query = $this->db->get_where( 'student', $where );
				
					// 12-1-14
				$data[ 'student' ] = $query->row_array(); 
				$data[ 'statusMap' ] = $statusMap;
			}
			
						
			$this->load->view('student_view', $data );
		}
		else { 
			foreach($_POST as $key=>$value){
				if ( $key != 'id' && $key != 'mysubmit' ){
					$data[ $key ] = $value;
				}
			}
			
			if ( $_POST['id'] == '-1') {
				if ( strlen( $data['First_Name'] ) > 0 || strlen( $data['Last_Name'] ) > 0 ) {
					$this->db->insert( 'student', $data );
				}
			}
			else { // allow the admin to remove a student, if first and last name are blank
				if ( strcmp($userdata['role'], 'admin') == 0 && strlen( $data['First_Name'] ) == 0 && strlen( $data['Last_Name'] )== 0)
				{
					$this->db->delete( 'student',"id = ".$_POST['id'] );
				}
				else { // perform update if there is data in the first name field
					if ( strlen( $data['First_Name'] ) > 0 )  {
						$this->db->update('student', $data, "id = ".$_POST['id']);
					}
				}
			}
					
			$query = $this->db->get('student');	
			$data[ 'students' ] = $query;
			$data[ 'statusMap' ] = $statusMap; 
			$data[ 'statusSelect' ] = '1';
			
			// get all course codes ie AM, BP, AP etc
			$query = $this->db->get('course');
			foreach ($query->result() as $row)
			{
				$courseCodes[] = $row->Course_Code;
			}
			$data[ 'courseCodes' ] = $courseCodes;
			
			$this->load->view('student_all_view', $data );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */