<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Login extends CI_Controller {

	public function __construct() {
	
		parent::__construct();
		$this->load->model('Login_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
		
	}
	
	public function check_login() {
		
		$post_login = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_login) {
			$result = $this->Login_model->check_login($post_login);
			if ($result)
			{
				if($result=='Deactive')
				{
					echo json_encode('Deactive');
				}
				else if($result == 'Activation')
				{
					echo json_encode('Activation');
				}
				else
				{
						$token = array(
							"UserId" => $result[0]->UserId,
							"InvitedByUserId" => $result[0]->InvitedByUserId,
							"RoleId" => $result[0]->RoleId,
							"EmailAddress" => $result[0]->EmailAddress,
							"FirstName" => $result[0]->FirstName,
							"LastName" => $result[0]->LastName,
							"IsActive" => $result[0]->IsActive
						);

						$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
						$output['token'] = $jwt;
						echo json_encode($output);	
			   }
			}
			else
			{
				return $this->output
				->set_IsStatus_header(404)
				->set_output(json_encode(array(
						'text' => 'Invalid username or password.',
						'type' => 'danger'
				)));
			}
		}
	}


	public function logout($userid = NULL) {		

		if (!empty($userid)) {
			$login_data = array(
				'UserId ' => $userid,
				'LoginType' => 0,
				'PanelType' => 1				
			);
			$res = $this->db->insert('tblloginlog',$login_data);
			echo json_encode('success');	
		}	
	}

}