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

    public function update_data()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->Coursebeforereminders_model->update($data);
        if ($result) {
            echo json_encode($data);
        }
    }
}
