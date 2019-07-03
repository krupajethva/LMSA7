<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-03 11:14:21 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 730 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-03 11:14:41 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 730 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-03 12:32:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND csi.PublishStatus=1 AND csi.IsActive=1 AND cs.Approval= 1 GROUP BY csi.Cours' at line 8 - Invalid query: select csi.SessionName,csi.TotalSeats,csi.StartDate,csi.weekday,(csi.StartDate - INTERVAL 1 DAY) as prestartdate,csi.EndDate,csi.StartTime,csi.EndTime,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=484 AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId= AND csi.PublishStatus=1 AND csi.IsActive=1 AND cs.Approval= 1 GROUP BY csi.CourseSessionId
