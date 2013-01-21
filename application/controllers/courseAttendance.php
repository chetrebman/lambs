<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class courseAttendance extends CI_Controller {

	
	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);
		
		$studentId = $params[ 'studentId' ];
		$courseCode    = $params[ 'courseCode'];
		
			// get info from student table.
		
		$where = null;
		$where[ 'id' ] = $studentId;
		$query = $this->db->get_where( 'student', $where );
		$tempArray = $query->row_array();
		$data[ 'student' ]= $tempArray[ 'First_Name' ]." ".$tempArray[ 'Last_Name' ] ;
		
		// get all instructor info
		$query = $this->db->get('instructor');
		foreach ($query->result() as $row)
		{		
			$instuctorMap[ $row->id ] = $row->First_Name.' '.$row->Last_Name;
		}
		$instuctorMap[ null ] = "Unknown";
		$instuctorMap[ 0 ] = "Unknown";
		
			// get info from course table
		
		$where = null;
		$where[ 'Course_Code' ] = $courseCode;
		$query = $this->db->get_where( 'course', $where );
		$tempArray = $query->row_array();
		$data[ 'instructor' ]= $instuctorMap[ $tempArray['Instructor_Id'] ];
		$data[ 'totalHours' ]= $tempArray[ 'Total_Hours' ];
		$data[ 'courseCode' ] = $courseCode;
		$data[ 'timeReport' ] = null;
		$data[ 'instructorMap' ] = $instuctorMap;
			// get data from timeReport
		
		$where[ 'Student_Id'] = $studentId;
		$where[ 'Course_Code']= $courseCode;
		$query = $this->db->get_where( 'timeReport', $where );
		$tempQuery = $query->row_array();
		if ( $query->num_rows() == 0 )
		{
			$this->load->view( 'courseAttendance_view', $data );
			return;
		}
		
		$data[ 'timeReport' ] = $query;
		$data[ 'studentId'  ] = $studentId;

		if ( isset( $params[ 'asPdf' ]) )
		{
			$data[ 'asPdf' ] = 1;
			$this->load->view( 'courseAttendance_view', $data );
				
			$html = $this->output->get_output();
		
			// Load library
			$this->load->library('dompdf_gen');
		
			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->render();
			$this->dompdf->stream("courseAttendance.pdf");
		}
		else {
			$this->load->view( 'courseAttendance_view', $data );
		}
		
	}
}
