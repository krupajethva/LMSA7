<?php
if (!function_exists('getFormattedBody')) {

    function getFormattedBody($res=null,$body=null)
    {
        $CI = & get_instance();
        try{
            $CurrentYear = date("Y");
             $data = json_decode(json_encode($res), True);
            // $LineManager = (isset($data['LineManager'])?$data['LineManager']:'Not assigned');
            // $Password = (isset($data['Password'])?$data['Password']:'');
            // $Requester = (isset($data['Requester'])?$data['Requester']:'');
            // $ForgotUrl = (isset($data['forgotUrl'])?$data['forgotUrl']:'');
            // $HrName = (isset($data['HrName'])?$data['HrName']:'');
            // $UserName = (isset($data['UserName'])?$data['UserName']:'');
            // $EvaluationName = (isset($data['EvaluationName'])?$data['EvaluationName']:'');
            // $EvaluationTypeName = (isset($data['EvaluationTypeName'])?$data['EvaluationTypeName']:'');
            // $EvaluationOf = (isset($data['EvaluationOf'])?$data['EvaluationOf']:'');
            // $EvaluationDate = (isset($data['EvaluationDate'])?$data['EvaluationDate']:'');
            // $RequesterComments = (isset($data['RequesterComments'])?$data['RequesterComments']:'');
            // $HrComments = (isset($data['HrComments'])?$data['HrComments']:'');
            // $CurrentExpiryDate = (isset($data['CurrentExpiryDate'])?$data['CurrentExpiryDate']:'');
            // $ExtendedExpiryDate = (isset($data['NewEndDate'])?$data['NewEndDate']:'');
            // $ExtendedDays = (isset($data['ExtendedDays'])?$data['ExtendedDays']:'');
            // $EvaluationStartDate = (isset($data['EvaluationStartDate'])?$data['EvaluationStartDate']:'');
            // $EvaluationEndDate = (isset($data['EvaluationEndDate'])?$data['EvaluationEndDate']:'');
            // $JoiningDate = (isset($data['JoiningDate'])?$data['JoiningDate']:'');
            // $ContactEmail = (isset($data['ContactEmail'])?$data['ContactEmail']:'');
            // $ContactPhoneNo = (isset($data['ContactPhoneNo'])?$data['ContactPhoneNo']:'');
            // $ContactMessage = (isset($data['ContactMessage'])?$data['ContactMessage']:'');

             $body = str_replace("{ link }",$data['loginUrl'],$body);
            // $body = str_replace("{LineManager}",$LineManager,$body);
            // $body = str_replace("{Password}",$Password,$body);
            // $body = str_replace("{logo_url}",''.BASE_URL.'/assets/images/oeti.png',$body);
            // $body = str_replace("{key_url}",''.BASE_URL.'/assets/images/users_lock.jpg',$body);
            // $body = str_replace("{forgot_url}",$ForgotUrl,$body);
            // $body = str_replace("{current_year}",$CurrentYear,$body);
            // $body = str_replace("{requester}",$Requester,$body);
            // $body = str_replace("{hrName}",$HrName,$body);
            // $body = str_replace("{userName}",$UserName,$body);
            // $body = str_replace("{evaluationName}",$EvaluationName,$body);
            // $body = str_replace("{evaluationType}",$EvaluationTypeName,$body);
            // $body = str_replace("{evaluationOf}",$EvaluationOf,$body);
            // $body = str_replace("{evaluationDate}",$EvaluationDate,$body);
            // $body = str_replace("{requesterComment}",$RequesterComments,$body);
            // $body = str_replace("{hrComment}",$HrComments,$body);
            // $body = str_replace("{currentExpiryDate}",$CurrentExpiryDate,$body);
            // $body = str_replace("{extendedExpiryDate}",$ExtendedExpiryDate,$body);
            // $body = str_replace("{extendedDays}",$ExtendedDays,$body);
            // $body = str_replace("{startDate}",$EvaluationStartDate,$body);
            // $body = str_replace("{expiryDate}",$EvaluationEndDate,$body);
            // $body = str_replace("{joiningDate}",$JoiningDate,$body);
            // $body = str_replace("{contactEmail}",$ContactEmail,$body);
            // $body = str_replace("{contactPhoneNo}",$ContactPhoneNo,$body);
            // $body = str_replace("{contactMessage}",$ContactMessage,$body);
            return $body;
        }   
        catch(Exception $e){
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

}

?>