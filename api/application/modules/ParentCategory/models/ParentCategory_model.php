<?php

class ParentCategory_model extends CI_Model
{
			
	public function add_Category($post_Category)
	{	try{
		
		if($post_Category['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
			$Category_data = array(
				'ParentId' => 0,
				'CategoryName' => $post_Category['CategoryName'],
				'CategoryCode' => $post_Category['CategoryCode'],
				'Description' => $post_Category['Description'],
				'IsActive' => $IsActive,
				'CreatedBy' => $post_Category['CreatedBy'],
				'CreatedOn' => date('y-m-d H:i:s'),
				'UpdatedBy' => $post_Category['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s')
			);
				
				// $res=$this->db->insert('tblmstcategory',$Category_data);
				$res=$this->db->query('call addParentCategory(?,?,?,?,?,?,?,?,?)',$Category_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					// $log_data = array(
					// 	'UserId' => trim($post_Category['CreatedBy']),
					// 	'Module' => 'Category',
					// 	'Activity' =>'Add'
		
					// );
					// $log = $this->db->insert('tblactivitylog',$log_data);
					return true;
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
	
	public function get_Categorydata($Category_id=Null)
	{
		try {
	  if($Category_id)
	  {

		//  $this->db->select('cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive');
		// // $this->db->order_by('cp.Name','asc');

		//  $this->db->where('CategoryId',$Category_id);
		//  $result=$this->db->get('tblmstcategory cp');
		$result=$this->db->query('call getParentCategoryById(?)',$Category_id);
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
	
	 public function edit_Category($post_Category)
	 {
		try
		{
		if($post_Category) {
			if($post_Category['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					
			
			$Category_data = array(
				'CategoryId' => $post_Category['CategoryId'],
				'ParentId' => 0,
				'CategoryName' => $post_Category['CategoryName'],
				'CategoryCode' => $post_Category['CategoryCode'],
				'Description' => $post_Category['Description'],
				'IsActive' => $IsActive,
				'UpdatedBy' =>trim($post_Category['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
				
			);
			$res=$this->db->query('call updateCategory(?,?,?,?,?,?,?,?)',$Category_data);
			// $this->db->where('CategoryId',trim($post_Category['CategoryId']));
			// $res = $this->db->update('tblmstcategory',$Category_data);

			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			if($res) 
			{	
				$log_data = array(
					'UserId' =>trim($post_Category['UpdatedBy']),
					'Module' => 'ParentCategory',
					'Activity' =>'Update'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else
				{
				 return false;
			    }
			}
			else 
			{
				return false;
			}
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}		
	
	}
	
	function getlist_Category()
	{
		
	

try{
		// $this->db->select('cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive,in.CategoryName as parentName');
		//  //$this->db->select('cp.CategoryId,cp.ParentId,cp.Name,cp.EmailAddressCom,cp.Address,cp.IndustryId,cp.Website,cp.PhoneNo,cp.IsActive,in.IndustryName');
		//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.ParentId', 'left');
		// $result = $this->db->get('tblmstcategory cp');
		$result=$this->db->query('call getParentCategories()');
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

	


	public function delete_Category($post_Category) 
	{
	 try{
		if($post_Category) 
		{
			$id=$post_Category['id'];
			// $this->db->where('CategoryId',$post_Category['id']);
			// $res = $this->db->delete('tblmstcategory');
			$res=$this->db->query('call deleteCategory(?)',$id);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_Category['Userid']),
					'Module' => 'Category',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
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
				);			
				$this->db->where('CategoryId',trim($post_data['CategoryId']));
				$res = $this->db->update('tblmstcategory',$data);
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
			}	}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}
		
	
	
	
	//list Industry
	
	
}