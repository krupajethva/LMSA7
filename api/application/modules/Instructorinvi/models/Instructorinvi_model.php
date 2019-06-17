<?php

class Instructorinvi_model extends CI_Model
{
	public function add_Instructor($post_Instructor)
	{
		try {
			if ($post_Instructor) {
				foreach ($post_Instructor['UserId'] as $row) {
					$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$ress = "";
					for ($i = 0; $i < 6; $i++) {
						$ress .= $chars[mt_rand(0, strlen($chars) - 1)];
					}
					$post_Instructor['Code'] = $ress;
					$Instructor_data = array(
						'CourseId' => $post_Instructor['CourseId'],
						'UserId' => $row,
						'Code' => $post_Instructor['Code'],
						'CreatedBy' => $post_Instructor['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
					);
					$res = $this->db->insert('courseinstructorinvitation', $Instructor_data);
				}
				if ($res) {
					return true;
				} else {
					return false;
				}
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
	function getlist_course()
	{
		try {
			$this->db->select('con.CourseId,con.InstructorId,con.CourseFullName');
			$result = $this->db->get('tblcourse as con');
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
	//list Industry
	function getlist_instructor()
	{
		try {
			$this->db->select('con.RoleId,con.UserId as value,con.FirstName as label,con.LastName,con.EmailAddress');
			$result = $this->db->get('tbluser as con');
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
	function get_instructorinvi()
	{
		try {
			$this->db->select('con.InvitationId,con.CourseId,con.Code,con.UserId,con.Approval,cp.CourseFullName,us.FirstName');
			$this->db->join('tblcourse cp', 'cp.CourseId = con.CourseId', 'left');
			$this->db->join('tbluser us', 'us.UserId = con.UserId', 'left');
			$result = $this->db->get('courseinstructorinvitation as con');
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
	public function ReInvite_Instructor($post_Instructor)
	{
		if ($post_Instructor) {
			$Instructor_data = array(
				'Approval' => 1,
				'Code' => trim($post_Instructor['Code']),
				'UpdatedBy' => trim($post_Instructor['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
			);
			$this->db->where('InvitationId', $post_Instructor['InvitationId']);
			$res = $this->db->update('courseinstructorinvitation', $Instructor_data);
			if ($res) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function EditInstRequest($type, $CourseSessionId, $UserId)
	{
		if ($type) {
			$Instructor_data = array(
				'Approval' => $type,
				'UpdatedBy' => $UserId,
				'UpdatedOn' => date('y-m-d H:i:s')
			);
			$this->db->where('CourseSessionId', $CourseSessionId);
			$this->db->where('UserId', $UserId);
			$res = $this->db->update('tblcourseinstructor', $Instructor_data);
			if ($res) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function Instructor_List($type, $CourseSessionId)
	{
		if ($type) {
			$this->db->select('UserId');
			$this->db->where('CourseSessionId', $CourseSessionId);
			$res = $this->db->get('tblcourseuserregister');
			if ($res) {
				return true;
			} else {
				return false;
			}

			$this->db->select('UserId');
			$this->db->where('CourseSessionId', $CourseSessionId);
			$res1 = $this->db->get('tblcourseuserregister');

		} else {
			return false;
		}
	}
}
