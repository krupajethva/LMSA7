<?php

class Dashboard_model extends CI_Model
 {	
	
	public function getlist_Setting() {
	
		$this->db->select('*');
		$this->db->where('SettingName=','Register');
		$this->db->where('IsActive=',1);
			// $this->db->order_by('SettingName','asc');
			$result = $this->db->get('tblsetting');

			$res=array();
			if($result->result())
			{
				$res=$result->result();
			}
			return $res;
		
	}
	public function getAnnouncementTypes() {
        $result = $this->db->query('call getAnnouncementTypes()');
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	/*################ GET ADMIN DASHBOARD START ##############*/
	public function getDashboard($Id=Null)
	{
		try{
			if($Id)
			{
				$AllData = array();	//create array $AllData which we return

				//Start - Total Learner
				$this->db->select('COUNT(UserId) as totalLearner');
				$this->db->where('RoleId',4);
				$this->db->where('IsStatus',0);
				$this->db->where('IsActive',1);
				$total_learner = $this->db->get('tbluser');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false;
				}
				$AllData['totalLearner']=$total_learner->result()[0]->totalLearner;
				//End - Total Learner
				
				//Start - Total Instructor
				$this->db->select('COUNT(UserId) as totalInstructor');
				$this->db->where('RoleId',3);
				$this->db->where('IsStatus',0);
				$this->db->where('IsActive',1);
				$total_instructor = $this->db->get('tbluser');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false;
				}
				$AllData['totalInstructor']=$total_instructor->result()[0]->totalInstructor;
				//End - Total Instructor
				
				//Start - Total Courses
				$this->db->select('COUNT(CourseId) as totalCourses');
				$this->db->where('IsActive',1);
				$total_courses = $this->db->get('tblcourse');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false;
				}
				$AllData['totalCourses']=$total_courses->result()[0]->totalCourses;
				//End - Total Courses

				/*################ GET TOP RATED COURSES START ##############*/
				$this->db->select('tcv.UserId,tcv.Rating,tcv.CourseId,tc.CourseFullName,tu.FirstName,tu.LastName');
				$this->db->join('tblcourse tc','tcv.CourseId=tc.CourseId');
				$this->db->join('tbluser tu','tcv.UserId=tu.UserId');
				$this->db->order_by('tcv.Rating','desc');
				$this->db->limit(5);
				$toprated_course = $this->db->get('tblcoursereview as tcv');
		
				$AllData['topratedcourse'] = $toprated_course->result();
				/*################ GET TOP RATED COURSES END ##############*/

				/*################ GET TOP LEARNERS START ##############*/
				$topLearner = $this->db->query('
				SELECT 
					tcur.UserId,COUNT(tcur.UserId) AS TOTALSESSION,tu.FirstName,tu.LastName,
					(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
						LEFT JOIN tblcoursesession tcs1
						ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=2
					) as complete,
					(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
						LEFT JOIN tblcoursesession tcs1
						ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=1
					) as inprocess,
					(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
						LEFT JOIN tblcoursesession tcs1
						ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=0
					) as pending
				FROM tblcourseuserregister tcur
				LEFT JOIN tblcoursesession tcs
				ON tcur.CourseSessionId=tcs.CourseSessionId
				LEFT JOIN tbluser tu
				ON tcur.UserId=tu.UserId
				GROUP BY tcur.UserId ORDER BY complete DESC, inprocess DESC, pending DESC LIMIT 5
				');

				
				$AllData['toplearner'] = $topLearner->result();

				return $AllData;	//return $AllData
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

	 public function getTopLearner()
	{
		// $this->db->select('tcur.UserId,tcur.CourseSessionId,COUNT(tcur.UserId) AS TOTALSESSION');
		// $this->db->join('tblcoursesession tcs','tcur.CourseSessionId=tcs.CourseSessionId','left');
		// $this->db->group_by('tcur.UserId','desc');
		
		// $topLearner = $this->db->get('tblcourseuserregister as tcur');

		// $res = array();
		// if($topLearner->result()) {
		// 	$res = $topLearner->result();
		// }

		$topLearner = $this->db->query('
		SELECT 
			tcur.UserId,COUNT(tcur.UserId) AS TOTALSESSION,
			(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
				LEFT JOIN tblcoursesession tcs1
				ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=2
			) as complete,
			(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
				LEFT JOIN tblcoursesession tcs1
				ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=1
			) as inprocess,
			(select COUNT(tcs1.CourseSessionId) from tblcourseuserregister tcur1
				LEFT JOIN tblcoursesession tcs1
				ON tcur1.CourseSessionId=tcs1.CourseSessionId where UserId=tcur.UserId AND tcs1.SessionStatus=0
			) as pending
		FROM tblcourseuserregister tcur
		LEFT JOIN tblcoursesession tcs
		ON tcur.CourseSessionId=tcs.CourseSessionId
		GROUP BY tcur.UserId ORDER BY complete DESC, inprocess DESC, pending DESC LIMIT 5
		');

		$res = array();
		if($topLearner->result()) {
			$res1 = $topLearner->result();
		}

		//print_r($res1);

		
		return $res;
	}
	/*################ GET ADMIN DASHBOARD END ##############*/

	// public function getLearnerCourses($Id=Null)
	// {
	// 	try{
	// 		if($Id)
	// 		{
	// 			$this->db->select('cur.CourseUserregisterId,cur.CourseSessionId,cur.UserId,c.CourseFullName,c.CourseFullName,CONCAT(u.Firstname," ",u.LastName) as InstructorName,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseSessionId =cur.CourseSessionId) as reviewavg');
	// 			$this->db->join('tblcourse c', 'c.CourseSessionId = cur.CourseSessionId', 'left');
	// 			$this->db->join('tbluser u', 'c.InstructorId = u.UserId', 'left');
	// 			$this->db->order_by('cur.CourseUserregisterId','desc');
	// 			$this->db->where('cur.IsActive',1);
	// 			$this->db->where('cur.UserId',$Id);
	// 			$this->db->limit(5);
	// 			$result = $this->db->get('tblcourseuserregister cur');
				
	// 			$res = array();
	// 			if($result->result()) {
	// 				$res = $result->result();
	// 			}
	// 			return $res;
			
	// 		} else {
	// 			return false;
	// 		}
	// 	}
	// 	catch(Exception $e){
	// 		trigger_error($e->getMessage(), E_USER_ERROR);
	// 		return false;
	// 	}
	// }
	public function getCalendarDetails($Id=Null)
	{
        if($Id) {
			$result = $this->db->query('call getCalendarDetails(?)',$Id);		
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
	/*################ LEARNER ACTIVITY  START ##############*/
	public function getLearnerActivities($Id=Null)
	{
		try{
			if($Id)
			{
				$this->db->select('a.Activity,a.CreatedOn');
				$this->db->order_by('a.ActivityLogId','desc');
				$this->db->where('a.UserId',$Id);
				$this->db->limit(5);
				$result = $this->db->get('tblactivitylog a');
				
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
	/*################ LEARNER ACTIVITY  START ##############*/

	/*################ RECENT INVITATION  START ##############*/
	public function getRecentInvitation()
	{
		$this->db->select('tu.FirstName,tu.LastName,tu.EmailAddress,tu.IsStatus,tu.IsActive');
		$this->db->where('tu.RoleId= 2 OR tu.RoleId=3 OR tu.RoleId=4');
		$this->db->where('tu.IsActive',1);
		$this->db->limit(5);
		$result = $this->db->get('tbluser tu');
		
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	/*################ RECENT INVITATION  END ##############*/

	
	/*################ RECENT ACTIVITIES  START ##############*/
	public function getRecentActivity($UserId)
	{
		$this->db->select('tal.UserId,tal.Module,tal.Activity,tal.CreatedOn,tu.FirstName,tu.LastName');
		$this->db->join('tbluser tu', 'tal.UserId = tu.UserId');
		$this->db->order_by('tal.ActivityLogId','desc');
		$this->db->where('tal.UserId',$UserId);
		$this->db->limit(5);
		$result = $this->db->get('tblactivitylog tal');
		
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	/*################ RECENT ACTIVITIES  END ##############*/

	/*################ TOP INSTRUCTORS  START ##############*/
	public function getTopInstructors()
	{
		$this->db->select('tci.UserId,COUNT(DISTINCT tci.CourseSessionId) AS TOTALSESSION,tu.FirstName,tu.LastName,tu.ProfileImage');
		$this->db->join('tbluser tu', 'tci.UserId = tu.UserId');
		$this->db->group_by('tci.UserId','desc');
		$this->db->order_by('count(DISTINCT tci.CourseSessionId)','desc');
		$this->db->limit(5);
		$result = $this->db->get('tblcourseinstructor tci');
		
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	/*################ TOP INSTRUCTORS  END ##############*/

	/*################ GET INSTRUCTOR DASHBOARD START ##############*/
	public function getInstructorDashboard($UserId)
	{ 

		/*################ GET TOTAL COURSE ##############*/
		$this->db->select('COUNT(DISTINCT tci.CourseSessionId) as totalcourse');
		$this->db->where('tci.UserId',$UserId);
		$result = $this->db->get('tblcourseinstructor tci');

		$allinstructordata = array();

		$allinstructordata['totalcourse'] = $result->result()[0]->totalcourse;

		/*################ GET RECENT ACTIVITY ##############*/
		$this->db->select('tal.Module,tal.Activity,tal.CreatedOn');
		$this->db->where('tal.UserId',$UserId);
		$this->db->order_by('ActivityLogId','desc');
		$this->db->limit(5);
		$result1 = $this->db->get('tblactivitylog tal');

		$allinstructordata['recentactivity'] = $result1->result();

		/*################ GET INSTRUCTOR COURSE ##############*/
		$this->db->distinct();
		$this->db->select('tci.CourseSessionId,tcs.CourseId,tc.CourseFullName,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId =tc.CourseId) as reviewavg');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->join('tblcourse tc','tcs.CourseId=tc.CourseId');
		$this->db->where('tci.UserId',$UserId);
		$this->db->group_by('tc.CourseId');
		$instructorCourseResult = $this->db->get('tblcourseinstructor as tci');
		
		$allinstructordata['instructorcourses'] = $instructorCourseResult->result();	
		
		/*################ GET COURSE VIEW ##############*/
		$this->db->select('count(tci.CourseSessionId) as courseview,tcs.SessionStatus');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->where('tci.UserId',$UserId);
		$this->db->group_by('tcs.SessionStatus');
		$this->db->order_by('tci.CourseSessionId','desc');
		$courseViewResult = $this->db->get('tblcourseinstructor as tci');

		$allinstructordata['courseview'] = $courseViewResult->result();

		/*################ GET TOTAL LESSONS ##############*/
		$this->db->select(' COUNT(DISTINCT tct.TopicId) as lessons');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->join('tblcoursetopic tct','tcs.CourseId=tct.CourseId');
		$this->db->where('tci.UserId',$UserId);
		$lessonResult = $this->db->get('tblcourseinstructor  tci');

		$allinstructordata['lessons'] = $lessonResult->result()[0]->lessons;

		/*################ GET TOTAL STUDENTS ##############*/
		$this->db->select('count(tcur.UserId) as student');
		$this->db->join('tblcourseuserregister tcur','tci.CourseSessionId=tcur.CourseSessionId');
		$this->db->where('tci.UserId',$UserId);
		$studentResult = $this->db->get('tblcourseinstructor as tci');

		$allinstructordata['student'] = $studentResult->result()[0]->student;

		return $allinstructordata;
	}
	/*################ GET INSTRUCTOR DASHBOARD END ##############*/

	/*################ GET LEARNER DASHBOARD START ##############*/
	public function getLearnerDashboard($UserId)
	{ 
		$allLearnerData = array();

		/*################ GET  ACTIVE COURSE START ##############*/
		$this->db->select('count(tci.CourseSessionId) as activecourse');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->where('tci.UserId',$UserId);
		$this->db->where('tcs.SessionStatus','!=',2);
		$activecourse = $this->db->get('tblcourseinstructor as tci');

		$allLearnerData['activecourse'] = $activecourse->result()[0]->activecourse;
		/*################ GET   ACTIVE COURSE END ##############*/

	/*################ GET RECENT ACTIVITY START ##############*/
	$this->db->select('tal.Module,tal.Activity,tal.CreatedOn');
	$this->db->where('tal.UserId',$UserId);
	$this->db->order_by('ActivityLogId','desc');
	$this->db->limit(5);
	$recentactivity = $this->db->get('tblactivitylog tal');

	$allLearnerData['recentactivity'] = $recentactivity->result();

/*################ GET RECENT ACTIVITY END ##############*/

		/*################ GET  COMPLETED COURSE START ##############*/
		$this->db->select('count(tci.CourseSessionId) as completedcourse');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->where('tci.UserId',$UserId);
		$this->db->where('tcs.SessionStatus',2);
		$completedcourse = $this->db->get('tblcourseinstructor as tci');

		$allLearnerData['completedcourse'] = $completedcourse->result()[0]->completedcourse;
		/*################ GET  COMPLETED COURSE END ##############*/

		/*################ GET COURSE VIEW START ##############*/
		$this->db->select('count(tci.CourseSessionId) as courseview,tcs.SessionStatus');
		$this->db->join('tblcoursesession tcs','tci.CourseSessionId=tcs.CourseSessionId');
		$this->db->where('tci.UserId',$UserId);
		$this->db->group_by('tcs.SessionStatus');
		$this->db->order_by('tci.CourseSessionId','desc');
		$learnercourseView = $this->db->get('tblcourseinstructor as tci');

		$allLearnerData['courseview'] = $learnercourseView->result();

		/*################ GET COURSE VIEW END ##############*/

		/*################ GET YOUR COURSES START ##############*/
		// SELECT  tcur.CourseSessionId,tc.CourseFullName,tc,CourseId,tci.UserId,tu.FirstName,tu.LastName FROM tblcourseuserregister tcur
		// INNER JOIN tblcoursesession tcs ON tcur.CourseSessionId=tcs.CourseSessionId
		// INNER JOIN tblcourse tc ON tcs.CourseId=tc.CourseId
		// INNER JOIN tblcourseinstructor tci ON tcur.CourseSessionId=tci.CourseSessionId
		// INNER JOIN tbluser tu ON tci.UserId=tu.UserId
		// WHERE tcur.UserId = 484

		// $this->db->select('tcur.CourseSessionId,tc.CourseFullName,tc.CourseId,tci.UserId,tu.FirstName,tu.LastName');
		// $this->db->join('tblcoursesession tcs','tcur.CourseSessionId=tcs.CourseSessionId');
		// $this->db->join('tblcourse tc','tcs.CourseId=tc.CourseId');
		// $this->db->join('tblcourseinstructor tci','tcur.CourseSessionId=tci.CourseSessionId');
		// $this->db->join('tbluser tu','tci.UserId=tu.UserId');
		// $this->db->where('tcur.UserId',$UserId);
		// $yourcourse = $this->db->get('tblcourseuserregister tcur');
		$yourcourse = $this->db->query(
			"SELECT `tcur`.`CourseSessionId`, `tc`.`CourseFullName`, `tc`.`CourseId`, `tci`.`UserId`,
			(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId =tc.CourseId) as ratingavg,
			(SELECT GROUP_CONCAT( CONCAT(u.FirstName ,' ',u.LastName)  SEPARATOR ',')
									  FROM tbluser u 
									  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(tci.UserId))) as FirstName
			FROM `tblcourseuserregister` `tcur`
			JOIN `tblcoursesession` `tcs` ON `tcur`.`CourseSessionId`=`tcs`.`CourseSessionId`
			JOIN `tblcourse` `tc` ON `tcs`.`CourseId`=`tc`.`CourseId`
			JOIN `tblcourseinstructor` `tci` ON `tcur`.`CourseSessionId`=`tci`.`CourseSessionId`
			JOIN `tbluser` `tu` ON `tci`.`UserId`=`tu`.`UserId`
			WHERE `tcur`.`UserId` = ".$UserId." AND `tci`.`Approval` = 1 GROUP by `tcur`.`CourseSessionId`"
		);
		$allLearnerData['yourcourse'] = $yourcourse->result();
		/*################ GET YOUR COURSES END ##############*/

		/*################ GET TEST SCORE START ##############*/
		$this->db->select('tmr.ResultId,tmr.LearnerId,tmr.CourseSessionId,tmr.Result,tmr.CreatedOn');
	
		$testdata = $this->db->get('tblmstresult tmr');

		$allLearnerData['testdata'] = $testdata->result();

		return $allLearnerData;
		/*################ GET YOUR COURSES END ##############*/
	}

	/*################ GET LEARNER DASHBOARD END ##############*/
}
