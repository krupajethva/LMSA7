<?php

class InstructorFollowers_model extends CI_Model
{

	public function get_Followerdata($FollowerId = Null)
	{
		try {
			if ($FollowerId) {
				$this->db->select('*');
				$this->db->where('UserId', $FollowerId);
				$result = $this->db->get('tbluser u');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$Follower_data = array();
				foreach ($result->result() as $row) {
					$Follower_data = $row;
				}
				return $Follower_data;
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}


	function getAllFollowers($InstructorId = NULL)
	{
		try {
			if ($InstructorId) {
				$result = $this->db->query(
					"SELECT u.UserId,CONCAT(u.FirstName,' ',u.LastName) as Name,u.Title,u.EmailAddress,u.PhoneNumber FROM tbluser u, tblinstructorfollowers i
		WHERE FIND_IN_SET(u.UserId, i.FollowerUserId) and i.InstructorUserId=" . $InstructorId
				);

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
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	function followInstructor($post_followInstructor)
	{
		try {
			if ($post_followInstructor) {
				$InstructorId = $post_followInstructor['InstructorId'];
				$LearnerId = $post_followInstructor['LearnerId'];

				$this->db->select('tif.InstructorUserId,tif.FollowerUserId');
				$this->db->from('tblinstructorfollowers tif');
				$this->db->where('tif.InstructorUserId', $InstructorId);
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$result = $query->result();
					$FollowerUserId = $result[0]->FollowerUserId;
					if ($FollowerUserId != '') {
						$FollowerIds  =  $FollowerUserId . ',' . $LearnerId;
					} else {
						$FollowerIds = $LearnerId;
					}
					$data = array(
						'InstructorUserId' => $InstructorId,
						'FollowerUserId' => $FollowerIds,
						'IsActive' => 1
					);
					$this->db->where('InstructorUserId', $InstructorId);
					$res = $this->db->update('tblinstructorfollowers', $data);
				} else {
					$data = array(
						'InstructorUserId' => $InstructorId,
						'FollowerUserId' => $LearnerId,
						'IsActive' => 1
					);
					$res = $this->db->insert('tblinstructorfollowers', $data);
				}


				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {
					$log_data = array(
						'UserId' => trim($post_followInstructor['LearnerId']),
						'Module' => 'Instructor',
						'Activity' => 'Follow Instructor'
					);
					$log = $this->db->insert('tblactivitylog', $log_data);
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

	function unfollowInstructor($post_unfollowInstructor)
	{
		try {
			if ($post_unfollowInstructor) {
				$InstructorId = $post_unfollowInstructor['InstructorId'];
				$LearnerId = $post_unfollowInstructor['LearnerId'];

				$res = $this->db->query("UPDATE tblinstructorfollowers SET FollowerUserId=replace(FollowerUserId,'" . $LearnerId . ",',''),FollowerUserId=replace(FollowerUserId,'," . $LearnerId . "',''),FollowerUserId=replace(FollowerUserId,'" . $LearnerId . "','') WHERE InstructorUserId=" . $InstructorId);

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {
					$log_data = array(
						'UserId' => trim($post_unfollowInstructor['LearnerId']),
						'Module' => 'Instructor',
						'Activity' => 'Unfollow Instructor'
					);
					$log = $this->db->insert('tblactivitylog', $log_data);
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
	function getFollowerDetails($post_data)
	{
		try {
			if ($post_data) {
				$this->db->select('FIND_IN_SET(' . $post_data['LearnerId'] . ',tif.FollowerUserId) as flag,tif.FollowerUserId,tif.InstructorUserId');
				$this->db->from('tblinstructorfollowers tif');
				$this->db->join('tbluser u', 'tif.FollowerUserId = u.UserId', 'inner');
				$this->db->where('tif.InstructorUserId', $post_data['InstructorId']);
				$result = $this->db->get();

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				$total = [];
				if ($result->result()) {
					foreach ($result->result() as $row) {
						//totalFollower
						$res['flag'] = $row->flag;
						if ($row->FollowerUserId != '') {
							$total = explode(',', $row->FollowerUserId);
						}
						$res['totalFollowers'] = count($total);
						//totalfollowing
						if ($row->InstructorUserId != '') {
							$result = $this->db->query('SELECT FIND_IN_SET(' . $row->InstructorUserId . ', tif.FollowerUserId) as flag FROM `tblinstructorfollowers` `tif`');
							$count = 0;
							if ($result->result()) {
								foreach ($result->result() as $row1) {
									if ($row1->flag != 0) {
										$count = $count + 1;
									}
								}
							}
							$res['totalFolloings']  = $count;
						} else {
							$res['totalFolloings'] = 0;
						}
						//Rating and Review
						if ($row->InstructorUserId != '') {
							$this->db->select('ROUND(AVG(Rating)) as Rating,count(ReviewId) as Reviews');
							$this->db->from('tblcoursereview');
							$this->db->where('UserId', $row->InstructorUserId);
							$this->db->group_by('UserId');
							$totalrating = $this->db->get()->result()[0];

							$res['Ratings'] = $totalrating->Rating;
							$res['Reviews'] = $totalrating->Reviews;
						} else {
							$res['Ratings'] = 0;
							$res['Reviews'] = 0;
						}
						//totalcourse 
						if ($row->InstructorUserId != '') {
							$this->db->select('tc.CourseFullName,tc.CourseId,tc.Description,ROUND(AVG(tr.Rating)) as Rating,count(tr.ReviewId) as Reviews,tc.Keyword');
							$this->db->join('tblcoursesession ts', 'tbc.CourseSessionId=ts.CourseSessionId');
							$this->db->join('tblcourse tc', 'ts.CourseId=tc.CourseId');
							$this->db->join('tblcoursereview tr','tc.CourseId=tr.CourseId','left');
							$this->db->from('tblcourseinstructor tbc');
							$this->db->where('tbc.UserId', $row->InstructorUserId);
							$this->db->Group_by("tc.CourseId");
							$totalcourse = $this->db->get()->result();
							$res['totalcoursesdetails'] = $totalcourse;

						
						
						} else { }

						array_push($res, $row);
						return $res;
					}
				} else {
					return null;
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getInstructorDetails($post_data)
	{
		try {
			if ($post_data) {
				$this->db->select('u.UserId,u.FirstName,u.LastName,u.EmailAddress,u.ProfileImage,el.Education,u.Biography');
				$this->db->from('tbluser u');
				$this->db->join('tbluserdetail ud', 'ud.UserDetailId = u.UserDetailId', 'left');
				$this->db->join('tblmsteducationlevel el', 'el.EducationLevelId = ud.EducationLevelId', 'left');
				$this->db->where('u.UserId', $post_data['InstructorId']);
				$result = $this->db->get();

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				foreach ($result->result() as $row) {
					$res = $row;
				}
				return $res;
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getActiveCourses($post_data)
	{
		try {
			if ($post_data) {
				$this->db->select('c.CourseId,c.CourseFullName,c.Description,rs.InstructorId,rs.FilePath,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId = c.CourseId) as reviewavg');
				$this->db->join('tblcoursesession cs', 'cs.CourseSessionId = tci.CourseSessionId', 'left');
				$this->db->join('tblcourse c', 'c.CourseId = cs.CourseId', 'left');
				$this->db->join('tblresources rs', 'rs.ResourcesId = c.CourseImageId', 'left');
				$this->db->where('tci.UserId', $post_data['InstructorId']);
				$this->db->where('cs.PublishStatus!=', 0);
				$this->db->group_by('c.CourseId');
				$this->db->from('tblcourseinstructor tci');
				$result = $this->db->get();

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
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	function getAllInstructors($post_data)
	{
		try {
			if ($post_data) {
				$this->db->select('FIND_IN_SET(' . $post_data['LearnerId'] . ',tif.FollowerUserId) as flag,u.UserId,u.FirstName,u.LastName,u.ProfileImage,u.Biography,tif.FollowerUserId,tif.InstructorUserId');
				$this->db->join('tblinstructorfollowers tif', 'tif.InstructorUserId = u.UserId', 'left');
				$this->db->from('tbluser u');
				$this->db->where('u.RoleId', 3);
				$result = $this->db->get();
				//$q = $this->db->last_query();

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$res = array();
				foreach ($result->result() as $row) {
					$total = [];
					if ($row->FollowerUserId != '') {
						$total = explode(',', $row->FollowerUserId);
						$row->totalFollowers = count($total);
					} else {
						$row->totalFollowers = 0;
					}
					//following
					if ($row->UserId != '') {
						$result = $this->db->query('SELECT FIND_IN_SET(' . $row->UserId . ', tif.FollowerUserId) as flag FROM `tblinstructorfollowers` `tif`');
						// $res = array();
						$count = 0;
						if ($result->result()) {
							foreach ($result->result() as $row1) {
								if ($row1->flag != 0) {
									$count = $count + 1;
								}
							}
						}
						$row->totalFolloings = $count;
					} else {
						$row->totalFolloings = 0;
					}
					//last course
					if ($row->UserId != '') {
						$result = $this->db->query('SELECT `tbc`.`CourseId`, `tbc`.`CourseFullName`
						FROM `tblcourseinstructor` `tc`
						JOIN `tblcoursesession` `ts` ON `tc`.`CourseSessionId`=`ts`.`CourseSessionId`
						JOIN `tblcourse` `tbc` ON `tbc`.`CourseId`=`ts`.`CourseId`
						WHERE `tc`.`UserId` = ' . $row->UserId . '
						ORDER BY `ts`.`EndDate` DESC
						 LIMIT 1');
						if ($result->result()) {
							foreach ($result->result() as $row1) {
								$row->lastcourse = $row1->CourseFullName;
							}
						} else {
							$row->lastcourse = '';
						}
					}
					array_push($res, $row);
				}
				return $res;
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	function SearchInstructor($data = NULL)
	{
		try {
			$this->db->select('FIND_IN_SET(' . $data['user'] . ',tif.FollowerUserId) as flag,u.UserId,u.FirstName,u.LastName,u.ProfileImage,u.Biography,tif.FollowerUserId,tif.InstructorUserId');
			$this->db->join('tblinstructorfollowers tif', 'tif.InstructorUserId = u.UserId', 'left');
			$this->db->from('tbluser u');
			$this->db->where('u.RoleId', 3);
		
			if ($data['Name'] != null) {
				// query to get user ids based on coursename and use user ids in main query search
				$likeResult = $this->db->query("
				SELECT `tc`.`UserId`, max(`ts`.`EndDate`)
				FROM `tblcourseinstructor` `tc`
				JOIN `tblcoursesession` `ts` ON `tc`.`CourseSessionId`=`ts`.`CourseSessionId`
				JOIN `tblcourse` `tbc` ON `tbc`.`CourseId`=`ts`.`CourseId`
				JOIN `tbluser` `u` ON `tc`.`UserId`=`u`.`UserId`
				WHERE `u`.`RoleId` = 3 AND tbc.CourseFullName LIKE '%" . $data['Name'] . "%'
				GROUP BY `u`.`UserId`");
				$finalResult = $likeResult->result();
				$userArr = array(); //user ids that have course name like passed name
				foreach ($finalResult as $finalResultRow) {
					$userArr[] = $finalResultRow->UserId;
				};
				// end of coursename search and we got user ids array, use this in main condition

				$this->db->where(
					"
				u.FirstName LIKE '%" . $data['Name'] . "%'
				OR u.LastName LIKE '%" . $data['Name'] . "%'
				"
				);
				if (count($userArr) > 0) {
					$this->db->or_where_in('u.UserId', $userArr);
				}
			}

			$this->db->group_by('u.UserId, tif.FollowerUserId');
			$result = $this->db->get();
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			foreach ($result->result() as $row) {
				$total = [];
				if ($row->FollowerUserId != '') {
					$total = explode(',', $row->FollowerUserId);
					$row->totalFollowers = count($total);
				} else {
					$row->totalFollowers = 0;
				}
				//following
				if ($row->UserId != '') {
					$result = $this->db->query('SELECT FIND_IN_SET(' . $row->UserId . ', tif.FollowerUserId) as flag FROM `tblinstructorfollowers` `tif`');
					// $res = array();
					$count = 0;
					if ($result->result()) {
						foreach ($result->result() as $row1) {
							if ($row1->flag != 0) {
								$count = $count + 1;
							}
						}
					}
					$row->totalFolloings = $count;
				} else {
					$row->totalFolloings = 0;
				}
				array_push($res, $row);
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function test()
	{
		$this->db->select("tbc.CourseId,tbc.CourseFullName, u.UserId, CONCAT(u.FirstName,' ',u.LastName) as Name, max(EndDate)");
		$this->db->join('tblcoursesession ts', 'tc.CourseSessionId=ts.CourseSessionId');
		$this->db->join('tblcourse tbc', 'tbc.CourseId=ts.CourseId');
		$this->db->join('tbluser u', 'tc.UserId=u.UserId');
		$this->db->from('tblcourseinstructor tc');
		$this->db->group_by('tbc.CourseId');
		$this->db->group_by('u.UserId');
		$this->db->where('u.RoleId', 3);
		$this->db->get();
		$q = $this->db->last_query();
		echo $q;
		exit;
		//return $res;
	}
}
