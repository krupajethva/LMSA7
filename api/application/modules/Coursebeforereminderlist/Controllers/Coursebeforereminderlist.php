<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Coursebeforereminderlist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Coursebeforereminderlist_model');
    }

    public function getAllDetails()
    {
        $data = $this->Coursebeforereminderlist_model->getAllDetails();
        $res = $data->result();
        echo json_encode($res);
    }

    public function deletereminder()
    {
        $courseReminderObj = json_decode(trim(file_get_contents('php://input')), true);
        try {
            if (!empty($courseReminderObj['CourseBeforeReminderId'])) {
                $this->Coursebeforereminderlist_model->deletereminder($courseReminderObj['CourseBeforeReminderId']);
                echo true;
            } else {
                echo false;
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}