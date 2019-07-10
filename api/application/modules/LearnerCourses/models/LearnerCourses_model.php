<?php

class LearnerCourses_model extends CI_Model
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
	function getlist_Course($User_Id = NULL)
	{
		try {
			// $this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseImage,cp.StartDate,cp.EndDate,cp.IsActive,cp.PublishStatus');
			// $this->db->where('cp.InstructorId',$User_Id);
			// $result = $this->db->get('tblcourse cp');
			$result = $this->db->query('select cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cs.PublishStatus,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseuserregister AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=' . $User_Id . ' AND cs.PublishStatus=1 AND cs.IsActive=1  GROUP BY cp.CourseId');

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
	public function Assessmentadd($post_question)
	{
		$sessionId = $post_question['sessionId'];
		$learner = $post_question['learner'];
		if ($post_question) {
			$result = $this->db->query('select cp.NoOfQuestion,cp.CourseId
			FROM tblcoursesession AS cs 
			LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId where cs.CourseSessionId =' . $sessionId);
			foreach ($result->result() as $row) {
				$NoOfQuestion = $row->NoOfQuestion;
				$CourseId = $row->CourseId;
			}
			$result_data = array(
				"CourseSessionId" => $sessionId,
				'LearnerId' => $learner,
				'TotalAttendQuestion' => $NoOfQuestion,
				"CreatedBy" => $learner,
				"CreatedOn" => date('y-m-d H:i:s')

			);
			$res = $this->db->insert('tblmstresult', $result_data);
			$resultid = $this->db->insert_id();

			//$result12 = $this->db->query('INSERT INTO tbllearnertest(QuestionId,ResultId,CreatedBy,UpdatedBy) SELECT QuestionId,'.$resultid.','.$learner.','.$learner.' from tblmstquestion where CourseId='.$CourseId.' ORDER BY RAND() LIMIT 5');
			$result12 = $this->db->query('INSERT INTO tbllearnertest(QuestionId,ResultId,CreatedBy,UpdatedBy,SerialNo) SELECT QuestionId,' . $resultid . ',' . $learner . ',' . $learner . ',@a:=@a+1 from tblmstquestion as tmq,  (SELECT @a:= 0) AS a where tmq.CourseId="' . $CourseId . '" ORDER BY RAND() LIMIT ' . $NoOfQuestion . '');

			if ($result12) {
				$log_data = array(
					'UserId' => $learner,
					'Module' => 'Question',
					'Activity' => 'Add'

				);
				$log = $this->db->insert('tblactivitylog', $log_data);
				return true;
			} else {
				return false;
			}
		} else {
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

			$result = $this->db->query('select csi.weekday,csi.SessionName,csi.TotalSeats,csi.CourseId,csi.StartDate,csi.SessionStatus,csi.EndDate,csi.StartTime,csi.EndTime,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=' . $User_Id . ' AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			(SELECT COUNT(rs.ResultId) FROM tblmstresult as rs WHERE rs.LearnerId=' . $User_Id . ' AND  rs.CourseSessionId=csi.CourseSessionId) as taketest,
			(SELECT Result FROM tblmstresult as rss WHERE rss.LearnerId=' . $User_Id . ' AND  rss.CourseSessionId=csi.CourseSessionId) as Result,
			(SELECT ResultId FROM tblmstresult as res WHERE res.LearnerId=' . $User_Id . ' AND  res.CourseSessionId=csi.CourseSessionId) as ResultId,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					LEFT JOIN  tblcourseuserregister AS dd ON dd.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId=' . $Course_id . ' AND dd.UserId=' . $User_Id . ' AND csi.PublishStatus=1 AND cs.IsActive=1 AND cs.Approval= 1  GROUP BY csi.CourseSessionId');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = $Course_data = array();
			$result = json_decode(json_encode($result->result()), TRUE);
			foreach ($result as $row) {
				$row['monday'] = substr($row['weekday'], 0, 1);
				$row['tuesday'] = substr($row['weekday'], 2, 1);
				$row['wednesday'] = substr($row['weekday'], 4, 1);
				$row['thursday'] = substr($row['weekday'], 6, 1);
				$row['friday'] = substr($row['weekday'], 8, 1);
				$row['saturday'] = substr($row['weekday'], 10, 1);
				$row['sunday'] = substr($row['weekday'], 12, 1);


				array_push($Course_data, $row);
			}
			return $Course_data;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getSearchCourseList($data = NULL)
	{
		try {
			$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cs.PublishStatus,rs.InstructorId as Fid,rs.FilePath');
			$this->db->join('tblcoursesession cs', 'cs.CourseSessionId = csi.CourseSessionId', 'left');
			$this->db->join('tblcourse cp', 'cp.CourseId = cs.CourseId', 'left');
			$this->db->join('tblresources rs', 'rs.ResourcesId = cp.CourseImageId', 'left');
			$this->db->where('cs.IsActive', 1);
			$this->db->where('cs.PublishStatus', 1);

			$this->db->where('csi.UserId', $data['user']);
			if ($data['Cat'] != 0) {
				$this->db->where('cp.CategoryId', $data['Cat']);
			}
			if ($data['Name'] != null) {
				$this->db->like('cp.CourseFullName', $data['Name']);
			}

			$this->db->group_by('cp.CourseId');
			$result = $this->db->get('tblcourseuserregister csi');


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
}
