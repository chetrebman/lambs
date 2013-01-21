<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instructor extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array('write', 'admin') ) )
		{
			return;
		}
		
		$this->load->helper('url');
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') // this is a get from the instructor_all_view page.
		{
			$url = parse_url($_SERVER['REQUEST_URI']);
			parse_str($url['query'], $params);
			$instructorId = $params[ 'instructorId' ];
			if ( $instructorId == -1 ){
				$newinstructor['id'] = $instructorId;
				$newinstructor['First_Name'] = "";
				$newinstructor['Last_Name'] = "";
				$newinstructor['Start_Date'] = "";
				$newinstructor['End_Date'] = "";
				$newinstructor['address'] = "";
				$newinstructor['City'] = "";
				$newinstructor['Zip'] = "";
				$newinstructor['Cell'] = "";
				$data[ 'instructor' ] = $newinstructor;
			}
			else {
				$query = $this->db->query("SELECT id, First_Name, Last_Name, Start_Date, End_Date, address, City, Zip, Cell FROM instructor WHERE id= $instructorId");
				$data[ 'instructor' ] = $query->row_array();
			}
			
						
			$this->load->view('instructor_view', $data );
		}
		else { // this is a form submit from the instructor_view page.
			foreach($_POST as $key=>$value){
				if ( $key != 'id' && $key != 'mysubmit' ){
					$data[ $key ] = $value;
				}
			}
			
			if ( $_POST['id'] == '-1') {
				if ( strlen( $data['First_Name'] ) > 0 || strlen( $data['Last_Name'] ) > 0 ) {
					$this->db->insert( 'instructor', $data );
				}
			}
			else { // allow the admin to remove a student, if first and last name are blank
				if ( strcmp($userdata['role'], 'admin') == 0 && strlen( $data['First_Name'] ) == 0 && strlen( $data['Last_Name'] )== 0)
				{
					$this->db->delete( 'instructor',"id = ".$_POST['id'] );
				}
				else { // perform update if there is data in the first name field
					if ( strlen( $data['First_Name'] ) > 0  ) 
					{
						$this->db->update('instructor', $data, "id = ".$_POST['id']);
					}
				}
			}
			
			
			$query = $this->db->get('instructor');
			
			$data[ 'instructor' ] = $query;
			$this->load->view('instructor_all_view', $data );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */