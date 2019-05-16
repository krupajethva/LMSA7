<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends CI_Controller {


	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Inbox_model');
		
	}


	// **   upload multie file //
	public function uploadFileMulti($iCount)
	{
		if(!empty($iCount))
		{
			if($_FILES)
			{
				for($i=0; $i<$iCount; $i++)
				{
					if(isset($_FILES['Attachment'.$i]) && !empty($_FILES['Attachment'.$i]))
					{
						move_uploaded_file($_FILES["Attachment".$i]["tmp_name"], "../src/assets/AttachmentDocument/".$_FILES["Attachment".$i]["name"]);
						
						//echo json_encode('success');	
					}
				}
						
			} else {
				//echo json_encode('error');
			}
			
		}

		
	}

	 // ** Email add as draft //
	public function addDraft() {	
		$post_Inbox = json_decode(trim(file_get_contents('php://input')), true);
		if($post_Inbox['EmailNotificationId'] > 0){
			$result = $this->Inbox_model->editDraftEmail($post_Inbox);
		}
		else{
				$result = $this->Inbox_model->addDraftEmail($post_Inbox);
		}
				if($result) {
					echo json_encode('success');
				}
				else
				{
					echo json_encode('error');
				}		
	}


	// // ** add To new email inbox
	// public function add1() {

		
				
				
	// 				$EmailNotificationId=37;
					
	// 				// To Emails
	// 				$resultTo=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.ToEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.ToEmailAddress)>0 WHERE find_in_set(aa.UserId, a.ToEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
	// 				$ToEmailAddress11=$resultTo->result();
	// 				$array = array();
	// 				foreach($ToEmailAddress11 as $toEmail)
	// 				{
	// 					array_push($array,$toEmail->EmailAddress);	
	// 				}
	// 				$ToEmailAddressString = implode(",", $array);

	// 				// Cc Emails
	// 				$resultCc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.CcEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.CcEmailAddress)>0 WHERE find_in_set(aa.UserId, a.CcEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
	// 				$CcEmailAddress11=$resultCc->result();
	// 				$array = array();
	// 				foreach($CcEmailAddress11 as $toEmail)
	// 				{
	// 					array_push($array,$toEmail->EmailAddress);	
	// 				}
	// 				$CcEmailAddressString = implode(",", $array);

	// 				// Bcc Emails
	// 				$resultBcc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.BccEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.BccEmailAddress)>0 WHERE find_in_set(aa.UserId, a.BccEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
	// 				$BccEmailAddress11=$resultBcc->result();
	// 				$array = array();
	// 				foreach($BccEmailAddress11 as $toEmail)
	// 				{
	// 					array_push($array,$toEmail->EmailAddress);	
	// 				}
	// 				$BccEmailAddressString = implode(",", $array);
					
				
					
	// 				$config['protocol']='smtp';
	// 				$config['smtp_host']='ssl://smtp.googlemail.com';
	// 				$config['smtp_port']='465';
	// 				$config['smtp_user']='myopeneyes3937@gmail.com';
	// 				$config['smtp_pass']='W3lc0m3@2019';
					
	// 				$config['charset']='utf-8';
	// 				$config['newline']="\r\n";
	// 				$config['mailtype'] = 'html';	
	// 				$this->email->initialize($config);
	// 				//$this->email->attach('../src/assets/AttachmentDocument/1550056467267_22.jpg');
								
						
	// 							$this->email->from('myopeneyes3937@gmail.com', 'LMS');
	// 							$this->email->to($ToEmailAddressString);	
	// 							$this->email->cc($CcEmailAddressString);
	// 							$this->email->bcc($BccEmailAddressString);		
	// 							$this->email->subject('test attach');
	// 							$this->email->message('hiiii');
	// 							if($this->email->send())
	// 							{
	// 								echo json_encode('success');
	// 							}
	// 							else
	// 							{
	// 								echo json_encode('error');
	// 							}
	// 							//echo json_encode($post_Inbox);	
							
	// 					//	echo json_encode('success');
											
	// }


	 // ** new email add // 
	public function add() {	
		$post_Inbox = json_decode(trim(file_get_contents('php://input')), true);		
				$result = $this->Inbox_model->addEmail($post_Inbox);
				if($result) {
					$EmailNotificationId=$result;
					
					// To Emails
					$resultTo=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.ToEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.ToEmailAddress)>0 WHERE find_in_set(aa.UserId, a.ToEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
					$ToEmailAddress11=$resultTo->result();
					$array = array();
					foreach($ToEmailAddress11 as $toEmail)
					{
						array_push($array,$toEmail->EmailAddress);	
					}
					$ToEmailAddressString = implode(",", $array);

					// Cc Emails
					$resultCc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.CcEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.CcEmailAddress)>0 WHERE find_in_set(aa.UserId, a.CcEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
					$CcEmailAddress11=$resultCc->result();
					$array = array();
					foreach($CcEmailAddress11 as $toEmail)
					{
						array_push($array,$toEmail->EmailAddress);	
					}
					$CcEmailAddressString = implode(",", $array);

					// Bcc Emails
					$resultBcc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.BccEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.BccEmailAddress)>0 WHERE find_in_set(aa.UserId, a.BccEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
					$BccEmailAddress11=$resultBcc->result();
					$array = array();
					foreach($BccEmailAddress11 as $toEmail)
					{
						array_push($array,$toEmail->EmailAddress);	
					}
					$BccEmailAddressString = implode(",", $array);
					
				
					$Subject=$post_Inbox['Subject'];
					$MessageBody=$post_Inbox['MessageBody'];

					$this->db->select('Value');
					$this->db->where('Key','EmailFrom');
					$smtp1 = $this->db->get('tblmstconfiguration');	
					foreach($smtp1->result() as $row) {
						$smtpEmail = $row->Value;
					}
					$this->db->select('Value');
					$this->db->where('Key','EmailPassword');
					$smtp2 = $this->db->get('tblmstconfiguration');	
					foreach($smtp2->result() as $row) {
						$smtpPassword = $row->Value;
					}
					$this->db->select('EmailAddress');
					$this->db->where('UserId',$post_Inbox['CreatedBy']);
					$email_info = $this->db->get('tbluser');	
					foreach($email_info->result() as $row) {
						$EmailAddress = $row->EmailAddress;
					}
					
					$config['protocol']=PROTOCOL;
					$config['smtp_host']=SMTP_HOST;
					$config['smtp_port']=SMTP_PORT;
					$config['smtp_user']=$smtpEmail;
					$config['smtp_pass']=$smtpPassword;
					
					$config['charset']='utf-8';
					$config['newline']="\r\n";
					$config['mailtype'] = 'html';	
					$this->email->initialize($config);
					if($post_Inbox['Attachment']!='')
					{
						foreach($post_Inbox['Attachment'] as $filename)
							{
								$this->email->attach('../src/assets/AttachmentDocument/'.$filename);
								
								$body =$MessageBody;
						
								$this->email->from($EmailAddress, 'LMS');
								$this->email->to($ToEmailAddressString);	
								$this->email->cc($CcEmailAddressString);
								$this->email->bcc($BccEmailAddressString);		
								$this->email->subject($Subject);
								$this->email->message($body);
								if($this->email->send())
								{
									//echo json_encode('success');
								}
								//echo json_encode($post_Inbox);	
							
							echo json_encode('success');
							}
					}
					else
					{						
								$body =$MessageBody;
								
								$this->email->from($EmailAddress, 'LMS');
								$this->email->to($ToEmailAddressString);	
								$this->email->cc($CcEmailAddressString);
								$this->email->bcc($BccEmailAddressString);		
								$this->email->subject($Subject);
								$this->email->message($body);
								if($this->email->send())
								{
									//echo json_encode('success');
								}
								//echo json_encode($post_Inbox);	
						
						echo json_encode('success');
					}
				}
				else
				{
					echo json_encode('error');
				}		
	}

		// ** add To new email inbox-Preview
		public function addPreview() {	
			$post_Inbox = json_decode(trim(file_get_contents('php://input')), true);		
					$result = $this->Inbox_model->addEmail($post_Inbox);
					if($result) {
						$EmailNotificationId=$result;
						
						// To Emails
						$resultTo=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.ToEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.ToEmailAddress)>0 WHERE find_in_set(aa.UserId, a.ToEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
						$ToEmailAddress11=$resultTo->result();
						$array = array();
						foreach($ToEmailAddress11 as $toEmail)
						{
							array_push($array,$toEmail->EmailAddress);	
						}
						$ToEmailAddressString = implode(",", $array);
	
						// Cc Emails
						$resultCc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.CcEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.CcEmailAddress)>0 WHERE find_in_set(aa.UserId, a.CcEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
						$CcEmailAddress11=$resultCc->result();
						$array = array();
						foreach($CcEmailAddress11 as $toEmail)
						{
							array_push($array,$toEmail->EmailAddress);	
						}
						$CcEmailAddressString = implode(",", $array);
	
						// Cc Emails
						$resultBcc=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.BccEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.BccEmailAddress)>0 WHERE find_in_set(aa.UserId, a.BccEmailAddress) and a.EmailNotificationId=$EmailNotificationId");
						$BccEmailAddress11=$resultBcc->result();
						$array = array();
						foreach($BccEmailAddress11 as $toEmail)
						{
							array_push($array,$toEmail->EmailAddress);	
						}
						$BccEmailAddressString = implode(",", $array);
						
						$Subject=$post_Inbox['Subject'];
						$MessageBody=$post_Inbox['MessageBody'];
	
						$this->db->select('Value');
						$this->db->where('Key','EmailFrom');
						$smtp1 = $this->db->get('tblmstconfiguration');	
						foreach($smtp1->result() as $row) {
							$smtpEmail = $row->Value;
						}
						$this->db->select('Value');
						$this->db->where('Key','EmailPassword');
						$smtp2 = $this->db->get('tblmstconfiguration');	
						foreach($smtp2->result() as $row) {
							$smtpPassword = $row->Value;
						}
						$this->db->select('EmailAddress');
						$this->db->where('UserId',$post_Inbox['CreatedBy']);
						$email_info = $this->db->get('tbluser');	
						foreach($email_info->result() as $row) {
							$EmailAddress = $row->EmailAddress;
						}
						
						$config['protocol']=PROTOCOL;
						$config['smtp_host']=SMTP_HOST;
						$config['smtp_port']=SMTP_PORT;
						$config['smtp_user']=$smtpEmail;
						$config['smtp_pass']=$smtpPassword;
						
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';	
						$this->email->initialize($config);
						if($post_Inbox['Attachment']!='')
						{		
							foreach($post_Inbox['Attachment'] as $filename)
							{
								$this->email->attach('../assets/AttachmentDocument/'.$filename);
								$body =$MessageBody;
						
								$this->email->from($EmailAddress, 'LMS');
								$this->email->to($ToEmailAddressString);	
								$this->email->cc($CcEmailAddressString);
								$this->email->bcc($BccEmailAddressString);		
								$this->email->subject($Subject);
								$this->email->message($body);
								if($this->email->send())
								{
									//echo json_encode('success');
								}
								//echo json_encode($post_Inbox);	
							
							echo json_encode('success');
							}
						
			
						}
						else
						{
									$body =$MessageBody;
									$this->email->from($EmailAddress, 'LMS');
									$this->email->to($ToEmailAddressString);	
									$this->email->cc($CcEmailAddressString);
									$this->email->bcc($BccEmailAddressString);		
									$this->email->subject($Subject);
									$this->email->message($body);
									if($this->email->send())
									{
										//echo json_encode('success');
									}
									//echo json_encode($post_Inbox);	
							
							echo json_encode('success');
						}
					}
					else
					{
						echo json_encode('error');
					}	
		}
	


		// get id wise Data //
		public function getById($EmailNotificationId = NULL) {
		
			if (!empty($EmailNotificationId)) {
				$data = [];		
				$data = $this->Inbox_model->get_Inboxdata($EmailNotificationId);
				//print_r($data);
				echo json_encode($data);			
			}
		}	

		// ** delete emails
		public function deleteEmails() {
			$post_Email = json_decode(trim(file_get_contents('php://input')), true);		
	
			if ($post_Email) {
				if($post_Email['EmailNotificationId'] > 0){
					$result = $this->Inbox_model->delete_Emails($post_Email);
					if($result) {
						
						echo json_encode("Successfully");
					}
					}
			
				
			} 
				
		}

		public function recoverMail() {
			$post_Email = json_decode(trim(file_get_contents('php://input')), true);		
	
			if ($post_Email) {
				if($post_Email['EmailNotificationId'] > 0){
					$result = $this->Inbox_model->recoverMail($post_Email);
					if($result) {
						
						echo json_encode("Successfully");
					}
					}
			
				
			} 
				
		}
			// ** delete permenant emails
			public function delete() {
				$post_Inbox = json_decode(trim(file_get_contents('php://input')), true);		
		
				if ($post_Inbox) {
					if($post_Inbox['id'] > 0){
						$result = $this->Inbox_model->delete_Inbox($post_Inbox);
						if($result) {
							
							echo json_encode("Delete successfully");
						}
						}
				
					
				} 
					
			}


		// ** delete Multi Emails
		public function deleteMultiEmails() {
			$post_Email = json_decode(trim(file_get_contents('php://input')), true);		
	
			if ($post_Email) {
			
					$result = $this->Inbox_model->delete_MultiEmails($post_Email);
					if($result) {
						
									echo json_encode("Successfully");
								}
					}		
		}
	


	// ** get all list data //
	public function getAllData($user_id=null) {
		
		
		$data['inbox']=$this->Inbox_model->getlist_Inbox($user_id);
		$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		$data['sendbox']=$this->Inbox_model->getlist_Sendbox($user_id);
		$data['draftcount']=$this->Inbox_model->getlist_Draftcount($user_id);
		$data['spam']=$this->Inbox_model->getlist_Spam($user_id);
		$data['draft']=$this->Inbox_model->getlist_Draft($user_id);
		$data['addstar']=$this->Inbox_model->getlist_Addstar($user_id);
		echo json_encode($data);
				
	}

	
	public function listUser() {
		$data=$this->Inbox_model->getlist_user();
		echo json_encode($data);			
	}

	// ** get list spam data //
	public function getAllSpam($user_id=null) {
		$data['spam']=$this->Inbox_model->getlist_Spam($user_id);
		$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		echo json_encode($data);			
	}
	
	// ** get list draft data //
	public function getAllDraft($user_id=null) {
		$data['draft']=$this->Inbox_model->getlist_Draft($user_id);
    	$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		echo json_encode($data);			
	}

     //  get list Inbox data //
	public function getAllInbox($user_id=null) {
		$data['inbox']=$this->Inbox_model->getlist_Inbox($user_id);
		$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		echo json_encode($data);			
	}

	public function getAllSentbox($user_id=null) {
		$data['sendbox']=$this->Inbox_model->getlist_Sendbox($user_id);
		$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		echo json_encode($data);			
	}

	  //  get list Starred data //
	public function getAllStarred($user_id=null) {
		$data['addstar']=$this->Inbox_model->getlist_Addstar($user_id);
		$data['inboxcount']=$this->Inbox_model->getlist_Inboxcount($user_id);
		echo json_encode($data);			
	}
	


	// ** update Multi Email as Unread
	public function updateUnReadMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->unread_MultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}
	


	// ** update send to Multi Email as Unread
	public function updateSendUnReadMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->unread_sendMultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}


	// ** update Multi Email as Read
	public function updateReadMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->read_MultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}

	// ** update Multi Email as Starred
	public function updateStarredMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->addStar_MultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}


	// ** add sendbox to mark as multie sttared
	public function sendupdateStarredMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->addStar_sendMultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}

	// **  Multi Email as Starred
	public function deleteAllPermInbox() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->delete_AllPermInbox($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}

	
	// ** update Multi Email as Important
	public function updateImportantMultiEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
		
				$result = $this->Inbox_model->addImportant_MultiEmails($post_Email);
				if($result) {
					
								echo json_encode("Successfully");
							}
				}		
	}


	

	// ** update Email as Read
	public function updateReadEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
			if($post_Email['EmailNotificationId'] > 0){
				$result = $this->Inbox_model->read_Emails($post_Email);
				if($result) {
					
					echo json_encode("Successfully");
				}
				}
		
			
		} 
			
	}

	// ** update Email as Read only
	public function onlyReadEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
			if($post_Email['EmailNotificationId'] > 0){
				$result = $this->Inbox_model->readOnly_Emails($post_Email);
				if($result) {
					
					echo json_encode("Successfully");
				}
				}
		
			
		} 
			
	}


	// ** update Email as Starred
	public function updateAddStarEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
			if($post_Email['EmailNotificationId'] > 0){
				$result = $this->Inbox_model->addStar_Emails($post_Email);
				if($result) {
					
					echo json_encode("Successfully");
				}
				}
		
			
		} 
			
	}
	
	// ** update Email as Important
	public function updateImportantEmails() {
		$post_Email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Email) {
			if($post_Email['EmailNotificationId'] > 0){
				$result = $this->Inbox_model->addImport_Emails($post_Email);
				if($result) {
					
					echo json_encode("Successfully");
				}
				}
		
			
		} 
			
	}
		
	
	
	
}
