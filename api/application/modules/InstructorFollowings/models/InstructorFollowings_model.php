<?php
class InstructorFollowings_model extends CI_Model
{

	function getAllFollowings($InstructorId = NULL)
	{
		try {
			if ($InstructorId) {
				$result = $this->db->query('SELECT FIND_IN_SET(' . $InstructorId . ', tif.FollowerUserId) as flag,tif.InstructorUserId  FROM `tblinstructorfollowers` `tif`');

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$allUsers = array();
				if ($result->result()) {
					foreach ($result->result() as $row1) {
						if ($row1->flag != 0) {
							$this->db->select("UserId,CONCAT(FirstName, '  ',LastName ) AS `Name`,Title,EmailAddress,PhoneNumber");
							$this->db->where('UserId', $row1->InstructorUserId);
							$this->db->from('tbluser');
							$result = $this->db->get();
							$res = $result->result();
							array_push($allUsers, $res[0]);
						}
					}
				}
				return $allUsers;
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
}
