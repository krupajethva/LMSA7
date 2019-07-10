<?php

class Attendance_model extends CI_Model
{
			
	
	public function getAttendanceUpdate($post_getupdate)
	{
		try {
	  if($post_getupdate)
	  {
	
	
		$this->db->select('csi.CreatedOn,csi.CourseUserregisterId,csi.Attendance,csi.Totalattendance');
		$this->db->where('csi.CourseUserregisterId',$post_getupdate['CourseUserregisterId']); 	
		$result = $this->db->get('tblcourseuserregister csi');
	

		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
	
			 foreach($result->result() as $row) 
			 {
				$Attendance = $row->Attendance;
				$ss=$row->Totalattendance;
				
					
			}
		
		 $j=$post_getupdate['j']+1;
		 $a=-1;
		 for($k=1;$k<=$j;$k++)
		 {
			 if($k>1)
			 {
				 $a++;
			 }
			 if($k==$j)
			 {
				 $b=$a+$j;
			 }
		 }        
		 $arr = array();
		$update=substr_replace($Attendance,$post_getupdate['Check'],$b,1);
		$attend = explode(",",$update);
		$count=0;
		foreach($attend as $row)
		{
					if($row==1)
					{
						$count++;
					}		
		}
		
		$attendance_data = array(
			'Attendance'=>$update,
		'Totalattendance'=>$count,
				'UpdatedBy' => $post_getupdate['UserId'],
				'UpdatedOn' => date('y-m-d H:i:s')
		);
		$this->db->where('CourseUserregisterId',$post_getupdate['CourseUserregisterId']);
		$res = $this->db->update('tblcourseuserregister',$attendance_data);
		if($res)
		{
			$data = explode(",", $update);
			return $data;

		}else
		{
			return false;
		}
		 
		 
	  }else
	  	{
			  return false;
	  	}
	  }
	  catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	
	public function get_Coursedata($Session_id=Null)
	{
		try {
	  if($Session_id)
	  {

		 $this->db->select('cs.CourseSessionId,cs.SessionName,cs.StartDate,cs.Location,cs.StartTime,cp.CourseFullName');
		// $this->db->order_by('cp.Name','asc');
		$this->db->join('tblcourse cp', 'cp.CourseId = cs.CourseId', 'left');
		 $this->db->where('cs.CourseSessionId',$Session_id);
		 $result=$this->db->get('tblcoursesession cs');
	
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Category_data= array();

		 foreach($result->result() as $row)
		 {
			$Category_data=$row;
			
		 }
		 return $Category_data;
		 
	  }else
	  	{
			  return false;
	  	}
	  }
	  catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	
	public function getlist_Country($User_Id = NULL) {
		try{
			$result = $this->db->query('select cp.CourseId,cp.CourseFullName
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        WHERE csi.UserId='.$User_Id.' AND  cs.PublishStatus!=0 AND cs.SessionStatus != 0 GROUP BY cp.CourseId ORDER BY cp.CourseFullName asc');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
		
	}
	public function getlist_State($User_Id = NULL) {
		try{
			$result = $this->db->query('select cs.CourseSessionId,cs.SessionName
			FROM tblcourseinstructor AS csi 
			LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
			WHERE csi.UserId='.$User_Id.' AND  cs.PublishStatus!=0 AND cs.SessionStatus != 0 GROUP BY cs.CourseSessionId ORDER BY cs.SessionName asc');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
		
	}
	public function getStateList($CourseId = NULL) {
		try{
		if($CourseId) {
			
			$result = $this->db->query('select cs.CourseSessionId,cs.SessionName
			FROM  tblcoursesession AS cs 
			WHERE cs.CourseId='.$CourseId.' AND  cs.PublishStatus!=0 AND cs.SessionStatus != 0 GROUP BY cs.CourseSessionId ORDER BY cs.SessionName asc');				
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
			
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	
	}
	
	public function getbyCourseId($Session_id=Null)
	{
		try {
	  if($Session_id)
	  {

		 $this->db->select('cp.CourseId,cs.CourseSessionId');
		// $this->db->order_by('cp.Name','asc');
		$this->db->join('tblcourse cp', 'cp.CourseId = cs.CourseId', 'left');
		 $this->db->where('cs.CourseSessionId',$Session_id);
		 $result=$this->db->get('tblcoursesession cs');
	
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Category_data= array();

		 foreach($result->result() as $row)
		 {
			$Category_data=$row;
			
		 }
		 return $Category_data;
		 
	  }else
	  	{
			  return false;
	  	}
	  }
	  catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	function getSearchAttendanceList($CourseSessionId = NULL)
	{
	try{
		$this->db->select('csi.CreatedOn,csi.CourseUserregisterId,csi.UserId,CONCAT(us.FirstName," ",us.LastName) as FirstName,us.EmailAddress,csi.Attendance,csi.Totalattendance');
		$this->db->join('tblcoursesession cs', 'cs.CourseSessionId = csi.CourseSessionId', 'left');
		$this->db->join('tbluser us', 'us.UserId = csi.UserId', 'left');
		$this->db->where('csi.CourseSessionId',$CourseSessionId); 	
		$this->db->where('cs.SessionStatus != 0'); 	
		$result = $this->db->get('tblcourseuserregister csi');
	

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				
				$res = array();
				// if($result->result())
				// {
				// 	$res=$result->result();
				// }
				
				foreach($result->result() as $row) {
					
					$ress = $row->Attendance;
					$data = explode(",", $ress);
					$row->Child = $data;
					array_push($res,$row);
				
				}
			
		return $res;

		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	
	function getAttendanceDateList($CourseSessionId = NULL)
	{
	try{
		$this->db->select('cs.CourseSessionId,cs.StartDate,cs.EndDate,cs.weekday');
		$this->db->where('cs.CourseSessionId',$CourseSessionId); 	
		$result1 = $this->db->get('tblcoursesession cs');
		$res=array();
		$result1 = json_decode(json_encode($result1->result()), TRUE);
		foreach($result1 as $row)
		{ 
		  $row['monday'] = substr($row['weekday'], 0, 1);
			$row['tuesday'] = substr($row['weekday'], 2, 1);
			$row['wednesday'] = substr($row['weekday'], 4, 1);
			$row['thursday'] = substr($row['weekday'], 6, 1);
			$row['friday'] = substr($row['weekday'], 8, 1);
			$row['saturday'] = substr($row['weekday'], 10, 1);
			$row['sunday'] = substr($row['weekday'], 12, 1);
		   if($row['monday']==1)
		   {
			$date = new DateTime($row['StartDate']);
			$date->modify('next monday');
			$begin = $date;
			$end = new DateTime($row['EndDate']);
			$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
			
			foreach($daterange as $date){
			$date1=$date->format("Y-m-d");
	        array_push($res,$date1);
			}
		  }
		  if($row['tuesday']==1)
		   {
			$date = new DateTime($row['StartDate']);
			$date->modify('next tuesday');
			$begin = $date;
			$end = new DateTime($row['EndDate']);
			$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
			
			foreach($daterange as $date){
			$date1=$date->format("Y-m-d");
	        array_push($res,$date1);
			}
		  }
		  if($row['wednesday']==1)
		   {
			$date = new DateTime($row['StartDate']);
			$date->modify('next wednesday');
			$begin = $date;
			$end = new DateTime($row['EndDate']);
			$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
			
			foreach($daterange as $date){
			$date1=$date->format("Y-m-d");
	        array_push($res,$date1);
			}
		  }
		  if($row['thursday']==1)
		   {
			$date = new DateTime($row['StartDate']);
			$date->modify('next thursday');
			$begin = $date;
			$end = new DateTime($row['EndDate']);
			$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
			
			foreach($daterange as $date){
			$date1=$date->format("Y-m-d");
	        array_push($res,$date1);
			}
		  }
		  if($row['friday']==1)
		   {
			$date = new DateTime($row['StartDate']);
			$date->modify('next friday');
			$begin = $date;
			$end = new DateTime($row['EndDate']);
			$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
			
			foreach($daterange as $date){
			$date1=$date->format("Y-m-d");
	        array_push($res,$date1);
			}
		  }
		  if($row['saturday']==1)
		  {
		   $date = new DateTime($row['StartDate']);
		   $date->modify('next saturday');
		   $begin = $date;
		   $end = new DateTime($row['EndDate']);
		   $daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
		   
		   foreach($daterange as $date){
		   $date1=$date->format("Y-m-d");
		   array_push($res,$date1);
		   }
		 }
		 if($row['sunday']==1)
		 {
		  $date = new DateTime($row['StartDate']);
		  $date->modify('next sunday');
		  $begin = $date;
		  $end = new DateTime($row['EndDate']);
		  $daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
		  
		  foreach($daterange as $date){
		  $date1=$date->format("Y-m-d");
		  array_push($res,$date1);
		  }
		}
			
	}

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
	
	
		// if($result1->result())
		// {
		// 	$res=$result1->result();
		// }
	
		return $res;
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
}