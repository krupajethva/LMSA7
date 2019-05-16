<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invitationcode extends CI_Controller {


	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Invitationcode_model');
		
	}

	
	public function code()
		{
								
		$post_Invitation = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_Invitation)
			{
			
				$result = $this->Invitationcode_model->Invitation_code($post_Invitation);
				if($result=='days')
				{
					echo json_encode("days");
				}
				elseif($result=='revoked')
				{
					echo json_encode("revoked");
				}elseif($result=='email')
				{
					echo json_encode("email");
				}
				elseif($result=='code')
				{
					foreach ($result as $users)
					{
						$this->db->select('UserId,EmailAddress');
						$this->db->where('UserId',$users->UserId);
						$this->db->where('EmailAddress',$users->EmailAddress);
						$this->db->get('tbluser');	
						$this->db->limit(1);
						$this->db->from('tbluser');
						$query = $this->db->get();
					
						if ($query->num_rows() == 1) 
						{
							return $query->result();
						
						}
						else
						{
							return false;
						}

					}
					echo json_encode("code");
				}
				else{
					echo json_encode($result);
				}
										
		}
		
	}

	public function getById($User_Id=null)
	{	
		if(!empty($User_Id))
		{
			$data=[];
			$data=$this->Register_model->get_userdata($User_Id);
			echo json_encode($data);
		}
	}
	
}
