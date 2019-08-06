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

        // $this->db->select('CourseBeforeReminderId');
        // $this->db->from('tblcoursebeforereminder');
        // $this->db->where('CourseId', $data['CourseId']);
        // $row = $this->db->get();
        // $courseResult = $row->result();

        // if (count($courseResult) > 0) {
        //     $data['CourseBeforeReminderId'] = $courseResult['0']->CourseBeforeReminderId;
        // }

        if (!empty($data['CourseBeforeReminderId'])) {
            $result = $this->Coursebeforereminders_model->update($data);
        } else {
            $result = $this->Coursebeforereminders_model->insert($data);
        }
        echo json_encode($result);
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

    public function deletereminder()
    {
        $courseReminderObj = json_decode(trim(file_get_contents('php://input')), true);
        try {
            if (!empty($courseReminderObj['CourseBeforeReminderId'])) {
                $this->Coursebeforereminders_model->deletereminder($courseReminderObj['CourseBeforeReminderId']);
                echo true;
            } else {
                echo false;
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update()
    {
        $CourseBeforeReminderId = $this->input->get('id');
        $data = $this->Coursebeforereminders_model->fetch_data($CourseBeforeReminderId);
        $res = $data->result();
        echo json_encode($res);
    }

    public function sendEmail($emailArr, $name, $CourseFullName, $StartDate, $StartTime, $type)
    {
        $allNames = '';
        foreach ($name as $users) {
            $allNames .= $users->FirstName . ',';
        }
        $smtpDetails = getSmtpDetails(); //get smtp details 
        foreach ($emailArr as $users) {
            $FirstName = $users->FirstName;
            $UserEmail = $users->EmailAddress;

            // print_r($EmailAddress=$users['EmailAddress']);
            if ($type == "Instructor") {
                $EmailToken = 'Instructor should get an email before X days';
            } else {
                $EmailToken = 'Course Start Reminder For Learner';
            }

            $res=new stdClass();
            $res->loginUrl = BASE_URL . '/login/';
            $res->CourseFullName = $CourseFullName;
            $res->StartDate = $StartDate;
            $res->StartTime = $StartTime;
            $res->InstructorName = $allNames;
            $userId = "''";
			$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
			$body = $EmailDetails['EmailBody'];
            $FormattedBody = getFormattedBody($res ,$body);
			
			// send email to particular email
            $send = SendEmail($smtpDetails['smtpEmail'], $UserEmail, $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
			
        }
    }

    public function getlist()
    {
        $data = $this->Coursebeforereminders_model->getlist();
        $CoursebeforeremindersResult = $data->result();

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
            print_r($CourseSessionResult);
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
                    $this->sendEmail($candidateResult, $nameArr, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
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
                    $this->sendEmail($instructorResult, $instructorResult, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
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
                    $this->sendEmail($candidateResult, $nameArr, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
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
                    $this->sendEmail($instructorResult, $instructorResult, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
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
                    $this->sendEmail($candidateResult, $nameArr, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'candidate');
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
                    $this->sendEmail($instructorResult, $instructorResult, $CourseSession->SessionName, $CourseSession->StartDate, $CourseSession->StartTime, 'Instructor');
                }
            }
        }
    }
}
