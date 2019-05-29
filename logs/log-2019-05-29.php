ERROR - 2019-05-29 11:10:20 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:10:25 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:10:30 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:10:35 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:16:02 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:16:07 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:16:12 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:16:16 --> Trying to get property of non-object at line no 397 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:19:03 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:19:08 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:19:18 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:35:55 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:36:02 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 11:36:10 --> Trying to get property of non-object at line no 398 in C:\wamp64\www\LMSA7\api\application\modules\Reminder\controllers\Reminder.php
ERROR - 2019-05-29 12:50:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY csi.CourseSessionId' at line 8 - Invalid query: select csi.IsActive,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.SessionStatus,csi.EndDate,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,csi.PublishStatus,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=484 AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId= GROUP BY csi.CourseSessionId
