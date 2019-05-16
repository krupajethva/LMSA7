<?php

class Calendar_model extends CI_Model
 {	
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
 }
 ?>