<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array('write', 'admin') ) )
		{
			return;
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') // this is a get from the course_all_view page.
		{
			$url = parse_url($_SERVER['REQUEST_URI']);
			parse_str($url['query'], $params);
			$courseId = $params[ 'courseId' ];
			
			// get all instructor info
			$query = $this->db->get('instructor');
			$instructors[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION;
			foreach ($query->result() as $row)
			{
				$instructors [$row->id ] = $row->First_Name.' '.$row->Last_Name;
				//$instuctorMap[ $row->First_Name.' '.$row->Last_Name ] = $row->id;
				$instuctorMap[ $row->id ] = $row->First_Name.' '.$row->Last_Name;
			}
			$instuctorMap[ null ] = "Unknown";
			
			if ( $courseId == -1 ){  // this is to an add a new course
				$newcourse['id'] = $courseId;
				
				$newcourse['Course_Code'] = "";
				$newcourse['Name'] = "";
				$newcourse['Instructor_Id'] = 0;
				$newcourse['Total_Hours'] = "";
				
				$newcourse['Homework'] = "";
				$newcourse['Quizzes'] = "";
				$newcourse['Tests'] = "";
				$newcourse['Extra_Credit'] = "";
				$newcourse['Classes'] = "";
				$newcourse['Written_Final'] = "";
				$newcourse['Practicum_Final'] = "";
				$newcourse['Projects'] = "";
				$newcourse['Total_Points'] = "1000";
				
				$data[ 'course' ] = $newcourse;
				
				$data[ 'instructors' ] = $instructors;
				$data[ 'instructorMap' ] = $instuctorMap;
				$data[ 'instructor'] = EMPTY_SELECT_OPTION;
			}
			else 
			{ 
				$where[ 'id' ] = $courseId;                                                                                        
				$query = $this->db->get_where( 'course', $where );
				$data[ 'course' ] = $query->row_array();
				
				$tempData = $query->row_array();
				$data[ 'instructors' ] = $instructors;
				$data[ 'instructorMap' ] = $instuctorMap;
				$data[ 'instructor'] = $tempData[ 'Instructor_Id' ];
			}
			
						
			$this->load->view('course_view', $data );
		}
		else { // this is a from submit from the course_view page.
			foreach($_POST as $key=>$value){
				if ( $key != 'id' && $key != 'mysubmit' ){
					$data[ $key ] = $value;
				}
			}
			
			if ( $_POST['id'] == '-1') {
				if ( strlen( $data['Course_Code'] ) > 0 ) {
					$this->db->insert( 'course', $data );
				}
			}
			else  { // allow the admin to remove a student, if course code and course name fields are blank
				if ( strcmp($userdata['role'], 'admin') == 0 && strlen( $data['Course_Code'] ) == 0 && strlen( $data['Name'] )== 0)
				{
					$this->db->delete( 'course',"id = ".$_POST['id'] );
				}
				else { // perform update if there is data in the Course_Code field
					if ( strlen( $data['Course_Code'] ) > 0  ) 
					{
						$this->db->update('course', $data, "id = ".$_POST['id']);
					}
				}
			}

			
			$query = $this->db->get('course');
			
			$data[ 'course' ] = $query;
			$this->load->view('course_all_view', $data );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */