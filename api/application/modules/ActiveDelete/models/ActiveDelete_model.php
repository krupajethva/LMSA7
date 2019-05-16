<?php

class ActiveDelete_model extends CI_Model
 {
    public function deleteItem($post_data) {
		try{
		if($post_data) {			
			$data = array(
				'Id' => trim($post_data['id']),
				'UserId' => trim($post_data['Userid']),
				'tableName' => trim($post_data['TableName']),
                'FieldName' => trim($post_data['FieldName']),
                'Module' => trim($post_data['Module'])
			);			
			$res = $this->db->query('call deleteItem(?,?,?,?,?)',$data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				return true;
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

	public function isActiveChange($post_data) {
		try{
		if($post_data) {
			if(trim($post_data['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$data = array(
				'IsActive' => $IsActive,
				'UpdatedBy' => trim($post_data['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s'),
				'tableName' => trim($post_data['TableName']),
				'Id' => trim($post_data['Id']),
                'FieldName' => trim($post_data['FieldName']),
                'Module' => trim($post_data['Module'])
			);			
			$res = $this->db->query('call activeChange(?,?,?,?,?,?,?)',$data);	
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				return true;
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
 }
