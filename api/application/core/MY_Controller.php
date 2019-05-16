<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    use \Firebase\JWT\JWT;

  class MY_Controller extends CI_Controller {
	
    public function __construct() {
      parent::__construct();
      include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
   
      $decoded = "";
       if(isset($_SERVER['Authorization']) && !empty($_SERVER['Authorization'])) {
        $token = $_SERVER['Authorization'];
        $decoded = JWT::decode($token,"MyGeneratedKey",array('HS256'));
       }
       
      if(isset($decoded->UserId) && !empty($decoded->UserId) && ($decoded->UserId > 0)) {
         
       
      } else {
        // $success = "FALSE";
        // $msg = "Some thing went wrong please take re-login and try again.";
        // $code = 2008;
        // $response_data['success'] = $success;
        // $response_data['message'] = (string) $msg;
        // $response_data['error_code'] = $code;
        // echo json_encode($response_data);
        // die;
      }

    }
	
  }
  
  
?>