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
                    'To' => trim($EmailAddress),
                    'Subject' => trim($row->Subject),
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
