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

    public function getlist()
    {
        $data = $this->Coursebeforereminders_model->getlist();
        $res = $data->result();
        // echo json_encode($res);
        print_r($res);

        //For reminderday1 
        foreach ($res as $List) {
            $this->db->select('CourseSessionId,SessionName');
            $this->db->from('tblcoursesession');
            $this->db->where('CourseId', $List->CourseId);
            $this->db->where('IsActive', 1);
            $this->db->where('StartDate', date('Y-m-d', strtotime('+' . $List->RemainderDay1 . 'days')));
            echo '<br/>';
            echo '<pre/>';
            echo $List->RemainderDay1;
            $this->db->order_by("CourseSessionId", "asc");
            $getID = $this->db->get();
            echo '<br />';
            echo '<pre />';
            print_r($this->db->last_query());
            $res1 = $getID->result();
            // print_r($res1);

            if (!empty($List->CourseSessionId)) {
                $Reminder1SendTo = explode(",", $List->Reminder1SendTo);
                $Reminder2SendTo = explode(",", $List->Reminder2SendTo);
                $Reminder3SendTo = explode(",", $List->Reminder3SendTo);
                //Candidate For Reminder1
                if ($Reminder1SendTo[0] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseuserregister');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidate->result();
                }
                //Insructor For Reminder1
                if ($Reminder1SendTo[1] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseinstructor');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $insructor = $this->db->get();
                    $insructor->result();
                }
                //Candidate For Reminder2
                if ($Reminder2SendTo[0] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseuserregister');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidate->result();
                }
                //Insructor For Reminder2
                if ($Reminder2SendTo[1] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseinstructor');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $insructor = $this->db->get();
                    $insructor->result();
                }

                //Candidate For Reminder3
                if ($Reminder3SendTo[0] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseuserregister');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $candidate = $this->db->get();
                    $candidate->result();
                }
                //Insructor For Reminder3
                if ($Reminder3SendTo[1] == true) {
                    $this->db->select('UserId');
                    $this->db->from('tblcourseinstructor');
                    $this->db->where('CourseSessionId', $List->CourseSessionId);
                    $insructor = $this->db->get();
                    $insructor->result();
                }
            }
        }

        //For reminderday2
        foreach ($res as $List) {
            $this->db->select('CourseSessionId,SessionName');
            $this->db->from('tblcoursesession');
            $this->db->where('CourseId', $List->CourseId);
            $this->db->where('IsActive', 1);
            $this->db->where('StartDate', date('Y-m-d', strtotime('+' . $List->RemainderDay2 . 'days')));
            echo '<br/>';
            echo '<pre/>';
            echo $List->RemainderDay1;
            $this->db->order_by("CourseSessionId", "asc");
            $getID = $this->db->get();
            echo '<br />';
            echo '<pre />';
            print_r($this->db->last_query());
            $res1 = $getID->result();
            // print_r($res1);
        }

        //For reminderday3
        foreach ($res as $List) {
            $this->db->select('CourseSessionId,SessionName');
            $this->db->from('tblcoursesession');
            $this->db->where('CourseId', $List->CourseId);
            $this->db->where('IsActive', 1);
            $this->db->where('StartDate', date('Y-m-d', strtotime('+' . $List->RemainderDay3 . 'days')));
            echo '<br/>';
            echo '<pre/>';
            echo $List->RemainderDay1;
            $this->db->order_by("CourseSessionId", "asc");
            $getID = $this->db->get();
            echo '<br />';
            echo '<pre />';
            print_r($this->db->last_query());
            $res1 = $getID->result();
            // print_r($res1);
        }
    }
}
