<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-06-26 12:59:25 --> Query error: Table 'lms.courseinstructorinvitation' doesn't exist - Invalid query: SELECT `con`.`InvitationId`, `con`.`CourseId`, `con`.`Code`, `con`.`UserId`, `con`.`Approval`, `cp`.`CourseFullName`, `us`.`FirstName`
FROM `courseinstructorinvitation` as `con`
LEFT JOIN `tblcourse` `cp` ON `cp`.`CourseId` = `con`.`CourseId`
LEFT JOIN `tbluser` `us` ON `us`.`UserId` = `con`.`UserId`
ERROR - 2019-06-26 12:59:54 --> Query error: Unknown column 'con.InstructorId' in 'field list' - Invalid query: SELECT `con`.`CourseId`, `con`.`InstructorId`, `con`.`CourseFullName`
FROM `tblcourse` as `con`
ERROR - 2019-06-26 17:15:11 --> Query error: Table 'lms.courseinstructorinvitation' doesn't exist - Invalid query: SELECT `con`.`InvitationId`, `con`.`CourseId`, `con`.`Code`, `con`.`UserId`, `con`.`Approval`, `cp`.`CourseFullName`, `us`.`FirstName`
FROM `courseinstructorinvitation` as `con`
LEFT JOIN `tblcourse` `cp` ON `cp`.`CourseId` = `con`.`CourseId`
LEFT JOIN `tbluser` `us` ON `us`.`UserId` = `con`.`UserId`
ERROR - 2019-06-26 17:49:20 --> Query error: Unknown column 'con.InstructorId' in 'field list' - Invalid query: SELECT `con`.`CourseId`, `con`.`InstructorId`, `con`.`CourseFullName`
FROM `tblcourse` as `con`
