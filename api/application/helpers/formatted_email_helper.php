<?php
if (!function_exists('getFormattedBody')) {

    function getFormattedBody($res=null,$body=null)
    {
        $CI = & get_instance();
        try{
            $CurrentYear = date("Y");
            $data = json_decode(json_encode($res), True);
            $EmailAddress = (isset($data['EmailAddress'])?$data['EmailAddress']:'');
            $FirstName = (isset($data['FirstName'])?$data['FirstName']:'');
            $LastName = (isset($data['LastName'])?$data['LastName']:'');
            $RoleName = (isset($data['RoleName'])?$data['RoleName']:'');
            $Text = (isset($data['Text'])?$data['Text']:'');
            $Button_text = (isset($data['Button_text'])?$data['Button_text']:'');
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
            $body = str_replace("{ email_address }",$EmailAddress,$body);
            $body = str_replace("{ first_name }",$FirstName,$body);
            $body = str_replace("{ last_name }",$LastName,$body);
            $body = str_replace("{ role }",$RoleName,$body);
            $body = str_replace("{text}",$Text,$body);
            $body = str_replace("{button_text}",$Button_text,$body);
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