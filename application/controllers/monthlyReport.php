<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class monthlyReport extends CI_Controller {


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
		$data[ 'studentId' ] = $studentId;
		
		// get info from student table.
		
		$where = null;
		$where[ 'id' ] = $studentId;
		$query = $this->db->get_where( 'student', $where );
		$tempArray = $query->row_array();
		$data[ 'student' ]= $tempArray[ 'First_Name' ]." ".$tempArray[ 'Last_Name' ] ;
		$data[ 'email' ] = $tempArray[ 'Email' ];
		$data[ 'tuitionPerHour' ] = $tempArray[ 'Tuition_Per_Hour' ];
		$data[ 'totalProgramHours' ] = $tempArray[ 'Total_Program_Hours' ];
		
		// get info from course table
		
		$where = null;
		$query = $this->db->get_where( 'course', $where );
		foreach( $query->result() as $row )
		{
			$allCourseHours[ $row->Course_Code ] = $row->Total_Hours;
			$allCoursePoints[ $row->Course_Code ] = $row->Total_Points ;
		}
		$data[ 'hoursNeededForClass' ]  = $allCourseHours;
		$data[ 'pointsNeededForClass' ] = $allCoursePoints;
		
		// get total points  completed for  each class from homeworkReport table
		
		foreach( $allCourseHours as $courseCode => $total_hours )
		{
			$where = null;
			$where[ 'Course_Code' ] = $courseCode;
			$where[ 'Student_Id' ] = $studentId;
			$query = $this->db->get_where( 'homeworkReport', $where );
			$coursePoints = $query->result();
			$pointsTowardCompletion[ $courseCode ] = 0;
			foreach( $coursePoints as $row )
			{
				$pointsTowardCompletion[ $courseCode ] +=  $row->Points;	
			}
		}
		$data[ 'pointsTowardCompletion' ] = $pointsTowardCompletion;
		
		// get total hours  completed for  each class from timeReport table.
		
		$totalHoursCompleted = 0;
		foreach( $allCourseHours as $courseCode => $total_hours  )
		{
			$where = null;
			$where[ 'Course_Code' ] = $courseCode;
			$where[ 'Student_Id' ] = $studentId;
			$query = $this->db->get_where( 'timeReport', $where );
			$coursePoints = $query->result();
			$hoursTowardCompletion[ $courseCode ] = 0;
			foreach( $coursePoints as $row )
			{
				$hoursTowardCompletion[ $courseCode ] +=  $row->Total_Time;	
				$totalHoursCompleted += $row->Total_Time;	
			}
		}
		$data[ 'totalHoursCompleted' ] = $totalHoursCompleted;
		$data[ 'hoursTowardCompletion' ] = $hoursTowardCompletion;

		
		
		
		// get total payment from payment table.
		
		foreach( $allCourseHours as $courseCode => $total_hours  )
		{
			$where = null;
			$where[ 'Student_Id' ] = $studentId;
			$query = $this->db->get_where( 'payment', $where );
			$totalPayment = 0;
			$allPayments = $query->result();
			foreach( $allPayments as $row )
			{
				$totalPayment +=  $row->Amount;
			}
		}
		$data[ 'totalPayment' ] = $totalPayment;
	
		
		

		if ( isset( $params[ 'asPdf' ]) )
		{
			$data[ 'asPdf' ] = 1;
			$this->load->view( 'monthlyReport_view', $data );
			
			$html = $this->output->get_output();

			// Load library
			$this->load->library('dompdf_gen');

			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->render();
			$this->dompdf->stream("monthly.pdf");
		}
		else {
			$this->load->view( 'monthlyReport_view', $data );
		}
	}
}
