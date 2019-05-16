<?php

class Addresses_model extends CI_Model
{
			
	public function add_addresses($post_addresses)
	{	
		if($post_addresses['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

		if(isset($post_addresses['Address2']) && $post_addresses['Address2']!=null )
		{
			$Address2 =$post_addresses['Address2'];
		} else {
			$Address2 = Null;
		}

		if($post_addresses)
		{
			$addresses_data = array(
				'Address1' => trim($post_addresses['Address1']),
				'Address2' => trim($Address2),
				'City' => trim($post_addresses['City']),
				'ZipCode' => trim($post_addresses['ZipCode']),
				'IsActive' => trim($IsActive),
				'CreatedBy' => trim($post_addresses['CreatedBy']),
				'CreatedOn' => date('y-m-d H:i:s')
			);
				
				$res=$this->db->insert('tblmstaddresses',$addresses_data);
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_addresses['CreatedBy']),
						'Module' => 'Address',
						'Activity' =>'Add'
		
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
	
	public function get_addressesdata($Addresses_Id=Null)
	{
	  if($Addresses_Id)
	  {

		 $this->db->select('*');
		 $this->db->order_by('Name','asc');
		 $this->db->where('AddressesId',$Addresses_Id);
		 $result=$this->db->get('tblmstaddresses');
		 $addresses_data= array();
		 foreach($result->result() as $row)
		 {
			$addresses_data=$row;
			
		 }
		 return $addresses_data;
		 
	  }
	  else
	  {
		  return false;
	  }
	}
	
	 public function edit_addresses($post_addresses)
	 {
		
		if($post_addresses) 
		{

			if($post_addresses['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

		if(isset($post_addresses['Address2']) && $post_addresses['Address2']!=null )
		{
			$Address2 =$post_addresses['Address2'];
		} else {
			$Address2 = Null;
		}

		if($post_addresses)
		{
			$addresses_data = array(
				'Address1' => trim($post_addresses['Address1']),
				'Address2' => trim($Address2),
				'City' => trim($post_addresses['City']),
				'ZipCode' => trim($post_addresses['ZipCode']),
				'IsActive' => trim($IsActive),
				'UpdatedBy' =>trim($post_addresses['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
				
			);
			
			$this->db->where('AddressesId',trim($post_addresses['AddressesId']));
			$res = $this->db->update('tblmstaddresses',$addresses_data);
			
			if($res) 
			{	
				$log_data = array(
					'UserId' =>trim($post_addresses['UpdatedBy']),
					'Module' => 'Address',
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
	
	  }
	}
	
	function getlist_addresses()
	{
	
		$this->db->select('*'); 
		$this->db->order_by('AddressesId','asc');
		$result = $this->db->get('tblmstaddresses');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}

	
	

	


	public function delete_addresses($post_addresses) 
	{
	
		if($post_addresses) 
		{
			
			$this->db->where('AddressesId',$post_addresses['AddressesId']);
			$res = $this->db->delete('tblmstaddresses');
			
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_addresses['Userid']),
					'Module' => 'Address',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		} 
		else 
		{
			return false;
		}
		
	}
	

	// ** isActive
	public function isActiveChange($post_data) {
	
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
			$this->db->where('AddressesId',trim($post_data['AddressesId']));
			$res = $this->db->update('tblmstaddresses',$data);
			if($res) {
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	
	
}