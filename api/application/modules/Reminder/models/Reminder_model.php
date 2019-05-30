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
		$this->db->select('co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,ca.StartTime,ca.EndTime
		,(SELECT GROUP_CONCAT(ua.FirstName)
FROM tbluser ua 
WHERE FIND_IN_SET(ua.UserId, GROUP_CONCAT(ins.UserId))) as FirstName
,(SELECT GROUP_CONCAT(ua.UserId)
FROM tbluser ua 
WHERE FIND_IN_SET(ua.UserId, GROUP_CONCAT(ins.UserId))) as UserId');
		$this->db->where('DATE(ca.StartDate)',$datetime1);
		$this->db->join(' tblcourse co', 'co.CourseId = ca.CourseId', 'left');
		$this->db->join(' tblcourseinstructor ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
		$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
		$this->db->group_by('ca.CourseSessionId'); 
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
		$this->db->select('user.UserId,co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,ca.StartTime,ca.EndTime
		,(SELECT GROUP_CONCAT(ua.FirstName)
FROM tbluser ua 
WHERE FIND_IN_SET(ua.UserId, GROUP_CONCAT(cins.UserId))) as FirstName');
		//$this->db->where('DATE(StartDate) =',$datetime1);
		$this->db->where('DATE(ca.StartDate)',$datetime1);
		$this->db->join(' tblcourse co', 'co.CourseId = ca.CourseId', 'left');
		$this->db->join('tblcourseinstructor cins', 'cins.CourseSessionId = ca.CourseSessionId', 'left');
		$this->db->join(' tblcourseuserregister ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
		$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
		$this->db->group_by('user.UserId'); 
		$result = $this->db->get('tblcoursesession ca');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
	public function getlist_Followvalue($datetime1 = NULL)
	{	      
// 		$result =$this->db->query('select user.FirstName,co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,ca.StartTime,ca.EndTime,(SELECT GROUP_CONCAT(u.UserId)
// 		FROM tbluser u WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cins.UserId))) as UserId 
// FROM tblcoursesession AS ca
// LEFT JOIN tblcourse AS co ON co.CourseId = ca.CourseId
// LEFT JOIN tblcourseuserregister AS ins ON ins.CourseSessionId = ca.CourseSessionId
// LEFT JOIN tbluser AS user ON user.UserId = ins.UserId
// LEFT join tblcourseinstructor AS cins ON cins.CourseSessionId=ca.CourseSessionId
// WHERE DATE(ca.StartDate)='.$datetime1);
$this->db->select('user.UserId,co.CourseFullName,user.EmailAddress,ca.CourseSessionId,ca.StartDate,
(SELECT GROUP_CONCAT(u.UserId)
FROM tbluser u WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cins.UserId))) as UserId,
(SELECT GROUP_CONCAT(ua.FirstName)
FROM tbluser ua 
WHERE FIND_IN_SET(ua.UserId, GROUP_CONCAT(cins.UserId))) as FirstName,ca.StartTime,ca.EndTime');

//$this->db->where('DATE(StartDate) =',$datetime1);
$this->db->where('DATE(ca.StartDate)',$datetime1);
$this->db->join(' tblcourse co', 'co.CourseId = ca.CourseId', 'left');
$this->db->join(' tblcourseuserregister ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
$this->db->join('tblcourseinstructor cins', 'cins.CourseSessionId = ca.CourseSessionId', 'left');

$result = $this->db->get('tblcoursesession ca');
	//	$res=array();
	foreach($result->result() as $row) {
		$res = $row;
	}
	return $res;
	}
}