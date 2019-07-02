ERROR - 2019-07-02 15:35:57 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:37:34 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:40:50 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-02 15:41:15 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:42:15 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:44:31 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:45:17 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:46:52 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:47:03 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:47:16 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 15:47:34 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 16:42:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND csi.PublishStatus=1 AND csi.IsActive=1 AND cs.Approval= 1 GROUP BY csi.Cours' at line 8 - Invalid query: select csi.SessionName,csi.TotalSeats,csi.StartDate,csi.weekday,(csi.StartDate - INTERVAL 1 DAY) as prestartdate,csi.EndDate,csi.StartTime,csi.EndTime,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,
			GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=484 AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseId= AND csi.PublishStatus=1 AND csi.IsActive=1 AND cs.Approval= 1 GROUP BY csi.CourseSessionId
