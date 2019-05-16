<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {


    public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Announcement_model');
		
    }
    public function getAnnouncementTypes() {
		
		$data=$this->Announcement_model->getAnnouncementTypes();		
		echo json_encode($data);
				
	}
	public function getAnnouncementAudience() {
		
		$data=$this->Announcement_model->getAnnouncementAudience();		
		echo json_encode($data);
				
	}
	public function getAnnouncements($Id = NULL) {
		if (!empty($Id)) {
		$data=$this->Announcement_model->getAnnouncements($Id);		
		echo json_encode($data);
		}
				
    }
    public function addAnnouncement()
		{
			$post_announce = json_decode(trim(file_get_contents('php://input')), true);	
			if ($post_announce) {
				if($post_announce['AnnouncementId'] > 0){
					$result = $this->Announcement_model->editAnnouncement($post_announce);
					$EmailToken = 'Announcement Update';
				}
				else{
					$result = $this->Announcement_model->addAnnouncement($post_announce);
					$EmailToken = 'Announcement Generate';
				}
					if($result) {
						$AudienceUserIds=$result;
						foreach($AudienceUserIds as $id){
							$userId=$id;
							$userId_backup=$userId;
				
				$this->db->select('Value');
				$this->db->where('Key','EmailFrom');
				$smtp1 = $this->db->get('tblmstconfiguration');	
				foreach($smtp1->result() as $row) {
					$smtpEmail = $row->Value;
					//mysqli_free_result($smtp1);
				}
				
				$this->db->select('Value');
				$this->db->where('Key','EmailPassword');
				$smtp2 = $this->db->get('tblmstconfiguration');	
				foreach($smtp2->result() as $row) {
					$smtpPassword = $row->Value;
				}

				 $config['protocol']='smtp';
				 $config['smtp_host']='ssl://smtp.googlemail.com';
				 $config['smtp_port']='465';
				 $config['smtp_user']='myopeneyes3937@gmail.com';
				 $config['smtp_pass']='W3lc0m3@2018';

				// $config['protocol']='mail';
				// $config['smtp_host']='vps40446.inmotionhosting.com';
				// $config['smtp_port']='587';
				// $config['smtp_user']=$smtpEmail;
				// $config['smtp_pass']=$smtpPassword;
				
				$config['charset']='utf-8';
				$config['newline']="\r\n";
				$config['mailtype'] = 'html';							
				$this->email->initialize($config);
		
				$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && 'IsStatus' = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && 'IsStatus' = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && 'IsStatus' = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
				foreach($query->result() as $row){ 
					if($row->To==4){
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
						$rowTo = $queryTo->result();
						$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
						$body = $row->EmailBody;
						// foreach($query1->result() as $row1){			
						// 	$query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblmstcountry AS con ON st.CountryId = con.CountryId LEFT JOIN tblcompany AS com ON tn.UserId = com.UserId WHERE tn.UserId = '.$userId);
						// 	$result2 = $query2->result();
						// 	$body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
						// } 
						if($row->BccEmail!=''){
							$bcc = $row->BccEmail.','.$row->totalbcc;
						} else {
							$bcc = $row->totalbcc;
						}

						$body = str_replace("{title}",$post_announce['Title'],$body);
						$body = str_replace("{start_date}",$post_announce['StartDate'],$body);
						$body = str_replace("{end_date}",$post_announce['EndDate'],$body);
						$body = str_replace("{location}",$post_announce['Location'],$body);
						$body = str_replace("{organizer}",$post_announce['Organizer'],$body);
						$body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);

						$this->db->select('TypeName');
						$this->db->where('AnnouncementTypeId',$post_announce['AnnouncementTypeId']);
						$typedata = $this->db->get('tblannouncementtype');	
						foreach($typedata->result() as $row1) {
							$typename = $row1->TypeName;
						}

						$body = str_replace("{announcement_type}",$typename,$body);

						$this->email->from($smtpEmail, 'LMS');
						$this->email->to($rowTo[0]->EmailAddress);		
						$this->email->subject($row->Subject);
						$this->email->cc($row->totalcc);
						$this->email->bcc($bcc);
						$this->email->message($body);
						if($this->email->send())
						{
							$email_log = array(
								'From' => trim($smtpEmail),
								'Cc' => trim($row->totalcc),
								'Bcc' => trim($bcc),
								'To' => trim($rowTo[0]->EmailAddress),
								'Subject' => trim($row->Subject),
								'MessageBody' => trim($body),
							);
							
							$res = $this->db->insert('tblemaillog',$email_log);
							// $log_data = array(
							// 	'UserId' => $userId,
							// 	'Module' => 'Client-Invitation',
							// 	'Activity' =>'Invitation'		
							// );
							// $log = $this->db->insert('tblactivitylog',$log_data);
							//echo json_encode("Success");
						}else
						{
							//echo json_encode("Fail");
						}
					} else {
						$userId_ar = explode(',', $row->totalTo);			 
						foreach($userId_ar as $userId){
							$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							$rowTo = $queryTo->result();
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							// foreach($query1->result() as $row1){			
							// 	$query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblmstcountry AS con ON st.CountryId = con.CountryId WHERE tn.UserId = '.$userId_backup);
							// 	$result2 = $query2->result();
							// 	$body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
							// } 
							//$body = str_replace("{logo_url}",''.BASE_URL.'/assets/images/template_logo.png',$body);
							
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($row->BccEmail.','.$row->totalbcc);
							$this->email->message($body);
							if($this->email->send())
							{
								//echo 'success';
							}else
							{
								//echo 'fail';
							}
						}
					}
				}
						}
						echo json_encode($post_announce);	
					}	
				}
			}
				
		public function addAnnouncementType()
		{
			$post_announcetype = json_decode(trim(file_get_contents('php://input')), true);	
			if ($post_announcetype) {
				if($post_announcetype['AnnouncementTypeId'] > 0){
					$result = $this->Announcement_model->editAnnouncementType($post_announcetype);
					if($result) {
						echo json_encode($post_announcetype);	
					}	
				}
				else{
					$result = $this->Announcement_model->addAnnouncementType($post_announcetype);
					if($result) {
						echo json_encode($post_announcetype);	
					}	
				}						
			}	
		}
		public function getAnnounceTypeById($announcetype_id = NULL) {
			if (!empty($announcetype_id)) {
				$data = $this->Announcement_model->getAnnounceTypeById($announcetype_id);
				echo json_encode($data);			
			}
		}	
		public function getAnnouncementById($announce_id = NULL) {
			if (!empty($announce_id)) {
				$data = $this->Announcement_model->getAnnouncementById($announce_id);
				echo json_encode($data);			
			}
		}	
}