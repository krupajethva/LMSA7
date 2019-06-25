ERROR - 2019-06-24 17:16:05 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 139 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\controllers\CourseScheduler.php
ERROR - 2019-06-24 17:16:58 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-06-24 17:17:41 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 739 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-06-24 17:27:02 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 139 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\controllers\CourseScheduler.php
ERROR - 2019-06-24 17:30:28 --> Undefined index: badgeletter at line no 1138 in C:\wamp64\www\LMSA7\api\application\modules\Course\models\Course_model.php
ERROR - 2019-06-24 17:37:19 --> Undefined variable: StartTime at line no 414 in C:\wamp64\www\LMSA7\api\application\modules\InstructorCourses\controllers\InstructorCourses.php
ERROR - 2019-06-24 17:41:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 2 - Invalid query: SELECT tmo.OptionId,tmo.OptionValue 
				   from tblmstquestionoption as tmo where tmo.QuestionId=
ERROR - 2019-06-24 17:41:30 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT tlt.QuestionId,tlt.ResultId,tlt.OptionId,tlt.OptionId,tmo.CorrectAnswer,trs.TotalAttendQuestion,trs.TotalCorrectAnswer
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		LEFT JOIN tblmstquestionoption AS tmo ON tmo.OptionId=tlt.OptionId
		where trs.LearnerId=297 AND trs.ResultId=undefined
ERROR - 2019-06-24 17:41:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 2 - Invalid query: SELECT tmo.OptionId,tmo.OptionValue 
				   from tblmstquestionoption as tmo where tmo.QuestionId=
ERROR - 2019-06-24 17:41:54 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT tlt.QuestionId,tlt.ResultId,tlt.OptionId,tlt.OptionId,tmo.CorrectAnswer,trs.TotalAttendQuestion,trs.TotalCorrectAnswer
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		LEFT JOIN tblmstquestionoption AS tmo ON tmo.OptionId=tlt.OptionId
		where trs.LearnerId=297 AND trs.ResultId=undefined
