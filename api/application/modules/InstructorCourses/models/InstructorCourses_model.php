<?php

class InstructorCourses_model extends CI_Model
{

	function getlist_SubCategory()
	{
		try {
			$this->db->select('CategoryId,CategoryName');
			$this->db->where('ParentId!="0"');
			$result = $this->db->get('tblmstcategory');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	function Instructor_Invite($data)
	{
		try {
			if (!empty($data)) {

				$post_data = $data;
				//echo $post_data;
				$this->db->select('FirstName,LastName,EmailAddress');
				$this->db->where('UserId', $post_data['UserId']);
				$this->db->from('tbluser');
				$result_Inst = $this->db->get()->result();
				$Instructor_name = $result_Inst['0']->FirstName . " " . $result_Inst['0']->LastName;
				$EmailAddress = $result_Inst['0']->EmailAddress;
				print_r($Instructor_name);


				$this->db->select('ts.SessionName,ts.StartTime,ts.StartDate,tc.CourseFullName');
				$this->db->where('ts.CourseSessionId', $post_data['CourseSessionId']);
				$this->db->join('tblcourse tc','ts.CourseId = tc.CourseId');
				$result = $this->db->get('tblcoursesession ts');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				if ($result->result()) {
					$res = $result->result();
					$res =$res['0'];
					$res->Instructor_name = $Instructor_name;
					$res->EmailAddress = $EmailAddress;
				}
				return $res;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_CourseStartHours()
	{
		try {
			$this->db->select('Value');
			$this->db->where('Key', 'CourseStartHours');
			$result = $this->db->get('tblmstconfiguration');

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
			foreach ($result->result() as $row) {
				return $row;
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_CourseEndHours()
	{
		try {
			$this->db->select('Value');
			$this->db->where('Key', 'CourseEndHours');
			$result = $this->db->get('tblmstconfiguration');

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
			foreach ($result->result() as $row) {
				return $row;
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_Course($User_Id = NULL)
	{
		try {
			// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishIsStatus');
			// $this->db->where('cp.InstructorId',$User_Id);
			// $result = $this->db->get('tblcourse cp');
			$result = $this->db->query('select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=' . $User_Id . ' GROUP BY cp.CourseId');

			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_CourseClone($CourseId = NULL)
	{
		try {
			// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishIsStatus');
			// $this->db->where('cp.InstructorId',$User_Id);
			// $result = $this->db->get('tblcourse cp');
			$result = $this->db->query('select ct.TopicId,ct.TopicName, true as Checksubtopic,ct.CourseId
		FROM tblcoursetopic AS ct 
		WHERE ct.CourseId=' . $CourseId . ' GROUP BY ct.TopicId');

			$result1 = $this->db->query('select cs.CourseSessionId,cs.SessionName,true as Checksession,cs.CourseId
		From tblcoursesession AS cs 
		WHERE cs.CourseId=' . $CourseId . ' GROUP BY cs.CourseSessionId');


			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res['topic'] = $result->result();
			}
			if ($result1->result()) {
				$res['session'] = $result1->result();
			}
			return $res;

			//return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function updatePublish($CourseSessionId = NULL)
	{
		try {
			if ($CourseSessionId) {
				$Course_data = array(
					'PublishStatus' => 1
				);

				$this->db->where('CourseSessionId', $CourseSessionId);
				$result = $this->db->update('tblcoursesession', $Course_data);
				// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishStatus');
				// $this->db->where('cp.CourseId',$CourseId);
				// $result = $this->db->get('tblcourse cp');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				//	$res=array();
				if ($result) {
					$data = $this->db->query('SELECT UserId FROM tblcoursesession AS cs 
			LEFT JOIN tblcourseinstructor AS cin ON
			 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId=' . $CourseSessionId);
					$ress = array();
					foreach ($data->result() as $row) {
						//print_r($ress);
						$data1 = $this->db->query('
					 SELECT FollowerUserId FROM tblinstructorfollowers AS cs WHERE cs.InstructorUserId=' . $row->UserId);
						foreach ($data1->result() as $row1) {
							if ($row1->FollowerUserId != '') {
								$FollowerUserId = explode(",", $row1->FollowerUserId);
								foreach ($FollowerUserId as $id) {
									array_push($ress, $id);
								}
							}
						}
					}
					return array_unique($ress);
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function updateinstdata($CourseSessionId = NULL)
	{
		try {
			if ($CourseSessionId) {
				$Course_data = array(
					'PublishStatus' => 1
				);

				$this->db->where('CourseSessionId', $CourseSessionId);
				$result = $this->db->update('tblcoursesession', $Course_data);
				// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishStatus');
				// $this->db->where('cp.CourseId',$CourseId);
				// $result = $this->db->get('tblcourse cp');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				//	$res=array();
				if ($result) {
					$data = $this->db->query('SELECT UserId FROM tblcoursesession AS cs 
			LEFT JOIN tblcourseinstructor AS cin ON
			 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId=' . $CourseSessionId);
					$ress = array();
					foreach ($data->result() as $row) {
						//print_r($ress);
						$id = $row->UserId;
						array_push($ress, $id);
						// foreach($data1->result() as $row1){
						// 	if($row1->FollowerUserId!='')
						// 	{
						// 	$FollowerUserId = explode(",",$row1->FollowerUserId);
						// 	foreach($FollowerUserId as $id){
						// 		array_push($ress,$id);
						// 	}
						//   }

						// }

					}
					return array_unique($ress);
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	// function updatePublish($data)
	// {
	// try{
	// 	if($data){
	// 	$Course_data = array(
	// 				'PublishIsStatus' =>1
	// 			);

	// 			$this->db->where('CourseId',$CourseId);
	// 			$result = $this->db->update('tblcourse',$Course_data);

	// 	$db_error = $this->db->error();
	// 			if (!empty($db_error) && !empty($db_error['code'])) { 
	// 				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
	// 				return false; // unreachable return statement !!!
	// 			}
	// 	$res=array();
	// 	if($result)
	// 	{
	// 		return true;
	// 	}else{return false;}
	// 	}{return false;}
	// 	}catch(Exception $e){
	// 	trigger_error($e->getMessage(), E_USER_ERROR);
	// 	return false;
	// 	}	
	// }
	function getSearchCourseList($data = NULL)
	{
		try {
			$this->db->select('cs.IsActive,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath');
			$this->db->join('tblcoursesession cs', 'cs.CourseSessionId = csi.CourseSessionId', 'left');
			$this->db->join('tblcourse cp', 'cp.CourseId = cs.CourseId', 'left');
			$this->db->join('tblresources rs', 'rs.ResourcesId = cp.CourseImageId', 'left');
			//$this->db->where('cp.CategoryId',$data['Cat']); 

			//$this->db->like('cp.CourseFullName', $data['Name']); 
			$this->db->where('csi.UserId', $data['user']);
			if ($data['Cat'] != 0) {
				$this->db->where('cp.CategoryId', $data['Cat']);
			}
			if ($data['Name'] != null) {
				$this->db->like('cp.CourseFullName', $data['Name']);
			}

			$this->db->group_by('cp.CourseId, cs.IsActive');
			$result = $this->db->get('tblcourseinstructor csi');
			//$this->db->like('cp.CourseFullName', $data['Name']); 
			//$this->db->like('cp.CourseFullName', $data['Name']); 

			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_session($data = NULL)
	{
		try {
			$Course_id = $data['CourseId'];
			$User_Id = $data['UserId'];
			// $result = $this->db->query('select cs.CourseId,cs.CourseSessionId,cs.EndDate,cs.SessionName,cs.TotalSeats,cs.StartTime,cs.EndTime,cs.StartDate
			// FROM tblcourseuserregister AS csi 
			// LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
			// WHERE csi.UserId=487 AND cs.CourseId=$Course_id');

			// $this->db->select('cs.CourseId,cs.CourseSessionId,cs.EndDate,cs.SessionName,cs.TotalSeats,cs.StartTime,cs.EndTime,cs.StartDate,cs.RemainingSeats');
			// $this->db->join('tblcoursesession cs', 'cs.CourseSessionId = csi.CourseSessionId', 'left');
			// $this->db->where('cs.CourseId',$data['CourseId']); 
			// $this->db->where('csi.UserId',$data['UserId']); 
			// $result = $this->db->get('tblcourseuserregister csi');

			$result = $this->db->query('select csi.IsActive,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.SessionStatus,csi.EndDate,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,csi.PublishStatus,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=' . $User_Id . ' AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId=' . $Course_id . ' GROUP BY csi.CourseSessionId');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
				foreach ($res as $row) {
					$UserID = explode(",", $row->UserId);
					$this->db->select('tc.UserID,tc.FirstName,tc.LastName,tc.EmailAddress,ti.Approval');
					$this->db->join('tblcourseinstructor as ti', 'ti.UserId = tc.UserId', 'inner');
					$this->db->where_in('tc.UserId', $UserID);
					$this->db->where_in('ti.CourseSessionId', $row->CourseSessionId);
					$this->db->from('tbluser as tc');
					$new_array = $this->db->get()->result();
					$row->userdetails = $new_array;
				}
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function StartSession($CourseSessionId = NULL,$UserId)
	{
		try {
			if ($CourseSessionId) {

				$this->db->select('cs.StartDate,cs.EndDate,cs.weekday');
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
			$Attendance = implode(',', $res);

				$Cart_data = array(
					'Attendance' =>  $Attendance,
					'UpdatedBy' =>$UserId,
					'UpdatedOn' => date('y-m-d H:i:s')
			
				);
				$this->db->where('CourseSessionId', $CourseSessionId);
				$updated_result=$this->db->update('tblcourseuserregister',$Cart_data);
				
				$Course_data = array(
					'SessionStatus' => 1
				);

				$this->db->where('CourseSessionId', $CourseSessionId);
				$result = $this->db->update('tblcoursesession', $Course_data);
				// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishStatus');
				// $this->db->where('cp.CourseId',$CourseId);
				// $result = $this->db->get('tblcourse cp');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				//	$res=array();
				if ($result) {
					return true;
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function EndSession($CourseSessionId = NULL)
	{
		try {
			if ($CourseSessionId) {
				$Course_data = array(
					'SessionStatus' => 2
				);

				$this->db->where('CourseSessionId', $CourseSessionId);
				$result = $this->db->update('tblcoursesession', $Course_data);
				// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishStatus');
				// $this->db->where('cp.CourseId',$CourseId);
				// $result = $this->db->get('tblcourse cp');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				//	$res=array();
				if ($result) {
					return true;
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function addclone($clone = NULL)
	{
		try {
			if ($clone) {
				$course = $clone['Course'];
				$CoursesesstionList = $clone['CoursesesstionList'];
				$CourseTopicList = $clone['CourseTopicList'];
				if ($course['CheckcourseDetail'] == true || $course['CheckcourseDetail'] == 1) {
					$result = $this->db->query('
				INSERT INTO tblcourse(CategoryId,CourseFullName,Description,Price,CourseImageId,CourseVideoId,
				Keyword,EmailBody,EmailBody2,EmailBody3,EmailBody4,Requirement,Featurescheck,whatgetcheck,
				Targetcheck,Requirementcheck,Morecheck,NoOfQuestion) 
				select CategoryId,CourseFullName,Description,Price,CourseImageId,CourseVideoId,
				Keyword,EmailBody,EmailBody2,EmailBody3,EmailBody4,Requirement,Featurescheck,whatgetcheck,
				Targetcheck,Requirementcheck,Morecheck,NoOfQuestion
						FROM tblcourse 
						WHERE CourseId=' . $course['CourseId']);
					$resultid = $this->db->insert_id();
				}
				if ($course['Checktopic'] == true || $course['Checktopic'] == 1) {
					$result1 = $this->db->query('SELECT CourseId,TopicName,TopicId 
				FROM tblcoursetopic WHERE CourseId=' . $course['CourseId']);
					foreach ($result1->result() as $row) {
						$result = $this->db->query('
					INSERT INTO tblcoursetopic(CourseId,TopicName) values(' . $resultid . ',"' . $row->TopicName . '")');
						$topicid = $this->db->insert_id();
						$result2 = $this->db->query('INSERT INTO tblcoursetopic(ParentId,TopicName,TopicTime,TopicDescription,Video)
					SELECT ' . $topicid . ',TopicName,TopicTime,TopicDescription,Video 
					from tblcoursetopic where ParentId=' . $row->TopicId);
					}
				} else {
					foreach ($CourseTopicList as $row1) {
						if ($row1['Checksubtopic'] == true || $row1['Checksubtopic'] == 1) {
							$result1 = $this->db->query('SELECT CourseId,TopicName,TopicId 
						FROM tblcoursetopic WHERE CourseId=' . $course['CourseId'] . ' AND TopicId=' . $row1['TopicId']);
							foreach ($result1->result() as $row) {
								$result = $this->db->query('
							INSERT INTO tblcoursetopic(CourseId,TopicName) values(' . $resultid . ',"' . $row->TopicName . '")');
								$topicid = $this->db->insert_id();
								$result2 = $this->db->query('INSERT INTO tblcoursetopic(ParentId,TopicName,TopicTime,TopicDescription,Video)
							SELECT ' . $topicid . ',TopicName,TopicTime,TopicDescription,Video 
							from tblcoursetopic where ParentId=' . $row->TopicId);
							}
						}
					}
				}
				if ($course['Checksession'] == true || $course['Checksession'] == 1) {
					$result3 = $this->db->query('SELECT CourseSessionId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate, 
				EndDate,CountryId,StateId,Location
				FROM tblcoursesession WHERE CourseId=' . $course['CourseId']);
					foreach ($result3->result() as $row) {
						$result4 = $this->db->query('
					INSERT INTO tblcoursesession(CourseId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate, 
					EndDate,CountryId,StateId,Location) values(' . $resultid . ',"' . $row->SessionName . '","' . $row->Showstatus . '",
					"' . $row->CourseCloseDate . '","' . $row->TotalSeats . '","' . $row->StartTime . '",
					"' . $row->EndTime . '","' . $row->StartDate . '","' . $row->EndDate . '","' . $row->CountryId . '","' . $row->StateId . '","' . $row->Location . '")');
						$sessionid = $this->db->insert_id();
						$result5 = $this->db->query('INSERT INTO tblcourseinstructor(CourseSessionId,UserId,IsPrimary)
					SELECT ' . $sessionid . ',UserId,IsPrimary 
					from tblcourseinstructor where CourseSessionId=' . $row->CourseSessionId);
					}
				} else {
					foreach ($CoursesesstionList as $row1) {
						if ($row1['Checksession'] == true || $row1['Checksession'] == 1) {
							$result3 = $this->db->query('SELECT CourseSessionId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate, 
				EndDate,CountryId,StateId,Location
				FROM tblcoursesession WHERE CourseId=' . $course['CourseId'] . ' AND CourseSessionId=' . $row1['CourseSessionId']);
							foreach ($result3->result() as $row) {
								$result4 = $this->db->query('
						INSERT INTO tblcoursesession(CourseId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate, 
						EndDate,CountryId,StateId,Location) values(' . $resultid . ',"' . $row->SessionName . '","' . $row->Showstatus . '",
						"' . $row->CourseCloseDate . '","' . $row->TotalSeats . '","' . $row->StartTime . '",
						"' . $row->EndTime . '","' . $row->StartDate . '","' . $row->EndDate . '","' . $row->CountryId . '","' . $row->StateId . '","' . $row->Location . '")');
								$sessionid = $this->db->insert_id();
								$result5 = $this->db->query('INSERT INTO tblcourseinstructor(CourseSessionId,UserId,IsPrimary)
						SELECT ' . $sessionid . ',UserId,IsPrimary 
						from tblcourseinstructor where CourseSessionId=' . $row->CourseSessionId);
							}
						}
					}
				}
				if ($course['Checkbages'] == true || $course['Checkbages'] == 1) {

					$bages = $this->db->query('INSERT INTO tblbadges(CourseId,BadgeImageId,badgeletter)
					SELECT ' . $resultid . ',BadgeImageId,badgeletter 
					from tblbadges where CourseId=' . $course['CourseId']);
				}


				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				//	$res=array();
				if ($result) {
					return $resultid;
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	public function getlist_value($timestamp = NULL, $date = NULL)
	{

		$this->db->select('ca.CourseSessionId,ca.SessionStatus');
		$this->db->where('TIME(EndTime) <', $timestamp);
		$this->db->where('DATE(EndDate)', $date);
		$result = $this->db->get('tblcoursesession ca');
		$myArray = json_decode(json_encode($result->result()), true);
		$res = array();

		foreach ($myArray as $row) {
			if ($row['SessionStatus'] == 1) {
				$Course_data = array(
					'SessionStatus' => 2
				);
				// $this->db->where('TIME(EndTime) =',$timestamp);
				$this->db->where('CourseSessionId', $row['CourseSessionId']);
				$result1 = $this->db->update('tblcoursesession', $Course_data);

				array_push($res, $row['CourseSessionId']);
			}
		}



		if ($result1) {
			return $res;
		} else {
			return false;
		}
	}
	public function getlist_emailvalue($lastemail = NULL, $date = NULL)
	{
		$this->db->select('ca.CourseSessionId');
		$this->db->where('TIME(EndTime) =', $lastemail);
		$this->db->where('DATE(EndDate)', $date);
		//$this->db->join('tblcourseinstructor ins', 'ins.CourseSessionId = ca.CourseSessionId', 'left');
		//$this->db->join('tbluser user', 'user.UserId = ins.UserId', 'left');
		$result = $this->db->get('tblcoursesession ca');
		$res = array();
		if ($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	public function isActiveChange($post_data)
	{
		try {
			if ($post_data) {
				if (trim($post_data['IsActive']) == 1) {
					$IsActive = true;
				} else {
					$IsActive = false;
				}
				$data = array(
					'IsActive' => $IsActive,
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);
				$this->db->where('CourseSessionId', trim($post_data['CourseSessionId']));
				$res = $this->db->update('tblcoursesession', $data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {

					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
}
