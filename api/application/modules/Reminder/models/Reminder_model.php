<?php

class Reminder_model extends CI_Model
{
	
	function getlist_InstructorBeforeDays()
	{
	try
	 {
		$this->db->select('Value');
		$this->db->where('Key','InstructorBeforeDays');
		$result = $this->db->get('tblmstconfiguration');

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		// if($result->result())
		// {
		// 	$res=$result->result();
		// }
		foreach($result->result() as $row) {
			$res = $row;
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	public function getlist_Instructor($datetime1 = NULL)
	{	      
		$this->db->select('user.UserId,user.FirstName,co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,ca.StartTime,ca.EndTime');
		//$this->db->where('DATE(StartDate) =',$datetime1);
		$this->db->where('DATE(ca.StartDate)',$datetime1);
		$this->db->join(' tblcourse co', 'co.CourseId = ca.CourseId', 'left');
		$this->db->join(' tblcourseinstructor ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
		$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
		$result = $this->db->get('tblcoursesession ca');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	function getlist_CourseStartDate()
	{
	try
	 {
		$this->db->select('Value');
		$this->db->where('Key','CourseStartDateReminder');
		$result = $this->db->get('tblmstconfiguration');

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		// if($result->result())
		// {
		// 	$res=$result->result();
		// }
		foreach($result->result() as $row) {
			$res = $row;
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	public function getlist_emailvalue($datetime1 = NULL)
	{	      
		$this->db->select('user.UserId,user.FirstName,co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,ca.StartTime,ca.EndTime');
		//$this->db->where('DATE(StartDate) =',$datetime1);
		$this->db->where('DATE(ca.StartDate)',$datetime1);
		$this->db->join(' tblcourse co', 'co.CourseId = ca.CourseId', 'left');
		$this->db->join(' tblcourseuserregister ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
		$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
		$result = $this->db->get('tblcoursesession ca');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
}