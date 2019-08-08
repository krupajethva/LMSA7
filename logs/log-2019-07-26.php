<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-26 14:55:59 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT DISTINCT `tci`.`CourseSessionId`, `tcs`.`CourseId`, `tc`.`CourseFullName`, (SELECT ROUND(AVG(Rating), 1) from tblcoursereview where CourseId =tc.CourseId) as reviewavg
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
JOIN `tblcourse` `tc` ON `tcs`.`CourseId`=`tc`.`CourseId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tc`.`CourseId`
ORDER BY `tcs`.`CourseId` DESC
 LIMIT 5
ERROR - 2019-07-26 14:56:41 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-26 14:56:59 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-26 14:57:11 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-26 14:57:15 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-07-26 14:58:13 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
