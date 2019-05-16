<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

class CourseScheduler extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CourseScheduler_model');
	}


	
	public function addScheduler()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Course) 
			{ 
					$result = $this->CourseScheduler_model->add_CourseScheduler($post_Course);
					if($result)
					{
						//print_r('success');
					echo json_encode($result);	
					}	
			}
					
			
	}
	public function addSingleSession()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		
		$post_Session=$post_Course['schedularList'];
		if($post_Session['CourseSessionId']>0)
			{ 
				$result = $this->CourseScheduler_model->edit_SingleSession($post_Course);
				if($result)
				{
					//print_r('success');
				echo json_encode($result);	
				}
			}
			else
			{
				$result = $this->CourseScheduler_model->add_SingleSession($post_Course);
				if($result)
				{
					//print_r('success');
				echo json_encode($result);	
				}
			}
					
			
	}
	public function updatePublish()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		
		$post_Session=$post_Course['schedularList'];
		if($post_Session['CourseSessionId']>0)
			{ 
				$result = $this->CourseScheduler_model->edit_updatePublish($post_Course);
				if($result)
				{
					if($post_Session['Check']==1)
					{
						$resultTo=$this->db->query("SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId 
						FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0 WHERE
						 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=$result GROUP BY us.EmailAddress");
						$ToEmailAddress=$resultTo->result();
						$array = array();
						foreach($ToEmailAddress as $toEmail)
						{
							array_push($array,$toEmail->EmailAddress);	
						}
						$ToEmailAddressString = implode(",", $array);
					
						$config['protocol']='smtp';
						$config['smtp_host']='ssl://smtp.googlemail.com';
						$config['smtp_port']='465';
						$config['smtp_user']='myopeneyes3937@gmail.com';
						$config['smtp_pass']='W3lc0m3@2019';	
		
						// $config['protocol']='mail';
						// $config['smtp_host']='vps40446.inmotionhosting.com';
						// $config['smtp_port']='587';
						// $config['smtp_user']=$smtpEmail;
						// $config['smtp_pass']=$smtpPassword;
						
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';							
						$this->email->initialize($config);
						$Subject = 'LMS - Session changes by instructor';
						$body = '<table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px">
						<tbody>
							<tr>
								<td style="background-color:#f3f3f3; background:#f3f3f3; border-bottom:1px solid #333333; padding:10px 10px 5px 10px"><img alt="Learn Feedback" src="'.BASE_URL.'/assets/images/logo.png" /></td>
							</tr>
							<tr>
								<td style="border-width:0; padding:20px 10px 10px 10px; text-align:center">
								<p style="color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;"><strong>Your Course  Changes By Instructor </strong><strong></strong></p>
					
								<p style="color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;">We&rsquo;re so happy you&rsquo;ve joined us.</p>
					
								<p style="color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;">Use the button below to login your account and get started:</p>
								</td>
							</tr>
								<tr>
								<td style="border-width:0; padding:0; text-align:center; vertical-align:middle">
								<table border="0" cellpadding="0" cellspacing="0" style="border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto">
									<tbody>
										<tr>
											<td style="background-color:#b11016; background:#b11016; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px"><a href="{login_link}" style="color:#fff; text-decoration:none;">Get Started</a></td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
								<tr>
								<td style="border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle">			
								<p style="color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;">If you have any questions, you can reply to this email and it will go right to them. Alternatively, feel free to contact our customer success team anytime.</p>
					
								<p style="color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href="{login_link}" style="cursor:pointer;">click here</a></p>
								</td>
							</tr>
							<tr>
								<td style="background-color:#222222; background:#222222; border-top:1px solid #cccccc; color:#ffffff; font-size:13px; padding:7px; text-align:center">Copyright &copy; 2018 Learning Management System</td>
							</tr>
						</tbody>
					</table>';
		
					$body = str_replace("{login_link}",''.BASE_URL.'/login',$body);
		
						$this->email->from('myopeneyes3937@gmail.com', 'LMS');
						$this->email->to($ToEmailAddressString);		
						$this->email->subject($Subject);
						$this->email->message($body);
						if($this->email->send())
						{
							echo json_encode('success');
						}	

					}else
					{
						echo json_encode($result);	
					}
					//print_r('success');

				}
			}
			else
			{
				// $result = $this->CourseScheduler_model->add_Publish($post_Course);
				// if($result)
				// {
				// 	//print_r('success');
				// echo json_encode($result);	
				// }
				echo json_encode('abc');

			}
					
			
	}

	public function getAllDefaultData()
	{

		$data['country']=$this->CourseScheduler_model->getlist_country();
	$data['state']=$this->CourseScheduler_model->getlist_state();
		$data['instructor']=$this->CourseScheduler_model->getlist_instructor();
		$data['instructor1']=$data['instructor'];
		echo json_encode($data);
	}
	public function getStateList($country_id = NULL) {
		
		if(!empty($country_id)) {
			
			$result = [];
			$result = $this->CourseScheduler_model->getStateList($country_id);			
			echo json_encode($result);				
		}			
	}
	public function getById($Course_id=null,$userid=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
	
			//$data['skill']=$this->Course_model->get_skilldata($Course_id);	
			$data['coursesession']=$this->CourseScheduler_model->get_Coursesession($Course_id,$userid);
			mysqli_next_result($this->db->conn_id);
			$data['coursename']=$this->CourseScheduler_model->get_Coursename($Course_id);
		//  print_r($data);
		echo json_encode($data);
		}
	}
	public function deleteScheduler() {
		$post_Scheduler = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Scheduler)
		 {
				$result = $this->CourseScheduler_model->delete_Scheduler($post_Scheduler);
				if($result)
				 {
					echo json_encode("Delete successfully");
				}
		} 
			
	}
	public function addClone() {
		$post_Clone = json_decode(trim(file_get_contents('php://input')), true);		
		$Courseschedular=$post_Clone['schedularList'];
		if ($post_Clone)
		 {
			if($Courseschedular['CourseSessionId'] > 0){
				$result = $this->CourseScheduler_model->Clone_Course($post_Clone);
				if($result) {
					
					echo json_encode($result);
					}
		 	}
		
			
		} 
			
	}
}