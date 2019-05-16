//For Truncate the tables

SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE TABLE tblemaillog;
TRUNCATE table logs;
TRUNCATE table tblloginlog;
TRUNCATE table tblactivitylog; 

TRUNCATE table tblbadges; 
TRUNCATE table tblcoursediscussion; 
TRUNCATE table tblcoursereview; 
TRUNCATE table tblmstcategory; 
TRUNCATE table tblresources;
TRUNCATE table tblcourse; 

TRUNCATE table tblcoursesession; 
TRUNCATE table tblcourseinstructor; 
TRUNCATE table tblcoursetopic; 
TRUNCATE table tblcourseuserregister; 
TRUNCATE table tblemailnotification; 
TRUNCATE table tblemailattachment; 
TRUNCATE table tblinstructorcertificate; 
TRUNCATE table tblinstructorfollowers; 

TRUNCATE table tblmstaddresses; 

TRUNCATE table tblmstquestion; 
TRUNCATE table tbllearnertest; 
TRUNCATE table tblmstquestionoption; 
TRUNCATE table tblmstresult; 

TRUNCATE table tbluserdetail;
TRUNCATE table tbluser;
TRUNCATE table tblcompany; 
TRUNCATE table tblmstindustry; 
 

SET FOREIGN_KEY_CHECKS = 1;

// For inserting the records in tbluser

INSERT INTO `tbluser` (`UserId`, `InvitedByUserId`, `RoleId`, `CompanyId`, `FirstName`, `LastName`, `Title`, `EmailAddress`, `Password`, `PhoneNumber`, `PhoneNumber2`, `AddressesId`, `UserDetailId`, `ProfileImage`, `SignatureId`, `Biography`, `AdminPrime`, `IsStatus`, `RegistrationCode`, `ResetPasswordCode`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 0, 5, NULL, 'IT', 'Admin', NULL, 'it@theopeneyes.in', MD5("itadmin"), '+1 323-935-2224', '+1 323-935-2224', 1, NULL, NULL, NULL, 'Masters in Computer Application', b'0', '0', NULL, NULL, b'1', 1, '2019-05-14 01:01:54', 1, '2019-05-14 01:01:54'),
(2, 1, 1, NULL, 'Super', 'Admin', NULL, 'tmehta@theopeneyes.in', MD5("tmehta"), '+1 808-959-7765', '+1 808-959-7765', 2, NULL, NULL, NULL, 'Masters in Computer Application', b'0', '0', NULL, NULL, b'1', 1, '2019-05-14 01:01:54', 1, '2019-05-14 01:01:54'),
(3, 2, 2, NULL, 'Pooja', 'Shah', NULL, 'spadmin@theopeneyes.in', MD5("spadmin"), '+1 770-227-2000', '+1 770-227-2000', 3, NULL, NULL, NULL, 'Masters in Computer Application', b'0', '0', NULL, NULL, b'1', 1, '2019-05-14 01:01:54', 1, '2019-05-14 01:01:54');

// For inserting the records in tbluser

INSERT INTO `tblmstaddresses` (`AddressesId`, `Address1`, `Address2`, `CountryId`, `StateId`, `City`, `ZipCode`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, b'1', 1, '2019-05-14 01:01:54', 1, '2019-05-14 05:49:36'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, b'1', 2, '2019-05-14 01:01:54', 2, '2019-05-14 05:49:36'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, b'1', 3, '2019-05-14 01:01:54', 3, '2019-05-14 05:49:36');

