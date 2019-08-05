<?php
if (!function_exists('SendEmail')) {

    function SendEmail($smtpEmail=null, $to=null, $cc=null, $bcc=null, $subject=null, $body=null)
    {
        $CI = & get_instance();
        try{
            $CI->email->from($smtpEmail, 'LMS Admin');
            $CI->email->to($to);		
            $CI->email->subject($subject);
            $CI->email->cc($cc);
            $CI->email->bcc($bcc);
            $CI->email->message($body);
            if($CI->email->send())
            {
                $email_log = array(
                    'From' => trim($smtpEmail),
                    'Cc' => trim($cc),
                    'Bcc' => trim($bcc),
                    'To' => trim($to),
                    'Subject' => trim($subject),
                    'MessageBody' => trim($body),
                );	
                $res = $CI->db->insert('tblemaillog',$email_log);	
                if (!empty($db_error) && !empty($db_error['code'])) { 
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                    return false; // unreachable return statement !!!
                }
                if($res){
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
}

if (!function_exists('getSmtpDetails')) {

    function getSmtpDetails()
    {
        $CI = & get_instance();
        try{
            $CI->db->select('Value');
			$CI->db->where('Key','EmailFrom');
			$smtp1 = $CI->db->get('tblmstconfiguration');	
			$row = $smtp1->result();
				$smtpEmail = $row[0]->Value;
			
			$CI->db->select('Value');
			$CI->db->where('Key','EmailPassword');
			$smtp2 = $CI->db->get('tblmstconfiguration');	
			$row1 = $smtp2->result();
                $smtpPassword = $row1[0]->Value;
                
            $res['smtpEmail']=$smtpEmail;
            $res['smtpPassword']=$smtpPassword;
            $config['protocol']='smtp';
            $config['smtp_host']=SMTP_HOST;
            $config['smtp_port']=SMTP_PORT;
            $config['smtp_user']=$smtpEmail;
            $config['smtp_pass']=$smtpPassword;

            $config['charset']='utf-8';
            $config['newline']="\r\n";
            $config['mailtype'] = 'html';                           
            $CI->email->initialize($config);
            if($res){
                return $res;
            }
            else{
                return false;
            }
        }   
        catch(Exception $e){
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
    
}

if (!function_exists('getEmailDetails')) {

    function getEmailDetails($EmailToken= null,$UserId=null)
    {
        $CI = & get_instance();
        try{
        
            $query = $CI->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
            $res=$query->result();
            $row=$res[0];
            if($EmailToken == 'Forgot Password' || $EmailToken == 'Reset Password' || $EmailToken == 'Change Password' || $EmailToken == 'Open Invitation'  || $EmailToken == 'Registration Complete')
            {
                $queryTo = $CI->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$UserId); 
                $rowTo = $queryTo->result();
                $Email_address = $rowTo[0]->EmailAddress;
            }
            else
            {
                if($row->To==5 || $row->To==4 || $row->To==3 ){
                    $queryTo = $CI->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$UserId); 
                    $rowTo = $queryTo->result();
                    if($rowTo)
                        $Email_address = $rowTo[0]->EmailAddress;
                    else
                        $Email_address = '';
                }
                else if($row->To==1 || $row->To==2){
                    $queryTo = $CI->db->query('SELECT EmailAddress,RoleId FROM tbluser where RoleId in ('.$UserId.') '); 
                    $email_address = array();
                        foreach($queryTo->result() as $row1){                        
                            array_push($email_address,$row1->EmailAddress);
                        }
                        $Email_address = implode(',',$email_address);
                }
                else
                {
                    $userId_ar = explode(',', $row->totalTo);	
                    $email_address = array();
                        foreach($userId_ar as $userId){
                        $queryTo = $CI->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
                        $rowTo = $queryTo->result();
                        array_push($email_address,$rowTo[0]->EmailAddress);
                        }
                        $Email_address = implode(',',$email_address);
                }
            }
            
                
                $query1 = $CI->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
                $body = $row->EmailBody;  
                // foreach($query1->result() as $row1){			
                //     $query2 = $CI->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId WHERE tn.UserId = '.$UserId);
                //     $result2 = $query2->result();
                //     $body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
                // } 
                
                if($row->BccEmail!=''){
                    $bcc = $row->BccEmail.','.$row->totalbcc;
                } else {
                    $bcc = $row->totalbcc;
                }
                $res['EmailBody']=$body;
                $res['Subject']=$row->Subject; 
                $res['Bcc']=$bcc;
                $res['To']=$Email_address;
                $res['Cc']=$row->totalcc; 
                if($res){
                    return $res;
                }
                else{
                    return false;
                }

        }   
        catch(Exception $e){
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
    
}

if (!function_exists('InsertActivityLog')) {

    function InsertActivityLog($UserId=null, $Module=null, $Activity=null)
    {
        $CI = & get_instance();
        try{
            $log_data = array(
                'UserId' =>  trim($UserId),
                'Module' => trim($Module),
                'Activity' => trim($Activity)
            );
            $result = $CI->db->insert('tblactivitylog',$log_data);
            $db_error = $CI->db->error();
            if (!empty($db_error) && !empty($db_error['code'])) { 
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable return statement !!!
            }
            if($result){
                return true; 
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
