<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-15 13:04:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
GROUP BY `u`.`UserId`, `tif`.`FollowerUserId`' at line 8 - Invalid query: SELECT FIND_IN_SET(1, tif.FollowerUserId) as flag, `u`.`UserId`, `u`.`FirstName`, `u`.`LastName`, `u`.`ProfileImage`, `u`.`Biography`, `tif`.`FollowerUserId`, `tif`.`InstructorUserId`
FROM `tbluser` `u`
LEFT JOIN `tblinstructorfollowers` `tif` ON `tif`.`InstructorUserId` = `u`.`UserId`
WHERE `u`.`RoleId` = 3
AND 
				`u`.`FirstName` LIKE '%,lkbvgfvbkm;onbjhjmsapjdybsaodkj.kjacjdkopAYT67DBNKalldhgyjsan..s;xmcjlnsxzkmcjlizhnxjicm;lzkfokjs%'
				OR `u`.`LastName` LIKE '%,lkbvgfvbkm;onbjhjmsapjdybsaodkj.kjacjdkopAYT67DBNKalldhgyjsan..s;xmcjlnsxzkmcjlizhnxjicm;lzkfokjs%'
OR `u`.`UserId` IN()
GROUP BY `u`.`UserId`, `tif`.`FollowerUserId`
ERROR - 2019-07-15 15:33:43 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 732 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
ERROR - 2019-07-15 16:31:01 --> Undefined variable: Course_data at line no 355 in C:\wamp64\www\LMSA7\api\application\modules\Course\models\Course_model.php
ERROR - 2019-07-15 16:31:01 --> Query error: Commands out of sync; you can't run this command now - Invalid query: INSERT INTO `logs` (`errno`, `errtype`, `errstr`, `errfile`, `errline`, `user_agent`, `ip_address`, `time`) VALUES (8, 'Notice', 'Undefined variable: Course_data', 'C:\\wamp64\\www\\LMSA7\\api\\application\\modules\\Course\\models\\Course_model.php', 355, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '::1', '2019-07-15 16:31:01')
ERROR - 2019-07-15 16:31:01 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 139 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\controllers\CourseScheduler.php
ERROR - 2019-07-15 16:32:32 --> mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method at line no 732 in C:\wamp64\www\LMSA7\api\application\modules\CourseScheduler\models\CourseScheduler_model.php
