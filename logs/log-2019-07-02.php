<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-02 12:21:27 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-02 12:31:40 --> Undefined variable: StartTime at line no 502 in C:\wamp64\www\LMSA7\api\application\modules\InstructorCourses\controllers\InstructorCourses.php
ERROR - 2019-07-02 12:34:09 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT tlt.QuestionId,tlt.ResultId,tlt.OptionId,tlt.OptionId,tmo.CorrectAnswer,trs.TotalAttendQuestion,trs.TotalCorrectAnswer
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		LEFT JOIN tblmstquestionoption AS tmo ON tmo.OptionId=tlt.OptionId
		where trs.LearnerId=undefined AND trs.ResultId=1
ERROR - 2019-07-02 12:44:41 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-02 13:16:34 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-02 13:16:49 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-02 13:18:35 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-02 13:20:39 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
