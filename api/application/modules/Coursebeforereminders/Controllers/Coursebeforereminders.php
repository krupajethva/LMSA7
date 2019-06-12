<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Coursebeforereminders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Coursebeforereminders_model');
    }

    public function insert_data()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        if (!empty($data['CourseBeforeReminderId'])) {
            $result = $this->Coursebeforereminders_model->update($data);
        } else {
            $result = $this->Coursebeforereminders_model->insert($data);
        }
        if ($result) {
            echo json_encode($result);
        }
    }
    public function course_list()
    {
        $data = $this->Coursebeforereminders_model->course_list();
        $res = $data->result();
        echo json_encode($res);
    }

    public function getAllDetails()
    {
        $data = $this->Coursebeforereminders_model->getAllDetails();
        $res = $data->result();
        echo json_encode($res);
    }

    public function sendEmail($emailArr,$name,$CourseFullName,$StartDate, $StartTime,$type)
    {
        $allNames = '';
        foreach ($name as $users) {
            $allNames .= $users->FirstName . ',';
        }
        foreach ($emailArr as $users) {
            $FirstName = $users->FirstName;
            $UserEmail = $users->EmailAddress;

            // print_r($EmailAddress=$users['EmailAddress']);
            if ($type == "Instructor") {
                $EmailToken = 'Instructor should get an email before X days';
            } else {
                $EmailToken = 'Course Start Reminder For Learner';
            }
            $this->db->select('Value');
            $this->db->where('Key', 'EmailFrom');
            $smtp1 = $this->db->get('tblmstconfiguration');
            foreach ($smtp1->result() as $row) {
                $smtpEmail = $row->Value;
            }
            $this->db->select('Value');
            $this->db->where('Key', 'EmailPassword');
            $smtp2 = $this->db->get('tblmstconfiguration');
            foreach ($smtp2->result() as $row) {
                $smtpPassword = $row->Value;
            }

            $config['protocol'] = PROTOCOL;
            $config['smtp_host'] = SMTP_HOST;
            $config['smtp_port'] = SMTP_PORT;
            $config['smtp_user'] = $smtpEmail;
            $config['smtp_pass'] = $smtpPassword;

            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

            $query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

            foreach ($query->result() as $row) {
                $body = $row->EmailBody;
                if ($row->BccEmail != '') {
                    $bcc = $row->BccEmail . ',' . $row->totalbcc;
                } else {
                    $bcc = $row->totalbcc;
                }
                $body = str_replace("{ CourseFullName }", $CourseFullName, $body);
                $body = str_replace("{ StartDate }", $StartDate, $body);
                $body = str_replace("{ StartTime }", $StartTime, $body);
                $body = str_replace("{ InstructorName }", $allNames, $body);
                //	$body = str_replace("{login_url}",$StartTime,$body);
                $body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
                $this->email->from($smtpEmail, 'LMS Admin');
                $this->email->to($UserEmail);
                $this->email->subject($row->Subject);
                $this->email->cc($row->totalcc);
                $this->email->bcc($bcc);
                $this->email->message($body);
                if ($this->email->send()) {
                    $email_log = array(
                        'From' => trim($smtpEmail),
                        'Cc' => '',
                        'Bcc' => '',
                        'To' => trim($users->EmailAddress),
                        'Subject' => trim($row->Subject),
                        'MessageBody' => trim($body),
                    );
                    $res = $this->db->insert('tblemaillog', $email_log);
                } else {
                    //echo json_encode("Fail");
                }
            }
        }
    }

    public function getlist()
    {
        $data = $this->Coursebeforereminders_model->getlist();
        $CoursebeforeremindersResult = $data->result();
        //  print_r($CoursebeforeremindersResult);

        foreach ($CoursebeforeremindersResult as $Coursebeforereminders) {

            $newReminderDate1 = date('Y-m-d', strtotime('+' . $Coursebeforereminders->RemainderDay1 . 'days'));
            $newReminderDate2 = date('Y-m-d', strtotime('+' . $Coursebeforereminders->RemainderDay2 . 'days'));
            $newReminderDate3 = date('Y-m-d', strtotime('+' . $Coursebeforereminders->RemainderDay3 . 'days'));

            $this->db->select('CourseSessionId,SessionName, StartDate, StartTime');
            $this->db->from('tblcoursesession');
            $this->db->where('CourseId', $Coursebeforereminders->CourseId);
            $this->db->where('IsActive', 1);
            $this->db->where_in('StartDate', [
                $newReminderDate1,
                $newReminderDate2,
                $newReminderDate3
            ]);
            $this->db->order_by("CourseSessionId", "asc");
            $getID = $this->db->get();
            $CourseSessionResult = $getID->result();

            if (count($CourseSessionResult) > 0) {
                foreach ($CourseSessionResult as $CourseSession)

                $Reminder1SendTo = explode(",", $Coursebeforereminders->Reminder1SendTo);
                $Reminder2SendTo = explode(",", $Coursebeforereminders->Reminder2SendTo);
                $Reminder3SendTo = explode(",", $Coursebeforereminders->Reminder3SendTo);

                //Candidate For Reminder1
                if ($Reminder1SendTo[0] == true && $CourseSession->StartDate == $newReminderDate1) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseuserregister tcur');
                    $this->db->join('tbluser user', 'tcur.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidateResult = $candidate->result();
                    print_r($candidateResult);

                    $this->db->select('user.FirstName');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $nameArr = $insructor->result();
                    print_r($nameArr);

                    $this->sendEmail($candidateResult,$nameArr->FirstName,$CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
                }
                //Insructor For Reminder1
                if ($Reminder1SendTo[1] == true && $CourseSession->StartDate == $newReminderDate1) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $instructorResult = $insructor->result();
                    print_r($instructorResult);
                    $this->sendEmail($instructorResult,$instructorResult->FirstName, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
                }
                //Candidate For Reminder2
                if ($Reminder2SendTo[0] == true && $CourseSession->StartDate == $newReminderDate2) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseuserregister tcur');
                    $this->db->join('tbluser user', 'tcur.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidateResult = $candidate->result();
                    print_r($candidateResult);

                    $this->db->select('user.FirstName');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $nameArr = $insructor->result();
                    print_r($nameArr);

                    $this->sendEmail($candidateResult,$nameArr->FirstName,$CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
                }
                //Insructor For Reminder2
                if ($Reminder2SendTo[1] == true && $CourseSession->StartDate == $newReminderDate2) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $insructor->result();
                    $instructorResult = $insructor->result();
                    print_r($instructorResult);
                    $this->sendEmail($instructorResult, $instructorResult->FirstName, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
                }

                //Candidate For Reminder3
                if ($Reminder3SendTo[0] == true && $CourseSession->StartDate == $newReminderDate3) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseuserregister tcur');
                    $this->db->join('tbluser user', 'tcur.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidateResult = $candidate->result();
                    print_r($candidateResult);

                    $this->db->select('user.FirstName');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $nameArr = $insructor->result();
                    print_r($nameArr);

                    $this->sendEmail($candidateResult,$nameArr->FirstName,$CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
                }
                //Insructor For Reminder3
                if ($Reminder3SendTo[1] == true && $CourseSession->StartDate == $newReminderDate3) {
                    $this->db->select('user.UserId, user.FirstName, user.EmailAddress');
                    $this->db->from('tblcourseinstructor tci');
                    $this->db->join('tbluser user', 'tci.UserId = user.UserId', 'left');
                    $this->db->where('CourseSessionId', $CourseSession->CourseSessionId);
                    $insructor = $this->db->get();
                    $insructor->result();
                    $instructorResult = $insructor->result();
                    print_r($instructorResult);
                    $this->sendEmail($instructorResult,$instructorResult->FirstName, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
                }
            }
        }
    }
}
