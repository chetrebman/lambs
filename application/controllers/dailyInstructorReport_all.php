<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dailyInstructorReport_all extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		// get all daily time reports
		$query = $this->db->get('timereport');		
		//$data[ 'timeReport' ] = $query;
		
		// create list of indivitual dates
		// store time reports for each date
		foreach ($query->result() as $row)
		{
			$trDates[ $row->Date ]    = $row->Date;
			
			$where[ 'date' ] =  $row->Date;
			$query = $this->db->get_where( 'timereport', $where );
			$timeReport[ $row->Date ][ $row->Section_Number ][ $row->Instructor_Id ] =  $row;
		}

		// get all daily homework reports
		$query_2 = $this->db->get('homeworkreport');		
		//$data[ 'homeworkReport' ] = $query_2;
		
		// append list of individual dates
		// store homework reports for each date
		foreach ($query_2->result() as $row)
		{
			// overwrite or append any homework without a corresponding time report
			$trDates[ $row->Date ]    = $row->Date;
				
			$where[ 'date' ] =  $row->Date;
			$query_2 = $this->db->get_where( 'homeworkreport', $where );
			$homeworkReport[ $row->Date ][ $row->Section_Number ][ $row->Instructor_Id ] =  $row;
		}
		
		
		// get instructor_id to instuctor name map
		$query = $this->db->get('instructor');
		foreach( $query->result() as $row )
		{
			$instructors[ $row->id ] = $row->First_Name;		
		}
		
		// get student_id to studen name map
		// get all students
		$query = $this->db->get('student');
		foreach ( $query->result() as $student )
		{
			$students[ $student->id ] = $student->First_Name." ".$student->Last_Name;
		}
		$data[ 'students' ] = $students;
		
		
		if ( isset($trDates) ){
			$data[ 'trDates' ]    = $trDates;
		}
		if ( isset($timeReport) ){
			$data[ 'timeReport' ] = $timeReport;
		}
		if ( isset($homeworkReport)){
			$data[ 'homeworkReport' ] = $homeworkReport;
		}
			
		$data[ 'instructors' ] = $instructors;
		
		$this->load->view( 'dailyInstructorReport_all_view', $data );
	}
}
