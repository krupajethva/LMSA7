<?php

class Courselist_model extends CI_Model
{
	function getUserDetail($userid = NULL)
	{
	try
	 {
		$this->db->select('CONCAT(u.FirstName," ",u.LastName) as Name,u.ProfileImage');
		$this->db->where('u.userid',$userid);
		$result = $this->db->get('tbluser as u');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
		foreach($result->result() as $row) {
			$res['Name'] = $row->Name;
			$res['ProfileImage'] = $row->ProfileImage;
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	function getCourseName($course_id = NULL)
	{
	try
	 {
		$this->db->select('c.CourseFullName');
		$this->db->where('c.CourseId',$course_id);
		$result = $this->db->get('tblcourse as c');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		//$res=array();
		foreach($result->result() as $row) {
			$res = $row->CourseFullName;
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	function getlist_Course()
	{
	try{
	// 	$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseShortName,cp.CourseCode,cp.Price,cp.Duration,cp.ShowTo,cp.CourseImage as Favicon,cp.Description,cp.IsActive,in.CategoryName as parentName');
	//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.CategoryId', 'left');
	// 	$result = $this->db->get('tblcourse cp');
	$result=$this->db->query('call getListCourse()');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		//$res=array();
		// mysqli_next_result($this->db->conn_id);
		// $result = json_decode(json_encode($result->result()), True);
		// foreach($result as $row){	
		// 	$Instructor_array=explode(",",$row['InstructorId']);
		// 	// echo "<pre>";
		// 	// print_r($row);
		// 	$childrow=array();
		// 	 foreach($Instructor_array as $instructor)
		// 	 { 
				
		// 		$this->db->select('us.FirstName as UserName,us.ProfileImage');
		// 		$this->db->Where('us.UserId',$instructor);
		// 		$result_child = $this->db->get('tbluser us');
		// 		$row_child = $result_child->result();
		// 		array_push($childrow,$row_child[0]);
		// 	 }
		// 	 $row['child']=$childrow;
		// 	array_push($res,$row);
		// }
		 return $result->result();
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}

	function getlist_SubCategory()
	{
	try
	 {
		$result = $this->db->query('SELECT cat.CategoryId,cat.CategoryName,COUNT(DISTINCT cs.CourseId) as totalcourse
		from tblmstcategory as cat
   LEFT JOIN tblcourse as cp on cp.CategoryId=cat.CategoryId
   LEFT JOIN tblcoursesession as cs  on cs.CourseId=cp.CourseId
   where cat.ParentId!=0 AND cs.PublishStatus!=0 AND cs.IsActive=1 GROUP BY cat.CategoryId');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}

	function getCategoryWiseList($Category_Id = NULL)
	{
	try{
	// 	$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseShortName,cp.CourseCode,cp.Price,cp.Duration,cp.ShowTo,cp.CourseImage as Favicon,cp.Description,cp.IsActive,in.CategoryName as parentName');
	//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.CategoryId', 'left');
	// 	$result = $this->db->get('tblcourse cp');
	$result=$this->db->query('call getCategoryWiseList(?)',$Category_Id);
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				// $res=array();
				// mysqli_next_result($this->db->conn_id);
				// $result = json_decode(json_encode($result->result()), True);
				// foreach($result as $row){	
				// 	$Instructor_array=explode(",",$row['InstructorId']);
				// 	// echo "<pre>";
				// 	// print_r($row);
				// 	$childrow=array();
				// 	 foreach($Instructor_array as $instructor)
				// 	 { 
						
				// 		$this->db->select('us.FirstName as UserName,us.ProfileImage');
				// 		$this->db->Where('us.UserId',$instructor);
				// 		$result_child = $this->db->get('tbluser us');
				// 		$row_child = $result_child->result();
				// 		array_push($childrow,$row_child[0]);
				// 	 }
				// 	 $row['child']=$childrow;
				// 	array_push($res,$row);
				// }
				 return $result->result();
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	function getlist_Instructors()
	{
	try
	 {
		$result = $this->db->query('select c.UserId,user.FirstName,user.LastName,user.ProfileImage,COUNT(DISTINCT cp.CourseId) as totalCourse FROM
        tblcourseinstructor as c LEFT JOIN tblcoursesession as cs  on cs.CourseSessionId=c.CourseSessionId
        LEFT JOIN tbluser as user on c.UserId=user.UserId
        LEFT JOIN tblcourse as cp on cp.CourseId=cs.CourseId WHERE cs.PublishStatus!=0 AND cs.IsActive=1
        GROUP BY c.UserId ORDER BY COUNT(DISTINCT cp.CourseId) DESC ');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		foreach($result->result() as $row)
		{
			$row = 
			array_push($res,$row);
		}
		return $res;
	  }catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	function getInstWiseList($User_Id = NULL)
	{
	try{
		$result = $this->db->query('select cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId = cp.CourseId) as reviewavg
        FROM tblcourseinstructor AS csi 
				LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId='.$User_Id.' AND  cs.PublishStatus!=0 AND cs.IsActive=1 GROUP BY cp.CourseId');
	
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				// $res=array();
				// // mysqli_next_result($this->db->conn_id);
				// $result = json_decode(json_encode($result->result()), True);
				// foreach($result as $row){	
				// 	$Instructor_array=explode(",",$row['InstructorId']);
				// 	// echo "<pre>";
				// 	// print_r($row);
				// 	$childrow=array();
				// 	 foreach($Instructor_array as $instructor)
				// 	 { 
						
				// 		$this->db->select('us.FirstName as UserName,us.ProfileImage');
				// 		$this->db->Where('us.UserId',$instructor);
				// 		$result_child = $this->db->get('tbluser us');
				// 		$row_child = $result_child->result();
				// 		array_push($childrow,$row_child[0]);
				// 	 }
				// 	 $row['child']=$childrow;
				// 	array_push($res,$row);
				// }
				 return $result->result();
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	function getCourseDetailList($post_getAllCourseDetail)
	{
	try{
		// if($post_getAllCourseDetail)
		// {
			$CourseId=$post_getAllCourseDetail['id'];
			$LearnerId=$post_getAllCourseDetail['LearnerId'];
			
			$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cp.EmailBody,rs.InstructorId as Fid,rs.FilePath,cp.Keyword,cp.Price,
			cp.EmailBody2,cp.EmailBody3,cp.EmailBody4,cp.Requirement,cp.Featurescheck,cp.whatgetcheck,cp.Targetcheck,cp.Requirementcheck,cp.Morecheck,cp.IsActive');
			$this->db->join('tblresources rs', 'rs.ResourcesId = cp.CourseVideoId', 'left');
		//	$this->db->where('cp.PublishStatus!="0"');
	 		$this->db->where('cp.CourseId',$CourseId);
			$result = $this->db->get('tblcourse cp');
		// }
	
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		//$res=array();
		//$res=array();
				//mysqli_next_result($this->db->conn_id);
				// $result = json_decode(json_encode($result->result()), True);
				// foreach($result as $row){	
				// 	$Instructor_array=explode(",",$row['InstructorId']);
				// 	// echo "<pre>";
				// 	// print_r($row);
				// 	$childrow=array();
				// 	 foreach($Instructor_array as $instructor)
				// 	 { 
						
				// 		$this->db->select('us.FirstName as UserName,us.ProfileImage');
				// 		$this->db->Where('us.UserId',$instructor);
				// 		$result_child = $this->db->get('tbluser us');
				// 		$row_child = $result_child->result();
				// 		array_push($childrow,$row_child[0]);
				// 	 }
				// 	 $row['child']=$childrow;
				// 	//array_push($res,$row);
				// }
				$Course_data= array();
			
			 foreach($result->result() as $row)
			 {
				$Course_data=$row;
				
			 }
				 return $Course_data;
	 			// return $row;
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	function getCourseSessionList($post_getAllCourseDetail)
	{
	try{
		// if($post_getAllCourseDetail)
		// {
			$CourseId=$post_getAllCourseDetail['id'];
			$LearnerId=$post_getAllCourseDetail['LearnerId'];
			
			$result = $this->db->query('select csi.SessionName,csi.TotalSeats,csi.StartDate,csi.weekday,(csi.StartDate - INTERVAL 1 DAY) as prestartdate,csi.EndDate,csi.StartTime,csi.EndTime,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId='.$LearnerId.' AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId='.$CourseId.' AND csi.PublishStatus=1 AND csi.IsActive=1 AND cs.Approval= 1 GROUP BY csi.CourseSessionId');
		
		// }
	
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			// 	$Course_data= array();
			
			//  foreach($result->result() as $row)
			//  {
			// 	$Course_data=$row;
				
			//  }
			$Course_data= array();
		$result = json_decode(json_encode($result->result()), TRUE);
		 foreach($result as $row)
		 { 
			$row['monday'] = substr($row['weekday'], 0, 1);
			$row['tuesday'] = substr($row['weekday'], 2, 1);
			$row['wednesday'] = substr($row['weekday'], 4, 1);
			$row['thursday'] = substr($row['weekday'], 6, 1);
			$row['friday'] = substr($row['weekday'], 8, 1);
			$row['saturday'] = substr($row['weekday'], 10, 1);
			$row['sunday'] = substr($row['weekday'], 12, 1);

			
			array_push($Course_data,$row);
		 }
			//  $Course_data= array();
			// if($result->result()) {
			// 	$Course_data = $result->result();
			// }
				 return $Course_data;
	 		
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	public function get_CourseContent($post_getAllCourseDetail = NULL) {
		try{
		if($post_getAllCourseDetail) 
		{
			$course_id=$post_getAllCourseDetail['id'];
			$LearnerId=$post_getAllCourseDetail['LearnerId'];
				$this->db->select('tp.TopicName,tp.TopicId,tp.TopicTime');
				$this->db->where('tp.CourseId',$course_id);
				$result = $this->db->get('tblcoursetopic as tp');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) 
				{ 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$result = json_decode(json_encode($result->result()), True);
				$result_data = array();
				foreach($result as $row)
				{	
					$result_child = $this->db->query('select us.TopicId,us.TopicName,us.TopicTime,us.TopicDescription,us.Video,rs.FilePath,rs.InstructorId as fid,
					(SELECT COUNT(mc.CourseSessionId) FROM tblcourseuserregister as mc
					 LEFT JOIN tblcoursesession AS cs ON cs.CourseSessionId = mc.CourseSessionId
				   WHERE cs.CourseId='.$course_id.' AND mc.UserId='.$LearnerId.') as enroll
				   FROM tblcoursetopic AS us LEFT JOIN tblresources AS rs ON rs.ResourcesId = us.Video WHERE us.ParentId='.$row['TopicId']);

					// $this->db->select('us.TopicId,us.TopicName,us.TopicTime,us.TopicDescription,us.Video,rs.FilePath,rs.InstructorId as fid');
					// $this->db->join('tblresources rs', 'rs.ResourcesId = us.Video', 'left');
					// 	$this->db->Where('us.ParentId',$row['TopicId']);
					// 	$result_child = $this->db->get('tblcoursetopic us');
						$row_child = $result_child->result();
						//array_push($childrow,$row_child);
					
					$row['child']=$row_child;
					array_push($result_data,$row);
				} 
				
				 return $result_data;
			} 
			else {
				return false;
			}
		}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	
	public function addEnroll($post_addEnroll)
	{				
		try
		{
		if($post_addEnroll)
			{
				/*$this->db->select('cs.StartDate,cs.EndDate,cs.weekday');
				$this->db->where('cs.CourseSessionId',$post_addEnroll['CourseSessionId']); 	
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
					$date1=0;
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
					$date1=0;
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
					$date1=0;
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
					$date1=0;
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
					$date1=0;
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
				   $date1=0;
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
				  $date1=0;
				  array_push($res,$date1);
				  }
				}
					
			}
			$Attendance = implode(',', $res);*/

				$Cart_data = array(
					'UserId' =>  trim($post_addEnroll['UserId']),
					'CourseSessionId' =>  $post_addEnroll['CourseSessionId'],
					//'Attendance' =>  $Attendance,
					'CreatedBy' =>trim($post_addEnroll['UserId']),
					'CreatedOn' => date('y-m-d H:i:s')
			
				);
				$insert = $this->db->insert('tblcourseuserregister',$Cart_data);
				$last_id = $this->db->insert_id();
				$this->db->select('cat.RemainingSeats');
				$this->db->where('CourseSessionId',$post_addEnroll['CourseSessionId']);
				$result = $this->db->get('tblcoursesession as cat');
					if($result)
					{     
						$ss=$result->result()[0]->RemainingSeats;
						$s=$ss+1;
						$change_data = array(
							'RemainingSeats' =>$s,
							'UpdatedOn' => date('y-m-d H:i:s')
					
						);
						$this->db->where('CourseSessionId',trim($post_addEnroll['CourseSessionId']));
						$ress = $this->db->update('tblcoursesession',$change_data);
					}
				
			}
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code']))
				{ 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($ress)
				{	
					$log_data = array(
						'UserId' => trim($post_addEnroll['UserId']),
						'Module' => 'Cart',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					return $last_id;
				}
				else
				{
					return false;
		
				}
		}
		catch(Exception $e)
		{
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	
	public function delete_Cart($post_Cart) 
	{
	 try{
		if($post_Cart) 
		{
			$this->db->where('CartId',$post_Cart['id']);
			$res = $this->db->delete('tblcart');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				// $log_data = array(
				// 	'UserId' =>trim($post_Course['Userid']),
				// 	'Module' => 'Category',
				// 	'Activity' =>'Delete'
	
				// );
				// $log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else 
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
	public function checkUser($post_data) 
	{	
		try{
		if($post_data)
		{
			$this->db->select('UserId,CourseId');				
			$this->db->where('CourseId',trim($post_data['CourseId']));
			$this->db->where('UserId',trim($post_data['UserId']));
			$this->db->limit(1);
			$this->db->from('tblcoursereview');
			$query = $this->db->get();
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}				
			if ($query->num_rows() == 1) 
			{
				return true;
			} 
			else
			{
				return false;
			}				
		} 
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}
	
	public function get_skilldata($Id=NULL)
	{
		//	$Course_id=$post_getAllCourseDetail['id'];
		try {
	  if($Id)
	  {
		  	$Skill =$this->db->query("SELECT keyword FROM tblcourse WHERE CourseId=".$Id);
			  $Course = $Skill->result();
			//  echo $Course[0]->keyword; echo "<br>";
			$aKeyword = explode(",", $Course[0]->keyword);
			

     	    $query ="SELECT c.CourseFullName,c.CourseId,c.Keyword,(SELECT COUNT(CourseSessionId) FROM tblcoursesession where CourseId=c.CourseId && PublishStatus=1 && IsActive=1) as totalSession,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId =c.CourseId) as ReviewAverage, (IF"; 
			 for($i = 0; $i < count($aKeyword); $i++) 
			 {
				$query .= "(c.Keyword like '%" . $aKeyword[$i] . "%')";
				if($i!=count($aKeyword)-1){
					$query .= " OR ";	
				} 						
			  }
			  $query .= ",keyword,'no') as match_keyword";		
			 $query .=" FROM tblcourse as c WHERE (c.CourseId!=".$Id." AND c.IsActive=1) AND (c.Keyword like '%" . $aKeyword[0] . "%'";
			 for($i = 1; $i < count($aKeyword); $i++) 
			 {
				$query .= " OR c.Keyword like '%" . $aKeyword[$i] . "%'";				
			  }


			  $query ="SELECT c.CourseFullName,c.CourseId,c.Keyword,(SELECT COUNT(CourseSessionId) FROM tblcoursesession where CourseId=c.CourseId && PublishStatus=1 && IsActive=1) as totalSession,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId =c.CourseId) as ReviewAverage, CONCAT("; 
			  $total_count = count($aKeyword);
			  for($i = 0; $i < count($aKeyword); $i++) 
			  {
				 $query .= "(CASE WHEN c.Keyword like '%" . $aKeyword[$i] . "%' THEN '".$aKeyword[$i]."' ELSE '' END)";		
				 if($i+1<	$total_count){
					$query .= ",";
				 }	
			   }
			   $query .= ") as match_keyword";		
			  $query .=" FROM tblcourse as c WHERE (c.CourseId!=".$Id." AND c.IsActive=1) AND (c.Keyword like '%" . $aKeyword[0] . "%'";
			  for($i = 1; $i < count($aKeyword); $i++) 
			  {
				 $query .= " OR c.Keyword like '%" . $aKeyword[$i] . "%'";				
			   }


				  $query .= ") AND (SELECT COUNT(CourseSessionId) FROM tblcoursesession where CourseId=c.CourseId && PublishStatus=1 && IsActive=1)>0 ORDER BY LENGTH(match_keyword) DESC limit 5";
			
			// echo $query;
			// 	echo "</br>";
			  $result = $this->db->query($query);
		
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
	
				$Course_data= array();
			if($result->result()) {
				$Course_data = $result->result();
			}
			// return $Course_data;
		//  foreach($result->result() as $row)
		//  {
		// 	$Course_data=$row;
			
		//  }
		 return $Course_data;
		 
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
	
	public function getDiscussionById($course_id = NULL) {
		try{
		if($course_id) {
			$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.ProfileImage,(select COUNT(c.DiscussionId) from tblcoursediscussion as c where c.ParentId=cd.DiscussionId) as count');
			$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
			$this->db->where('cd.CourseId',$course_id);
			$this->db->where('cd.ParentId',0);
			$this->db->order_by('cd.DiscussionId','desc');
			$this->db->limit(3);
			$result = $this->db->get('tblcoursediscussion as cd');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				foreach($result->result() as $row) {
					$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.ProfileImage,(select COUNT(c.DiscussionId) from tblcoursediscussion as c where c.ParentId=cd.DiscussionId) as count');
					$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
					$this->db->where('cd.CourseId',$course_id);
					$this->db->where('cd.ParentId',$row->DiscussionId);
					$this->db->order_by('cd.DiscussionId','desc');
					$result1 = $this->db->get('tblcoursediscussion as cd');
					foreach($result1->result() as $row1){
						$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.ProfileImage');
						$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
						$this->db->where('cd.CourseId',$course_id);
						$this->db->where('cd.ParentId',$row1->DiscussionId);
						$this->db->order_by('cd.DiscussionId','desc');
						$result2 = $this->db->get('tblcoursediscussion as cd');
	
						$row1->child = $result2->result();
					}
					$row->child = $result1->result();
					array_push($res,$row);
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
	public function getAllDiscussions($course_id = NULL) {
		try{
		if($course_id) {
			$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.FirstName,u.LastName,u.ProfileImage,(select COUNT(c.DiscussionId) from tblcoursediscussion as c where c.ParentId=cd.DiscussionId) as count');
			$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
			$this->db->where('cd.CourseId',$course_id);
			$this->db->where('cd.ParentId',0);
			$this->db->order_by('cd.DiscussionId','desc');
			$result = $this->db->get('tblcoursediscussion as cd');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				foreach($result->result() as $row) {
					$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.FirstName,u.LastName,u.ProfileImage,(select COUNT(c.DiscussionId) from tblcoursediscussion as c where c.ParentId=cd.DiscussionId) as count');
					$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
					$this->db->where('cd.CourseId',$course_id);
					$this->db->where('cd.ParentId',$row->DiscussionId);
					$this->db->order_by('cd.DiscussionId','desc');
					$result1 = $this->db->get('tblcoursediscussion as cd');
					foreach($result1->result() as $row1){
						$this->db->select('cd.DiscussionId,cd.ParentId,cd.UserId,cd.Comment,cd.Reply,cd.PostTime,cd.IsActive,CONCAT(u.FirstName," ",u.LastName) as Name,u.FirstName,u.LastName,u.ProfileImage');
						$this->db->join('tbluser u', 'u.UserId=cd.userId', 'inner');
						$this->db->where('cd.CourseId',$course_id);
						$this->db->where('cd.ParentId',$row1->DiscussionId);
						$this->db->order_by('cd.DiscussionId','desc');
						$result2 = $this->db->get('tblcoursediscussion as cd');
	
						$row1->child = $result2->result();
					}
					$row->child = $result1->result();
					array_push($res,$row);
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
	public function getReviews($post_data)
	{
		try{
			if($post_data){
			$this->db->select('CONCAT(u.FirstName," ",u.LastName) as Name,u.FirstName,u.LastName,u.ProfileImage,cr.Rating,cr.ReviewId,cr.UserId,cr.ReviewComment,cr.ReviewTime,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId ='.$post_data['CourseId'].') as reviewavg');
			$this->db->join('tbluser u', 'cr.UserId = u.UserId');
			$this->db->where('cr.CourseId',$post_data['CourseId']);
			$this->db->order_by('FIELD(cr.UserId,'.$post_data['UserId'].') desc');
			$this->db->order_by('cr.ReviewId','desc');
			$this->db->limit(5);
			$this->db->from('tblcoursereview cr');
			$result = $this->db->get();
			$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			$res=array();
			if($result->result())
			{
				$res=$result->result();
			}
			return $res;
		}
		else{
			return false;
		}
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
	}
	public function getAllReviews($post_data)
	{
		try{
			if($post_data){
			$this->db->select('CONCAT(u.FirstName," ",u.LastName) as Name,u.ProfileImage,cr.Rating,cr.ReviewId,cr.UserId,cr.ReviewComment,cr.ReviewTime,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId ='.$post_data['CourseId'].') as reviewavg');
			$this->db->join('tbluser u', 'cr.UserId = u.UserId');
			$this->db->where('cr.CourseId',$post_data['CourseId']);
			$this->db->order_by('FIELD(cr.UserId,'.$post_data['UserId'].') desc');
			$this->db->order_by('cr.ReviewId','desc');
			$this->db->from('tblcoursereview cr');
			$result = $this->db->get();
			$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			$res=array();
			if($result->result())
			{
				$res=$result->result();
			}
			return $res;
		}
		else{
			return false;
		}
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
	}
	
	public function addPost($post_data) {
		try{
			if($post_data) {
				$postTime = date('Y-m-d H:i:s');
				$data = array(
					'UserId' => trim($post_data['UserId']),
					'CourseId' => trim($post_data['CourseId']),
					'Comment' => trim($post_data['Comment']),
					'PostTime' => $postTime,
					'CreatedBy' => trim($post_data['CreatedBy']),
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblcoursediscussion',$data);
				$insert_id = $this->db->insert_id();
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($post_data['UpdatedBy']),
						'Module' => 'Comment',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'DiscussionId' => $insert_id,
						'PostTime' => $postTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function editPost($post_data) {
		try{
			if($post_data) {
				$postTime = date('Y-m-d H:i:s');
				$data = array(
					'UserId' => trim($post_data['UserId']),
					'CourseId' => trim($post_data['CourseId']),
					'Comment' => trim($post_data['Comment']),
					'PostTime' => $postTime,
					//'CreatedBy' => trim($post_data['CreatedBy']),
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);	
				$this->db->where('DiscussionId',$post_data['DiscussionId']);		
				$res = $this->db->update('tblcoursediscussion',$data);
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($post_data['UpdatedBy']),
						'Module' => 'Comment',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'DiscussionId' => $post_data['DiscussionId'],
						'PostTime' => $postTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function addCommentReply($post_data) {
		try{
			if($post_data) {
				$postTime = date('Y-m-d H:i:s');
				$data = array(
					'ParentId' => trim($post_data['ParentId']),
					'UserId' => trim($post_data['UserId']),
					'CourseId' => trim($post_data['CourseId']),
					'Reply' => trim($post_data['CommentReply']),
					'PostTime' => $postTime,
					'CreatedBy' => trim($post_data['CreatedBy']),
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblcoursediscussion',$data);
				$insert_id = $this->db->insert_id();
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($post_data['UpdatedBy']),
						'Module' => 'Comment Reply',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'DiscussionId' => $insert_id,
						'PostTime' => $postTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function editCommentReply($post_data) {
		try{
			if($post_data) {
				$postTime = date('Y-m-d H:i:s');
				$data = array(
					'UserId' => trim($post_data['UserId']),
					'CourseId' => trim($post_data['CourseId']),
					'Reply' => trim($post_data['CommentReply']),
					'PostTime' => $postTime,
					//'CreatedBy' => trim($post_data['CreatedBy']),
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$this->db->where('DiscussionId',$post_data['DiscussionId']);
				$res = $this->db->update('tblcoursediscussion',$data);
				$insert_id = $this->db->insert_id();
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($post_data['UpdatedBy']),
						'Module' => 'Comment Reply',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'DiscussionId' => $post_data['DiscussionId'],
						'PostTime' => $postTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function addReview($review_data) {
		try{
			if($review_data) {
				$reviewTime = date('Y-m-d H:i:s');
				$data = array(
					'CourseId' => trim($review_data['CourseId']),
					'UserId' => trim($review_data['UserId']),
					'Rating' => trim($review_data['Ratings']),
					'ReviewComment' => trim($review_data['ReviewComment']),
					'ReviewTime' => $reviewTime,
					'CreatedBy' => trim($review_data['CreatedBy']),
					'CreatedOn' => date('y-m-d H:i:s'),
					'UpdatedBy' => trim($review_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblcoursereview',$data);
				$insert_id = $this->db->insert_id();
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($review_data['UpdatedBy']),
						'Module' => 'Review Comment',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'ReviewId' => $insert_id,
						'ReviewTime' => $reviewTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function editReview($review_data) {
		try{
			if($review_data) {
				$reviewTime = date('Y-m-d H:i:s');
				$data = array(
					'CourseId' => trim($review_data['CourseId']),
					'UserId' => trim($review_data['UserId']),
					'Rating' => trim($review_data['Ratings']),
					'ReviewComment' => trim($review_data['ReviewComment']),
					'ReviewTime' => $reviewTime,
					//'CreatedBy' => trim($review_data['CreatedBy']),
					'CreatedOn' => date('y-m-d H:i:s'),
					'UpdatedBy' => trim($review_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);
				$this->db->where('ReviewId',$review_data['ReviewId']);
				$res = $this->db->update('tblcoursereview',$data);
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($review_data['UpdatedBy']),
						'Module' => 'Review Comment',
						'Activity' =>'Add'
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data = array(
						'ReviewId' => $review_data['ReviewId'],
						'ReviewTime' => $reviewTime,
					);
					return $return_data;
				} else {
					return false;
				}	
			} else {
				return false;
			}
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function deleteReview($ReviewId = NULL) {
		try{
			if($ReviewId) 
			{
				$this->db->where('ReviewId',$ReviewId);
				$res = $this->db->delete('tblcoursereview');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				return true;
			}else {
				return false;
			}
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	public function deleteDiscussion($DiscussionId = NULL) {
		try{
			if($DiscussionId) 
			{
				$this->db->where('DiscussionId',$DiscussionId);
				$res = $this->db->delete('tblcoursediscussion');
				if($res) {

					$this->db->select('DiscussionId');
					$this->db->where('ParentId',$DiscussionId);
					$result = $this->db->get('tblcoursediscussion');

					$ids=array();
					foreach($result->result() as $row)
					{
						array_push($ids,$row->DiscussionId);
					}

					$this->db->where('ParentId',$DiscussionId);
					$res1 = $this->db->delete('tblcoursediscussion');

					if($res1 && !empty($ids)){
						$this->db->where_in('ParentId',$ids);
						$res2 = $this->db->delete('tblcoursediscussion');
					}
				}
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				return true;
			}else {
				return false;
			}
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
		function PreviewgetCourseSessionList($post_getAllCourseDetail)
	{
	try{
		// if($post_getAllCourseDetail)
		// {
			$CourseId=$post_getAllCourseDetail['id'];
			$LearnerId=$post_getAllCourseDetail['LearnerId'];
			
			$result = $this->db->query('select csi.SessionName,csi.TotalSeats,csi.StartDate,csi.weekday,(csi.StartDate - INTERVAL 1 DAY) as prestartdate,csi.EndDate,csi.StartTime,csi.EndTime,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId='.$LearnerId.' AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId='.$CourseId.' GROUP BY csi.CourseSessionId');
		
		// }
	
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			// 	$Course_data= array();
			
			//  foreach($result->result() as $row)
			//  {
			// 	$Course_data=$row;
				
			//  }
			$Course_data= array();
		$result = json_decode(json_encode($result->result()), TRUE);
		 foreach($result as $row)
		 { 
			$row['monday'] = substr($row['weekday'], 0, 1);
			$row['tuesday'] = substr($row['weekday'], 2, 1);
			$row['wednesday'] = substr($row['weekday'], 4, 1);
			$row['thursday'] = substr($row['weekday'], 6, 1);
			$row['friday'] = substr($row['weekday'], 8, 1);
			$row['saturday'] = substr($row['weekday'], 10, 1);
			$row['sunday'] = substr($row['weekday'], 12, 1);

			
			array_push($Course_data,$row);
		 }
			//  $Course_data= array();
			// if($result->result()) {
			// 	$Course_data = $result->result();
			// }
				 return $Course_data;
	 		
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	
	public function getAllCourseKey() {
		try{
		// $this->db->select('*');
		$this->db->select('tc.Keyword');
		$result = $this->db->get('tblcourse tc');
		//$result = $this->db->query('call getCountryList()');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		foreach($result->result() as $row) {
			$skill_explode = explode(',', $row->Keyword);
			foreach ($skill_explode as $skill) {
				if($skill!="" || $skill!=null){
					array_push($res,$skill);
				}					
			}
		}
		return array_values(array_unique($res));
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	// filter for course list
	public function courseFilter($courseFilter_data) {
		try{
			$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cp.NoOfQuestion,cp.IsActive,rs.InstructorId as Fid,rs.FilePath,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId = cp.CourseId) as reviewavg');
			$this->db->join('tblcoursesession cs', 'cs.CourseId = cp.CourseId', 'left');
			$this->db->join('tblresources rs', 'rs.ResourcesId = cp.CourseImageId', 'left');
			$this->db->join('tblcourseinstructor tci', 'tci.CourseSessionId = cs.CourseSessionId', 'left');
			$this->db->where('cs.IsActive', 1);
			$this->db->where('cs.PublishStatus', 1);

		
			if ($courseFilter_data['CourseFullName'] != null && $courseFilter_data['CourseFullName'] != '' ) {
				$this->db->like('cp.CourseFullName', $courseFilter_data['CourseFullName']);
			}
			if ($courseFilter_data['CourseSkill'] != null && $courseFilter_data['CourseSkill'] != '' ) {
				$this->db->like('cp.Keyword', $courseFilter_data['CourseSkill']);
			}
			if ($courseFilter_data['Instructor'] != null && $courseFilter_data['Instructor'] != '' ) {
				$this->db->like('tci.UserId', $courseFilter_data['Instructor']);
			}
			$this->db->group_by('cp.CourseId');
			$result = $this->db->get('tblcourse cp');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			else {
				$res = false;	
			}
			return $res;
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

}