ERROR - 2019-06-25 18:26:49 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-06-25 18:26:53 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-06-25 18:26:56 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `cs`.`IsActive`, `cp`.`CourseId`, `cp`.`CourseFullName`, `cp`.`CategoryId`, `cp`.`Description`, `cp`.`Price`, `rs`.`InstructorId` as `Fid`, `rs`.`FilePath`
FROM `tblcourseinstructor` `csi`
LEFT JOIN `tblcoursesession` `cs` ON `cs`.`CourseSessionId` = `csi`.`CourseSessionId`
LEFT JOIN `tblcourse` `cp` ON `cp`.`CourseId` = `cs`.`CourseId`
LEFT JOIN `tblresources` `rs` ON `rs`.`ResourcesId` = `cp`.`CourseImageId`
WHERE `csi`.`UserId` = '484'
AND `cp`.`CategoryId` = '2'
GROUP BY `cp`.`CourseId`
ERROR - 2019-06-25 18:26:57 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
ERROR - 2019-06-25 18:26:58 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-06-25 18:27:05 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: select cs.IsActive,cp.CourseId,cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,rs.InstructorId as Fid,rs.FilePath
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
        WHERE csi.UserId=484 GROUP BY cp.CourseId
ERROR - 2019-06-25 18:27:11 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'lms.cs.IsActive' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `cs`.`IsActive`, `cp`.`CourseId`, `cp`.`CourseFullName`, `cp`.`CategoryId`, `cp`.`Description`, `cp`.`Price`, `rs`.`InstructorId` as `Fid`, `rs`.`FilePath`
FROM `tblcourseinstructor` `csi`
LEFT JOIN `tblcoursesession` `cs` ON `cs`.`CourseSessionId` = `csi`.`CourseSessionId`
LEFT JOIN `tblcourse` `cp` ON `cp`.`CourseId` = `cs`.`CourseId`
LEFT JOIN `tblresources` `rs` ON `rs`.`ResourcesId` = `cp`.`CourseImageId`
WHERE `csi`.`UserId` = '484'
AND `cp`.`CategoryId` = '2'
AND  `cp`.`CourseFullName` LIKE '%gffdjdfg%' ESCAPE '!'
GROUP BY `cp`.`CourseId`
ERROR - 2019-06-25 18:27:11 --> Query error: Expression #1 of ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'lms.tci.CourseSessionId' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT count(tci.CourseSessionId) as courseview, `tcs`.`SessionStatus`
FROM `tblcourseinstructor` as `tci`
JOIN `tblcoursesession` `tcs` ON `tci`.`CourseSessionId`=`tcs`.`CourseSessionId`
WHERE `tci`.`UserId` = '484'
GROUP BY `tcs`.`SessionStatus`
ORDER BY `tci`.`CourseSessionId` DESC
