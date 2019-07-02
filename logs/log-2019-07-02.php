<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-02 04:01:12 --> Severity: Warning --> mkdir(): File exists C:\wamp64\www\LMSA7\api\system\core\Log.php 131
ERROR - 2019-07-02 09:36:06 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=1 GROUP BY cp.CourseId
ERROR - 2019-07-02 09:38:27 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '297'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 09:39:30 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '297'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 09:42:40 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '297'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 09:43:07 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '297'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 09:43:48 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 09:45:19 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-02 09:46:30 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-02 09:47:23 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-07-02 12:30:56 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=1 GROUP BY cp.CourseId
ERROR - 2019-07-02 12:33:33 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=1 GROUP BY cp.CourseId
ERROR - 2019-07-02 12:47:56 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=1 GROUP BY cp.CourseId
ERROR - 2019-07-02 12:51:02 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '297'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
