<?php

class Badges_model extends CI_Model
{
			
	public function add_badges($post_Badges)
	{	
		try{
		if($post_Badges)
		{
		if($post_Badges['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					
				
					$image_data = array(
						'InstructorId' => $post_Badges['CreatedBy'],
						'FilePath' => $post_Badges['BadgeImage'],
						'Dataurl' => $post_Badges['Dataurl'],
						'Keyword' => "DefalutBadges",
						'IsActive'=>$IsActive,
						'CreatedBy' => $post_Badges['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
							);
						$res=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
						 $out_param_query = $this->db->query('select @id as out_param;');
						$id=$out_param_query->result()[0]->out_param;

			 $out_param_query = $this->db->query('select @id as out_param;');
			$id=$out_param_query->result()[0]->out_param;
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Badges['CreatedBy']),
						'Module' => 'Default Badges',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					return $id;
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
	public function edit_badges($post_Badges)
	{	
		try{
		if($post_Badges)
		{
		if($post_Badges['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					
				
					$image_data = array(
						'InstructorId' => $post_Badges['UpdatedBy'],
						'FilePath' => $post_Badges['BadgeImage'],
						'Dataurl' => $post_Badges['Dataurl'],
						'Keyword' => "DefalutBadges",
						'IsActive'=>$IsActive,
						'UpdatedBy' => $post_Badges['UpdatedBy'],
						'UpdatedOn' => date('y-m-d H:i:s')
							);
							$this->db->where('ResourcesId',trim($post_Badges['ResourcesId']));
							$res = $this->db->update('tblresources',$image_data);

			 $out_param_query = $this->db->query('select @id as out_param;');
			$id=$out_param_query->result()[0]->out_param;
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Badges['UpdatedBy']),
						'Module' => 'Default Badges',
						'Activity' =>'update'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
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
	public function get_badgedata($Badge_id=Null)
	{
		try {
	  if($Badge_id)
	  {

		$result=$this->db->query('SELECT 
		res.FilePath as BadgeImage,res.InstructorId as rid,res.ResourcesId,res.IsActive
		from tblresources as res where res.ResourcesId ='.$Badge_id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$badge_data = array();
		foreach($result->result() as $row)
		 {
			$badge_data=$row;
		
	 	}
		 return $badge_data;
		 
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
	function getlist_Badges()
	{
		
	

try{
		// $this->db->select('cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive,in.CategoryName as parentName');
		//  //$this->db->select('cp.CategoryId,cp.ParentId,cp.Name,cp.EmailAddressCom,cp.Address,cp.IndustryId,cp.Website,cp.PhoneNo,cp.IsActive,in.IndustryName');
		//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.ParentId', 'left');
		// $result = $this->db->get('tblmstcategory cp');
		$result=$this->db->query('SELECT res.FilePath as BadgeImage,res.InstructorId as rid,res.ResourcesId,res.IsActive
		from tblresources as res where res.Keyword="DefalutBadges"');
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
	public function delete_badge($post_Category) 
	{
	 try{
		if($post_Category) 
		{
			//$id=$post_Category['ResourcesId'];
			$this->db->where('ResourcesId',$post_Category['id']);
			$res = $this->db->delete('tblresources');
		
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_Category['UpdatedBy']),
					'Module' => 'Default Badge',
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
			$this->db->where('ResourcesId',trim($post_data['ResourcesId']));
			$res = $this->db->update('tblresources',$data);
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
	
}
