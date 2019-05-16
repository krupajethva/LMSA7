-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2019 at 01:59 AM
-- Server version: 10.2.23-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devbyo5_LMS`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `activeChange` (IN `IsActive` VARCHAR(10), IN `UpdatedBy` INT(11), IN `UpdatedOn` VARCHAR(100), IN `tableName` VARCHAR(100), IN `Id` INT(11), IN `FieldName` VARCHAR(100), IN `Module` VARCHAR(100))  NO SQL
BEGIN
START TRANSACTION;
SET @t1 = CONCAT('UPDATE ', tableName,' SET `IsActive` = ',IsActive,', `UpdatedBy` = ',UpdatedBy,', `UpdatedOn` = now()',' WHERE ',FieldName,'=',Id);
 PREPARE stmt3 FROM @t1;
 EXECUTE stmt3;
 DEALLOCATE PREPARE stmt3;
 INSERT INTO tblactivitylog
(UserId,Module,Activity) VALUES (UpdatedBy,Module,'Update');
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addAnnouncement` (IN `AnnouncementTypeId` INT(11), IN `UserId` INT(11), IN `AudienceUserIds` TEXT, IN `AudienceId` VARCHAR(100), IN `Title` VARCHAR(100), IN `StartDate` DATETIME, IN `EndDate` DATETIME, IN `Description` TEXT, IN `Location` TEXT, IN `Organizer` VARCHAR(100), IN `IsActive` BIT(1), IN `CreatedBy` INT(11), IN `UpdatedBy` INT(11), IN `Module` VARCHAR(50))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tblannouncement (UserId,AudienceUserIds,AnnouncementTypeId,AudienceId,Title,StartDate,EndDate,Description,Location,Organizer,CreatedBy,UpdatedBy) VALUES (UserId,AudienceUserIds,AnnouncementTypeId,AudienceId,Title,StartDate,EndDate,Description,Location,Organizer,CreatedBy,UpdatedBy);
INSERT INTO tblactivitylog
(UserId,Module,Activity) VALUES (CreatedBy,Module,'Add');
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addCategory` (IN `CategoryName` VARCHAR(100), IN `ParentId` INT(11), IN `CategoryCode` VARCHAR(50), IN `Description` TEXT, IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tblmstcategory (CategoryName,ParentId,CategoryCode,Description,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn) VALUES (CategoryName,ParentId,CategoryCode,Description,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn);
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addCertificate` (IN `CertificateName` VARCHAR(100), IN `CertificateTemplate` TEXT, IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tblcertificatetemplate (CertificateName,CertificateTemplate,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn) VALUES (CertificateName,CertificateTemplate,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn);
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addCountry` (IN `CountryName` VARCHAR(100), IN `CountryAbbreviation` VARCHAR(3), IN `PhonePrefix` INT(11), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblmstcountry (CountryName,CountryAbbreviation,PhonePrefix,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (CountryName,CountryAbbreviation,PhonePrefix,IsActive,CreatedBy,now(),UpdatedBy);
 
 
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addCourse` (IN `CategoryId` INT(11), IN `CourseFullName` VARCHAR(100), IN `Price` VARCHAR(11), IN `NoOfQuestion` INT(11), IN `Description` TEXT, IN `CourseImageId` INT(11), IN `CourseVideoId` INT(11), IN `Keyword` VARCHAR(255), IN `EmailBody` TEXT, IN `EmailBody2` TEXT, IN `EmailBody3` TEXT, IN `EmailBody4` TEXT, IN `Requirement` TEXT, IN `Featurescheck` BIT(1), IN `whatgetcheck` BIT(1), IN `Targetcheck` BIT(1), IN `Requirementcheck` BIT(1), IN `Morecheck` BIT(1), IN `PublishStatus` INT(11), IN `IsActive` BIT(1), IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblcourse (CategoryId,CourseFullName,Price,NoOfQuestion,Description,CourseImageId,CourseVideoId,Keyword,EmailBody,EmailBody2,EmailBody3,EmailBody4,Requirement,Featurescheck,whatgetcheck,Targetcheck,Requirementcheck,Morecheck,PublishStatus,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn) VALUES (CategoryId,CourseFullName,Price,NoOfQuestion,Description,CourseImageId,CourseVideoId,Keyword,EmailBody,EmailBody2,EmailBody3,EmailBody4,Requirement,Featurescheck,whatgetcheck,Targetcheck,Requirementcheck,Morecheck,PublishStatus,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn);
 
 SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addcourseinstructor` (IN `CourseSessionId` INT(11), IN `UserId` INT(11), IN `IsPrimary` BIT(1), IN `CreatedBy` INT(11))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO tblcourseinstructor (CourseSessionId,UserId,IsPrimary,CreatedBy) VALUES (CourseSessionId,UserId,IsPrimary,CreatedBy);

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addCoursesession` (IN `CourseId` INT(11), IN `SessionName` VARCHAR(255), IN `Showstatus` BIT(1), IN `CourseCloseDate` DATE, IN `TotalSeats` INT(11), IN `StartTime` TIME, IN `EndTime` TIME, IN `StartDate` DATE, IN `EndDate` DATE, IN `CountryId` INT(11), IN `StateId` INT(11), IN `Location` VARCHAR(255), IN `weekday` VARCHAR(50), IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, OUT `CourseSessionId` INT(11))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO tblcoursesession (CourseId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate,EndDate,CountryId,StateId,Location,weekday,CreatedBy,CreatedOn) VALUES (CourseId,SessionName,Showstatus,CourseCloseDate,TotalSeats,StartTime,EndTime,StartDate,EndDate,CountryId,StateId,Location,weekday,CreatedBy,CreatedOn);

 SET CourseSessionId = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addFileupload` (IN `CourseId` INT(11), IN `CourseImage` VARCHAR(255), IN `CreatedBy` INT(11), IN `CourseVideo` VARCHAR(255), IN `CourseDoc` VARCHAR(255))  NO SQL
BEGIN
START TRANSACTION;
INSERT into tblfileupload(CourseId,CourseImage,CourseVideo,CourseDoc,CreatedBy) VALUES(CourseId,CourseImage,CourseDoc,CourseVideo,CreatedBy);
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addParentCategory` (IN `ParentId` INT(11), IN `CategoryName` VARCHAR(100), IN `CategoryCode` VARCHAR(50), IN `Description` TEXT, IN `IsActive` BIT(1), IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tblmstcategory (ParentId,CategoryName,CategoryCode,Description,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn) VALUES (ParentId,CategoryName,CategoryCode,Description,IsActive,CreatedBy,CreatedOn,UpdatedBy,UpdatedOn);
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addResources` (IN `InstructorId` INT(11), IN `FilePath` VARCHAR(255), IN `Keyword` VARCHAR(100), IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblresources 
(InstructorId,FilePath,Keyword,CreatedBy,CreatedOn) VALUES (InstructorId,FilePath,Keyword,CreatedBy,CreatedOn);
 
 SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addSubtopic` (IN `ParentId` INT(11), IN `TopicName` VARCHAR(100), IN `TopicTime` VARCHAR(100), IN `TopicDescription` TEXT, IN `Video` VARCHAR(255), OUT `TopicId` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tblcoursetopic(ParentId,TopicName,TopicTime,TopicDescription,Video) VALUES (ParentId,TopicName,TopicTime,TopicDescription,Video);
 SET TopicId = LAST_INSERT_ID();
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `addtopic` (IN `id` INT(11), IN `TopicName` VARCHAR(100), OUT `TopicId` INT(11))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO tblcoursetopic (CourseId,TopicName) VALUES (id,TopicName);

 SET TopicId = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `adminAdd` (IN `ParentId` INT(11), IN `RoleId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `PhoneNumber` VARCHAR(13), IN `EmailAddress` VARCHAR(100), IN `Passwordss` VARCHAR(100), IN `EducationLevelId` INT(11), IN `Fieldss` VARCHAR(100), IN `Skills` VARCHAR(100), IN `Statuss` INT(11), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tbluser (ParentId,RoleId,FirstName,LastName,PhoneNumber,EmailAddress,`Password`,EducationLevelId,`Field`,Skills,`Status`,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (1,4,FirstName,LastName,PhoneNumber,EmailAddress,Passwordss,EducationLevelId,Fieldss,Skills,Statuss,IsActive,1,now(),1); 
SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `adminPasswordChange` (IN `Id` INT(11), IN `Password` VARCHAR(100), IN `CreatedOn` INT(11), IN `UpdatedOn` INT(11))  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as u SET u.UserId=Id,u.Password=Password,u.CreatedOn=now(),u.UpdatedOn=now()
WHERE u.UserId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `countryDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tblmstcountry where CountryId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `countryUpdate` (IN `Id` INT(11), IN `CountryName` VARCHAR(100), IN `CountryAbbreviation` VARCHAR(3), IN `PhonePrefix` INT(11), IN `IsActive` BIT, IN `UpdatedBy` INT(11), IN `UpdatedOn` INT(11))  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblmstcountry SET CountryId=Id,CountryName=CountryName,CountryAbbreviation=CountryAbbreviation,PhonePrefix=PhonePrefix,
IsActive=IsActive,UpdatedBy=UpdatedBy,UpdatedOn=now()
WHERE CountryId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `deleteCategory` (IN `Category_id` INT(11))  NO SQL
DELETE from tblmstcategory WHERE CategoryId=Category_id$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `deleteCertificate` (IN `Certificate_Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

DELETE from tblcertificatetemplate WHERE CertificateId=Certificate_Id;

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `deleteItem` (IN `Id` INT(11), IN `UserId` INT(11), IN `tableName` VARCHAR(100), IN `FieldName` VARCHAR(100), IN `Module` VARCHAR(100))  NO SQL
BEGIN
START TRANSACTION;
SET @t1 = CONCAT('DELETE FROM ', tableName, ' WHERE ',FieldName,'=',Id);
 PREPARE stmt3 FROM @t1;
 EXECUTE stmt3;
 DEALLOCATE PREPARE stmt3;
 INSERT INTO tblactivitylog
(UserId,Module,Activity) VALUES (UserId,Module,'Delete');
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `educationAdd` (IN `Education` VARCHAR(100), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblmsteducationlevel (Education,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (Education,IsActive,CreatedBy,CreatedOn,UpdatedBy);
 
 
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `educationDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tblmsteducationlevel where EducationLevelId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `educationList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT el.EducationLevelId,el.Education,el.IsActive,(SELECT COUNT(u.UserId) FROM tbluser as u WHERE u.EducationLevelId=el.EducationLevelId) as isdisabled FROM tblmsteducationlevel as el where el.IsActive='1' ORDER BY el.Education ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `educationUpdate` (IN `Id` INT(11), IN `Education` VARCHAR(100), IN `IsActive` BIT, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblmsteducationlevel as st SET el.EducationLevelId=Id,el.Education=Education,el.IsActive=IsActive,el.UpdatedBy=UpdatedBy,el.UpdatedOn=UpdatedOn
WHERE el.EducationLevelId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `emailTemplateAdd` (IN `Token` VARCHAR(255), IN `Subject` VARCHAR(500), IN `EmailBody` TEXT, IN `Too` INT(11), IN `Cc` INT(11), IN `Bcc` INT(11), IN `BccEmail` VARCHAR(100), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblemailtemplate (Token,Subject,EmailBody,`To`,Cc,Bcc,BccEmail,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (Token,Subject,EmailBody,Too,Cc,Bcc,BccEmail,IsActive,CreatedBy,now(),UpdatedBy);
  
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `emailTemplateDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tblemailtemplate where EmailId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `emailTemplateList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT em.EmailId,em.Token,em.Subject,em.EmailBody,em.To,em.Cc,em.Bcc,
em.BccEmail,em.IsActive,em.CreatedBy,role1.RoleId, role2.RoleId,role3.RoleId,role1.RoleName as roleTo,role2.RoleName as roleCc,role3.RoleName as roleBcc FROM tblemailtemplate as em LEFT JOIN tblmstuserrole as role1 ON role1.RoleId = em.To LEFT JOIN tblmstuserrole as role2 ON role2.RoleId = em.Cc LEFT JOIN tblmstuserrole as role3 ON role3.RoleId = em.Bcc;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `emailTemplateUpdate` (IN `Id` INT(11), IN `Token` VARCHAR(250), IN `Subject` VARCHAR(500), IN `EmailBody` TEXT, IN `Too` INT(11), IN `Cc` INT(11), IN `Bcc` INT(11), IN `BccEmail` VARCHAR(100), IN `IsActive` BIT, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblemailtemplate SET Token=Token,Subject=Subject,EmailBody=EmailBody,`To`=Too,Cc=Cc,Bcc=Bcc,BccEmail=BccEmail,
IsActive=IsActive,UpdatedBy=UpdatedBy,UpdatedOn=now()
WHERE EmailId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getAnnouncements` (IN `UserId` INT(11))  NO SQL
BEGIN
Start transaction;
SELECT a.AnnouncementId,a.UserId,a.AnnouncementTypeId,a.AudienceId,a.Title,a.StartDate,a.EndDate,a.Description,a.Location,a.Organizer,IF(a.IsActive=1,"1","0") as IsActive,GROUP_CONCAT(aa.Name ORDER BY aa.AudienceId) Names FROM tblannouncement as a INNER JOIN tblannouncementaudience as aa on find_in_set(aa.AudienceId, a.AudienceId) > 0 WHERE find_in_set(UserId, a.AudienceUserIds) GROUP BY a.AnnouncementId ORDER BY a.AnnouncementId desc;
commit;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getAnnouncementTypes` ()  NO SQL
BEGIN
Start transaction;
SELECT at.AnnouncementTypeId,at.TypeName,at.IsActive,at.ColorCode FROM tblannouncementtype as at ORDER BY at.AnnouncementTypeId DESC;
commit;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getByCourseSession` (IN `Course_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CourseId,cp.CourseSessionId,cins.UserId as Instructorone,cp.SessionName,cp.Showstatus,cp.CourseCloseDate,cp.TotalSeats,cp.RemainingSeats,TIME_FORMAT(cp.StartTime, "%h %i %p") as StartTime,TIME_FORMAT(cp.EndTime, "%h %i %p") as EndTime,cp.StartDate,cp.EndDate,cp.CountryId,cp.StateId,cp.Location,cp.IsActive from tblcoursesession as cp
LEFT JOIN tblcourseinstructor as cins ON cins.CourseSessionId=cp.CourseSessionId
where cp.CourseId=Course_id AND cins.IsPrimary=1;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getBySessioninstructor` (IN `CourseSession_Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.UserId from tblcourseinstructor as cp
where cp.CourseSessionId=CourseSession_Id AND cp.IsPrimary=0;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getBySubtopicid` (IN `Topic_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.TopicId,cp.ParentId,cp.TopicName as SubTopicName,cp.TopicTime as SubTopicTime,cp.TopicDescription as SubTopicDescription,ress.FilePath as Video from tblcoursetopic as cp
LEFT JOIN tblresources as ress ON ress.ResourcesId = cp.Video
where cp.ParentId=Topic_id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getByTopicId` (IN `Course_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CourseId,cp.TopicId,cp.TopicName from tblcoursetopic as cp

where cp.CourseId=Course_id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCalendarDetails` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT a.AnnouncementId,a.Title as title,a.StartDate as start,a.EndDate as end,a.Description as description,a.Location as location,a.Organizer as organizer,tl.ColorCode as dotcolor FROM tblannouncement as a LEFT JOIN tblannouncementtype as tl ON a.AnnouncementTypeId = tl.AnnouncementTypeId WHERE find_in_set(Id, a.AudienceUserIds) and tl.IsActive = 1;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCategories` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive,ins.CategoryName as parentName from tblmstcategory as cp LEFT JOIN tblmstcategory as ins ON ins.CategoryId = cp.ParentId where cp.ParentId!=0;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCategoryById` (IN `Category_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive from tblmstcategory as cp where cp.CategoryId=Category_id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCategoryWiseList` (IN `Category_Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

SELECT cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cp.IsActive,rs.InstructorId as Fid,rs.FilePath,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId = cp.CourseId) as reviewavg 
from tblcourse as cp 
LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId 
LEFT JOIN  tblcoursesession AS cs ON cs.CourseId = cp.CourseId
where cp.CategoryId=Category_Id AND cs.PublishStatus!=0 GROUP BY cp.CourseId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCertificate` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT ct.CertificateId,ct.CertificateName,ct.CertificateTemplate,ct.IsActive 
FROM tblcertificatetemplate as ct;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCertificateById` (IN `CertificateId` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT ct.CertificateId,ct.CertificateName,ct.CertificateTemplate,ct.IsActive from tblcertificatetemplate as ct where ct.CertificateId=CertificateId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCountryList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT co.CountryId,co.CountryName,co.CountryAbbreviation,co.PhonePrefix,co.IsActive,(SELECT COUNT(u.UserId) FROM tbluser as u WHERE u.CountryId=co.CountryId) as isdisabled FROM tblmstcountry as co ORDER BY co.CountryName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCourse` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cp.NoOfQuestion
,cp.EmailBody,cp.EmailBody2,cp.EmailBody3,cp.EmailBody4,cp.IsActive,ins.CategoryName as parentName,res.FilePath as CourseImage,ress.FilePath as Video,(SELECT COUNT(mc.TopicId) FROM tblcoursetopic as mc WHERE mc.CourseId=cp.CourseId) as isdisabled from tblcourse as cp LEFT JOIN tblmstcategory as ins ON ins.CategoryId = cp.CategoryId LEFT JOIN tblresources as res ON res.ResourcesId = cp.CourseImageId LEFT JOIN tblresources as ress ON ress.ResourcesId = cp.CourseVideoId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getCourseById` (IN `Course_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CourseId,cp.CategoryId,cp.CourseFullName,cp.Description,cp.Price,cp.NoOfQuestion,
res.FilePath as CourseImage,res.InstructorId AS rid,ress.FilePath as Video,cp.Keyword,cp.Requirement,cp.EmailBody,cp.EmailBody2,cp.EmailBody3,cp.EmailBody4,cp.Featurescheck,cp.whatgetcheck,cp.Targetcheck,cp.Requirementcheck,cp.Morecheck,cp.IsActive
from tblcourse as cp 
LEFT JOIN tblresources as res ON res.ResourcesId = cp.CourseImageId LEFT JOIN tblresources as ress ON ress.ResourcesId = cp.CourseVideoId
where cp.CourseId=Course_id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getInstructorList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT us.UserId,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.EmailAddress,us.Title,us.PhoneNumber,us.Status,us.IsActive,cp.Name FROM tbluser as us LEFT JOIN tblcompany as cp ON cp.CompanyId = us.CompanyId LEFT JOIN tblmstdepartment as dep ON dep.DepartmentId = us.DepartmentId LEFT JOIN tblmstuserrole as role ON role.RoleId = us.RoleId WHERE role.RoleId = 3 ORDER BY us.FirstName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getListCourse` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.Description,cp.Price,cp.NoOfQuestion,cp.IsActive,rs.InstructorId as Fid,rs.FilePath,(SELECT ROUND(AVG(Rating),1) from tblcoursereview where CourseId = cp.CourseId) as reviewavg
from tblcourse as cp 
LEFT JOIN  tblresources AS rs ON rs.ResourcesId = cp.CourseImageId
LEFT JOIN  tblcoursesession AS cs ON cs.CourseId = cp.CourseId where cs.PublishStatus!=0 GROUP BY cp.CourseId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getParentCategories` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive,
(SELECT COUNT(mc.CategoryId) FROM tblmstcategory as mc WHERE mc.ParentId=cp.CategoryId) as isdisabled 
from tblmstcategory as cp where cp.ParentId=0;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getParentCategoryById` (IN `Category_id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
SELECT cp.CategoryId,cp.CategoryName,cp.ParentId,cp.CategoryCode,cp.Description,cp.IsActive from tblmstcategory as cp where cp.CategoryId=Category_id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getStateList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT st.StateId,st.StateName,st.StateAbbreviation,st.IsActive,con.CountryName FROM tblmststate as st LEFT JOIN tblmstcountry as con ON con.CountryId = st.CountryId ORDER BY st.StateName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `getUsersList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT us.UserId,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.EmailAddress,us.Title,us.PhoneNumber,us.Status,us.IsActive,cp.Name FROM tbluser as us LEFT JOIN tblcompany as cp ON cp.CompanyId = us.CompanyId LEFT JOIN tblmstdepartment as dep ON dep.DepartmentId = us.DepartmentId LEFT JOIN tblmstuserrole as role ON role.RoleId = us.RoleId WHERE role.RoleId = 4 ORDER BY us.FirstName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `instructorRegister` (IN `ParentId` INT(11), IN `RoleId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `PhoneNumber` VARCHAR(13), IN `EmailAddress` VARCHAR(100), IN `Passwordss` VARCHAR(100), IN `EducationLevelId` INT(11), IN `Fieldss` VARCHAR(100), IN `Certificate` VARCHAR(200), IN `Statuss` INT(11), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tbluser (ParentId,RoleId,FirstName,LastName,PhoneNumber,EmailAddress,`Password`,EducationLevelId,`Field`,Certificate,`Status`,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (ParentId,RoleId,FirstName,LastName,PhoneNumber,EmailAddress,Passwordss,EducationLevelId,Fieldss,Certificate,Statuss,IsActive,1,now(),1); 
SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `invitedInstructorList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT us.UserId,uss.ParentId,uss.FirstName as IvitedUserName,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.EmailAddress,us.Title,us.PhoneNumber,us.Status,us.IsActive,cp.Name FROM tbluser as us LEFT JOIN tbluser as uss ON uss.UserId = us.ParentId LEFT JOIN tblcompany as cp ON cp.CompanyId = us.CompanyId LEFT JOIN tblmstdepartment as dep ON dep.DepartmentId = us.DepartmentId LEFT JOIN tblmstuserrole as role ON role.RoleId = us.RoleId WHERE role.RoleId = '3' ORDER BY us.FirstName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `invitedLearnerList` ()  NO SQL
BEGIN
START TRANSACTION;
SELECT us.UserId,uss.ParentId,uss.FirstName as IvitedUserName,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.EmailAddress,us.Title,us.PhoneNumber,us.Status,us.IsActive,cp.Name FROM tbluser as us LEFT JOIN tbluser as uss ON uss.UserId = us.ParentId LEFT JOIN tblcompany as cp ON cp.CompanyId = us.CompanyId LEFT JOIN tblmstdepartment as dep ON dep.DepartmentId = us.DepartmentId LEFT JOIN tblmstuserrole as role ON role.RoleId = us.RoleId WHERE role.RoleId = '4' ORDER BY us.FirstName ASC ;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `invitedLearnerRegister` (IN `User_Id` INT(11), IN `RoleId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `EmailAddress` VARCHAR(100), IN `PhoneNumber` VARCHAR(13), IN `Passwordss` VARCHAR(100), IN `EducationLevelId` INT(11), IN `Fieldss` VARCHAR(100), IN `Skills` VARCHAR(100), IN `Statuss` INT(11), IN `Codee` VARCHAR(100), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP, OUT `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

UPDATE tbluser as u SET u.UserId=User_Id, u.FirstName=FirstName,u.LastName=LastName,u.EmailAddress=EmailAddress,u.PhoneNumber=PhoneNumber,u.Password=Passwordss,u.EducationLevelId=EducationLevelId,u.Field=Fieldss,u.Skills=Skills,u.Status=Statuss,u.Code=Codee,u.IsActive=IsActive,u.CreatedBy=CreatedBy,u.UpdatedBy=UpdatedBy,u.UpdatedOn=UpdatedOn
WHERE u.UserId=User_Id;
SET id = LAST_INSERT_ID();
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `inviteInstructor` (IN `ParentId` INT(11), IN `RoleId` INT(11), IN `EmailAddress` VARCHAR(100), IN `Statuss` INT(11), IN `Codee` VARCHAR(100), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tbluser (ParentId,RoleId,EmailAddress,`Status`,`Code`,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (ParentId,RoleId,EmailAddress,Statuss,Codee,IsActive,CreatedBy,CreatedOn,UpdatedBy); 
SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `inviteLearner` (IN `ParentId` INT(11), IN `RoleId` INT(11), IN `EmailAddress` VARCHAR(100), IN `Statuss` INT(11), IN `Codee` VARCHAR(100), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tbluser (ParentId,RoleId,EmailAddress,`Status`,`Code`,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (ParentId,RoleId,EmailAddress,Statuss,Codee,IsActive,CreatedBy,CreatedOn,UpdatedBy); 
SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `learnerRegister` (IN `ParentId` INT(11), IN `RoleId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `PhoneNumber` VARCHAR(13), IN `EmailAddress` VARCHAR(100), IN `Passwordss` VARCHAR(100), IN `EducationLevelId` INT(11), IN `Fieldss` VARCHAR(100), IN `Skills` VARCHAR(100), IN `Statuss` INT(11), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11), OUT `id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO tbluser (ParentId,RoleId,FirstName,LastName,PhoneNumber,EmailAddress,`Password`,EducationLevelId,`Field`,Skills,`Status`,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (1,4,FirstName,LastName,PhoneNumber,EmailAddress,Passwordss,EducationLevelId,Fieldss,Skills,Statuss,IsActive,1,now(),1); 
SET id = LAST_INSERT_ID();

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `reinviteUser` (IN `Id` INT, IN `Status` INT(11), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as a SET a.UserId=Id, a.Status=Status,a.UpdatedBy=UpdatedBy,a.UpdatedOn=UpdatedOn
WHERE a.UserId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `revokeUser` (IN `Id` INT(11), IN `Status` INT(11), IN `IsActive` BIT, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as a SET a.UserId=Id, a.Status=Status,a.IsActive=IsActive,a.UpdatedBy=UpdatedBy,a.UpdatedOn=UpdatedOn
WHERE a.UserId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `stateAdd` (IN `CountryId` INT(11), IN `StateName` VARCHAR(100), IN `StateAbbreviation` VARCHAR(3), IN `IsActive` BIT, IN `CreatedBy` INT(11), IN `CreatedOn` TIMESTAMP, IN `UpdatedBy` INT(11))  NO SQL
BEGIN
START TRANSACTION;

  INSERT INTO tblmststate (CountryId,StateName,StateAbbreviation,IsActive,CreatedBy,CreatedOn,UpdatedBy) VALUES (CountryId,StateName,StateAbbreviation,IsActive,CreatedBy,now(),UpdatedBy);
 
 
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `stateDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tblmststate where StateId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `stateUpdate` (IN `Id` INT(11), IN `CountryId` INT(11), IN `StateName` VARCHAR(100), IN `StateAbbreviation` VARCHAR(3), IN `IsActive` BIT, IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblmststate as st SET st.StateId=Id,st.CountryId=CountryId,st.StateName=StateName,st.StateAbbreviation=StateAbbreviation,st.IsActive=IsActive,st.UpdatedBy=UpdatedBy,st.UpdatedOn=now()
WHERE st.StateId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updateCategory` (IN `CategoryId` INT(11), IN `ParentId` INT(11), IN `CategoryName` VARCHAR(100), IN `CategoryCode` VARCHAR(50), IN `Description` TEXT, IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblmstcategory as c SET c.CategoryId=CategoryId,c.ParentId=ParentId,c.CategoryName=CategoryName,
c.CategoryCode=CategoryCode,c.Description=Description,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,
c.UpdatedOn=UpdatedOn WHERE c.CategoryId=CategoryId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updateCertificate` (IN `CertificateId` INT(11), IN `CertificateName` VARCHAR(100), IN `CertificateTemplate` TEXT, IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblcertificatetemplate as c SET c.CertificateId=CertificateId,c.CertificateName=CertificateName,
c.CertificateTemplate=CertificateTemplate,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn WHERE c.CertificateId=CertificateId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updateCourse` (IN `CategoryId` INT(11), IN `CourseFullName` VARCHAR(100), IN `Price` VARCHAR(11), IN `NoOfQuestion` INT(11), IN `Description` TEXT, IN `CourseImageId` INT(11), IN `CourseVideoId` INT(11), IN `Keyword` VARCHAR(50), IN `EmailBody` TEXT, IN `EmailBody2` TEXT, IN `EmailBody3` TEXT, IN `EmailBody4` TEXT, IN `Requirement` TEXT, IN `Featurescheck` BIT(1), IN `whatgetcheck` BIT(1), IN `Targetcheck` BIT(1), IN `Requirementcheck` BIT(1), IN `Morecheck` BIT(1), IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP, IN `Course_Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
IF(CourseImageId IS NOT NULL AND CourseVideoId IS NOT NULL) 
THEN
UPDATE  tblcourse as c SET c.CategoryId=CategoryId,c.CourseFullName=CourseFullName,
c.Price=Price,c.NoOfQuestion=NoOfQuestion,c.Description=Description,c.CourseImageId=CourseImageId,
c.CourseVideoId=CourseVideoId,c.Keyword=Keyword,c.EmailBody=EmailBody,c.EmailBody2=EmailBody2,c.EmailBody3=EmailBody,c.EmailBody4=EmailBody4,c.Requirement=Requirement,c.Featurescheck=Featurescheck,c.whatgetcheck=whatgetcheck,c.Targetcheck=Targetcheck,c.Requirementcheck=Requirementcheck,c.Morecheck=Morecheck,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn,
c.UpdatedOn=UpdatedOn WHERE c.CourseId=Course_Id;

ELSEIF(CourseImageId IS NULL AND CourseVideoId IS NOT NULL) 
THEN
UPDATE  tblcourse as c SET c.CategoryId=CategoryId,c.CourseFullName=CourseFullName,
c.Price=Price,c.NoOfQuestion=NoOfQuestion,c.Description=Description,
c.CourseVideoId=CourseVideoId,c.Keyword=Keyword,c.EmailBody=EmailBody,c.EmailBody2=EmailBody2,c.EmailBody3=EmailBody,c.EmailBody4=EmailBody4,c.Requirement=Requirement,c.Featurescheck=Featurescheck,c.whatgetcheck=whatgetcheck,c.Targetcheck=Targetcheck,c.Requirementcheck=Requirementcheck,c.Morecheck=Morecheck,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn,
c.UpdatedOn=UpdatedOn WHERE c.CourseId=Course_Id;

ELSEIF(CourseImageId IS NOT NULL AND CourseVideoId IS NULL) 
THEN
UPDATE  tblcourse as c SET c.CategoryId=CategoryId,c.CourseFullName=CourseFullName,
c.Price=Price,c.NoOfQuestion=NoOfQuestion,c.Description=Description,
c.CourseImageId=CourseImageId,c.Keyword=Keyword,c.EmailBody=EmailBody,c.EmailBody2=EmailBody2,c.EmailBody3=EmailBody,c.EmailBody4=EmailBody4,c.Requirement=Requirement,c.Featurescheck=Featurescheck,c.whatgetcheck=whatgetcheck,c.Targetcheck=Targetcheck,c.Requirementcheck=Requirementcheck,c.Morecheck=Morecheck,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn,
c.UpdatedOn=UpdatedOn WHERE c.CourseId=Course_Id;

ELSEIF(CourseImageId IS NULL AND CourseVideoId IS NULL) 
THEN
UPDATE  tblcourse as c SET c.CategoryId=CategoryId,c.CourseFullName=CourseFullName,
c.Price=Price,c.NoOfQuestion=NoOfQuestion,c.Description=Description,c.Keyword=Keyword,c.EmailBody=EmailBody,c.EmailBody2=EmailBody2,c.EmailBody3=EmailBody,c.EmailBody4=EmailBody4,c.Requirement=Requirement,c.Featurescheck=Featurescheck,c.whatgetcheck=whatgetcheck,c.Targetcheck=Targetcheck,c.Requirementcheck=Requirementcheck,c.Morecheck=Morecheck,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn,c.UpdatedOn=UpdatedOn WHERE c.CourseId=Course_Id;
END IF;

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updateCoursesession` (IN `CourseId` INT(11), IN `SessionName` VARCHAR(255), IN `Showstatus` BIT(1), IN `CourseCloseDate` DATE, IN `TotalSeats` INT(11), IN `StartTime` TIME, IN `EndTime` TIME, IN `StartDate` DATE, IN `EndDate` DATE, IN `CountryId` INT(11), IN `StateId` INT(11), IN `Location` VARCHAR(255), IN `weekday` VARCHAR(50), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP, IN `CourseSession_Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;

UPDATE  tblcoursesession as c SET c.CourseId=CourseId,
c.SessionName=SessionName,c.Showstatus=Showstatus,c.CourseCloseDate=CourseCloseDate,c.TotalSeats=TotalSeats,c.StartTime=StartTime,c.EndTime=EndTime,c.StartDate=StartDate,c.EndDate=EndDate,c.CountryId=CountryId,c.StateId=StateId,c.Location=Location,c.weekday=weekday,c.UpdatedBy=UpdatedBy,c.UpdatedOn=UpdatedOn WHERE c.CourseSessionId=CourseSession_Id;

COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updateParentCategory` (IN `CategoryId` INT(11), IN `ParentId` INT(11), IN `CategoryName` VARCHAR(100), IN `CategoryCode` VARCHAR(50), IN `Description` TEXT, IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` TIMESTAMP)  NO SQL
BEGIN
START TRANSACTION;
UPDATE tblmstcategory as c SET c.CategoryId=CategoryId,c.ParentId=ParentId,c.CategoryName=CategoryName,
c.CategoryCode=CategoryCode,c.Description=Description,c.IsActive=IsActive,c.UpdatedBy=UpdatedBy,
c.UpdatedOn=UpdatedOn WHERE c.CategoryId=CategoryId;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updatesubtopic` (IN `TopicId` INT(11), IN `ParentId` INT(11), IN `TopicName` VARCHAR(100), IN `TopicTime` VARCHAR(100), IN `TopicDescription` TEXT, IN `Video` INT(11))  NO SQL
BEGIN
START TRANSACTION;
IF(Video IS NULL) 
THEN
UPDATE  tblcoursetopic as c SET c.ParentId=ParentId,c.TopicName=TopicName,
c.TopicTime=TopicTime,
c.TopicDescription=TopicDescription WHERE c.TopicId=TopicId;

ELSE 
UPDATE  tblcoursetopic as c SET c.ParentId=ParentId,c.TopicName=TopicName,
c.TopicTime=TopicTime,
c.TopicDescription=TopicDescription,c.Video=Video WHERE c.TopicId=TopicId;
END IF;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `updatetopic` (IN `TopicId` INT(11), IN `TopicName` VARCHAR(100))  NO SQL
BEGIN
START TRANSACTION;

UPDATE  tblcoursetopic as c SET c.TopicName=TopicName WHERE c.TopicId=TopicId;


COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `userAdminUpdate` (IN `Id` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `EmailAddress` VARCHAR(100), IN `Title` VARCHAR(100), IN `Address1` VARCHAR(250), IN `Address2` VARCHAR(250), IN `CountryId` INT(11), IN `StateId` INT(11), IN `City` VARCHAR(100), IN `ZipCode` INT(11), IN `PhoneNumber` VARCHAR(13), IN `PhoneNumberL` VARCHAR(13), IN `UpdatedOn` INT(11))  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as u SET u.UserId=Id,u.FirstName=FirstName,u.LastName=LastName,u.EmailAddress=EmailAddress,
u.Title=Title,u.Address1=Address1,u.Address2=Address2,u.CountryId=CountryId,u.StateId=StateId,u.City=City,u.ZipCode=ZipCode,u.PhoneNumber=PhoneNumber,u.PhoneNumberL=PhoneNumberL,u.UpdatedOn=now()
WHERE u.UserId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `userInstructorDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tbluser where UserId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `userInstructorUpdate` (IN `Id` INT(11), IN `RoleId` INT(11), IN `CompanyId` INT(11), IN `DepartmentId` INT(11), IN `CountryId` INT(11), IN `StateId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `Title` VARCHAR(100), IN `EmailAddress` VARCHAR(100), IN `City` VARCHAR(100), IN `ZipCode` INT(6), IN `Address1` VARCHAR(300), IN `Address2` VARCHAR(300), IN `PhoneNumber` INT(13), IN `PhoneNumberL` INT(13), IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` INT(11))  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as u SET u.UserId=Id,u.RoleId=RoleId,u.CompanyId=CompanyId,
u.DepartmentId=DepartmentId,u.CountryId=CountryId,u.StateId=StateId,u.FirstName=FirstName,u.LastName=LastName,u.Title=Title,u.EmailAddress=EmailAddress,u.City=City,u.ZipCode=ZipCode,u.Address1=Address1,u.Address2=Address2,u.PhoneNumber=PhoneNumber,u.PhoneNumberL=PhoneNumberL,u.IsActive=IsActive,u.UpdatedBy=1,u.UpdatedOn=now()
WHERE u.UserId=Id;
COMMIT;
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `userlearnerDelete` (IN `Id` INT(11))  NO SQL
BEGIN
START TRANSACTION;
delete from tbluser where UserId=Id;
COMMIT; 
END$$

CREATE DEFINER=`devbyo5`@`localhost` PROCEDURE `userLearnerUpdate` (IN `Id` INT(11), IN `RoleId` INT(11), IN `CompanyId` INT(11), IN `DepartmentId` INT(11), IN `CountryId` INT(11), IN `StateId` INT(11), IN `FirstName` VARCHAR(100), IN `LastName` VARCHAR(100), IN `Title` VARCHAR(100), IN `EmailAddress` VARCHAR(100), IN `City` VARCHAR(100), IN `ZipCode` INT(6), IN `Address1` VARCHAR(300), IN `Address2` VARCHAR(300), IN `PhoneNumber` INT(13), IN `PhoneNumberL` INT(13), IN `IsActive` BIT(1), IN `UpdatedBy` INT(11), IN `UpdatedOn` INT(11))  NO SQL
BEGIN
START TRANSACTION;
UPDATE tbluser as u SET u.UserId=Id,u.RoleId=RoleId,u.CompanyId=CompanyId,
u.DepartmentId=DepartmentId,u.CountryId=CountryId,u.StateId=StateId,u.FirstName=FirstName,u.LastName=LastName,u.Title=Title,u.EmailAddress=EmailAddress,u.City=City,u.ZipCode=ZipCode,u.Address1=Address1,u.Address2=Address2,u.PhoneNumber=PhoneNumber,u.PhoneNumberL=PhoneNumberL,u.IsActive=IsActive,u.UpdatedBy=UpdatedBy,u.UpdatedOn=now()
WHERE u.UserId=Id;
COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `errno` int(2) NOT NULL,
  `errtype` varchar(32) NOT NULL,
  `errstr` text NOT NULL,
  `errfile` varchar(255) NOT NULL,
  `errline` int(4) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `errno`, `errtype`, `errstr`, `errfile`, `errline`, `user_agent`, `ip_address`, `time`) VALUES
(1, 2048, 'Runtime Notice', 'mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/CourseScheduler/controllers/CourseScheduler.php', 201, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 17:51:21'),
(2, 2, 'Warning', 'copy(../src/assets/Instructor/badges/certificatebadge1.png): failed to open stream: No such file or directory', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Course/controllers/Course.php', 466, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 17:54:59'),
(3, 2048, 'Runtime Notice', 'mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/CourseScheduler/models/CourseScheduler_model.php', 515, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:04:26'),
(4, 2048, 'Runtime Notice', 'mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/CourseScheduler/controllers/CourseScheduler.php', 201, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:13:47'),
(5, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:25:40'),
(6, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:26:09'),
(7, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:27:08'),
(8, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:28:00'),
(9, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:28:35'),
(10, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:29:18'),
(11, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:35:10'),
(12, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:36:00'),
(13, 8, 'Notice', 'Undefined index: QuestionId', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Question/controllers/Question.php', 41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:37:49'),
(14, 2048, 'Runtime Notice', 'mysqli_next_result(): There is no next result set. Please, call mysqli_more_results()/mysqli::more_results() to check whether to call this function/method', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/CourseScheduler/models/CourseScheduler_model.php', 515, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '144.48.250.226', '2019-04-26 18:40:00'),
(15, 8, 'Notice', 'Undefined variable: row', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:29:56'),
(16, 2, 'Warning', 'implode(): Invalid arguments passed', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:29:56'),
(17, 8, 'Notice', 'Undefined variable: row', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:30:44'),
(18, 2, 'Warning', 'implode(): Invalid arguments passed', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:30:44'),
(19, 8, 'Notice', 'Undefined variable: row', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:31:08'),
(20, 2, 'Warning', 'implode(): Invalid arguments passed', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:31:08'),
(21, 8, 'Notice', 'Undefined variable: row', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:42:06'),
(22, 2, 'Warning', 'implode(): Invalid arguments passed', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:42:06'),
(23, 8, 'Notice', 'Undefined variable: row', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:49:47'),
(24, 2, 'Warning', 'implode(): Invalid arguments passed', '/home/devbyo5/public_html/LMS-TEST/api/application/modules/Assessment/models/Assessment_model.php', 39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '144.48.250.226', '2019-04-30 12:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `tblactivitylog`
--

CREATE TABLE `tblactivitylog` (
  `ActivityLogId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Module` varchar(100) NOT NULL,
  `Activity` varchar(50) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblactivitylog`
--

INSERT INTO `tblactivitylog` (`ActivityLogId`, `UserId`, `Module`, `Activity`, `CreatedOn`) VALUES
(1, 484, 'Course', 'Add', '2019-04-26 12:14:49'),
(2, 484, 'topic', 'Add', '2019-04-26 12:21:17'),
(3, 484, 'Courseschedular', 'Add', '2019-04-26 12:24:30'),
(4, 484, 'Course', 'Update', '2019-04-26 12:32:36'),
(5, 484, 'Course', 'Update', '2019-04-26 12:34:15'),
(6, 484, 'Courseschedular', 'Add', '2019-04-26 12:34:32'),
(7, 484, 'Course', 'Update', '2019-04-26 12:38:03'),
(8, 484, 'Course', 'Add', '2019-04-26 12:42:34'),
(9, 484, 'topic', 'Add', '2019-04-26 12:43:45'),
(10, 484, 'Courseschedular', 'Add', '2019-04-26 12:45:56'),
(11, 484, 'Question', 'Add', '2019-04-26 12:53:31'),
(12, 484, 'Question', 'Add', '2019-04-26 12:55:40'),
(13, 484, 'Question', 'Add', '2019-04-26 12:56:09'),
(14, 484, 'Question', 'Add', '2019-04-26 12:57:08'),
(15, 484, 'Question', 'Add', '2019-04-26 12:58:00'),
(16, 484, 'Question', 'Add', '2019-04-26 12:58:35'),
(17, 484, 'Question', 'Add', '2019-04-26 12:59:18'),
(18, 484, 'Question', 'update', '2019-04-26 13:00:32'),
(19, 484, 'Question', 'update', '2019-04-26 13:01:03'),
(20, 484, 'Question', 'update', '2019-04-26 13:01:24'),
(21, 484, 'Question', 'update', '2019-04-26 13:01:37'),
(22, 484, 'Question', 'update', '2019-04-26 13:01:48'),
(23, 484, 'Question', 'update', '2019-04-26 13:02:01'),
(24, 484, 'Question', 'update', '2019-04-26 13:02:14'),
(25, 484, 'Question', 'update', '2019-04-26 13:02:44'),
(26, 484, 'Question', 'update', '2019-04-26 13:03:00'),
(27, 484, 'Question', 'Add', '2019-04-26 13:04:24'),
(28, 484, 'Question', 'Add', '2019-04-26 13:05:11'),
(29, 484, 'Question', 'Add', '2019-04-26 13:06:00'),
(30, 484, 'Question', 'Add', '2019-04-26 13:07:49'),
(31, 484, 'Question', 'Add', '2019-04-26 13:08:50'),
(32, 484, 'Course', 'Update', '2019-04-26 13:09:54'),
(33, 484, 'Courseschedular', 'Add', '2019-04-26 13:11:42'),
(34, 512, 'Instructor', 'Unfollow Instructor', '2019-04-26 13:17:07'),
(35, 512, 'Cart', 'Add', '2019-04-26 13:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncement`
--

CREATE TABLE `tblannouncement` (
  `AnnouncementId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AudienceUserIds` text NOT NULL,
  `AnnouncementTypeId` int(11) NOT NULL,
  `AudienceId` varchar(100) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Description` text NOT NULL,
  `Location` text NOT NULL,
  `Organizer` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncementaudience`
--

CREATE TABLE `tblannouncementaudience` (
  `AudienceId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncementtype`
--

CREATE TABLE `tblannouncementtype` (
  `AnnouncementTypeId` int(11) NOT NULL,
  `TypeName` varchar(100) NOT NULL,
  `ColorCode` varchar(50) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblbadges`
--

CREATE TABLE `tblbadges` (
  `BadgesId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `BadgeImageId` int(11) NOT NULL,
  `badgeletter` varchar(8) DEFAULT NULL,
  `badge_dataurl` text DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblbadges`
--

INSERT INTO `tblbadges` (`BadgesId`, `CourseId`, `BadgeImageId`, `badgeletter`, `badge_dataurl`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, 7, 'Ang-Css', NULL, b'1', 484, '2019-04-26 21:54:58', 484, '2019-04-26 22:04:45'),
(2, 2, 9, 'CSS', NULL, b'1', 484, '2019-04-26 22:16:08', 0, '2019-04-26 12:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `tblcertificatetemplate`
--

CREATE TABLE `tblcertificatetemplate` (
  `CertificateId` int(11) NOT NULL,
  `CertificateName` varchar(100) NOT NULL,
  `CertificateTemplate` text NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcertificatetemplate`
--

INSERT INTO `tblcertificatetemplate` (`CertificateId`, `CertificateName`, `CertificateTemplate`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(3, 'dfgdf', 'fhfgh', b'1', 1, '2019-01-04 07:50:39', 1, '2019-01-04 07:50:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `CompanyId` int(11) NOT NULL,
  `ParentId` int(11) DEFAULT NULL,
  `IndustryId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Website` varchar(250) NOT NULL,
  `AddressesId` int(11) DEFAULT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`CompanyId`, `ParentId`, `IndustryId`, `Name`, `EmailAddress`, `Website`, `AddressesId`, `PhoneNumber`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, NULL, 2, 'oess', 'oess@gmail.com', 'oess.com', 1, '1234567890', b'1', 1, '2019-03-05 10:26:17', 1, '2019-04-26 04:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `CourseId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `CourseFullName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` varchar(11) NOT NULL,
  `CourseImageId` int(11) NOT NULL,
  `CourseVideoId` int(11) NOT NULL,
  `Keyword` varchar(255) NOT NULL,
  `EmailBody` text DEFAULT NULL,
  `EmailBody2` text DEFAULT NULL,
  `EmailBody3` text DEFAULT NULL,
  `EmailBody4` text DEFAULT NULL,
  `Requirement` text NOT NULL,
  `Featurescheck` bit(1) NOT NULL,
  `whatgetcheck` bit(1) NOT NULL,
  `Targetcheck` bit(1) NOT NULL,
  `Requirementcheck` bit(1) NOT NULL,
  `Morecheck` bit(1) NOT NULL,
  `NoOfQuestion` int(5) NOT NULL DEFAULT 0,
  `PublishStatus` int(11) NOT NULL DEFAULT 0,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcourse`
--

INSERT INTO `tblcourse` (`CourseId`, `CategoryId`, `CourseFullName`, `Description`, `Price`, `CourseImageId`, `CourseVideoId`, `Keyword`, `EmailBody`, `EmailBody2`, `EmailBody3`, `EmailBody4`, `Requirement`, `Featurescheck`, `whatgetcheck`, `Targetcheck`, `Requirementcheck`, `Morecheck`, `NoOfQuestion`, `PublishStatus`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 2, 'Angular Material 2 Design For Programmers and CSS Newbies', 'Knowing AngularJS can get you a job or improve the one you have. It\'s a skill that will put you more in demand in the modern web development industry, and make your web software life easier, that\'s why it\'s so popular and backed by Google. This course will get you up and running quickly, and teach you the core knowledge you need to deeply understand and build AngularJS applications - and we\'ll build a single page application along the way.', '500', 1, 2, 'php,css', '', '', '', '', '', b'1', b'1', b'1', b'1', b'1', 5, 0, b'1', 484, '2019-04-26 21:44:49', 484, '2019-04-26 22:39:54'),
(2, 2, 'Build Responsive Real World Websites with HTML5 and CSS3', 'The easiest way to learn modern web design, HTML5 and CSS3 step-by-step from scratch. Design AND code a huge project.', '700', 8, 3, 'php,css', '\r\nReal-world skills to build real-world websites: professional, beautiful and truly responsive websites', '\r\nThe proven 7 real-world steps from complete scratch to a fully functional and optimized website', 'Learn super cool jQuery effects like animations, scroll effects and &quot;sticky&quot; navigation', 'Simple-to-use web design guidelines and tips to make your website stand out from the crowd', 'Downloadable lectures, code and design assets for the entire project', b'1', b'1', b'1', b'1', b'1', 5, 0, b'1', 484, '2019-04-26 22:12:34', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcoursecertificate`
--

CREATE TABLE `tblcoursecertificate` (
  `CourseCertificateId` int(11) NOT NULL,
  `Certificate` text NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcoursecertificate`
--

INSERT INTO `tblcoursecertificate` (`CourseCertificateId`, `Certificate`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'ss<br />\n{ Course_Instructor_sign }-{ Course_date }-{ User_name }-{ Course_name }', b'1', 1, '2019-03-27 11:46:22', 1, '2019-04-02 10:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblcoursediscussion`
--

CREATE TABLE `tblcoursediscussion` (
  `DiscussionId` int(11) NOT NULL,
  `ParentId` int(11) NOT NULL DEFAULT 0,
  `UserId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `Comment` text DEFAULT NULL,
  `Reply` text DEFAULT NULL,
  `PostTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblcourseinstructor`
--

CREATE TABLE `tblcourseinstructor` (
  `CourseInstructorId` int(11) NOT NULL,
  `CourseSessionId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `IsPrimary` bit(1) NOT NULL DEFAULT b'0',
  `Code` varchar(11) DEFAULT NULL,
  `Approval` bit(1) NOT NULL DEFAULT b'0',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcourseinstructor`
--

INSERT INTO `tblcourseinstructor` (`CourseInstructorId`, `CourseSessionId`, `UserId`, `IsPrimary`, `Code`, `Approval`, `IsActive`, `CreatedBy`, `CreatedOn`) VALUES
(8, 1, 506, b'0', NULL, b'0', b'1', 484, '2019-04-26 13:11:42'),
(7, 1, 484, b'1', NULL, b'0', b'1', 484, '2019-04-26 13:11:42'),
(5, 2, 484, b'1', NULL, b'0', b'1', 484, '2019-04-26 12:45:56'),
(6, 2, 506, b'0', NULL, b'0', b'1', 484, '2019-04-26 12:45:56'),
(9, 3, 506, b'1', NULL, b'0', b'1', 484, '2019-04-26 13:11:42'),
(10, 3, 484, b'0', NULL, b'0', b'1', 484, '2019-04-26 13:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `tblcoursereview`
--

CREATE TABLE `tblcoursereview` (
  `ReviewId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Rating` int(1) NOT NULL,
  `ReviewComment` text NOT NULL,
  `ReviewTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcoursesession`
--

CREATE TABLE `tblcoursesession` (
  `CourseSessionId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `SessionName` varchar(255) NOT NULL,
  `Showstatus` int(1) NOT NULL,
  `CourseCloseDate` date DEFAULT NULL,
  `TotalSeats` int(11) DEFAULT NULL,
  `RemainingSeats` int(11) DEFAULT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `CountryId` int(11) NOT NULL,
  `StateId` int(11) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `weekday` varchar(50) NOT NULL,
  `PublishStatus` int(1) NOT NULL DEFAULT 0,
  `SessionStatus` int(1) NOT NULL DEFAULT 0,
  `IsDelete` bit(1) NOT NULL DEFAULT b'0',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcoursesession`
--

INSERT INTO `tblcoursesession` (`CourseSessionId`, `CourseId`, `SessionName`, `Showstatus`, `CourseCloseDate`, `TotalSeats`, `RemainingSeats`, `StartTime`, `EndTime`, `StartDate`, `EndDate`, `CountryId`, `StateId`, `Location`, `weekday`, `PublishStatus`, `SessionStatus`, `IsDelete`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, '2019', 0, NULL, 20, NULL, '05:30:00', '05:30:00', '2019-04-28', '2019-04-30', 101, 82, 'Gotri Road, Vadodara', '1,1,0,0,0,0,1', 1, 0, b'0', b'1', 484, '2019-04-26 13:11:42', 484, '2019-04-26 22:41:42'),
(2, 2, '2008', 0, NULL, 10, 1, '21:45:00', '22:50:00', '2019-04-25', '2019-05-16', 101, 82, ' ISCON Atria-1,  Gotri Road  Vadodara', '1,0,1,1,0,0,0', 1, 2, b'0', b'1', 484, '2019-04-26 13:22:13', NULL, '2019-04-26 22:48:16'),
(3, 1, '2020', 0, NULL, 20, NULL, '09:45:00', '11:50:00', '2020-01-10', '2020-01-24', 101, 82, 'Vadodara', '1,0,0,0,0,0,0', 0, 0, b'0', b'1', 484, '2019-04-26 13:12:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcoursetopic`
--

CREATE TABLE `tblcoursetopic` (
  `TopicId` int(11) NOT NULL,
  `CourseId` int(11) DEFAULT NULL,
  `ParentId` int(11) DEFAULT NULL,
  `TopicName` varchar(100) NOT NULL,
  `TopicTime` varchar(100) DEFAULT NULL,
  `TopicDescription` text DEFAULT NULL,
  `Video` varchar(255) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcoursetopic`
--

INSERT INTO `tblcoursetopic` (`TopicId`, `CourseId`, `ParentId`, `TopicName`, `TopicTime`, `TopicDescription`, `Video`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, NULL, 'Course Introduction', NULL, NULL, NULL, b'1', NULL, '2019-04-26 12:21:17', NULL, '2019-04-26 12:21:17'),
(2, NULL, 1, 'What is Angular', '11:111:11', 'First things first! What is Angular? Why would you want to learn it? This lecture helps answering this question.', '3', b'1', NULL, '2019-04-26 12:21:17', NULL, '2019-04-26 12:21:17'),
(3, NULL, 1, 'Angular vs Angular 2 vs Angular 7', '11:11:11', 'So many Angular versions! What\'s up with them and which version does this course cover?', '4', b'1', NULL, '2019-04-26 12:21:17', NULL, '2019-04-26 12:21:17'),
(4, 1, NULL, 'CLI Deep Dive  Troubleshooting ', NULL, NULL, NULL, b'1', NULL, '2019-04-26 12:21:17', NULL, '2019-04-26 12:21:17'),
(5, NULL, 4, 'CLI Deep Dive Troubleshooting ', '11:11:11', 'Got issues using the CLI, setting up a project or simply want to learn more about it? Check out this lecture.', '5', b'1', NULL, '2019-04-26 12:21:17', NULL, '2019-04-26 12:21:17'),
(6, 2, NULL, 'Course introduction', NULL, NULL, NULL, b'1', NULL, '2019-04-26 12:43:45', NULL, '2019-04-26 12:43:45'),
(7, NULL, 6, ' Let\'s start this amazing journey', '11:11:22', 'READ BEFORE YOU START!', '5', b'1', NULL, '2019-04-26 12:43:45', NULL, '2019-04-26 12:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblcourseuserregister`
--

CREATE TABLE `tblcourseuserregister` (
  `CourseUserregisterId` int(11) NOT NULL,
  `CourseSessionId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcourseuserregister`
--

INSERT INTO `tblcourseuserregister` (`CourseUserregisterId`, `CourseSessionId`, `UserId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 2, 512, b'1', 512, '2019-04-26 22:48:16', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblemailattachment`
--

CREATE TABLE `tblemailattachment` (
  `AttachmentId` int(11) NOT NULL,
  `EmailNotificationId` int(11) NOT NULL,
  `Attachment` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblemaillog`
--

CREATE TABLE `tblemaillog` (
  `EmailLogId` int(11) NOT NULL,
  `From` varchar(100) NOT NULL,
  `To` varchar(500) NOT NULL,
  `Cc` varchar(500) DEFAULT NULL,
  `Bcc` varchar(500) DEFAULT NULL,
  `Subject` varchar(250) NOT NULL,
  `MessageBody` text NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblemailnotification`
--

CREATE TABLE `tblemailnotification` (
  `EmailNotificationId` int(11) NOT NULL,
  `InvitedByUserId` int(11) DEFAULT NULL,
  `SenderId` int(11) NOT NULL,
  `ToEmailAddress` varchar(100) NOT NULL,
  `CcEmailAddress` varchar(100) DEFAULT NULL,
  `BccEmailAddress` varchar(100) DEFAULT NULL,
  `Subject` varchar(255) NOT NULL,
  `MessageBody` text NOT NULL,
  `IsRead` bit(1) NOT NULL DEFAULT b'0' COMMENT '0=Unread,1=Readed',
  `IsStar` bit(1) NOT NULL DEFAULT b'0',
  `IsDraft` bit(1) NOT NULL DEFAULT b'0',
  `IsDelete` bit(1) NOT NULL DEFAULT b'0',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblemailtemplate`
--

CREATE TABLE `tblemailtemplate` (
  `EmailId` int(11) NOT NULL,
  `TokenId` int(11) NOT NULL,
  `Subject` varchar(500) NOT NULL,
  `EmailBody` text NOT NULL,
  `To` int(11) DEFAULT NULL,
  `Cc` int(11) DEFAULT NULL,
  `Bcc` int(11) DEFAULT NULL,
  `BccEmail` varchar(1000) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblemailtemplate`
--

INSERT INTO `tblemailtemplate` (`EmailId`, `TokenId`, `Subject`, `EmailBody`, `To`, `Cc`, `Bcc`, `BccEmail`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, 'Send request for registration', '<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #0333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#fafafa; border-bottom:1px solid #cccccc; padding:10px\">LMS TOOL</td>\n		</tr>\n		<tr>\n			<td style=\"padding:10px\">\n			<p>Hi,</p>\n\n			<p>Client want to register to LMS</p>\n\n			<p>Name :&nbsp;{ first_name }&nbsp;{ last_name }</p>\n\n			<p>Email Address :&nbsp;{ email_address }</p>\n\n			<p>Admin Team,<br />\n			LMS</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#072b49; background:#072b49; border-top:5px solid #a51c36; color:#ffffff; padding:10px; text-align:center\">Copyright &copy; 2019 LMS - All rights reserved.</td>\n		</tr>\n	</tbody>\n</table>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>', 2, 0, 0, '', b'1', 1, '2018-09-16 23:57:39', 1, '2019-04-30 10:02:09'),
(2, 2, 'User invite for LMS TOOL', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>LMS Invited!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your are invited to LMS.</p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to access your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Login to Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-17 01:57:58', 1, '2019-04-30 10:02:23'),
(3, 3, 'User Re-invite for LMS TOOL', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>LMS Re-Invited!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your are Re-Invited to LMS.</p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to access your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Login to Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-17 18:29:51', 1, '2019-04-30 10:02:37'),
(4, 4, 'User Register Completed', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Registration &ndash; </strong>{ first_name }&nbsp;{ last_name }<strong>!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">The below User&nbsp;completed their registration:</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ first_name } { last_name }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Email Address</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ email_address }&nbsp;</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Role</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ role }</td>\n					</tr>\n				</tbody>\n			</table>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\"><br />\n			Use the button below to set up your account and get started:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">View Profile</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-17 18:48:52', 1, '2019-04-30 10:02:52'),
(5, 5, 'Reset Password for LMS TOOL', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Password Changed!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your new password has been set.</p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to access your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Login to Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-17 20:46:14', 1, '2019-04-30 10:03:07'),
(6, 6, 'User request for forgot password', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/users_lock.png\" style=\"margin-bottom:15px\" width=\"150\" />\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Forgot</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your Password?</p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Not to worry, we got you! Let&rsquo;s get you a new password.</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Reset Password</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you did not request a password reset, please ignore this email.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-17 20:50:20', 1, '2019-04-30 10:03:24'),
(7, 7, 'change password', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Password Changed!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your new password has been set.</p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to access your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Login to Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2018-09-18 01:58:37', 1, '2019-04-30 10:03:43'),
(8, 8, 'User register to Admin', '<p>&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</p>\n\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #0333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#fafafa; border-bottom:1px solid #cccccc; padding:10px\">LMS TOOL</td>\n		</tr>\n		<tr>\n			<td style=\"padding:10px\">\n			<p>LMS Admin</p>\n\n			<p>Confirmation to you about one user is registered for LMS tool</p>\n\n			<p>Name {first_name} {last_name}</p>\n			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;\n\n			<p>You have to send the detail about user,some one is register for the&nbsp;LMS&nbsp;Corporate tool. To access your account, please <a href=\"{ link }\">click here</a>.</p>\n\n			<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>\n\n			<p>LMS TEAM</p>\n\n			<p>(LMS)</p>\n			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#072b49; background:#072b49; border-top:5px solid #a51c36; color:#ffffff; padding:10px; text-align:center\">Copyright &copy; 2019 LMS - All rights reserved.</td>\n		</tr>\n	</tbody>\n</table>', 2, 0, 0, '', b'1', 1, '2018-09-23 20:08:13', 1, '2019-04-30 10:04:01'),
(9, 9, 'Admin registered', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Registration &ndash; </strong>{ first_name }&nbsp;{ last_name }<strong>!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">The below User&nbsp;completed their registration:</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ first_name } { last_name }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Email Address</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ email_address }&nbsp;</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Role</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ role }</td>\n					</tr>\n				</tbody>\n			</table>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\"><br />\n			Use the button below to set up your account and get started:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">View Profile</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 2, 1, 0, '', b'1', 1, '2018-09-23 22:29:38', 1, '2019-04-30 10:04:16'),
(10, 10, 'User Activation', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Registration successful!</strong></p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">You can login after administration&#39;s permission.</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 3, 0, 0, '', b'1', 297, '2018-11-27 02:11:51', 1, '2019-05-02 11:26:20'),
(12, 11, 'LMS successful registration', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Registration successful!</strong></p>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to activate your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Activate Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 416, '2018-12-18 10:53:35', 1, '2019-04-30 10:05:02'),
(13, 12, 'User Revoked', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>LMS Revoked!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your are temporary Revoked&nbsp;to LMS.</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ first_name } { last_name }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Email Address</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ email_address }&nbsp;</td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">Use the button below to access your account:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{ link }\" style=\"color:#fff; text-decoration:none;\">Login to Account</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;\">If you have any questions, you can reply to this email and it will go right to them.</p>\n\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{ link }\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 504, '2019-03-12 04:22:53', 1, '2019-04-30 10:05:32'),
(14, 13, 'Course Start', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" width=\"200\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Course Start &ndash; </strong>{ CourseFullName }<strong>!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">The below Client completed their registration:</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Course Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ CourseFullName }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Date</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartDate }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Time</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartTime }</td>\n					</tr>\n				</tbody>\n			</table>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\"><br />\n			Use the button below to set up your account and get started:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-style:none; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{login_url}\" style=\"color:#fff; text-decoration:none;\">View Profile</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{login_url}\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2019-04-12 07:14:07', 1, '2019-04-30 10:05:50'),
(15, 14, 'Course Start Before Days', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" width=\"200\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Course Start &ndash; </strong>{ CourseFullName }<strong>!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your Course Start Before Your Changes:</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Course Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ CourseFullName }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Date</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartDate }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Time</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartTime }</td>\n					</tr>\n				</tbody>\n			</table>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\"><br />\n			Use the button below to set up your account and get started:</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-style:none; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{login_url}\" style=\"color:#fff; text-decoration:none;\">View Profile</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{login_url}\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 3, 0, 0, '', b'1', 1, '2019-04-15 05:34:10', 1, '2019-04-30 10:06:23'),
(16, 15, 'Course Start', '<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px\">\n	<tbody>\n		<tr>\n			<td style=\"background-color:#102749; background:#102749; border-bottom:1px solid #333333; padding:10px 10px 5px 10px\"><img alt=\"\" src=\"https://devbyopeneyes.com/emailer_images/logo-email.png\" width=\"200\" /></td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center\">\n			<p style=\"color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;\"><strong>Course Start &ndash; </strong>{ CourseFullName }<strong>!</strong></p>\n\n			<p style=\"color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;\">Your Course Start Before Your Changes:</p>\n\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:100%\">\n				<tbody>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Course Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ CourseFullName }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Date</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartDate }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Start Time</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ StartTime }</td>\n					</tr>\n					<tr>\n						<td style=\"padding:5px; text-align:right; width:35%\">Instructor Name</td>\n						<td style=\"padding:5px; text-align:center; width:4%\">:</td>\n						<td style=\"padding:5px; text-align:left; width:48%\">{ InstructorName }</td>\n					</tr>\n				</tbody>\n			</table>\n\n			<p style=\"color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;\">&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:0; text-align:center; vertical-align:middle\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto\">\n				<tbody>\n					<tr>\n						<td style=\"background-color:#102749; background:#102749; border-radius:4px; border-style:none; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px\"><a href=\"{login_url}\" style=\"color:#fff; text-decoration:none;\">View Course</a></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"border-style:none; border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle\">\n			<p style=\"color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;\">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href=\"{login_url}\" style=\"cursor:pointer;\">click here</a></p>\n			</td>\n		</tr>\n		<tr>\n			<td style=\"background-color:#60b8d1; background:#60b8d1; border-top:1px solid #cccccc; color:#000000; font-size:13px; padding:7px; text-align:center\">Copyright &copy; 2019 Learning Management System</td>\n		</tr>\n	</tbody>\n</table>', 4, 0, 0, '', b'1', 1, '2019-04-16 07:34:30', 1, '2019-04-30 10:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `tblinstructorcertificate`
--

CREATE TABLE `tblinstructorcertificate` (
  `CertificateId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Certificate` varchar(300) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblinstructorcertificate`
--

INSERT INTO `tblinstructorcertificate` (`CertificateId`, `UserId`, `Certificate`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(10, 484, '1553687775710_Address Proof.pdf', b'1', 484, '2019-03-27 11:56:16', 0, '2019-03-27 11:56:16'),
(11, 484, '1553687775710_PanCard.pdf', b'1', 484, '2019-03-27 11:56:16', 0, '2019-03-27 11:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblinstructorfollowers`
--

CREATE TABLE `tblinstructorfollowers` (
  `InstructorFollowerId` int(11) NOT NULL,
  `InstructorUserId` int(11) NOT NULL,
  `FollowerUserId` text NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllearnertest`
--

CREATE TABLE `tbllearnertest` (
  `LearnerTestID` int(11) NOT NULL,
  `ResultId` int(11) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  `OptionId` int(11) NOT NULL DEFAULT 0,
  `MarkasReview` int(1) NOT NULL DEFAULT 0,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblloginlog`
--

CREATE TABLE `tblloginlog` (
  `tblLoginLogId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `LoginType` int(1) NOT NULL,
  `PanelType` int(1) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblloginlog`
--

INSERT INTO `tblloginlog` (`tblLoginLogId`, `UserId`, `LoginType`, `PanelType`, `CreatedOn`) VALUES
(1, 512, 0, 1, '2019-04-26 12:07:31'),
(2, 484, 1, 1, '2019-04-26 12:10:21'),
(3, 1, 0, 1, '2019-04-26 13:15:52'),
(4, 512, 1, 1, '2019-04-26 13:16:27'),
(5, 504, 1, 1, '2019-04-26 14:40:16'),
(6, 484, 0, 1, '2019-04-29 11:59:34'),
(7, 1, 0, 1, '2019-05-03 05:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstaddresses`
--

CREATE TABLE `tblmstaddresses` (
  `AddressesId` int(11) NOT NULL,
  `Address1` varchar(300) DEFAULT NULL,
  `Address2` varchar(300) DEFAULT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `StateId` int(11) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `ZipCode` varchar(6) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstaddresses`
--

INSERT INTO `tblmstaddresses` (`AddressesId`, `Address1`, `Address2`, `CountryId`, `StateId`, `City`, `ZipCode`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'bbbbb', 'ccccc', 101, 82, 'bbbbbbvvv', '222222', b'1', 501, '2019-03-07 06:11:41', 503, '2019-03-08 05:04:21'),
(2, 'anand', NULL, NULL, NULL, 'anand', NULL, b'1', 502, '2019-03-07 09:42:17', 502, '2019-03-07 09:44:04'),
(3, 'anand', NULL, 101, 82, 'Anand', '111111', b'1', 503, '2019-03-07 13:05:04', 484, '2019-04-01 10:25:24'),
(4, 'anand', 'nnnnnyyyy', 101, 82, 'vasad', '123456', b'1', 504, '2019-03-08 05:42:01', 297, '2019-04-02 07:11:59'),
(5, 'aaa', NULL, NULL, NULL, 'anand', NULL, b'1', 509, '2019-03-26 13:25:42', 0, '2019-03-26 13:25:42'),
(6, 'asasas', NULL, NULL, NULL, 'Anand', NULL, b'1', 511, '2019-04-01 11:41:25', 0, '2019-04-01 11:41:25'),
(7, 'Vadodara', NULL, NULL, NULL, 'Vadodara', NULL, b'1', 512, '2019-04-03 11:59:46', 0, '2019-04-03 11:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstcategory`
--

CREATE TABLE `tblmstcategory` (
  `CategoryId` int(11) NOT NULL,
  `ParentId` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `CategoryCode` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstcategory`
--

INSERT INTO `tblmstcategory` (`CategoryId`, `ParentId`, `CategoryName`, `CategoryCode`, `Description`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 0, 'Development', '011', 'Development', b'1', 1, '2018-12-06 01:25:29', 1, '2019-04-25 12:06:18'),
(2, 1, 'PHP', '001', 'Category PHP', b'1', 1, '2018-12-06 01:29:28', 1, '2019-03-25 08:20:59'),
(3, 1, '.net', '002', 'Category PHP ', b'1', 1, '2018-12-06 01:29:53', 1, '2018-12-06 01:29:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstconfiguration`
--

CREATE TABLE `tblmstconfiguration` (
  `ConfigurationId` int(11) NOT NULL,
  `Key` varchar(100) DEFAULT NULL,
  `Value` varchar(100) DEFAULT NULL,
  `DisplayText` varchar(100) DEFAULT NULL,
  `Description` text NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstconfiguration`
--

INSERT INTO `tblmstconfiguration` (`ConfigurationId`, `Key`, `Value`, `DisplayText`, `Description`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'EmailFrom', 'myopeneyes3937@gmail.com', NULL, '', b'1', 1, '2018-09-17 05:46:40', 1, '2019-04-16 06:42:30'),
(2, 'EmailPassword', 'W3lc0m3$2019', NULL, '', b'1', 1, '2018-09-17 05:47:08', 1, '2019-04-16 06:42:30'),
(3, 'ContactFrom', 'mitesh.patel@theopeneyes.in', NULL, '', b'1', 0, '2018-11-19 07:04:09', 1, '2019-04-16 07:45:50'),
(4, 'InvitationMsgSuccess', 'success', NULL, '', b'1', 0, '2018-11-19 07:04:09', 1, '2019-04-16 07:45:50'),
(5, 'InvitationMsgRevoke', 'revoke', NULL, '', b'1', 0, '2018-11-19 07:04:09', 1, '2019-04-16 07:45:50'),
(6, 'InvitationMsgPending', 'pending', NULL, '', b'1', 0, '2018-11-19 07:04:09', 1, '2019-04-16 07:45:50'),
(7, 'Settings', '1', NULL, '', b'1', 1, '2018-11-22 07:07:07', 1, '2019-04-16 09:52:43'),
(10, 'CourseKeyword', '', NULL, 'php,angular,css', b'1', 459, '2018-12-17 05:49:44', 1, '2019-04-16 07:45:50'),
(11, 'SettingsInstructor', '1', NULL, '', b'1', 1, '2018-11-22 07:07:07', 1, '2019-04-16 09:52:43'),
(12, 'CourseStartHours', '2', NULL, '', b'1', 1, '2019-04-10 10:12:34', 1, '2019-04-16 13:30:14'),
(13, 'CourseEndHours', '3', NULL, '', b'1', 1, '2019-04-10 10:57:32', 1, '2019-04-16 13:30:14'),
(14, 'CourseStartDateReminder', '4', NULL, '', b'1', 1, '2019-04-12 07:21:50', 1, '2019-04-16 13:30:14'),
(15, 'InstructorBeforeDays', '5', NULL, '', b'1', 1, '2019-04-15 06:10:13', 1, '2019-04-16 13:30:14'),
(16, 'Invitation', '1', NULL, '', b'1', 1, '2019-04-16 13:07:21', 1, '2019-04-16 13:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstcountry`
--

CREATE TABLE `tblmstcountry` (
  `CountryId` int(11) NOT NULL,
  `CountryName` varchar(100) DEFAULT NULL,
  `CountryAbbreviation` varchar(3) NOT NULL,
  `PhonePrefix` varchar(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstcountry`
--

INSERT INTO `tblmstcountry` (`CountryId`, `CountryName`, `CountryAbbreviation`, `PhonePrefix`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'Afghanistan', 'AF', '93', b'1', 1, '2018-06-15 04:31:53', 1, '2019-03-29 10:27:04'),
(2, 'Albania', 'AL', '355', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(3, 'Algeria', 'DZ', '213', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(6, 'Angola', 'AO', '244', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(8, 'Antarctica', 'AQ', '0', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(10, 'Argentina', 'AR', '54', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(11, 'Armenia', 'AM', '374', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(13, 'Australia', 'AU', '61', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(14, 'Austria', 'AT', '43', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(15, 'Azerbaijan', 'AZ', '994', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(16, 'Bahamas The', 'BS', '1242', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(17, 'Bahrain', 'BH', '973', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(18, 'Bangladesh', 'BD', '880', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(20, 'Belarus', 'BY', '375', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(21, 'Belgium', 'BE', '32', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(22, 'Belize', 'BZ', '501', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(23, 'Benin', 'BJ', '229', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(25, 'Bhutan', 'BT', '975', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(26, 'Bolivia', 'BO', '591', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(27, 'Bosnia and Herzegovina', 'BA', '387', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(28, 'Botswana', 'BW', '267', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(30, 'Brazil', 'BR', '55', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(32, 'Brunei', 'BN', '673', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(33, 'Bulgaria', 'BG', '359', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(34, 'Burkina Faso', 'BF', '226', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(35, 'Burundi', 'BI', '257', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(36, 'Cambodia', 'KH', '855', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(37, 'Cameroon', 'CM', '237', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(38, 'Canada', 'CA', '1', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(39, 'Cape Verde', 'CV', '238', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(41, 'Central African Republic', 'CF', '236', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(42, 'Chad', 'TD', '235', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(43, 'Chile', 'CL', '56', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(44, 'China', 'CN', '86', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(47, 'Colombia', 'CO', '57', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(48, 'Comoros', 'KM', '269', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(49, 'Republic Of The Congo', 'CG', '242', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(50, 'Democratic Republic Of The Congo', 'CD', '242', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(52, 'Costa Rica', 'CR', '506', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(53, 'Cote D\'Ivoire (Ivory Coast)', 'CI', '225', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(54, 'Croatia (Hrvatska)', 'HR', '385', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(55, 'Cuba', 'CU', '53', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(56, 'Cyprus', 'CY', '357', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(57, 'Czech Republic', 'CZ', '420', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(58, 'Denmark', 'DK', '45', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(59, 'Djibouti', 'DJ', '253', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(61, 'Dominican Republic', 'DO', '1809', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(62, 'East Timor', 'TP', '670', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(63, 'Ecuador', 'EC', '593', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(64, 'Egypt', 'EG', '20', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(65, 'El Salvador', 'SV', '503', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(66, 'Equatorial Guinea', 'GQ', '240', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(67, 'Eritrea', 'ER', '291', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(68, 'Estonia', 'EE', '372', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(69, 'Ethiopia', 'ET', '251', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(73, 'Fiji Islands', 'FJ', '679', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(74, 'Finland', 'FI', '358', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(75, 'France', 'FR', '33', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(80, 'Gambia The', 'GM', '220', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(82, 'Germany', 'DE', '49', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(83, 'Ghana', 'GH', '233', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(85, 'Greece', 'GR', '30', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(90, 'Guatemala', 'GT', '502', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(93, 'Guinea-Bissau', 'GW', '245', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(94, 'Guyana', 'GY', '592', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(95, 'Haiti', 'HT', '509', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(97, 'Honduras', 'HN', '504', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(98, 'Hong Kong S.A.R.', 'HK', '852', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(99, 'Hungary', 'HU', '36', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(100, 'Iceland', 'IS', '354', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(101, 'India', 'IN', '91', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(102, 'Indonesia', 'ID', '62', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(103, 'Iran', 'IR', '98', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(104, 'Iraq', 'IQ', '964', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(105, 'Ireland', 'IE', '353', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(106, 'Israel', 'IL', '972', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(107, 'Italy', 'IT', '39', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(108, 'Jamaica', 'JM', '1876', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(109, 'Japan', 'JP', '81', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(111, 'Jordan', 'JO', '962', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(112, 'Kazakhstan', 'KZ', '7', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(113, 'Kenya', 'KE', '254', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(114, 'Kiribati', 'KI', '686', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(115, 'Korea North', 'KP', '850', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(116, 'Korea South', 'KR', '82', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(117, 'Kuwait', 'KW', '965', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(118, 'Kyrgyzstan', 'KG', '996', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(119, 'Laos', 'LA', '856', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(120, 'Latvia', 'LV', '371', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(121, 'Lebanon', 'LB', '961', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(122, 'Lesotho', 'LS', '266', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(123, 'Liberia', 'LR', '231', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(126, 'Lithuania', 'LT', '370', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(127, 'Luxembourg', 'LU', '352', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(130, 'Madagascar', 'MG', '261', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(131, 'Malawi', 'MW', '265', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(132, 'Malaysia', 'MY', '60', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(133, 'Maldives', 'MV', '960', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(134, 'Mali', 'ML', '223', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(137, 'Marshall Islands', 'MH', '692', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(139, 'Mauritania', 'MR', '222', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(140, 'Mauritius', 'MU', '230', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(142, 'Mexico', 'MX', '52', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(143, 'Micronesia', 'FM', '691', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(144, 'Moldova', 'MD', '373', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(146, 'Mongolia', 'MN', '976', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(148, 'Morocco', 'MA', '212', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(149, 'Mozambique', 'MZ', '258', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(150, 'Myanmar', 'MM', '95', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(151, 'Namibia', 'NA', '264', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(154, 'Netherlands Antilles', 'AN', '599', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(155, 'Netherlands The', 'NL', '31', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(157, 'New Zealand', 'NZ', '64', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(158, 'Nicaragua', 'NI', '505', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(159, 'Niger', 'NE', '227', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(160, 'Nigeria', 'NG', '234', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(164, 'Norway', 'NO', '47', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(165, 'Oman', 'OM', '968', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(166, 'Pakistan', 'PK', '92', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(168, 'Palestinian Territory Occupied', 'PS', '970', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(169, 'Panama', 'PA', '507', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(170, 'Papua new Guinea', 'PG', '675', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(171, 'Paraguay', 'PY', '595', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(172, 'Peru', 'PE', '51', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(173, 'Philippines', 'PH', '63', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(175, 'Poland', 'PL', '48', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(176, 'Portugal', 'PT', '351', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(178, 'Qatar', 'QA', '974', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(180, 'Romania', 'RO', '40', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(181, 'Russia', 'RU', '70', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(182, 'Rwanda', 'RW', '250', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(183, 'Saint Helena', 'SH', '290', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(188, 'Samoa', 'WS', '684', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(190, 'Sao Tome and Principe', 'ST', '239', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(191, 'Saudi Arabia', 'SA', '966', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(192, 'Senegal', 'SN', '221', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(193, 'Serbia', 'RS', '381', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(197, 'Slovakia', 'SK', '421', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(198, 'Slovenia', 'SI', '386', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(200, 'Solomon Islands', 'SB', '677', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(201, 'Somalia', 'SO', '252', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(202, 'South Africa', 'ZA', '27', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(205, 'Spain', 'ES', '34', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(206, 'Sri Lanka', 'LK', '94', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(207, 'Sudan', 'SD', '249', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(208, 'Suriname', 'SR', '597', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(210, 'Swaziland', 'SZ', '268', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(211, 'Sweden', 'SE', '46', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(212, 'Switzerland', 'CH', '41', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(213, 'Syria', 'SY', '963', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(214, 'Taiwan', 'TW', '886', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(215, 'Tajikistan', 'TJ', '992', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(216, 'Tanzania', 'TZ', '255', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(217, 'Thailand', 'TH', '66', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(218, 'Togo', 'TG', '228', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(221, 'Trinidad And Tobago', 'TT', '1868', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(222, 'Tunisia', 'TN', '216', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(223, 'Turkey', 'TR', '90', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(224, 'Turkmenistan', 'TM', '7370', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(227, 'Uganda', 'UG', '256', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(228, 'Ukraine', 'UA', '380', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(230, 'United Kingdom', 'GB', '44', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(231, 'United States', 'US', '1', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(232, 'United States Minor Outlying Islands', 'UM', '1', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(233, 'Uruguay', 'UY', '598', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(234, 'Uzbekistan', 'UZ', '998', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(235, 'Vanuatu', 'VU', '678', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(237, 'Venezuela', 'VE', '58', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(238, 'Vietnam', 'VN', '84', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(243, 'Yemen', 'YE', '967', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(245, 'Zambia', 'ZM', '260', b'1', 1, '2018-06-15 04:31:53', 1, NULL),
(246, 'Zimbabwe', 'ZW', '263', b'1', 1, '2018-06-15 04:31:53', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblmstdepartment`
--

CREATE TABLE `tblmstdepartment` (
  `DepartmentId` int(11) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstdepartment`
--

INSERT INTO `tblmstdepartment` (`DepartmentId`, `DepartmentName`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'MSC', b'1', 1, '2018-11-14 00:45:36', 1, '2018-11-14 00:45:36'),
(2, 'Teaching', b'1', 1, '2018-11-14 00:45:45', 1, '2018-11-14 00:45:45'),
(3, 'Manager', b'1', 1, '2018-11-14 00:45:56', 1, '2018-11-14 00:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `tblmsteducationlevel`
--

CREATE TABLE `tblmsteducationlevel` (
  `EducationLevelId` int(11) NOT NULL,
  `Education` varchar(250) NOT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmsteducationlevel`
--

INSERT INTO `tblmsteducationlevel` (`EducationLevelId`, `Education`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'Secondary School', b'1', 1, '2018-10-11 06:05:10', 1, '2018-10-11 06:05:10'),
(2, 'Higher Secondary School', b'1', 1, '2018-10-11 06:05:10', 1, '2018-11-16 08:05:32'),
(3, 'Bachelor', b'1', 1, '2018-10-11 06:05:39', 504, '2019-03-13 10:44:08'),
(4, 'Masters', b'1', 1, '2018-10-11 06:05:39', 57, '2019-03-05 12:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstemailplaceholder`
--

CREATE TABLE `tblmstemailplaceholder` (
  `PlaceholderId` int(11) NOT NULL,
  `PlaceholderName` varchar(100) NOT NULL,
  `ColumnId` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstemailplaceholder`
--

INSERT INTO `tblmstemailplaceholder` (`PlaceholderId`, `PlaceholderName`, `ColumnId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'first_name', 1, b'1', 18, '2018-04-18 20:32:20', 18, '2018-04-18 20:32:20'),
(2, 'last_name', 2, b'1', 18, '2018-04-18 20:32:32', 18, '2018-04-18 20:32:32'),
(3, 'title', 3, b'1', 18, '2018-04-18 20:32:44', 18, '2018-04-18 20:32:44'),
(4, 'email_address', 4, b'1', 18, '2018-04-18 20:32:58', 18, '2018-04-18 20:32:58'),
(5, 'address1', 5, b'1', 18, '2018-04-18 20:33:13', 18, '2018-04-18 20:33:13'),
(6, 'address2', 6, b'1', 18, '2018-04-18 20:33:24', 18, '2018-04-18 20:33:24'),
(7, 'country', 7, b'0', 18, '2018-04-18 20:33:35', 18, '2018-04-18 22:37:22'),
(8, 'state', 8, b'0', 18, '2018-04-18 20:33:46', 18, '2018-04-18 22:37:16'),
(9, 'city', 9, b'1', 18, '2018-04-18 20:33:54', 18, '2018-04-18 20:33:54'),
(10, 'zipcode', 10, b'1', 18, '2018-04-18 20:34:07', 18, '2018-04-18 20:34:07'),
(11, 'phone_number', 11, b'1', 18, '2018-04-18 20:35:04', 18, '2018-04-18 20:35:04'),
(12, 'role', 12, b'1', 18, '2018-04-18 20:35:13', 18, '2018-04-18 20:35:13'),
(13, 'company_name', 13, b'1', 18, '2018-04-18 20:35:24', 18, '2018-04-18 20:35:24'),
(14, 'company_website', 14, b'1', 18, '2018-04-18 20:35:39', 18, '2018-04-18 20:35:39'),
(15, 'company_phone_number', 15, b'1', 18, '2018-04-18 20:35:58', 18, '2018-04-18 20:35:58'),
(16, 'industry_name', 16, b'1', 18, '2018-04-18 20:36:19', 18, '2018-04-18 20:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstindustry`
--

CREATE TABLE `tblmstindustry` (
  `IndustryId` int(11) NOT NULL,
  `IndustryName` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmstindustry`
--

INSERT INTO `tblmstindustry` (`IndustryId`, `IndustryName`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'developing', b'1', 1, '2018-11-26 06:29:59', 1, '2019-03-28 07:24:18'),
(2, 'chemical', b'1', 1, '2018-11-26 06:30:46', 1, '2018-11-26 06:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstquestion`
--

CREATE TABLE `tblmstquestion` (
  `QuestionId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `QuestionName` text NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstquestion`
--

INSERT INTO `tblmstquestion` (`QuestionId`, `CourseId`, `QuestionName`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, '<p>Is AngularJS code unit testable?</p>', b'1', 484, '2019-04-26 22:23:31', 0, '2019-04-26 12:53:31'),
(2, 1, '<p>Which of the following is true about $invalid flag?</p>', b'1', 484, '2019-04-26 22:25:40', 0, '2019-04-26 12:55:40'),
(3, 1, '<p>Custom directives are used in AngularJS to extend the functionality of HTML.</p>', b'1', 484, '2019-04-26 22:26:09', 0, '2019-04-26 12:56:09'),
(4, 1, '<p>AngularJS expressions are written using</p>', b'1', 484, '2019-04-26 22:27:08', 19, '2019-04-26 12:57:08'),
(5, 1, '<p>Which directive initializes an AngularJS application?</p>', b'1', 484, '2019-04-26 22:28:00', 19, '2019-04-26 12:58:00'),
(6, 1, '<p>Internationalization is a way to show locale specific information on a website.</p>', b'1', 484, '2019-04-26 22:28:35', 0, '2019-04-26 12:58:35'),
(7, 1, '<p>What are Angular Controllers are responsible for</p>', b'1', 484, '2019-04-26 22:29:18', 19, '2019-04-26 12:59:18'),
(8, 2, '<p>Which of the following selector selects the element that is the target of a referring URI?</p>', b'1', 484, '2019-04-26 22:34:24', 0, '2019-04-26 13:04:24'),
(9, 2, '<p>Which of the following selector applies styles to elements that are valid per HTML5 validations set either with the pattern or type<br />\nattributes?</p>', b'1', 484, '2019-04-26 22:35:11', 0, '2019-04-26 13:05:11'),
(10, 2, '<p>Which of the following selector selects the elements that are the default among a set of similar elements?</p>', b'1', 484, '2019-04-26 22:36:00', 0, '2019-04-26 13:06:00'),
(11, 2, '<p>What does CSS stand for?</p>', b'1', 484, '2019-04-26 22:37:49', 0, '2019-04-26 13:07:49'),
(12, 2, '<p>&nbsp;Which of the following selector selects an element if it&rsquo;s the only child of its parent?</p>\n\n<p>&nbsp;</p>\n\n<pre>\n:root\nb) :nth-oftype(n)\nc) :only-child\nd) none of the mentioned</pre>', b'1', 484, '2019-04-26 22:38:50', 0, '2019-04-26 13:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstquestionoption`
--

CREATE TABLE `tblmstquestionoption` (
  `OptionId` int(11) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  `OptionValue` varchar(50) NOT NULL,
  `Display` int(5) DEFAULT NULL,
  `CorrectAnswer` bit(1) NOT NULL DEFAULT b'0',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstquestionoption`
--

INSERT INTO `tblmstquestionoption` (`OptionId`, `QuestionId`, `OptionValue`, `Display`, `CorrectAnswer`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, 'true', NULL, b'1', b'1', 484, '2019-04-26 22:23:31', 0, '0000-00-00 00:00:00'),
(2, 1, 'false', NULL, b'0', b'1', 484, '2019-04-26 22:23:31', 0, '0000-00-00 00:00:00'),
(3, 2, '$invalid flag has been changed.', NULL, b'0', b'1', 484, '2019-04-26 22:25:40', 0, '0000-00-00 00:00:00'),
(4, 2, '$invalid flag has invalid data.', NULL, b'1', b'1', 484, '2019-04-26 22:25:40', 0, '0000-00-00 00:00:00'),
(5, 2, 'None of the above.', NULL, b'0', b'1', 484, '2019-04-26 22:25:40', 0, '0000-00-00 00:00:00'),
(6, 2, 'Both of the above.', NULL, b'0', b'1', 484, '2019-04-26 22:25:40', 0, '0000-00-00 00:00:00'),
(7, 3, 'true', NULL, b'1', b'1', 484, '2019-04-26 22:26:09', 0, '0000-00-00 00:00:00'),
(8, 3, 'false', NULL, b'0', b'1', 484, '2019-04-26 22:26:09', 0, '0000-00-00 00:00:00'),
(50, 4, '[expression]', NULL, b'0', b'1', 484, '2019-04-26 22:33:00', 0, '0000-00-00 00:00:00'),
(48, 4, '{{expression}}', NULL, b'1', b'1', 484, '2019-04-26 22:33:00', 0, '0000-00-00 00:00:00'),
(38, 5, ' ngSrc', NULL, b'0', b'1', 484, '2019-04-26 22:32:01', 0, '0000-00-00 00:00:00'),
(37, 5, ' ng-app', NULL, b'1', b'1', 484, '2019-04-26 22:32:01', 0, '0000-00-00 00:00:00'),
(36, 5, 'ng-init', NULL, b'0', b'1', 484, '2019-04-26 22:32:01', 0, '0000-00-00 00:00:00'),
(17, 6, 'false', NULL, b'1', b'1', 484, '2019-04-26 22:28:35', 0, '0000-00-00 00:00:00'),
(18, 6, 'true', NULL, b'0', b'1', 484, '2019-04-26 22:28:35', 0, '0000-00-00 00:00:00'),
(26, 7, 'Displaying the data', NULL, b'0', b'1', 484, '2019-04-26 22:31:24', 0, '0000-00-00 00:00:00'),
(25, 7, 'Controlling the data.', NULL, b'1', b'1', 484, '2019-04-26 22:31:24', 0, '0000-00-00 00:00:00'),
(35, 5, 'ng-start', NULL, b'0', b'1', 484, '2019-04-26 22:32:01', 0, '0000-00-00 00:00:00'),
(49, 4, '{{{expression}}}', NULL, b'0', b'1', 484, '2019-04-26 22:33:00', 0, '0000-00-00 00:00:00'),
(47, 4, '(expression)', NULL, b'0', b'1', 484, '2019-04-26 22:33:00', 0, '0000-00-00 00:00:00'),
(51, 8, 'true', NULL, b'0', b'1', 484, '2019-04-26 22:34:24', 0, '0000-00-00 00:00:00'),
(52, 8, 'false', NULL, b'1', b'1', 484, '2019-04-26 22:34:24', 0, '0000-00-00 00:00:00'),
(53, 9, ':valid', NULL, b'1', b'1', 484, '2019-04-26 22:35:11', 0, '0000-00-00 00:00:00'),
(54, 9, ':required', NULL, b'0', b'1', 484, '2019-04-26 22:35:11', 0, '0000-00-00 00:00:00'),
(55, 9, ':optional', NULL, b'0', b'1', 484, '2019-04-26 22:35:11', 0, '0000-00-00 00:00:00'),
(56, 9, ':invalid', NULL, b'0', b'1', 484, '2019-04-26 22:35:11', 0, '0000-00-00 00:00:00'),
(57, 10, ':default', NULL, b'0', b'1', 484, '2019-04-26 22:36:00', 0, '0000-00-00 00:00:00'),
(58, 10, ':%', NULL, b'1', b'1', 484, '2019-04-26 22:36:00', 0, '0000-00-00 00:00:00'),
(59, 10, ':disabled', NULL, b'0', b'1', 484, '2019-04-26 22:36:00', 0, '0000-00-00 00:00:00'),
(60, 10, 'none of the mentioned', NULL, b'0', b'1', 484, '2019-04-26 22:36:00', 0, '0000-00-00 00:00:00'),
(61, 11, 'Cascading Style Sheets', NULL, b'1', b'1', 484, '2019-04-26 22:37:49', 0, '0000-00-00 00:00:00'),
(62, 11, 'Cascading Sheets Style ', NULL, b'0', b'1', 484, '2019-04-26 22:37:49', 0, '0000-00-00 00:00:00'),
(63, 11, 'Style ', NULL, b'0', b'1', 484, '2019-04-26 22:37:49', 0, '0000-00-00 00:00:00'),
(64, 11, 'Cascading', NULL, b'0', b'1', 484, '2019-04-26 22:37:49', 0, '0000-00-00 00:00:00'),
(65, 12, ':only-child', NULL, b'1', b'1', 484, '2019-04-26 22:38:50', 0, '0000-00-00 00:00:00'),
(66, 12, ':root', NULL, b'0', b'1', 484, '2019-04-26 22:38:50', 0, '0000-00-00 00:00:00'),
(67, 12, ':nth-oftype(n)', NULL, b'0', b'1', 484, '2019-04-26 22:38:50', 0, '0000-00-00 00:00:00'),
(68, 12, 'none of the mentioned', NULL, b'0', b'1', 484, '2019-04-26 22:38:50', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstresult`
--

CREATE TABLE `tblmstresult` (
  `ResultId` int(11) NOT NULL,
  `LearnerId` int(11) NOT NULL,
  `CourseSessionId` int(11) NOT NULL,
  `TotalAttendQuestion` int(5) NOT NULL,
  `TotalCorrectAnswer` int(3) NOT NULL DEFAULT 0,
  `TotalTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Result` decimal(12,2) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmstscreen`
--

CREATE TABLE `tblmstscreen` (
  `ScreenId` int(11) NOT NULL,
  `InvitedByUserId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `Url` varchar(100) NOT NULL,
  `Icon` varchar(100) NOT NULL,
  `SerialNo` int(2) NOT NULL,
  `SelectedClass` varchar(100) DEFAULT NULL,
  `InMenu` bit(1) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstscreen`
--

INSERT INTO `tblmstscreen` (`ScreenId`, `InvitedByUserId`, `Name`, `DisplayName`, `Url`, `Icon`, `SerialNo`, `SelectedClass`, `InMenu`, `IsActive`) VALUES
(1, 0, 'General', 'General', '', 'fa fa-users', 1, 'general', b'0', b'1'),
(2, 1, 'Dashboard', 'Dashboard', '/dashboard', 'fa fa-tachometer', 1, 'dashboard', b'1', b'1'),
(4, 0, 'Manage', 'Manage', '', '', 2, 'manage', b'0', b'1'),
(5, 39, 'Learner List', 'Learners', '/user-list', 'fa fa-users', 3, 'users', b'1', b'1'),
(6, 4, 'Courses', 'Courses', '', 'fa fa-book', 4, 'courses', b'0', b'1'),
(7, 6, 'Course List', 'View', '/course-list', 'fa fa-list', 2, 'view', b'1', b'1'),
(8, 6, 'Add Course', 'Add', '/course', 'fa fa-plus', 1, 'add', b'1', b'1'),
(9, 4, 'Sub-Categories', 'Sub-Categories', '', 'fa fa-sitemap', 3, 'subcategories', b'0', b'1'),
(10, 9, 'Category List', 'View', '/categorylist', 'fa fa-list', 2, 'view', b'1', b'1'),
(11, 9, 'Add Category', 'Add', '/category', 'fa fa-plus', 1, 'add', b'1', b'1'),
(15, 21, 'Country', 'Country', '', 'fa fa-globe', 3, 'country', b'0', b'1'),
(16, 15, 'Country List', 'View', '/country-list', 'fa fa-list', 2, 'view', b'1', b'1'),
(17, 15, 'Add Country', 'Add', '/country', 'fa fa-plus', 1, 'add', b'1', b'1'),
(18, 21, 'State', 'State', '', 'fa fa-globe', 4, 'state', b'0', b'1'),
(19, 18, 'State List', 'View', '/state-list', 'fa fa-list', 2, 'view', b'1', b'1'),
(20, 18, 'Add State', 'Add', '/state', 'fa fa-plus', 1, 'add', b'1', b'1'),
(21, 0, 'Configuration', 'Configuration', '', 'fa fa-cogs', 3, 'configuration', b'0', b'1'),
(22, 21, 'Role Permissions', 'Role Permissions', '/rolepermission', 'fa fa-users', 2, 'rolepermission', b'1', b'1'),
(23, 21, 'Settings', 'Settings', '/settings', 'fa fa-cog', 1, 'settings', b'1', b'1'),
(25, 24, 'Invited Instructor List', 'Invited Instructor List', '/invited-instructor-list', '	\r\nfa fa-list', 2, 'view', b'1', b'1'),
(26, 24, 'Invite User', 'Invite User', '/invite-user', 'fa fa-plus', 1, 'Add', b'1', b'1'),
(29, 4, 'Instructor Courses', 'Instructor Courses', '/instructor-courses', 'fa fa-book', 9, 'instructor-courses', b'1', b'1'),
(30, 4, 'Learner Courses', 'Courses', '/course-list', 'fa fa-book', 10, 'learner-courses', b'1', b'1'),
(31, 4, 'Company', 'Company', '', 'fa fa-building', 1, 'company', b'0', b'1'),
(32, 31, 'Company List', 'View', '/company-list', '	\r\nfa fa-list', 2, 'view', b'1', b'1'),
(33, 31, 'Add Company', 'Add', '/company', 'fa fa-plus', 1, 'add', b'1', b'1'),
(34, 21, 'Education', 'Education', '', 'fa fa-graduation-cap', 5, 'education', b'0', b'1'),
(35, 34, 'Education List', '	\r\nView', '/education-list', '	\r\nfa fa-list', 1, 'view', b'1', b'1'),
(36, 34, 'Add Education', 'Add', '/education', 'fa fa-plus', 1, 'add', b'1', b'1'),
(37, 39, 'Instructor List', 'Instructors', '/instructor-list', 'fa fa-user-circle', 2, 'view', b'1', b'1'),
(38, 4, 'Inbox', 'Inbox', '/inbox', 'fa fa-envelope', 12, 'inbox', b'1', b'1'),
(39, 0, 'Reports', 'Reports', '', '', 4, 'reports', b'0', b'1'),
(40, 21, 'Industry', 'Industry', '', 'fa fa-industry', 6, 'industry', b'0', b'1'),
(41, 40, 'Industry List', 'View', '/industry/list', '	\r\nfa fa-list', 2, 'view', b'1', b'1'),
(42, 40, 'Add Industry', 'Add', '/industry/add', 'fa fa-plus', 1, 'add', b'1', b'1'),
(43, 39, 'Admin List', 'Admins', '/admin-list', 'fa fa-user', 1, 'view', b'1', b'1'),
(44, 39, 'Logs', 'Logs', '', 'fa fa-database', 4, 'logs', b'0', b'1'),
(45, 44, 'Loginlog List', 'Login Logs', '/loginlog', 'fa fa-key', 2, 'view', b'1', b'1'),
(46, 44, 'Activitylog List', 'Activity Logs', '/activity-list', 'fa fa-tasks', 1, 'view', b'1', b'1'),
(47, 44, 'Emaillog List', 'Email Logs', '/emaillog', 'fa fa-envelope-open', 3, 'view', b'1', b'1'),
(48, 21, 'Email Templates', 'Email Templates', '', 'fa fa-building', 7, 'emailtemplates', b'0', b'1'),
(49, 48, 'Emailtemplate list', 'View', '/emailtemplate-list', '	\r\nfa fa-list', 2, 'view', b'1', b'1'),
(50, 48, 'Add Emailtemplate', 'Add', '/emailtemplate', 'fa fa-plus', 1, 'add', b'1', b'1'),
(51, 4, 'Course-Certificate', 'Course-Certificate', '/course-certificate', 'fa fa-building', 6, 'certificate', b'1', b'1'),
(52, 1, 'Dashboard', 'Dashboard', '/dashboard-instructor', 'fa fa-tachometer', 1, 'dashboard', b'1', b'1'),
(53, 1, 'Dashboard', 'Dashboard', '/dashboard-learner', 'fa fa-tachometer', 1, 'dashboard', b'1', b'1'),
(54, 4, 'Categories', 'Categories', '', 'fa fa-sitemap', 2, 'categories', b'0', b'1'),
(55, 4, 'Course Questions', 'Course Questions', '/courselist-question', 'fa fa-question-circle-o', 5, 'coursequestion', b'1', b'1'),
(56, 4, 'Followers', 'Followers', '/instructorfollowers', 'fa fa-users', 8, 'followers', b'1', b'1'),
(57, 4, 'Our Courses', 'Our Courses', '/learner-courses', 'fa fa-book', 11, 'courses', b'1', b'1'),
(58, 4, 'Instructor List', 'Instructors', '/instructorlist', 'fa fa-user-circle', 7, 'instructors', b'1', b'1'),
(59, 54, 'Main Category List', 'View', '/Parentcategorylist', 'fa fa-list', 2, 'view', b'1', b'1'),
(60, 54, 'Add Main Category', 'Add', '/Parentcategory', 'fa fa-plus', 1, 'add', b'1', b'1'),
(66, 21, 'Default Badges', 'Default Badges', '', 'fa fa-id-badge', 8, 'defaultbadges', b'0', b'1'),
(67, 66, 'Default Badge list', 'View', '/default-badgelist', '	\r\nfa fa-list', 2, 'view', b'1', b'1'),
(68, 66, 'Add Default Badge', 'Add', '/default-badge', 'fa fa-plus', 1, 'add', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmststate`
--

CREATE TABLE `tblmststate` (
  `StateId` int(11) NOT NULL,
  `StateName` varchar(100) DEFAULT NULL,
  `StateAbbreviation` varchar(4) DEFAULT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmststate`
--

INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'Alabama', 'AL', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2, 'Alaska', 'AK', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3, 'Arizona', 'AZ', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(4, 'Arkansas', 'AR', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(5, 'California', 'CA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(6, 'Colorado', 'CO', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(7, 'Connecticut', 'CT', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(8, 'Delaware', 'DE', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(9, 'Florida', 'FL', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(10, 'Georgia', 'GA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(11, 'Hawaii', 'HI', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(12, 'Idaho', 'ID', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(13, 'Illinois', 'IL', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(14, 'Indiana', 'IN', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(15, 'Iowa', 'IA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(16, 'Kansas', 'KS', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(17, 'Kentucky', 'KY', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(18, 'Louisiana', 'LA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(19, 'Maine', 'ME', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(20, 'Maryland', 'MD', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(21, 'Massachusetts', 'MA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(22, 'Michigan', 'MI', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(23, 'Minnesota', 'MN', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(24, 'Mississippi', 'MS', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(25, 'Missouri', 'MO', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(26, 'Montana', 'MT', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(27, 'Nebraska', 'NE', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(28, 'Nevada', 'NV', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(29, 'New Hampshire', 'NH', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(30, 'New Jersey', 'NJ', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(31, 'New Mexico', 'NM', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(32, 'New York', 'NY', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(33, 'North Carolina', 'NC', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(34, 'North Dakota', 'ND', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(35, 'Ohio', 'OH', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(36, 'Oklahoma', 'OK', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(37, 'Oregon', 'OR', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(38, 'Pennsylvania', 'PA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(39, 'Rhode Island', 'RI', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(40, 'South Carolina', 'SC', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(41, 'South Dakota', 'SD', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(42, 'Tennessee', 'TN', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(43, 'Texas', 'TX', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(44, 'Utah', 'UT', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(45, 'Vermont', 'VT', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(46, 'Virginia', 'VA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(47, 'Washington', 'WA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(48, 'West Virginia', 'WV', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(49, 'Wisconsin', 'WI', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(50, 'Wyoming', 'WY', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(51, 'District of Columbia', 'DC', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(52, 'American Samoa', 'AS', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(53, 'Guam', 'GU', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(54, 'Northern Mariana Islands', 'MP', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(55, 'Puerto Rico', 'PR', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(56, 'Virgin Islands', 'VI', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(57, 'United States Minor Outlying Islands', 'UM', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(58, 'Armed Forces Europe', 'AE', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(59, 'Armed Forces Americas', 'AA', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(60, 'Armed Forces Pacific', 'AP', 231, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(61, 'Alberta', 'AB', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(62, 'British Columbia', 'BC', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(63, 'Manitoba', 'MB', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(64, 'New Brunswick', 'NB', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(65, 'Newfoundland and Labrador', 'NL', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(66, 'Northwest Territories', 'NT', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(67, 'Nova Scotia', 'NS', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(68, 'Nunavut', 'NU', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(69, 'Ontario', 'ON', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(70, 'Prince Edward Island', 'PE', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(71, 'Quebec', 'QC', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(72, 'Saskatchewan', 'SK', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(73, 'Yukon Territory', 'YT', 38, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(74, 'Maharashtra', 'MM', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(75, 'Karnataka', 'KA', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(76, 'Andhra Pradesh', 'AP', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(77, 'Arunachal Pradesh', 'AR', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(78, 'Assam', 'AS', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(79, 'Bihar', 'BR', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(80, 'Chhattisgarh', 'CH', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(81, 'Goa', 'GA', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(82, 'Gujarat', 'GJ', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(83, 'Haryana', 'HR', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(84, 'Himachal Pradesh', 'HP', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(85, 'Jammu and Kashmir', 'JK', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(86, 'Jharkhand', 'JH', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(87, 'Kerala', 'KL', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(88, 'Madhya Pradesh', 'MP', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(89, 'Manipur', 'MN', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(90, 'Meghalaya', 'ML', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(91, 'Mizoram', 'MZ', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(92, 'Nagaland', 'NL', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(93, 'Orissa', 'OR', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(94, 'Punjab', 'PB', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(95, 'Rajasthan', 'RJ', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(96, 'Sikkim', 'SK', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(97, 'Tamil Nadu', 'TN', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(98, 'Tripura', 'TR', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(99, 'Uttaranchal', 'UL', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(100, 'Uttar Pradesh', 'UP', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(101, 'West Bengal', 'WB', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(102, 'Andaman and Nicobar Islands', 'AN', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(103, 'Dadra and Nagar Haveli', 'DN', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(104, 'Daman and Diu', 'DD', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(105, 'Delhi', 'DL', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(106, 'Lakshadweep', 'LD', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(107, 'Pondicherry', 'PY', 101, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(108, 'mazowieckie', 'MZ', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(109, 'pomorskie', 'PM', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(110, 'dolnośląskie', 'DS', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(111, 'kujawsko-pomorskie', 'KP', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(112, 'lubelskie', 'LU', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(113, 'lubuskie', 'LB', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(114, 'łódzkie', 'LD', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(115, 'małopolskie', 'MA', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(116, 'opolskie', 'OP', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(117, 'podkarpackie', 'PK', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(118, 'podlaskie', 'PD', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(119, 'śląskie', 'SL', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(120, 'świętokrzyskie', 'SK', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(121, 'warmińsko-mazurskie', 'WN', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(122, 'wielkopolskie', 'WP', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(123, 'zachodniopomorskie', 'ZP', 175, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(124, 'Abu Zaby', 'AZ', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(126, 'Al Fujayrah', 'FU', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(127, 'Ash Shariqah', 'SH', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(128, 'Dubayy', 'DU', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(129, 'Ra\'s al Khaymah', 'RK', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(130, 'Dac Lac', '33', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(131, 'Umm al Qaywayn', 'UQ', 1225, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(132, 'Badakhshan', 'BDS', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(133, 'Badghis', 'BDG', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(134, 'Baghlan', 'BGL', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(135, 'Balkh', 'BAL', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(136, 'Bamian', 'BAM', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(137, 'Farah', 'FRA', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(138, 'Faryab', 'FYB', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(139, 'Ghazni', 'GHA', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(140, 'Ghowr', 'GHO', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(141, 'Helmand', 'HEL', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(142, 'Herat', 'HER', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(143, 'Jowzjan', 'JOW', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(144, 'Kabul', 'KAB', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(145, 'Kandahar', 'KAN', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(146, 'Kapisa', 'KAP', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(147, 'Khowst', 'KHO', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(148, 'Konar', 'KNR', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(149, 'Kondoz', 'KDZ', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(150, 'Laghman', 'LAG', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(151, 'Lowgar', 'LOW', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(152, 'Nangrahar', 'NAN', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(153, 'Nimruz', 'NIM', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(154, 'Nurestan', 'NUR', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(155, 'Oruzgan', 'ORU', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(156, 'Paktia', 'PIA', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(157, 'Paktika', 'PKA', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(158, 'Parwan', 'PAR', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(159, 'Samangan', 'SAM', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(160, 'Sar-e Pol', 'SAR', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(161, 'Takhar', 'TAK', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(162, 'Wardak', 'WAR', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(163, 'Zabol', 'ZAB', 1, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(164, 'Berat', 'BR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(165, 'Bulqizë', 'BU', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(166, 'Delvinë', 'DL', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(167, 'Devoll', 'DV', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(168, 'Dibër', 'DI', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(169, 'Durrsës', 'DR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(170, 'Elbasan', 'EL', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(171, 'Fier', 'FR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(172, 'Gramsh', 'GR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(173, 'Gjirokastër', 'GJ', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(174, 'Has', 'HA', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(175, 'Kavajë', 'KA', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(176, 'Kolonjë', 'ER', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(177, 'Korcë', 'KO', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(178, 'Krujë', 'KR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(179, 'Kuçovë', 'KC', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(180, 'Kukës', 'KU', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(181, 'Kurbin', 'KB', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(182, 'Lezhë', 'LE', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(183, 'Librazhd', 'LB', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(184, 'Lushnjë', 'LU', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(185, 'Malësi e Madhe', 'MM', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(186, 'Mallakastër', 'MK', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(187, 'Mat', 'MT', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(188, 'Mirditë', 'MR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(189, 'Peqin', 'PQ', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(190, 'Përmet', 'PR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(191, 'Pogradec', 'PG', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(192, 'Pukë', 'PU', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(193, 'Sarandë', 'SR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(194, 'Skrapar', 'SK', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(195, 'Shkodër', 'SH', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(196, 'Tepelenë', 'TE', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(197, 'Tiranë', 'TR', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(198, 'Tropojë', 'TP', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(199, 'Vlorë', 'VL', 2, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(200, 'Erevan', 'ER', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(201, 'Aragacotn', 'AG', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(202, 'Ararat', 'AR', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(203, 'Armavir', 'AV', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(204, 'Gegarkunik\'', 'GR', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(205, 'Kotayk\'', 'KT', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(206, 'Lory', 'LO', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(207, 'Sirak', 'SH', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(208, 'Syunik\'', 'SU', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(209, 'Tavus', 'TV', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(210, 'Vayoc Jor', 'VD', 11, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(211, 'Bengo', 'BGO', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(212, 'Benguela', 'BGU', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(213, 'Bie', 'BIE', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(214, 'Cabinda', 'CAB', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(215, 'Cuando-Cubango', 'CCU', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(216, 'Cuanza Norte', 'CNO', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(217, 'Cuanza Sul', 'CUS', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(218, 'Cunene', 'CNN', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(219, 'Huambo', 'HUA', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(220, 'Huila', 'HUI', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(221, 'Luanda', 'LUA', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(222, 'Lunda Norte', 'LNO', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(223, 'Lunda Sul', 'LSU', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(224, 'Malange', 'MAL', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(225, 'Moxico', 'MOX', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(226, 'Namibe', 'NAM', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(227, 'Uige', 'UIG', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(228, 'Zaire', 'ZAI', 6, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(229, 'Capital federal', 'C', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(230, 'Buenos Aires', 'B', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(231, 'Catamarca', 'K', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(232, 'Cordoba', 'X', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(233, 'Corrientes', 'W', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(234, 'Chaco', 'H', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(235, 'Chubut', 'U', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(236, 'Entre Rios', 'E', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(237, 'Formosa', 'P', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(238, 'Jujuy', 'Y', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(239, 'La Pampa', 'L', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(240, 'Mendoza', 'M', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(241, 'Misiones', 'N', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(242, 'Neuquen', 'Q', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(243, 'Rio Negro', 'R', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(244, 'Salta', 'A', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(245, 'San Juan', 'J', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(246, 'San Luis', 'D', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(247, 'Santa Cruz', 'Z', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(248, 'Santa Fe', 'S', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(249, 'Santiago del Estero', 'G', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(250, 'Tierra del Fuego', 'V', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(251, 'Tucuman', 'T', 10, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(252, 'Burgenland', '1', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(253, 'Kärnten', '2', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(254, 'Niederosterreich', '3', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(255, 'Oberosterreich', '4', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(256, 'Salzburg', '5', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(257, 'Steiermark', '6', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(258, 'Tirol', '7', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(259, 'Vorarlberg', '8', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(260, 'Wien', '9', 14, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(261, 'Australian Antarctic Territory', 'AAT', 8, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(262, 'Australian Capital Territory', 'ACT', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(263, 'Northern Territory', 'NT', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(264, 'New South Wales', 'NSW', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(265, 'Queensland', 'QLD', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(266, 'South Australia', 'SA', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(267, 'Tasmania', 'TAS', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(268, 'Victoria', 'VIC', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(269, 'Western Australia', 'WA', 13, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(270, 'Naxcivan', 'NX', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(271, 'Ali Bayramli', 'AB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(272, 'Baki', 'BA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(273, 'Ganca', 'GA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(274, 'Lankaran', 'LA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(275, 'Mingacevir', 'MI', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(276, 'Naftalan', 'NA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(277, 'Saki', 'SA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(278, 'Sumqayit', 'SM', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(279, 'Susa', 'SS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(280, 'Xankandi', 'XA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(281, 'Yevlax', 'YE', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(282, 'Abseron', 'ABS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(283, 'Agcabadi', 'AGC', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(284, 'Agdam', 'AGM', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(285, 'Agdas', 'AGS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(286, 'Agstafa', 'AGA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(287, 'Agsu', 'AGU', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(288, 'Astara', 'AST', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(289, 'Babak', 'BAB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(290, 'Balakan', 'BAL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(291, 'Barda', 'BAR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(292, 'Beylagan', 'BEY', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(293, 'Bilasuvar', 'BIL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(294, 'Cabrayll', 'CAB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(295, 'Calilabad', 'CAL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(296, 'Culfa', 'CUL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(297, 'Daskasan', 'DAS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(298, 'Davaci', 'DAV', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(299, 'Fuzuli', 'FUZ', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(300, 'Gadabay', 'GAD', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(301, 'Goranboy', 'GOR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(302, 'Goycay', 'GOY', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(303, 'Haciqabul', 'HAC', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(304, 'Imisli', 'IMI', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(305, 'Ismayilli', 'ISM', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(306, 'Kalbacar', 'KAL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(307, 'Kurdamir', 'KUR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(308, 'Lacin', 'LAC', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(309, 'Lerik', 'LER', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(310, 'Masalli', 'MAS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(311, 'Neftcala', 'NEF', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(312, 'Oguz', 'OGU', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(313, 'Ordubad', 'ORD', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(314, 'Qabala', 'QAB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(315, 'Qax', 'QAX', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(316, 'Qazax', 'QAZ', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(317, 'Qobustan', 'QOB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(318, 'Quba', 'QBA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(319, 'Qubadli', 'QBI', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(320, 'Qusar', 'QUS', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(321, 'Saatli', 'SAT', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(322, 'Sabirabad', 'SAB', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(323, 'Sadarak', 'SAD', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(324, 'Sahbuz', 'SAH', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(325, 'Salyan', 'SAL', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(326, 'Samaxi', 'SMI', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(327, 'Samkir', 'SKR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(328, 'Samux', 'SMX', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(329, 'Sarur', 'SAR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(330, 'Siyazan', 'SIY', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(331, 'Tartar', 'TAR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(332, 'Tovuz', 'TOV', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(333, 'Ucar', 'UCA', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(334, 'Xacmaz', 'XAC', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(335, 'Xanlar', 'XAN', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(336, 'Xizi', 'XIZ', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(337, 'Xocali', 'XCI', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(338, 'Xocavand', 'XVD', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(339, 'Yardimli', 'YAR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(340, 'Zangilan', 'ZAN', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(341, 'Zaqatala', 'ZAQ', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(342, 'Zardab', 'ZAR', 15, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(343, 'Federacija Bosna i Hercegovina', 'BIH', 27, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(344, 'Republika Srpska', 'SRP', 27, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(345, 'Bagerhat zila', '5', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(346, 'Bandarban zila', '1', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(347, 'Barguna zila', '2', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(348, 'Barisal zila', '6', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(349, 'Bhola zila', '7', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(350, 'Bogra zila', '3', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(351, 'Brahmanbaria zila', '4', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(352, 'Chandpur zila', '9', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(353, 'Chittagong zila', '10', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(354, 'Chuadanga zila', '12', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(355, 'Comilla zila', '8', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(356, 'Cox\'s Bazar zila', '11', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(357, 'Dhaka zila', '13', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(358, 'Dinajpur zila', '14', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(359, 'Faridpur zila', '15', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(360, 'Feni zila', '16', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(361, 'Gaibandha zila', '19', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(362, 'Gazipur zila', '18', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(363, 'Gopalganj zila', '17', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(364, 'Habiganj zila', '20', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(365, 'Jaipurhat zila', '24', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(366, 'Jamalpur zila', '21', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(367, 'Jessore zila', '22', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(368, 'Jhalakati zila', '25', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(369, 'Jhenaidah zila', '23', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(370, 'Khagrachari zila', '29', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(371, 'Khulna zila', '27', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(372, 'Kishorganj zila', '26', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(373, 'Kurigram zila', '28', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(374, 'Kushtia zila', '30', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(375, 'Lakshmipur zila', '31', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(376, 'Lalmonirhat zila', '32', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(377, 'Madaripur zila', '36', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(378, 'Magura zila', '37', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(379, 'Manikganj zila', '33', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(380, 'Meherpur zila', '39', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(381, 'Moulvibazar zila', '38', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(382, 'Munshiganj zila', '35', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(383, 'Mymensingh zila', '34', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(384, 'Naogaon zila', '48', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(385, 'Narail zila', '43', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(386, 'Narayanganj zila', '40', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(387, 'Narsingdi zila', '42', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(388, 'Natore zila', '44', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(389, 'Nawabganj zila', '45', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(390, 'Netrakona zila', '41', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(391, 'Nilphamari zila', '46', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(392, 'Noakhali zila', '47', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(393, 'Pabna zila', '50', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(394, 'Panchagarh zila', '52', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(395, 'Patuakhali zila', '51', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(396, 'Pirojpur zila', '50', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(397, 'Rajbari zila', '53', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(398, 'Rajshahi zila', '54', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(399, 'Rangamati zila', '56', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(400, 'Rangpur zila', '55', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(401, 'Satkhira zila', '58', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(402, 'Shariatpur zila', '62', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(403, 'Sherpur zila', '57', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(404, 'Sirajganj zila', '59', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(405, 'Sunamganj zila', '61', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(406, 'Sylhet zila', '60', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(407, 'Tangail zila', '63', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(408, 'Thakurgaon zila', '64', 18, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(409, 'Antwerpen', 'VAN', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(410, 'Brabant Wallon', 'WBR', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(411, 'Hainaut', 'WHT', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(412, 'Liege', 'WLG', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(413, 'Limburg', 'VLI', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(414, 'Luxembourg', 'WLX', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(415, 'Namur', 'WNA', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(416, 'Oost-Vlaanderen', 'VOV', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(417, 'Vlaams-Brabant', 'VBR', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(418, 'West-Vlaanderen', 'VWV', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(419, 'Bale', 'BAL', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(420, 'Bam', 'BAM', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(421, 'Banwa', 'BAN', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(422, 'Bazega', 'BAZ', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(423, 'Bougouriba', 'BGR', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(424, 'Boulgou', 'BLG', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(425, 'Boulkiemde', 'BLK', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(426, 'Comoe', 'COM', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(427, 'Ganzourgou', 'GAN', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(428, 'Gnagna', 'GNA', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(429, 'Gourma', 'GOU', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(430, 'Houet', 'HOU', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(431, 'Ioba', 'IOB', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(432, 'Kadiogo', 'KAD', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(433, 'Kenedougou', 'KEN', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(434, 'Komondjari', 'KMD', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(435, 'Kompienga', 'KMP', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(436, 'Kossi', 'KOS', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(437, 'Koulpulogo', 'KOP', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(438, 'Kouritenga', 'KOT', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(439, 'Kourweogo', 'KOW', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(440, 'Leraba', 'LER', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(441, 'Loroum', 'LOR', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(442, 'Mouhoun', 'MOU', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(443, 'Nahouri', 'NAO', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(444, 'Namentenga', 'NAM', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(445, 'Nayala', 'NAY', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(446, 'Noumbiel', 'NOU', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(447, 'Oubritenga', 'OUB', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(448, 'Oudalan', 'OUD', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(449, 'Passore', 'PAS', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(450, 'Poni', 'PON', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(451, 'Sanguie', 'SNG', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(452, 'Sanmatenga', 'SMT', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(453, 'Seno', 'SEN', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(454, 'Siasili', 'SIS', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(455, 'Soum', 'SOM', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(456, 'Sourou', 'SOR', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(457, 'Tapoa', 'TAP', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(458, 'Tui', 'TUI', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(459, 'Yagha', 'YAG', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(460, 'Yatenga', 'YAT', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(461, 'Ziro', 'ZIR', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(462, 'Zondoma', 'ZON', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(463, 'Zoundweogo', 'ZOU', 34, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(464, 'Blagoevgrad', '1', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(465, 'Burgas', '2', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(466, 'Dobric', '8', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(467, 'Gabrovo', '7', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(468, 'Haskovo', '26', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(469, 'Jambol', '28', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(470, 'Kardzali', '9', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(471, 'Kjstendil', '10', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(472, 'Lovec', '11', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(473, 'Montana', '12', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(474, 'Pazardzik', '13', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(475, 'Pernik', '14', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(476, 'Pleven', '15', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(477, 'Plovdiv', '16', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(478, 'Razgrad', '17', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(479, 'Ruse', '18', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(480, 'Silistra', '19', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(481, 'Sliven', '20', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(482, 'Smoljan', '21', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(483, 'Sofia', '23', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(484, 'Stara Zagora', '24', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(485, 'Sumen', '27', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(486, 'Targoviste', '25', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(487, 'Varna', '3', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(488, 'Veliko Tarnovo', '4', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(489, 'Vidin', '5', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(490, 'Vraca', '6', 33, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(491, 'Al Hadd', '1', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(492, 'Al Manamah', '3', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(493, 'Al Mintaqah al Gharbiyah', '10', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(494, 'Al Mintagah al Wusta', '7', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(495, 'Al Mintaqah ash Shamaliyah', '5', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(496, 'Al Muharraq', '2', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(497, 'Ar Rifa', '9', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(498, 'Jidd Hafs', '4', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(499, 'Madluat Jamad', '12', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(500, 'Madluat Isa', '8', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(501, 'Mintaqat Juzur tawar', '11', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(502, 'Sitrah', '6', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(503, 'Bubanza', 'BB', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(504, 'Bujumbura', 'BJ', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(505, 'Bururi', 'BR', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(506, 'Cankuzo', 'CA', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(507, 'Cibitoke', 'CI', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(508, 'Gitega', 'GI', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(509, 'Karuzi', 'KR', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(510, 'Kayanza', 'KY', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(511, 'Makamba', 'MA', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(512, 'Muramvya', 'MU', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(513, 'Mwaro', 'MW', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(514, 'Ngozi', 'NG', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(515, 'Rutana', 'RT', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(516, 'Ruyigi', 'RY', 35, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(517, 'Alibori', 'AL', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(518, 'Atakora', 'AK', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(519, 'Atlantique', 'AQ', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(520, 'Borgou', 'BO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(521, 'Collines', 'CO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(522, 'Donga', 'DO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(523, 'Kouffo', 'KO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(524, 'Littoral', 'LI', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(525, 'Mono', 'MO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(526, 'Oueme', 'OU', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(527, 'Plateau', 'PL', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(528, 'Zou', 'ZO', 23, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(529, 'Belait', 'BE', 32, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(530, 'Brunei-Muara', 'BM', 32, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(531, 'Temburong', 'TE', 32, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(532, 'Tutong', 'TU', 32, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(533, 'Cochabamba', 'C', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(534, 'Chuquisaca', 'H', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(535, 'El Beni', 'B', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(536, 'La Paz', 'L', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(537, 'Oruro', 'O', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(538, 'Pando', 'N', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(539, 'Potosi', 'P', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(540, 'Tarija', 'T', 26, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(541, 'Acre', 'AC', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(542, 'Alagoas', 'AL', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(543, 'Amazonas', 'AM', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(544, 'Amapa', 'AP', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(545, 'Baia', 'BA', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(546, 'Ceara', 'CE', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(547, 'Distrito Federal', 'DF', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(548, 'Espirito Santo', 'ES', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(549, 'Fernando de Noronha', 'FN', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(550, 'Goias', 'GO', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(551, 'Maranhao', 'MA', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(552, 'Minas Gerais', 'MG', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(553, 'Mato Grosso do Sul', 'MS', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(554, 'Mato Grosso', 'MT', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(555, 'Para', 'PA', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(556, 'Paraiba', 'PB', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(557, 'Pernambuco', 'PE', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(558, 'Piaui', 'PI', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(559, 'Parana', 'PR', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(560, 'Rio de Janeiro', 'RJ', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(561, 'Rio Grande do Norte', 'RN', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(562, 'Rondonia', 'RO', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(563, 'Roraima', 'RR', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(564, 'Rio Grande do Sul', 'RS', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(565, 'Santa Catarina', 'SC', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(566, 'Sergipe', 'SE', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(567, 'Sao Paulo', 'SP', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(568, 'Tocatins', 'TO', 30, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(569, 'Acklins and Crooked Islands', 'AC', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(570, 'Bimini', 'BI', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(571, 'Cat Island', 'CI', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(572, 'Exuma', 'EX', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(573, 'Freeport', 'FP', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(574, 'Fresh Creek', 'FC', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(575, 'Governor\'s Harbour', 'GH', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(576, 'Green Turtle Cay', 'GT', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(577, 'Harbour Island', 'HI', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(578, 'High Rock', 'HR', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(579, 'Inagua', 'IN', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(580, 'Kemps Bay', 'KB', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(581, 'Long Island', 'LI', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(582, 'Marsh Harbour', 'MH', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(583, 'Mayaguana', 'MG', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(584, 'New Providence', 'NP', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(585, 'Nicholls Town and Berry Islands', 'NB', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(586, 'Ragged Island', 'RI', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(587, 'Rock Sound', 'RS', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(588, 'Sandy Point', 'SP', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(589, 'San Salvador and Rum Cay', 'SR', 16, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(590, 'Bumthang', '33', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(591, 'Chhukha', '12', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(592, 'Dagana', '22', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(593, 'Gasa', 'GA', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(594, 'Ha', '13', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(595, 'Lhuentse', '44', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(596, 'Monggar', '42', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(597, 'Paro', '11', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(598, 'Pemagatshel', '43', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(599, 'Punakha', '23', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(600, 'Samdrup Jongkha', '45', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(601, 'Samtee', '14', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(602, 'Sarpang', '31', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(603, 'Thimphu', '15', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(604, 'Trashigang', '41', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(605, 'Trashi Yangtse', 'TY', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(606, 'Trongsa', '32', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(607, 'Tsirang', '21', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(608, 'Wangdue Phodrang', '24', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(609, 'Zhemgang', '34', 25, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(610, 'Central', 'CE', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(611, 'Ghanzi', 'GH', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(612, 'Kgalagadi', 'KG', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(613, 'Kgatleng', 'KL', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(614, 'Kweneng', 'KW', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(615, 'Ngamiland', 'NG', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(616, 'North-East', 'NE', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(617, 'North-West', 'NW', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(618, 'South-East', 'SE', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(619, 'Southern', 'SO', 28, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(620, 'Brèsckaja voblasc\'', 'BR', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(621, 'Homel\'skaja voblasc\'', 'HO', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(622, 'Hrodzenskaja voblasc\'', 'HR', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(623, 'Mahilëuskaja voblasc\'', 'MA', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(624, 'Minskaja voblasc\'', 'MI', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(625, 'Vicebskaja voblasc\'', 'VI', 20, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(626, 'Belize', 'BZ', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(627, 'Cayo', 'CY', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(628, 'Corozal', 'CZL', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(629, 'Orange Walk', 'OW', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(630, 'Stann Creek', 'SC', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(631, 'Toledo', 'TOL', 22, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(632, 'Kinshasa', 'KN', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(633, 'Bandundu', 'BN', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(634, 'Bas-Congo', 'BC', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(635, 'Equateur', 'EQ', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(636, 'Haut-Congo', 'HC', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(637, 'Kasai-Occidental', 'KW', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(638, 'Kasai-Oriental', 'KE', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(639, 'Katanga', 'KA', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(640, 'Maniema', 'MA', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(641, 'Nord-Kivu', 'NK', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(642, 'Orientale', 'OR', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(643, 'Sud-Kivu', 'SK', 49, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(644, 'Bangui', 'BGF', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(645, 'Bamingui-Bangoran', 'BB', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(646, 'Basse-Kotto', 'BK', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(647, 'Haute-Kotto', 'HK', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(648, 'Haut-Mbomou', 'HM', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(649, 'Kemo', 'KG', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(650, 'Lobaye', 'LB', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(651, 'Mambere-Kadei', 'HS', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(652, 'Mbomou', 'MB', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(653, 'Nana-Grebizi', 'KB', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(654, 'Nana-Mambere', 'NM', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(655, 'Ombella-Mpoko', 'MP', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(656, 'Ouaka', 'UK', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(657, 'Ouham', 'AC', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(658, 'Ouham-Pende', 'OP', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(659, 'Sangha-Mbaere', 'SE', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(660, 'Vakaga', 'VR', 41, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(661, 'Brazzaville', 'BZV', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(662, 'Bouenza', '11', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(663, 'Cuvette', '8', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(664, 'Cuvette-Ouest', '15', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(665, 'Kouilou', '5', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(666, 'Lekoumou', '2', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(667, 'Likouala', '7', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(668, 'Niari', '9', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(669, 'Plateaux', '14', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(670, 'Pool', '12', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(671, 'Sangha', '13', 50, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(672, 'Aargau', 'AG', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(673, 'Appenzell Innerrhoden', 'AI', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(674, 'Appenzell Ausserrhoden', 'AR', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(675, 'Bern', 'BE', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(676, 'Basel-Landschaft', 'BL', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(677, 'Basel-Stadt', 'BS', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(678, 'Fribourg', 'FR', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(679, 'Geneva', 'GE', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(680, 'Glarus', 'GL', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(681, 'Graubunden', 'GR', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(682, 'Jura', 'JU', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(683, 'Luzern', 'LU', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(684, 'Neuchatel', 'NE', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(685, 'Nidwalden', 'NW', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(686, 'Obwalden', 'OW', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(687, 'Sankt Gallen', 'SG', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(688, 'Schaffhausen', 'SH', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(689, 'Solothurn', 'SO', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(690, 'Schwyz', 'SZ', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(691, 'Thurgau', 'TG', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(692, 'Ticino', 'TI', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(693, 'Uri', 'UR', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(694, 'Vaud', 'VD', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(695, 'Valais', 'VS', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(696, 'Zug', 'ZG', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(697, 'Zurich', 'ZH', 212, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(698, 'Montagnes', 'MT', 53, b'1', 1, '2018-06-29 06:11:24', 297, '2018-11-16 05:59:28'),
(699, 'Agnebi', '16', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(700, 'Bas-Sassandra', '9', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(701, 'Denguele', '10', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(702, 'Haut-Sassandra', '2', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(703, 'Lacs', '7', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(704, 'Lagunes', '1', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(705, 'Marahoue', '12', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(706, 'Moyen-Comoe', '5', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(707, 'Nzi-Comoe', '11', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(708, 'Savanes', '3', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(709, 'Sud-Bandama', '15', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(710, 'Sud-Comoe', '13', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(711, 'Vallee du Bandama', '4', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(712, 'Worodouqou', '14', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(713, 'Zanzan', '8', 53, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(714, 'Aisen del General Carlos Ibanez del Campo', 'AI', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(715, 'Antofagasta', 'AN', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(716, 'Araucania', 'AR', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(717, 'Atacama', 'AT', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(718, 'Bio-Bio', 'BI', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(719, 'Coquimbo', 'CO', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(720, 'Libertador General Bernardo O\'Higgins', 'LI', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(721, 'Los Lagos', 'LL', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(722, 'Magallanes', 'MA', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(723, 'Maule', 'ML', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(724, 'Region Metropolitana de Santiago', 'RM', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(725, 'Tarapaca', 'TA', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(726, 'Valparaiso', 'VS', 43, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(727, 'Adamaoua', 'AD', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(728, 'Centre', 'CE', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(729, 'East', 'ES', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(730, 'Far North', 'EN', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(731, 'North', 'NO', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(732, 'South', 'SW', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(733, 'South-West', 'SW', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(734, 'West', 'OU', 37, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(735, 'Beijing', '11', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(736, 'Chongqing', '50', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(737, 'Shanghai', '31', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(738, 'Tianjin', '12', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(739, 'Anhui', '34', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(740, 'Fujian', '35', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(741, 'Gansu', '62', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(742, 'Guangdong', '44', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(743, 'Guizhou', '52', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(744, 'Hainan', '46', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(745, 'Hebei', '13', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(746, 'Heilongjiang', '23', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(747, 'Henan', '41', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(748, 'Hubei', '42', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(749, 'Hunan', '43', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(750, 'Jiangsu', '32', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(751, 'Jiangxi', '36', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(752, 'Jilin', '22', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(753, 'Liaoning', '21', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(754, 'Qinghai', '63', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(755, 'Shaanxi', '61', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(756, 'Shandong', '37', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(757, 'Shanxi', '14', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(758, 'Sichuan', '51', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(759, 'Taiwan', '71', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(760, 'Yunnan', '53', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(761, 'Zhejiang', '33', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(762, 'Guangxi', '45', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(763, 'Neia Mongol (mn)', '15', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(764, 'Xinjiang', '65', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(765, 'Xizang', '54', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(766, 'Hong Kong', '91', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(767, 'Macau', '92', 44, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(768, 'Distrito Capital de Bogotá', 'DC', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(769, 'Amazonea', 'AMA', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(770, 'Antioquia', 'ANT', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(771, 'Arauca', 'ARA', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(772, 'Atlántico', 'ATL', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(773, 'Bolívar', 'BOL', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(774, 'Boyacá', 'BOY', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(775, 'Caldea', 'CAL', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(776, 'Caquetá', 'CAQ', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(777, 'Casanare', 'CAS', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(778, 'Cauca', 'CAU', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(779, 'Cesar', 'CES', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(780, 'Córdoba', 'COR', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(781, 'Cundinamarca', 'CUN', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(782, 'Chocó', 'CHO', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(783, 'Guainía', 'GUA', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(784, 'Guaviare', 'GUV', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(785, 'La Guajira', 'LAG', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(786, 'Magdalena', 'MAG', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(787, 'Meta', 'MET', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(788, 'Nariño', 'NAR', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(789, 'Norte de Santander', 'NSA', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(790, 'Putumayo', 'PUT', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(791, 'Quindio', 'QUI', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(792, 'Risaralda', 'RIS', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(793, 'San Andrés, Providencia y Santa Catalina', 'SAP', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(794, 'Santander', 'SAN', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(795, 'Sucre', 'SUC', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(796, 'Tolima', 'TOL', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(797, 'Valle del Cauca', 'VAC', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(798, 'Vaupés', 'VAU', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(799, 'Vichada', 'VID', 47, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(800, 'Alajuela', 'A', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(801, 'Cartago', 'C', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(802, 'Guanacaste', 'G', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(803, 'Heredia', 'H', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(804, 'Limon', 'L', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(805, 'Puntarenas', 'P', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(806, 'San Jose', 'SJ', 52, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(807, 'Camagey', '9', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(808, 'Ciego de `vila', '8', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(809, 'Cienfuegos', '6', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(810, 'Ciudad de La Habana', '3', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(811, 'Granma', '12', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(812, 'Guantanamo', '14', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(813, 'Holquin', '11', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(814, 'La Habana', '2', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(815, 'Las Tunas', '10', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(816, 'Matanzas', '4', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(817, 'Pinar del Rio', '1', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(818, 'Sancti Spiritus', '7', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(819, 'Santiago de Cuba', '13', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(820, 'Villa Clara', '5', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(821, 'Isla de la Juventud', '99', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(822, 'Pinar del Roo', 'PR', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(823, 'Ciego de Avila', 'CA', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(824, 'Camagoey', 'CG', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(825, 'Holgun', 'HO', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(826, 'Sancti Spritus', 'SS', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(827, 'Municipio Especial Isla de la Juventud', 'IJ', 55, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(828, 'Boa Vista', 'BV', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(829, 'Brava', 'BR', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(830, 'Calheta de Sao Miguel', 'CS', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(831, 'Fogo', 'FO', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(832, 'Maio', 'MA', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(833, 'Mosteiros', 'MO', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(834, 'Paul', 'PA', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(835, 'Porto Novo', 'PN', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(836, 'Praia', 'PR', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(837, 'Ribeira Grande', 'RG', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(838, 'Sal', 'SL', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(839, 'Sao Domingos', 'SD', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(840, 'Sao Filipe', 'SF', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(841, 'Sao Nicolau', 'SN', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(842, 'Sao Vicente', 'SV', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(843, 'Tarrafal', 'TA', 39, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(844, 'Ammochostos Magusa', '4', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(845, 'Keryneia', '6', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(846, 'Larnaka', '3', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(847, 'Lefkosia', '1', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(848, 'Lemesos', '2', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(849, 'Pafos', '5', 56, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(850, 'Jihočeský kraj', 'JC', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(851, 'Jihomoravský kraj', 'JM', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(852, 'Karlovarský kraj', 'KA', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(853, 'Královéhradecký kraj', 'KR', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(854, 'Liberecký kraj', 'LI', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(855, 'Moravskoslezský kraj', 'MO', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(856, 'Olomoucký kraj', 'OL', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(857, 'Pardubický kraj', 'PA', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(858, 'Plzeňský kraj', 'PL', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(859, 'Praha, hlavní město', 'PR', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(860, 'Středočeský kraj', 'ST', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(861, 'Ústecký kraj', 'US', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(862, 'Vysočina', 'VY', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(863, 'Zlínský kraj', 'ZL', 57, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(864, 'Baden-Wuerttemberg', 'BW', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(865, 'Bayern', 'BY', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(866, 'Bremen', 'HB', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(867, 'Hamburg', 'HH', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(868, 'Hessen', 'HE', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(869, 'Niedersachsen', 'NI', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(870, 'Nordrhein-Westfalen', 'NW', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(871, 'Rheinland-Pfalz', 'RP', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(872, 'Saarland', 'SL', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(873, 'Schleswig-Holstein', 'SH', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(874, 'Berlin', 'BR', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(875, 'Brandenburg', 'BB', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(876, 'Mecklenburg-Vorpommern', 'MV', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(877, 'Sachsen', 'SN', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(878, 'Sachsen-Anhalt', 'ST', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(879, 'Thueringen', 'TH', 82, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(880, 'Ali Sabiah', 'AS', 59, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(881, 'Dikhil', 'DI', 59, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(882, 'Djibouti', 'DJ', 59, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(883, 'Obock', 'OB', 59, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(884, 'Tadjoura', 'TA', 59, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(885, 'Frederiksberg', '147', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(886, 'Copenhagen City', '101', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(887, 'Copenhagen', '15', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(888, 'Frederiksborg', '20', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(889, 'Roskilde', '25', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(890, 'Vestsjælland', '30', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(891, 'Storstrøm', '35', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(892, 'Bornholm', '40', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(893, 'Fyn', '42', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(894, 'South Jutland', '50', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(895, 'Ribe', '55', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(896, 'Vejle', '60', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(897, 'Ringkjøbing', '65', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(898, 'Århus', '70', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(899, 'Viborg', '76', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(900, 'North Jutland', '80', 58, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(901, 'Distrito Nacional (Santo Domingo)', '1', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(902, 'Azua', '2', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(903, 'Bahoruco', '3', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(904, 'Barahona', '4', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(905, 'Dajabón', '5', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(906, 'Duarte', '6', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(907, 'El Seybo [El Seibo]', '8', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(908, 'Espaillat', '9', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(909, 'Hato Mayor', '30', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(910, 'Independencia', '10', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(911, 'La Altagracia', '11', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(912, 'La Estrelleta [Elias Pina]', '7', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(913, 'La Romana', '12', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(914, 'La Vega', '13', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(915, 'Maroia Trinidad Sánchez', '14', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(916, 'Monseñor Nouel', '28', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(917, 'Monte Cristi', '15', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(918, 'Monte Plata', '29', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(919, 'Pedernales', '16', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(920, 'Peravia', '17', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(921, 'Puerto Plata', '18', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(922, 'Salcedo', '19', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(923, 'Samaná', '20', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(924, 'San Cristóbal', '21', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(925, 'San Pedro de Macorís', '23', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(926, 'Sánchez Ramírez', '24', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(927, 'Santiago', '25', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(928, 'Santiago Rodríguez', '26', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(929, 'Valverde', '27', 61, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(930, 'Adrar', '1', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(931, 'Ain Defla', '44', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(932, 'Ain Tmouchent', '46', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(933, 'Alger', '16', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(934, 'Annaba', '23', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(935, 'Batna', '5', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(936, 'Bechar', '8', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(937, 'Bejaia', '6', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(938, 'Biskra', '7', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(939, 'Blida', '9', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(940, 'Bordj Bou Arreridj', '34', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(941, 'Bouira', '10', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(942, 'Boumerdes', '35', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(943, 'Chlef', '2', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(944, 'Constantine', '25', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(945, 'Djelfa', '17', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(946, 'El Bayadh', '32', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(947, 'El Oued', '39', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(948, 'El Tarf', '36', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(949, 'Ghardaia', '47', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(950, 'Guelma', '24', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(951, 'Illizi', '33', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(952, 'Jijel', '18', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(953, 'Khenchela', '40', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(954, 'Laghouat', '3', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(955, 'Mascara', '29', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(956, 'Medea', '26', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(957, 'Mila', '43', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(958, 'Mostaganem', '27', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(959, 'Msila', '28', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(960, 'Naama', '45', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(961, 'Oran', '31', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(962, 'Ouargla', '30', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(963, 'Oum el Bouaghi', '4', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(964, 'Relizane', '48', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(965, 'Saida', '20', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(966, 'Setif', '19', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(967, 'Sidi Bel Abbes', '22', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(968, 'Skikda', '21', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(969, 'Souk Ahras', '41', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(970, 'Tamanghasset', '11', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(971, 'Tebessa', '12', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(972, 'Tiaret', '14', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(973, 'Tindouf', '37', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(974, 'Tipaza', '42', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(975, 'Tissemsilt', '38', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(976, 'Tizi Ouzou', '15', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(977, 'Tlemcen', '13', 3, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(978, 'Azuay', 'A', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(979, 'Bolivar', 'B', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(980, 'Canar', 'F', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(981, 'Carchi', 'C', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(982, 'Cotopaxi', 'X', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(983, 'Chimborazo', 'H', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(984, 'El Oro', 'O', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(985, 'Esmeraldas', 'E', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(986, 'Galapagos', 'W', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(987, 'Guayas', 'G', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(988, 'Imbabura', 'I', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(989, 'Loja', 'L', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(990, 'Los Rios', 'R', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(991, 'Manabi', 'M', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(992, 'Morona-Santiago', 'S', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(993, 'Napo', 'N', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(994, 'Orellana', 'D', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(995, 'Pastaza', 'Y', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(996, 'Pichincha', 'P', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(997, 'Sucumbios', 'U', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(998, 'Tungurahua', 'T', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(999, 'Zamora-Chinchipe', 'Z', 63, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1000, 'Harjumsa', '37', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1001, 'Hitumea', '39', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1002, 'Ida-Virumsa', '44', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1003, 'Jogevamsa', '50', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1004, 'Jarvamsa', '51', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1005, 'Lasnemsa', '57', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1006, 'Laane-Virumaa', '59', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1007, 'Polvamea', '65', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1008, 'Parnumsa', '67', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1009, 'Raplamsa', '70', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1010, 'Saaremsa', '74', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1011, 'Tartumsa', '7B', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1012, 'Valgamaa', '82', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1013, 'Viljandimsa', '84', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1014, 'Vorumaa', '86', 68, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1015, 'Ad Daqahllyah', 'DK', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1016, 'Al Bahr al Ahmar', 'BA', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1017, 'Al Buhayrah', 'BH', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1018, 'Al Fayym', 'FYM', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1019, 'Al Gharbiyah', 'GH', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1020, 'Al Iskandarlyah', 'ALX', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1021, 'Al Isma illyah', 'IS', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1022, 'Al Jizah', 'GZ', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1023, 'Al Minuflyah', 'MNF', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1024, 'Al Minya', 'MN', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1025, 'Al Qahirah', 'C', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1026, 'Al Qalyublyah', 'KB', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1027, 'Al Wadi al Jadid', 'WAD', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1028, 'Ash Sharqiyah', 'SHR', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1029, 'As Suways', 'SUZ', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1030, 'Aswan', 'ASN', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1031, 'Asyut', 'AST', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1032, 'Bani Suwayf', 'BNS', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1033, 'Bur Sa\'id', 'PTS', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1034, 'Dumyat', 'DT', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1035, 'Janub Sina\'', 'JS', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1036, 'Kafr ash Shaykh', 'KFS', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1037, 'Matruh', 'MT', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1038, 'Qina', 'KN', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1039, 'Shamal Sina\'', 'SIN', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1040, 'Suhaj', 'SHG', 64, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1041, 'Anseba', 'AN', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1042, 'Debub', 'DU', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1043, 'Debubawi Keyih Bahri [Debub-Keih-Bahri]', 'DK', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1044, 'Gash-Barka', 'GB', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1045, 'Maakel [Maekel]', 'MA', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1046, 'Semenawi Keyih Bahri [Semien-Keih-Bahri]', 'SK', 67, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1047, 'Álava', 'VI', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1048, 'Albacete', 'AB', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1049, 'Alicante', 'A', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1050, 'Almería', 'AL', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1051, 'Asturias', 'O', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1052, 'Ávila', 'AV', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1053, 'Badajoz', 'BA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1054, 'Baleares', 'PM', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1055, 'Barcelona', 'B', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1056, 'Burgos', 'BU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1057, 'Cáceres', 'CC', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1058, 'Cádiz', 'CA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1059, 'Cantabria', 'S', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1060, 'Castellón', 'CS', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1061, 'Ciudad Real', 'CR', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1062, 'Cuenca', 'CU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1063, 'Girona [Gerona]', 'GE', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1064, 'Granada', 'GR', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1065, 'Guadalajara', 'GU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1066, 'Guipúzcoa', 'SS', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1067, 'Huelva', 'H', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1068, 'Huesca', 'HU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1069, 'Jaén', 'J', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1070, 'La Coruña', 'C', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1071, 'La Rioja', 'LO', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1072, 'Las Palmas', 'GC', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1073, 'León', 'LE', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1074, 'Lleida [Lérida]', 'L', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1075, 'Lugo', 'LU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1076, 'Madrid', 'M', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1077, 'Málaga', 'MA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1078, 'Murcia', 'MU', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1079, 'Navarra', 'NA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1080, 'Ourense', 'OR', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1081, 'Palencia', 'P', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1082, 'Pontevedra', 'PO', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1083, 'Salamanca', 'SA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1084, 'Santa Cruz de Tenerife', 'TF', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1085, 'Segovia', 'SG', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1086, 'Sevilla', 'SE', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1087, 'Soria', 'SO', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1088, 'Tarragona', 'T', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1089, 'Teruel', 'TE', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1090, 'Valencia', 'V', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1091, 'Valladolid', 'VA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1092, 'Vizcaya', 'BI', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1093, 'Zamora', 'ZA', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1094, 'Zaragoza', 'Z', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1095, 'Ceuta', 'CE', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1096, 'Melilla', 'ML', 205, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1097, 'Addis Ababa', 'AA', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1098, 'Dire Dawa', 'DD', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1099, 'Afar', 'AF', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1100, 'Amara', 'AM', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1101, 'Benshangul-Gumaz', 'BE', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1102, 'Gambela Peoples', 'GA', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1103, 'Harari People', 'HA', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1104, 'Oromia', 'OR', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1105, 'Somali', 'SO', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1106, 'Southern Nations, Nationalities and Peoples', 'SN', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1107, 'Tigrai', 'TI', 69, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1108, 'Eastern', 'E', 73, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1109, 'Northern', 'N', 73, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1110, 'Western', 'W', 73, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1111, 'Rotuma', 'R', 73, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1112, 'Chuuk', 'TRK', 143, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1113, 'Kosrae', 'KSA', 143, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1114, 'Pohnpei', 'PNI', 143, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1115, 'Yap', 'YAP', 143, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1116, 'Ain', '1', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1117, 'Aisne', '2', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1118, 'Allier', '3', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1119, 'Alpes-de-Haute-Provence', '4', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1120, 'Alpes-Maritimes', '6', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1121, 'Ardèche', '7', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1122, 'Ardennes', '8', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1123, 'Ariège', '9', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1124, 'Aube', '10', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1125, 'Aude', '11', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1126, 'Aveyron', '12', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1127, 'Bas-Rhin', '67', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1128, 'Bouches-du-Rhône', '13', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1129, 'Calvados', '14', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1130, 'Cantal', '15', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1131, 'Charente', '16', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1132, 'Charente-Maritime', '17', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1133, 'Cher', '18', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1134, 'Corrèze', '19', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1135, 'Corse-du-Sud', '20A', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1136, 'Côte-d\'Or', '21', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1137, 'Côtes-d\'Armor', '22', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1138, 'Creuse', '23', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1139, 'Deux-Sèvres', '79', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1140, 'Dordogne', '24', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1141, 'Doubs', '25', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1142, 'Drôme', '26', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1143, 'Essonne', '91', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1144, 'Eure', '27', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1145, 'Eure-et-Loir', '28', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1146, 'Finistère', '29', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1147, 'Gard', '30', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1148, 'Gers', '32', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1149, 'Gironde', '33', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1150, 'Haut-Rhin', '68', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1151, 'Haute-Corse', '20B', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1152, 'Haute-Garonne', '31', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1153, 'Haute-Loire', '43', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1154, 'Haute-Saône', '70', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1155, 'Haute-Savoie', '74', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1156, 'Haute-Vienne', '87', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1157, 'Hautes-Alpes', '5', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1158, 'Hautes-Pyrénées', '65', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1159, 'Hauts-de-Seine', '92', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1160, 'Hérault', '34', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1161, 'Indre', '36', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1162, 'Ille-et-Vilaine', '35', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1163, 'Indre-et-Loire', '37', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1164, 'Isère', '38', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1165, 'Landes', '40', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1166, 'Loir-et-Cher', '41', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1167, 'Loire', '42', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1168, 'Loire-Atlantique', '44', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1169, 'Loiret', '45', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1170, 'Lot', '46', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1171, 'Lot-et-Garonne', '47', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1172, 'Lozère', '48', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1173, 'Maine-et-Loire', '50', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1174, 'Manche', '50', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1175, 'Marne', '51', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1176, 'Mayenne', '53', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1177, 'Meurthe-et-Moselle', '54', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1178, 'Meuse', '55', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1179, 'Morbihan', '56', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1180, 'Moselle', '57', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1181, 'Nièvre', '58', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1182, 'Nord', '59', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1183, 'Oise', '60', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1184, 'Orne', '61', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1185, 'Paris', '75', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1186, 'Pas-de-Calais', '62', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1187, 'Puy-de-Dôme', '63', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1188, 'Pyrénées-Atlantiques', '64', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1189, 'Pyrénées-Orientales', '66', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1190, 'Rhône', '69', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1191, 'Saône-et-Loire', '71', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1192, 'Sarthe', '72', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1193, 'Savoie', '73', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1194, 'Seine-et-Marne', '77', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1195, 'Seine-Maritime', '76', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1196, 'Seine-Saint-Denis', '93', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1197, 'Somme', '80', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1198, 'Tarn', '81', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1199, 'Tarn-et-Garonne', '82', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1200, 'Val d\'Oise', '95', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1201, 'Territoire de Belfort', '90', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1202, 'Val-de-Marne', '94', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1203, 'Var', '83', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1204, 'Vaucluse', '84', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1205, 'Vendée', '85', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1206, 'Vienne', '86', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1207, 'Vosges', '88', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1208, 'Yonne', '89', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1209, 'Yvelines', '78', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1210, 'Aberdeen City', 'ABE', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1211, 'Aberdeenshire', 'ABD', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1212, 'Angus', 'ANS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1213, 'Co Antrim', 'ANT', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1214, 'Argyll and Bute', 'AGB', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1215, 'Co Armagh', 'ARM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1216, 'Bedfordshire', 'BDF', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1217, 'Gwent', 'BGW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1218, 'Bristol, City of', 'BST', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1219, 'Buckinghamshire', 'BKM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1220, 'Cambridgeshire', 'CAM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1221, 'Cheshire', 'CHS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1222, 'Clackmannanshire', 'CLK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1223, 'Cornwall', 'CON', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1224, 'Cumbria', 'CMA', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1225, 'Derbyshire', 'DBY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1226, 'Co Londonderry', 'DRY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1227, 'Devon', 'DEV', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1228, 'Dorset', 'DOR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1229, 'Co Down', 'DOW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1230, 'Dumfries and Galloway', 'DGY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1231, 'Dundee City', 'DND', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1232, 'County Durham', 'DUR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1233, 'East Ayrshire', 'EAY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1234, 'East Dunbartonshire', 'EDU', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1235, 'East Lothian', 'ELN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1236, 'East Renfrewshire', 'ERW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1237, 'East Riding of Yorkshire', 'ERY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1238, 'East Sussex', 'ESX', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1239, 'Edinburgh, City of', 'EDH', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1240, 'Na h-Eileanan Siar', 'ELS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1241, 'Essex', 'ESS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1242, 'Falkirk', 'FAL', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1243, 'Co Fermanagh', 'FER', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1244, 'Fife', 'FIF', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1245, 'Glasgow City', 'GLG', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1246, 'Gloucestershire', 'GLS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1247, 'Gwynedd', 'GWN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1248, 'Hampshire', 'HAM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1249, 'Herefordshire', 'HEF', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1250, 'Hertfordshire', 'HRT', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1251, 'Highland', 'HED', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1252, 'Inverclyde', 'IVC', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1253, 'Isle of Wight', 'IOW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1254, 'Kent', 'KEN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1255, 'Lancashire', 'LAN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1256, 'Leicestershire', 'LEC', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1257, 'Midlothian', 'MLN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1258, 'Moray', 'MRY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1259, 'Norfolk', 'NFK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1260, 'North Ayrshire', 'NAY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1261, 'North Lanarkshire', 'NLK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1262, 'North Yorkshire', 'NYK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1263, 'Northamptonshire', 'NTH', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1264, 'Northumberland', 'NBL', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1265, 'Nottinghamshire', 'NTT', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1266, 'Oldham', 'OLD', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1267, 'Omagh', 'OMH', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1268, 'Orkney Islands', 'ORR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1269, 'Oxfordshire', 'OXF', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1270, 'Perth and Kinross', 'PKN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1271, 'Powys', 'POW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1272, 'Renfrewshire', 'RFW', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1273, 'Rutland', 'RUT', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1274, 'Scottish Borders', 'SCB', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1275, 'Shetland Islands', 'ZET', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1276, 'Shropshire', 'SHR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1277, 'Somerset', 'SOM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1278, 'South Ayrshire', 'SAY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1279, 'South Gloucestershire', 'SGC', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1280, 'South Lanarkshire', 'SLK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1281, 'Staffordshire', 'STS', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1282, 'Stirling', 'STG', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1283, 'Suffolk', 'SFK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1284, 'Surrey', 'SRY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1285, 'Mid Glamorgan', 'VGL', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1286, 'Warwickshire', 'WAR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1287, 'West Dunbartonshire', 'WDU', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1288, 'West Lothian', 'WLN', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1289, 'West Sussex', 'WSX', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1290, 'Wiltshire', 'WIL', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1291, 'Worcestershire', 'WOR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1292, 'Ashanti', 'AH', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1293, 'Brong-Ahafo', 'BA', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1294, 'Greater Accra', 'AA', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1295, 'Upper East', 'UE', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1296, 'Upper West', 'UW', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1297, 'Volta', 'TV', 83, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1298, 'Banjul', 'B', 80, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1299, 'Lower River', 'L', 80, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1300, 'MacCarthy Island', 'M', 80, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1301, 'North Bank', 'N', 80, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1302, 'Upper River', 'U', 80, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1303, 'Beyla', 'BE', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1304, 'Boffa', 'BF', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1305, 'Boke', 'BK', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1306, 'Coyah', 'CO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1307, 'Dabola', 'DB', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1308, 'Dalaba', 'DL', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1309, 'Dinguiraye', 'DI', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1310, 'Dubreka', 'DU', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1311, 'Faranah', 'FA', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1312, 'Forecariah', 'FO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1313, 'Fria', 'FR', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1314, 'Gaoual', 'GA', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1315, 'Guekedou', 'GU', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1316, 'Kankan', 'KA', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1317, 'Kerouane', 'KE', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1318, 'Kindia', 'KD', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1319, 'Kissidougou', 'KS', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1320, 'Koubia', 'KB', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1321, 'Koundara', 'KN', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1322, 'Kouroussa', 'KO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1323, 'Labe', 'LA', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1324, 'Lelouma', 'LE', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1325, 'Lola', 'LO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1326, 'Macenta', 'MC', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1327, 'Mali', 'ML', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1328, 'Mamou', 'MM', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1329, 'Mandiana', 'MD', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1330, 'Nzerekore', 'NZ', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1331, 'Pita', 'PI', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1332, 'Siguiri', 'SI', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1333, 'Telimele', 'TE', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1334, 'Tougue', 'TO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1335, 'Yomou', 'YO', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1336, 'Region Continental', 'C', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1337, 'Region Insular', 'I', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1338, 'Annobon', 'AN', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1339, 'Bioko Norte', 'BN', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1340, 'Bioko Sur', 'BS', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1341, 'Centro Sur', 'CS', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1342, 'Kie-Ntem', 'KN', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1343, 'Litoral', 'LI', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1344, 'Wele-Nzas', 'WN', 66, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1345, 'Achaïa', '13', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1346, 'Aitolia-Akarnania', '1', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1347, 'Argolis', '11', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1348, 'Arkadia', '12', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1349, 'Arta', '31', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1350, 'Attiki', 'A1', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1351, 'Chalkidiki', '64', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1352, 'Chania', '94', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1353, 'Chios', '85', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1354, 'Dodekanisos', '81', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1355, 'Drama', '52', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1356, 'Evros', '71', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1357, 'Evrytania', '5', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1358, 'Evvoia', '4', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1359, 'Florina', '63', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1360, 'Fokis', '7', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1361, 'Fthiotis', '6', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1362, 'Grevena', '51', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1363, 'Ileia', '14', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1364, 'Imathia', '53', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1365, 'Ioannina', '33', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1366, 'Irakleion', '91', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1367, 'Karditsa', '41', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1368, 'Kastoria', '56', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1369, 'Kavalla', '55', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1370, 'Kefallinia', '23', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1371, 'Kerkyra', '22', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1372, 'Kilkis', '57', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1373, 'Korinthia', '15', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1374, 'Kozani', '58', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1375, 'Kyklades', '82', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1376, 'Lakonia', '16', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1377, 'Larisa', '42', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1378, 'Lasithion', '92', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1379, 'Lefkas', '24', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1380, 'Lesvos', '83', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1381, 'Magnisia', '43', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1382, 'Messinia', '17', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1383, 'Pella', '59', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1384, 'Preveza', '34', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1385, 'Rethymnon', '93', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1386, 'Rodopi', '73', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1387, 'Samos', '84', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1388, 'Serrai', '62', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1389, 'Thesprotia', '32', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1390, 'Thessaloniki', '54', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1391, 'Trikala', '44', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1392, 'Voiotia', '3', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1393, 'Xanthi', '72', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1394, 'Zakynthos', '21', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1395, 'Agio Oros', '69', 85, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1396, 'Alta Verapez', 'AV', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1397, 'Baja Verapez', 'BV', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1398, 'Chimaltenango', 'CM', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1399, 'Chiquimula', 'CQ', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1400, 'El Progreso', 'PR', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1401, 'Escuintla', 'ES', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1402, 'Guatemala', 'GU', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1403, 'Huehuetenango', 'HU', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1404, 'Izabal', 'IZ', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1405, 'Jalapa', 'JA', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1406, 'Jutiapa', 'JU', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1407, 'Peten', 'PE', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1408, 'Quetzaltenango', 'QZ', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1409, 'Quiche', 'QC', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1410, 'Reta.thuleu', 'RE', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1411, 'Sacatepequez', 'SA', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1412, 'San Marcos', 'SM', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1413, 'Santa Rosa', 'SR', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1414, 'Solol6', 'SO', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1415, 'Suchitepequez', 'SU', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1416, 'Totonicapan', 'TO', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1417, 'Zacapa', 'ZA', 90, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1418, 'Bissau', 'BS', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1419, 'Bafata', 'BA', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1420, 'Biombo', 'BM', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1421, 'Bolama', 'BL', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1422, 'Cacheu', 'CA', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1423, 'Gabu', 'GA', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1424, 'Oio', 'OI', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1425, 'Quloara', 'QU', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1426, 'Tombali S', 'TO', 93, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1427, 'Barima-Waini', 'BA', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1428, 'Cuyuni-Mazaruni', 'CU', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1429, 'Demerara-Mahaica', 'DE', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1430, 'East Berbice-Corentyne', 'EB', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1431, 'Essequibo Islands-West Demerara', 'ES', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1432, 'Mahaica-Berbice', 'MA', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1433, 'Pomeroon-Supenaam', 'PM', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1434, 'Potaro-Siparuni', 'PT', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1435, 'Upper Demerara-Berbice', 'UD', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1436, 'Upper Takutu-Upper Essequibo', 'UT', 94, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1437, 'Atlantida', 'AT', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1438, 'Colon', 'CL', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1439, 'Comayagua', 'CM', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1440, 'Copan', 'CP', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1441, 'Cortes', 'CR', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1442, 'Choluteca', 'CH', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1443, 'El Paraiso', 'EP', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1444, 'Francisco Morazan', 'FM', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1445, 'Gracias a Dios', 'GD', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1446, 'Intibuca', 'IN', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1447, 'Islas de la Bahia', 'IB', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1448, 'Lempira', 'LE', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1449, 'Ocotepeque', 'OC', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1450, 'Olancho', 'OL', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1451, 'Santa Barbara', 'SB', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1452, 'Valle', 'VA', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1453, 'Yoro', 'YO', 97, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1454, 'Bjelovarsko-bilogorska zupanija', '7', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1455, 'Brodsko-posavska zupanija', '12', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1456, 'Dubrovacko-neretvanska zupanija', '19', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1457, 'Istarska zupanija', '18', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1458, 'Karlovacka zupanija', '4', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1459, 'Koprivnickco-krizevacka zupanija', '6', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1460, 'Krapinako-zagorska zupanija', '2', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1461, 'Licko-senjska zupanija', '9', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1462, 'Medimurska zupanija', '20', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1463, 'Osjecko-baranjska zupanija', '14', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1464, 'Pozesko-slavonska zupanija', '11', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1465, 'Primorsko-goranska zupanija', '8', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1466, 'Sisacko-moelavacka Iupanija', '3', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1467, 'Splitako-dalmatinska zupanija', '17', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1468, 'Sibenako-kninska zupanija', '15', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1469, 'Varaidinska zupanija', '5', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1470, 'VirovitiEko-podravska zupanija', '10', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1471, 'VuRovarako-srijemska zupanija', '16', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1472, 'Zadaraka', '13', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1473, 'Zagrebacka zupanija', '1', 54, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1474, 'Grande-Anse', 'GA', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1475, 'Nord-Est', 'NE', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1476, 'Nord-Ouest', 'NO', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1477, 'Ouest', 'OU', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1478, 'Sud', 'SD', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1479, 'Sud-Est', 'SE', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1480, 'Budapest', 'BU', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1481, 'Bács-Kiskun', 'BK', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1482, 'Bar2018-06-15 05:11:06a', 'BA', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1483, 'Békés', 'BE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1484, 'Borsod-Abaúj-Zemplén', 'BZ', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1485, 'Csongrád', 'CS', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1486, 'Fejér', 'FE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1487, 'Győr-Moson-Sopron', 'GS', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1488, 'Hajdu-Bihar', 'HB', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1489, 'Heves', 'HE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1490, 'Jász-Nagykun-Szolnok', 'JN', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1491, 'Komárom-Esztergom', 'KE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1492, 'Nográd', 'NO', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1493, 'Pest', 'PE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1494, 'Somogy', 'SO', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1495, 'Szabolcs-Szatmár-Bereg', 'SZ', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1496, 'Tolna', 'TO', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1497, 'Vas', 'VA', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1498, 'Veszprém', 'VE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1499, 'Zala', 'ZA', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1500, 'Békéscsaba', 'BC', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1501, 'Debrecen', 'DE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1502, 'Dunaújváros', 'DU', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1503, 'Eger', 'EG', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1504, 'Győr', 'GY', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1505, 'Hódmezővásárhely', 'HV', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1506, 'Kaposvár', 'KV', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1507, 'Kecskemét', 'KM', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1508, 'Miskolc', 'MI', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1509, 'Nagykanizsa', 'NK', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1510, 'Nyiregyháza', 'NY', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1511, 'Pécs', 'PS', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1512, 'Salgótarján', 'ST', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1513, 'Sopron', 'SN', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1514, 'Szeged', 'SD', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1515, 'Székesfehérvár', 'SF', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1516, 'Szekszárd', 'SS', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1517, 'Szolnok', 'SK', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1518, 'Szombathely', 'SH', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1519, 'Tatabánya', 'TB', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1520, 'Zalaegerszeg', 'ZE', 99, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1521, 'Bali', 'BA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1522, 'Bangka Belitung', 'BB', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1523, 'Banten', 'BT', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1524, 'Bengkulu', 'BE', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1525, 'Gorontalo', 'GO', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1526, 'Irian Jaya', 'IJ', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1527, 'Jambi', 'JA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1528, 'Jawa Barat', 'JB', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1529, 'Jawa Tengah', 'JT', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1530, 'Jawa Timur', 'JI', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1531, 'Kalimantan Barat', 'KB', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1532, 'Kalimantan Timur', 'KT', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1533, 'Kalimantan Selatan', 'KS', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1534, 'Kepulauan Riau', 'KR', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1535, 'Lampung', 'LA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1536, 'Maluku', 'MA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1537, 'Maluku Utara', 'MU', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1538, 'Nusa Tenggara Barat', 'NB', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1539, 'Nusa Tenggara Timur', 'NT', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1540, 'Papua', 'PA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1541, 'Riau', 'RI', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1542, 'Sulawesi Selatan', 'SN', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1543, 'Sulawesi Tengah', 'ST', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1544, 'Sulawesi Tenggara', 'SG', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1545, 'Sulawesi Utara', 'SA', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1546, 'Sumatra Barat', 'SB', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1547, 'Sumatra Selatan', 'SS', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1548, 'Sumatera Utara', 'SU', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1549, 'Jakarta Raya', 'JK', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1550, 'Aceh', 'AC', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1551, 'Yogyakarta', 'YO', 102, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1552, 'Cork', 'C', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1553, 'Clare', 'CE', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1554, 'Cavan', 'CN', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1555, 'Carlow', 'CW', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1556, 'Dublin', 'D', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1557, 'Donegal', 'DL', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1558, 'Galway', 'G', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1559, 'Kildare', 'KE', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1560, 'Kilkenny', 'KK', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1561, 'Kerry', 'KY', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1562, 'Longford', 'LD', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1563, 'Louth', 'LH', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1564, 'Limerick', 'LK', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1565, 'Leitrim', 'LM', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1566, 'Laois', 'LS', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1567, 'Meath', 'MH', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1568, 'Monaghan', 'MN', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1569, 'Mayo', 'MO', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1570, 'Offaly', 'OY', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1571, 'Roscommon', 'RN', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1572, 'Sligo', 'SO', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1573, 'Tipperary', 'TA', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1574, 'Waterford', 'WD', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1575, 'Westmeath', 'WH', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1576, 'Wicklow', 'WW', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1577, 'Wexford', 'WX', 105, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1578, 'HaDarom', 'D', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1579, 'HaMerkaz', 'M', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1580, 'HaZafon', 'Z', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1581, 'Haifa', 'HA', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1582, 'Tel-Aviv', 'TA', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1583, 'Jerusalem', 'JM', 106, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1584, 'Al Anbar', 'AN', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1585, 'Al Ba,rah', 'BA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1586, 'Al Muthanna', 'MU', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1587, 'Al Qadisiyah', 'QA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1588, 'An Najef', 'NA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1589, 'Arbil', 'AR', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1590, 'As Sulaymaniyah', 'SW', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1591, 'At Ta\'mim', 'TS', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1592, 'Babil', 'BB', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1593, 'Baghdad', 'BG', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1594, 'Dahuk', 'DA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1595, 'Dhi Qar', 'DQ', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1596, 'Diyala', 'DI', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1597, 'Karbala\'', 'KA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1598, 'Maysan', 'MA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1599, 'Ninawa', 'NI', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1600, 'Salah ad Din', 'SD', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1601, 'Wasit', 'WA', 104, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1602, 'Ardabil', '3', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1603, 'Azarbayjan-e Gharbi', '2', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1604, 'Azarbayjan-e Sharqi', '1', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1605, 'Bushehr', '6', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1606, 'Chahar Mahall va Bakhtiari', '8', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1607, 'Esfahan', '4', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1608, 'Fars', '14', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1609, 'Gilan', '19', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1610, 'Golestan', '27', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1611, 'Hamadan', '24', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1612, 'Hormozgan', '23', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1613, 'Iiam', '5', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1614, 'Kerman', '15', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1615, 'Kermanshah', '17', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1616, 'Khorasan', '9', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1617, 'Khuzestan', '10', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1618, 'Kohjiluyeh va Buyer Ahmad', '18', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1619, 'Kordestan', '16', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1620, 'Lorestan', '20', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1621, 'Markazi', '22', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1622, 'Mazandaran', '21', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1623, 'Qazvin', '28', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1624, 'Qom', '26', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1625, 'Semnan', '12', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1626, 'Sistan va Baluchestan', '13', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1627, 'Tehran', '7', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1628, 'Yazd', '25', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1629, 'Zanjan', '11', 103, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1630, 'Austurland', '7', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1631, 'Hofuoborgarsvaeoi utan Reykjavikur', '1', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1632, 'Norourland eystra', '6', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1633, 'Norourland vestra', '5', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1634, 'Reykjavik', '0', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1635, 'Suourland', '8', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1636, 'Suournes', '2', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1637, 'Vestfirolr', '4', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1638, 'Vesturland', '3', 100, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1639, 'Agrigento', 'AG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1640, 'Alessandria', 'AL', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1641, 'Ancona', 'AN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1642, 'Aosta', 'AO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1643, 'Arezzo', 'AR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1644, 'Ascoli Piceno', 'AP', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1645, 'Asti', 'AT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1646, 'Avellino', 'AV', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1647, 'Bari', 'BA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1648, 'Belluno', 'BL', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1649, 'Benevento', 'BN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1650, 'Bergamo', 'BG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1651, 'Biella', 'BI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1652, 'Bologna', 'BO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1653, 'Bolzano', 'BZ', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1654, 'Brescia', 'BS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1655, 'Brindisi', 'BR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1656, 'Cagliari', 'CA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1657, 'Caltanissetta', 'CL', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1658, 'Campobasso', 'CB', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1659, 'Caserta', 'CE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1660, 'Catania', 'CT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1661, 'Catanzaro', 'CZ', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1662, 'Chieti', 'CH', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1663, 'Como', 'CO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1664, 'Cosenza', 'CS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1665, 'Cremona', 'CR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1666, 'Crotone', 'KR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1667, 'Cuneo', 'CN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1668, 'Enna', 'EN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1669, 'Ferrara', 'FE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1670, 'Firenze', 'FI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1671, 'Foggia', 'FG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1672, 'Forlì-Cesena', 'FC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1673, 'Frosinone', 'FR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1674, 'Genova', 'GE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1675, 'Gorizia', 'GO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1676, 'Grosseto', 'GR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1677, 'Imperia', 'IM', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1678, 'Isernia', 'IS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1679, 'L\'Aquila', 'AQ', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1680, 'La Spezia', 'SP', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1681, 'Latina', 'LT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1682, 'Lecce', 'LE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1683, 'Lecco', 'LC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1684, 'Livorno', 'LI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1685, 'Lodi', 'LO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1686, 'Lucca', 'LU', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1687, 'Macerata', 'MC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1688, 'Mantova', 'MN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1689, 'Massa-Carrara', 'MS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1690, 'Matera', 'MT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1691, 'Messina', 'ME', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1692, 'Milano', 'MI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1693, 'Modena', 'MO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1694, 'Napoli', 'NA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1695, 'Novara', 'NO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1696, 'Nuoro', 'NU', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1697, 'Oristano', 'OR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1698, 'Padova', 'PD', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1699, 'Palermo', 'PA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1700, 'Parma', 'PR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1701, 'Pavia', 'PV', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1702, 'Perugia', 'PG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1703, 'Pesaro e Urbino', 'PU', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1704, 'Pescara', 'PE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1705, 'Piacenza', 'PC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1706, 'Pisa', 'PI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1707, 'Pistoia', 'PT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1708, 'Pordenone', 'PN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1709, 'Potenza', 'PZ', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1710, 'Prato', 'PO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1711, 'Ragusa', 'RG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1712, 'Ravenna', 'RA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1713, 'Reggio Calabria', 'RC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1714, 'Reggio Emilia', 'RE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1715, 'Rieti', 'RI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1716, 'Rimini', 'RN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1717, 'Roma', 'RM', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1718, 'Rovigo', 'RO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1719, 'Salerno', 'SA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1720, 'Sassari', 'SS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1721, 'Savona', 'SV', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1722, 'Siena', 'SI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1723, 'Siracusa', 'SR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1724, 'Sondrio', 'SO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1725, 'Taranto', 'TA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1726, 'Teramo', 'TE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1727, 'Terni', 'TR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1728, 'Torino', 'TO', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1729, 'Trapani', 'TP', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1730, 'Trento', 'TN', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1731, 'Treviso', 'TV', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1732, 'Trieste', 'TS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1733, 'Udine', 'UD', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1734, 'Varese', 'VA', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1735, 'Venezia', 'VE', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1736, 'Verbano-Cusio-Ossola', 'VB', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1737, 'Vercelli', 'VC', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1738, 'Verona', 'VR', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1739, 'Vibo Valentia', 'VV', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1740, 'Vicenza', 'VI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1741, 'Viterbo', 'VT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1742, 'Aichi', '23', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1743, 'Akita', '5', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1744, 'Aomori', '2', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1745, 'Chiba', '12', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1746, 'Ehime', '38', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1747, 'Fukui', '18', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1748, 'Fukuoka', '40', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1749, 'Fukusima', '7', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1750, 'Gifu', '21', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1751, 'Gunma', '10', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1752, 'Hiroshima', '34', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1753, 'Hokkaido', '1', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1754, 'Hyogo', '28', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1755, 'Ibaraki', '8', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1756, 'Ishikawa', '17', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1757, 'Iwate', '3', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1758, 'Kagawa', '37', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1759, 'Kagoshima', '46', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1760, 'Kanagawa', '14', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1761, 'Kochi', '39', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1762, 'Kumamoto', '43', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1763, 'Kyoto', '26', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1764, 'Mie', '24', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1765, 'Miyagi', '4', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1766, 'Miyazaki', '45', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1767, 'Nagano', '20', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1768, 'Nagasaki', '42', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1769, 'Nara', '29', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1770, 'Niigata', '15', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1771, 'Oita', '44', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1772, 'Okayama', '33', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1773, 'Okinawa', '47', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1774, 'Osaka', '27', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1775, 'Saga', '41', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1776, 'Saitama', '11', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1777, 'Shiga', '25', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1778, 'Shimane', '32', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1779, 'Shizuoka', '22', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1780, 'Tochigi', '9', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1781, 'Tokushima', '36', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1782, 'Tokyo', '13', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1783, 'Tottori', '31', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1784, 'Toyama', '16', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1785, 'Wakayama', '30', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1786, 'Yamagata', '6', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1787, 'Yamaguchi', '35', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1788, 'Yamanashi', '19', 109, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1789, 'Clarendon', 'CN', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1790, 'Hanover', 'HR', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1791, 'Kingston', 'KN', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1792, 'Portland', 'PD', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1793, 'Saint Andrew', 'AW', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1794, 'Saint Ann', 'AN', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1795, 'Saint Catherine', 'CE', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1796, 'Saint Elizabeth', 'EH', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1797, 'Saint James', 'JS', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1798, 'Saint Mary', 'MY', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1799, 'Saint Thomas', 'TS', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1800, 'Trelawny', 'TY', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1801, 'Westmoreland', 'WD', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1802, 'Ajln', 'AJ', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1803, 'Al \'Aqaba', 'AQ', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1804, 'Al Balqa\'', 'BA', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1805, 'Al Karak', 'KA', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1806, 'Al Mafraq', 'MA', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1807, 'Amman', 'AM', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1808, 'At Tafilah', 'AT', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1809, 'Az Zarga', 'AZ', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1810, 'Irbid', 'JR', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1811, 'Jarash', 'JA', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1812, 'Ma\'an', 'MN', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1813, 'Madaba', 'MD', 111, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1814, 'Nairobi Municipality', '110', 113, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1815, 'Coast', '300', 113, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1816, 'North-Eastern Kaskazini Mashariki', '500', 113, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1817, 'Rift Valley', '700', 113, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1818, 'Western Magharibi', '900', 113, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1819, 'Bishkek', 'GB', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1820, 'Batken', 'B', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1821, 'Chu', 'C', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1822, 'Jalal-Abad', 'J', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1823, 'Naryn', 'N', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1824, 'Osh', 'O', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1825, 'Talas', 'T', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1826, 'Ysyk-Kol', 'Y', 118, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1827, 'Krong Kaeb', '23', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1828, 'Krong Pailin', '24', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1829, 'Xrong Preah Sihanouk', '18', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1830, 'Phnom Penh', '12', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1831, 'Baat Dambang', '2', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1832, 'Banteay Mean Chey', '1', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1833, 'Rampong Chaam', '3', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1834, 'Kampong Chhnang', '4', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1835, 'Kampong Spueu', '5', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1836, 'Kampong Thum', '6', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1837, 'Kampot', '7', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1838, 'Kandaal', '8', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1839, 'Kach Kong', '9', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1840, 'Krachoh', '10', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1841, 'Mondol Kiri', '11', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1842, 'Otdar Mean Chey', '22', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1843, 'Pousaat', '15', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1844, 'Preah Vihear', '13', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1845, 'Prey Veaeng', '14', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1846, 'Rotanak Kiri', '16', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1847, 'Siem Reab', '17', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1848, 'Stueng Traeng', '19', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1849, 'Svaay Rieng', '20', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1850, 'Taakaev', '21', 36, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1851, 'Gilbert Islands', 'G', 114, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1852, 'Line Islands', 'L', 114, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1853, 'Phoenix Islands', 'P', 114, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1854, 'Anjouan Ndzouani', 'A', 48, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1855, 'Grande Comore Ngazidja', 'G', 48, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1856, 'Moheli Moili', 'M', 48, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1857, 'Kaesong-si', 'KAE', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1858, 'Nampo-si', 'NAM', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1859, 'Pyongyang-ai', 'PYO', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1860, 'Chagang-do', 'CHA', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1861, 'Hamgyongbuk-do', 'HAB', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1862, 'Hamgyongnam-do', 'HAN', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1863, 'Hwanghaebuk-do', 'HWB', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1864, 'Hwanghaenam-do', 'HWN', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1865, 'Kangwon-do', 'KAN', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1866, 'Pyonganbuk-do', 'PYB', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1867, 'Pyongannam-do', 'PYN', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1868, 'Yanggang-do', 'YAN', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1869, 'Najin Sonbong-si', 'NAJ', 115, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1870, 'Seoul Teugbyeolsi', '11', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1871, 'Busan Gwang\'yeogsi', '26', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1872, 'Daegu Gwang\'yeogsi', '27', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1873, 'Daejeon Gwang\'yeogsi', '30', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1874, 'Gwangju Gwang\'yeogsi', '29', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1875, 'Incheon Gwang\'yeogsi', '28', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1876, 'Ulsan Gwang\'yeogsi', '31', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1877, 'Chungcheongbugdo', '43', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1878, 'Chungcheongnamdo', '44', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1879, 'Gang\'weondo', '42', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1880, 'Gyeonggido', '41', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1881, 'Gyeongsangbugdo', '47', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1882, 'Gyeongsangnamdo', '48', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1883, 'Jejudo', '50', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1884, 'Jeonrabugdo', '45', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1885, 'Jeonranamdo', '46', 116, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1886, 'Al Ahmadi', 'AH', 117, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1887, 'Al Farwanlyah', 'FA', 117, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1888, 'Al Jahrah', 'JA', 117, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1889, 'Al Kuwayt', 'KU', 117, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1890, 'Hawalli', 'HA', 117, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1891, 'Almaty', 'ALA', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1892, 'Astana', 'AST', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1893, 'Almaty oblysy', 'ALM', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1894, 'Aqmola oblysy', 'AKM', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1895, 'Aqtobe oblysy', 'AKT', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1896, 'Atyrau oblyfiy', 'ATY', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1897, 'Batys Quzaqstan oblysy', 'ZAP', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1898, 'Mangghystau oblysy', 'MAN', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1899, 'Ongtustik Quzaqstan oblysy', 'YUZ', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1900, 'Pavlodar oblysy', 'PAV', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1901, 'Qaraghandy oblysy', 'KAR', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1902, 'Qostanay oblysy', 'KUS', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1903, 'Qyzylorda oblysy', 'KZY', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1904, 'Shyghys Quzaqstan oblysy', 'VOS', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1905, 'Soltustik Quzaqstan oblysy', 'SEV', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1906, 'Zhambyl oblysy Zhambylskaya oblast\'', 'ZHA', 112, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1907, 'Vientiane', 'VT', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1908, 'Attapu', 'AT', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1909, 'Bokeo', 'BK', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1910, 'Bolikhamxai', 'BL', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1911, 'Champasak', 'CH', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1912, 'Houaphan', 'HO', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1913, 'Khammouan', 'KH', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1914, 'Louang Namtha', 'LM', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1915, 'Louangphabang', 'LP', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1916, 'Oudomxai', 'OU', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1917, 'Phongsali', 'PH', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1918, 'Salavan', 'SL', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1919, 'Savannakhet', 'SV', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1920, 'Xaignabouli', 'XA', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1921, 'Xiasomboun', 'XN', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1922, 'Xekong', 'XE', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1923, 'Xiangkhoang', 'XI', 119, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1924, 'Beirout', 'BA', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1925, 'El Begsa', 'BI', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1926, 'Jabal Loubnane', 'JL', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1927, 'Loubnane ech Chemali', 'AS', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1928, 'Loubnane ej Jnoubi', 'JA', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1929, 'Nabatiye', 'NA', 121, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1930, 'Ampara', '52', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1931, 'Anuradhapura', '71', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1932, 'Badulla', '81', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1933, 'Batticaloa', '51', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1934, 'Colombo', '11', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1935, 'Galle', '31', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1936, 'Gampaha', '12', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1937, 'Hambantota', '33', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1938, 'Jaffna', '41', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1939, 'Kalutara', '13', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1940, 'Kandy', '21', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1941, 'Kegalla', '92', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1942, 'Kilinochchi', '42', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1943, 'Kurunegala', '61', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1944, 'Mannar', '43', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1945, 'Matale', '22', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1946, 'Matara', '32', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1947, 'Monaragala', '82', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1948, 'Mullaittivu', '45', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1949, 'Nuwara Eliya', '23', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1950, 'Polonnaruwa', '72', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1951, 'Puttalum', '62', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1952, 'Ratnapura', '91', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1953, 'Trincomalee', '53', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1954, 'VavunLya', '44', 206, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1955, 'Bomi', 'BM', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1956, 'Bong', 'BG', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1957, 'Grand Basaa', 'GB', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1958, 'Grand Cape Mount', 'CM', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1959, 'Grand Gedeh', 'GG', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1960, 'Grand Kru', 'GK', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1961, 'Lofa', 'LO', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1962, 'Margibi', 'MG', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1963, 'Maryland', 'MY', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1964, 'Montserrado', 'MO', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1965, 'Nimba', 'NI', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1966, 'Rivercess', 'RI', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1967, 'Sinoe', 'SI', 123, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1968, 'Berea', 'D', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1969, 'Butha-Buthe', 'B', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1970, 'Leribe', 'C', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1971, 'Mafeteng', 'E', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1972, 'Maseru', 'A', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1973, 'Mohale\'s Hoek', 'F', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1974, 'Mokhotlong', 'J', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1975, 'Qacha\'s Nek', 'H', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1976, 'Quthing', 'G', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1977, 'Thaba-Tseka', 'K', 122, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1978, 'Alytaus Apskritis', 'AL', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1979, 'Kauno Apskritis', 'KU', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1980, 'Klaipedos Apskritis', 'KL', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1981, 'Marijampoles Apskritis', 'MR', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1982, 'Panevezio Apskritis', 'PN', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1983, 'Sisuliu Apskritis', 'SA', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1984, 'Taurages Apskritis', 'TA', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1985, 'Telsiu Apskritis', 'TE', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1986, 'Utenos Apskritis', 'UT', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1987, 'Vilniaus Apskritis', 'VL', 126, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1988, 'Diekirch', 'D', 127, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1989, 'GreveNmacher', 'G', 127, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1990, 'Aizkraukles Apripkis', 'AI', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1991, 'Alkanes Apripkis', 'AL', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1992, 'Balvu Apripkis', 'BL', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1993, 'Bauskas Apripkis', 'BU', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1994, 'Cesu Aprikis', 'CE', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1995, 'Daugavpile Apripkis', 'DA', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1996, 'Dobeles Apripkis', 'DO', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1997, 'Gulbenes Aprlpkis', 'GU', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1998, 'Jelgavas Apripkis', 'JL', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(1999, 'Jekabpils Apripkis', 'JK', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2000, 'Kraslavas Apripkis', 'KR', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2001, 'Kuldlgas Apripkis', 'KU', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2002, 'Limbazu Apripkis', 'LM', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2003, 'Liepajas Apripkis', 'LE', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2004, 'Ludzas Apripkis', 'LU', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2005, 'Madonas Apripkis', 'MA', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2006, 'Ogres Apripkis', 'OG', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2007, 'Preilu Apripkis', 'PR', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2008, 'Rezaknes Apripkis', 'RE', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2009, 'Rigas Apripkis', 'RI', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2010, 'Saldus Apripkis', 'SA', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2011, 'Talsu Apripkis', 'TA', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2012, 'Tukuma Apriplcis', 'TU', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2013, 'Valkas Apripkis', 'VK', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2014, 'Valmieras Apripkis', 'VM', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2015, 'Ventspils Apripkis', 'VE', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2016, 'Daugavpils', 'DGV', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2017, 'Jelgava', 'JEL', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2018, 'Jurmala', 'JUR', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2019, 'Liepaja', 'LPX', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2020, 'Rezekne', 'REZ', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2021, 'Riga', 'RIX', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2022, 'Ventspils', 'VEN', 120, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2023, 'Agadir', 'AGD', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2024, 'Aït Baha', 'BAH', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2025, 'Aït Melloul', 'MEL', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2026, 'Al Haouz', 'HAO', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2027, 'Al Hoceïma', 'HOC', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2028, 'Assa-Zag', 'ASZ', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2029, 'Azilal', 'AZI', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2030, 'Beni Mellal', 'BEM', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2031, 'Ben Sllmane', 'BES', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2032, 'Berkane', 'BER', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2033, 'Boujdour', 'BOD', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2034, 'Boulemane', 'BOM', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2035, 'Casablanca [Dar el Beïda]', 'CAS', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2036, 'Chefchaouene', 'CHE', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2037, 'Chichaoua', 'CHI', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2038, 'El Hajeb', 'HAJ', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2039, 'El Jadida', 'JDI', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2040, 'Errachidia', 'ERR', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2041, 'Essaouira', 'ESI', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2042, 'Es Smara', 'ESM', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2043, 'Fès', 'FES', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2044, 'Figuig', 'FIG', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2045, 'Guelmim', 'GUE', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2046, 'Ifrane', 'IFR', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2047, 'Jerada', 'JRA', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2048, 'Kelaat Sraghna', 'KES', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2049, 'Kénitra', 'KEN', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2050, 'Khemisaet', 'KHE', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2051, 'Khenifra', 'KHN', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2052, 'Khouribga', 'KHO', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2053, 'Laâyoune (EH)', 'LAA', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2054, 'Larache', 'LAP', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2055, 'Marrakech', 'MAR', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2056, 'Meknsès', 'MEK', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2057, 'Nador', 'NAD', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2058, 'Ouarzazate', 'OUA', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2059, 'Oued ed Dahab (EH)', 'OUD', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2060, 'Oujda', 'OUJ', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2061, 'Rabat-Salé', 'RBA', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2062, 'Safi', 'SAF', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2063, 'Sefrou', 'SEF', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2064, 'Settat', 'SET', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2065, 'Sidl Kacem', 'SIK', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2066, 'Tanger', 'TNG', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2067, 'Tan-Tan', 'TNT', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2068, 'Taounate', 'TAO', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2069, 'Taroudannt', 'TAR', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2070, 'Tata', 'TAT', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2071, 'Taza', 'TAZ', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2072, 'Tétouan', 'TET', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2073, 'Tiznit', 'TIZ', 148, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2074, 'Gagauzia, Unitate Teritoriala Autonoma', 'GA', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2075, 'Chisinau', 'CU', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2076, 'Stinga Nistrului, unitatea teritoriala din', 'SN', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2077, 'Balti', 'BA', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2078, 'Cahul', 'CA', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2079, 'Edinet', 'ED', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2080, 'Lapusna', 'LA', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2081, 'Orhei', 'OR', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2082, 'Soroca', 'SO', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2083, 'Taraclia', 'TA', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2084, 'Tighina [Bender]', 'TI', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2085, 'Ungheni', 'UN', 144, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2086, 'Antananarivo', 'T', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2087, 'Antsiranana', 'D', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2088, 'Fianarantsoa', 'F', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2089, 'Mahajanga', 'M', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2090, 'Toamasina', 'A', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2091, 'Toliara', 'U', 130, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2092, 'Ailinglapalap', 'ALL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2093, 'Ailuk', 'ALK', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2094, 'Arno', 'ARN', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2095, 'Aur', 'AUR', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2096, 'Ebon', 'EBO', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2097, 'Eniwetok', 'ENI', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2098, 'Jaluit', 'JAL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2099, 'Kili', 'KIL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2100, 'Kwajalein', 'KWA', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2101, 'Lae', 'LAE', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2102, 'Lib', 'LIB', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2103, 'Likiep', 'LIK', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2104, 'Majuro', 'MAJ', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2105, 'Maloelap', 'MAL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2106, 'Mejit', 'MEJ', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2107, 'Mili', 'MIL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2108, 'Namorik', 'NMK', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2109, 'Namu', 'NMU', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2110, 'Rongelap', 'RON', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2111, 'Ujae', 'UJA', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2112, 'Ujelang', 'UJL', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2113, 'Utirik', 'UTI', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2114, 'Wotho', 'WTN', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2115, 'Wotje', 'WTJ', 137, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2116, 'Bamako', 'BK0', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2117, 'Gao', '7', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2118, 'Kayes', '1', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2119, 'Kidal', '8', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2120, 'Xoulikoro', '2', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2121, 'Mopti', '5', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2122, 'S69ou', '4', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2123, 'Sikasso', '3', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2124, 'Tombouctou', '6', 134, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2125, 'Ayeyarwady', '7', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2126, 'Bago', '2', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2127, 'Magway', '3', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2128, 'Mandalay', '4', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2129, 'Sagaing', '1', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2130, 'Tanintharyi', '5', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2131, 'Yangon', '6', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2132, 'Chin', '14', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2133, 'Kachin', '11', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2134, 'Kayah', '12', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2135, 'Kayin', '13', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2136, 'Mon', '15', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2137, 'Rakhine', '16', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2138, 'Shan', '17', 150, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2139, 'Ulaanbaatar', '1', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2140, 'Arhangay', '73', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2141, 'Bayanhongor', '69', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2142, 'Bayan-Olgiy', '71', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2143, 'Bulgan', '67', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2144, 'Darhan uul', '37', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2145, 'Dornod', '61', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2146, 'Dornogov,', '63', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2147, 'DundgovL', '59', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2148, 'Dzavhan', '57', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2149, 'Govi-Altay', '65', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2150, 'Govi-Smber', '64', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2151, 'Hentiy', '39', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2152, 'Hovd', '43', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2153, 'Hovsgol', '41', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2154, 'Omnogovi', '53', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2155, 'Orhon', '35', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2156, 'Ovorhangay', '55', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2157, 'Selenge', '49', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2158, 'Shbaatar', '51', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2159, 'Tov', '47', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2160, 'Uvs', '46', 146, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2161, 'Nouakchott', 'NKC', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2162, 'Assaba', '3', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2163, 'Brakna', '5', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2164, 'Dakhlet Nouadhibou', '8', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2165, 'Gorgol', '4', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2166, 'Guidimaka', '10', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2167, 'Hodh ech Chargui', '1', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2168, 'Hodh el Charbi', '2', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2169, 'Inchiri', '12', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2170, 'Tagant', '9', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2171, 'Tiris Zemmour', '11', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2172, 'Trarza', '6', 139, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2173, 'Beau Bassin-Rose Hill', 'BR', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2174, 'Curepipe', 'CU', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2175, 'Port Louis', 'PU', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2176, 'Quatre Bornes', 'QB', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2177, 'Vacosa-Phoenix', 'VP', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2178, 'Black River', 'BL', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2179, 'Flacq', 'FL', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2180, 'Grand Port', 'GP', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2181, 'Moka', 'MO', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2182, 'Pamplemousses', 'PA', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2183, 'Plaines Wilhems', 'PW', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2184, 'Riviere du Rempart', 'RP', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2185, 'Savanne', 'SA', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2186, 'Agalega Islands', 'AG', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2187, 'Cargados Carajos Shoals', 'CC', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2188, 'Rodrigues Island', 'RO', 140, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2189, 'Male', 'MLE', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2190, 'Alif', '2', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2191, 'Baa', '20', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2192, 'Dhaalu', '17', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2193, 'Faafu', '14', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2194, 'Gaaf Alif', '27', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2195, 'Gaefu Dhaalu', '28', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2196, 'Gnaviyani', '29', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2197, 'Haa Alif', '7', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2198, 'Haa Dhaalu', '23', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2199, 'Kaafu', '26', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2200, 'Laamu', '5', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2201, 'Lhaviyani', '3', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2202, 'Meemu', '12', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2203, 'Noonu', '25', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2204, 'Raa', '13', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2205, 'Seenu', '1', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2206, 'Shaviyani', '24', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2207, 'Thaa', '8', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2208, 'Vaavu', '4', 133, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2209, 'Balaka', 'BA', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2210, 'Blantyre', 'BL', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2211, 'Chikwawa', 'CK', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2212, 'Chiradzulu', 'CR', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2213, 'Chitipa', 'CT', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2214, 'Dedza', 'DE', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2215, 'Dowa', 'DO', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2216, 'Karonga', 'KR', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2217, 'Kasungu', 'KS', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2218, 'Likoma Island', 'LK', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2219, 'Lilongwe', 'LI', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2220, 'Machinga', 'MH', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2221, 'Mangochi', 'MG', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2222, 'Mchinji', 'MC', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2223, 'Mulanje', 'MU', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2224, 'Mwanza', 'MW', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2225, 'Mzimba', 'MZ', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2226, 'Nkhata Bay', 'NB', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2227, 'Nkhotakota', 'NK', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2228, 'Nsanje', 'NS', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2229, 'Ntcheu', 'NU', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2230, 'Ntchisi', 'NI', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2231, 'Phalomba', 'PH', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2232, 'Rumphi', 'RU', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2233, 'Salima', 'SA', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2234, 'Thyolo', 'TH', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2235, 'Zomba', 'ZO', 131, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2236, 'Aguascalientes', 'AGU', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2237, 'Baja California', 'BCN', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2238, 'Baja California Sur', 'BCS', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2239, 'Campeche', 'CAM', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2240, 'Coahuila', 'COA', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2241, 'Colima', 'COL', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2242, 'Chiapas', 'CHP', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2243, 'Chihuahua', 'CHH', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2244, 'Durango', 'DUR', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2245, 'Guanajuato', 'GUA', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2246, 'Guerrero', 'GRO', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2247, 'Hidalgo', 'HID', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2248, 'Jalisco', 'JAL', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2249, 'Mexico', 'MEX', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2250, 'Michoacin', 'MIC', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2251, 'Morelos', 'MOR', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2252, 'Nayarit', 'NAY', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2253, 'Nuevo Leon', 'NLE', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2254, 'Oaxaca', 'OAX', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2255, 'Puebla', 'PUE', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2256, 'Queretaro', 'QUE', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2257, 'Quintana Roo', 'ROO', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2258, 'San Luis Potosi', 'SLP', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2259, 'Sinaloa', 'SIN', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2260, 'Sonora', 'SON', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2261, 'Tabasco', 'TAB', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2262, 'Tamaulipas', 'TAM', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2263, 'Tlaxcala', 'TLA', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2264, 'Veracruz', 'VER', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2265, 'Yucatan', 'YUC', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2266, 'Zacatecas', 'ZAC', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2267, 'Wilayah Persekutuan Kuala Lumpur', '14', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2268, 'Wilayah Persekutuan Labuan', '15', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2269, 'Wilayah Persekutuan Putrajaya', '16', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2270, 'Johor', '1', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2271, 'Kedah', '2', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2272, 'Kelantan', '3', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2273, 'Melaka', '4', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2274, 'Negeri Sembilan', '5', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2275, 'Pahang', '6', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2276, 'Perak', '8', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2277, 'Perlis', '9', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2278, 'Pulau Pinang', '7', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2279, 'Sabah', '12', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(2280, 'Sarawak', '13', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2281, 'Selangor', '10', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2282, 'Terengganu', '11', 132, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2283, 'Maputo', 'MPM', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2284, 'Cabo Delgado', 'P', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2285, 'Gaza', 'G', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2286, 'Inhambane', 'I', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2287, 'Manica', 'B', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2288, 'Numpula', 'N', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2289, 'Niaaea', 'A', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2290, 'Sofala', 'S', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2291, 'Tete', 'T', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2292, 'Zambezia', 'Q', 149, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2293, 'Caprivi', 'CA', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2294, 'Erongo', 'ER', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2295, 'Hardap', 'HA', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2296, 'Karas', 'KA', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2297, 'Khomae', 'KH', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2298, 'Kunene', 'KU', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2299, 'Ohangwena', 'OW', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2300, 'Okavango', 'OK', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2301, 'Omaheke', 'OH', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2302, 'Omusati', 'OS', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2303, 'Oshana', 'ON', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2304, 'Oshikoto', 'OT', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2305, 'Otjozondjupa', 'OD', 151, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2306, 'Niamey', '8', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2307, 'Agadez', '1', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2308, 'Diffa', '2', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2309, 'Dosso', '3', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2310, 'Maradi', '4', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2311, 'Tahoua', 'S', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2312, 'Tillaberi', '6', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2313, 'Zinder', '7', 159, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2314, 'Abuja Capital Territory', 'FC', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2315, 'Abia', 'AB', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2316, 'Adamawa', 'AD', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2317, 'Akwa Ibom', 'AK', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2318, 'Anambra', 'AN', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2319, 'Bauchi', 'BA', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2320, 'Bayelsa', 'BY', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2321, 'Benue', 'BE', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2322, 'Borno', 'BO', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2323, 'Cross River', 'CR', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2324, 'Delta', 'DE', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2325, 'Ebonyi', 'EB', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2326, 'Edo', 'ED', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2327, 'Ekiti', 'EK', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2328, 'Enugu', 'EN', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2329, 'Gombe', 'GO', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2330, 'Imo', 'IM', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2331, 'Jigawa', 'JI', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2332, 'Kaduna', 'KD', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2333, 'Kano', 'KN', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2334, 'Katsina', 'KT', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2335, 'Kebbi', 'KE', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2336, 'Kogi', 'KO', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2337, 'Kwara', 'KW', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2338, 'Lagos', 'LA', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2339, 'Nassarawa', 'NA', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2340, 'Niger', 'NI', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2341, 'Ogun', 'OG', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2342, 'Ondo', 'ON', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2343, 'Osun', 'OS', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2344, 'Oyo', 'OY', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2345, 'Rivers', 'RI', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2346, 'Sokoto', 'SO', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2347, 'Taraba', 'TA', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2348, 'Yobe', 'YO', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2349, 'Zamfara', 'ZA', 160, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2350, 'Boaco', 'BO', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2351, 'Carazo', 'CA', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2352, 'Chinandega', 'CI', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2353, 'Chontales', 'CO', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2354, 'Esteli', 'ES', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2355, 'Jinotega', 'JI', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2356, 'Leon', 'LE', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2357, 'Madriz', 'MD', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2358, 'Managua', 'MN', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2359, 'Masaya', 'MS', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2360, 'Matagalpa', 'MT', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2361, 'Nueva Segovia', 'NS', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2362, 'Rio San Juan', 'SJ', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2363, 'Rivas', 'RI', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2364, 'Atlantico Norte', 'AN', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2365, 'Atlantico Sur', 'AS', 158, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2366, 'Drente', 'DR', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2367, 'Flevoland', 'FL', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2368, 'Friesland', 'FR', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2369, 'Gelderland', 'GL', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2370, 'Groningen', 'GR', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2371, 'Noord-Brabant', 'NB', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2372, 'Noord-Holland', 'NH', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2373, 'Overijssel', 'OV', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2374, 'Utrecht', 'UT', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2375, 'Zuid-Holland', 'ZH', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2376, 'Zeeland', 'ZL', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2377, 'Akershus', '2', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2378, 'Aust-Agder', '9', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2379, 'Buskerud', '6', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2380, 'Finumark', '20', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2381, 'Hedmark', '4', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2382, 'Hordaland', '12', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2383, 'Mire og Romsdal', '15', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2384, 'Nordland', '18', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2385, 'Nord-Trindelag', '17', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2386, 'Oppland', '5', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2387, 'Oslo', '3', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2388, 'Rogaland', '11', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2389, 'Sogn og Fjordane', '14', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2390, 'Sir-Trindelag', '16', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2391, 'Telemark', '6', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2392, 'Troms', '19', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2393, 'Vest-Agder', '10', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2394, 'Vestfold', '7', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2395, 'Ostfold', '1', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2396, 'Jan Mayen', '22', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2397, 'Svalbard', '21', 164, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2398, 'Auckland', 'AUK', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2399, 'Bay of Plenty', 'BOP', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2400, 'Canterbury', 'CAN', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2401, 'Gisborne', 'GIS', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2402, 'Hawkes Bay', 'HKB', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2403, 'Manawatu-Wanganui', 'MWT', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2404, 'Marlborough', 'MBH', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2405, 'Nelson', 'NSN', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2406, 'Northland', 'NTL', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2407, 'Otago', 'OTA', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2408, 'Southland', 'STL', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2409, 'Taranaki', 'TKI', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2410, 'Tasman', 'TAS', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2411, 'waikato', 'WKO', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2412, 'Wellington', 'WGN', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2413, 'West Coast', 'WTC', 157, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2414, 'Ad Dakhillyah', 'DA', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2415, 'Al Batinah', 'BA', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2416, 'Al Janblyah', 'JA', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2417, 'Al Wusta', 'WU', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2418, 'Ash Sharqlyah', 'SH', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2419, 'Az Zahirah', 'ZA', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2420, 'Masqat', 'MA', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2421, 'Musandam', 'MU', 165, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2422, 'Bocas del Toro', '1', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2423, 'Cocle', '2', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2424, 'Chiriqui', '4', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2425, 'Darien', '5', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2426, 'Herrera', '6', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2427, 'Loa Santoa', '7', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2428, 'Panama', '8', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2429, 'Veraguas', '9', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2430, 'Comarca de San Blas', 'Q', 169, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2431, 'El Callao', 'CAL', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2432, 'Ancash', 'ANC', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2433, 'Apurimac', 'APU', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2434, 'Arequipa', 'ARE', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2435, 'Ayacucho', 'AYA', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2436, 'Cajamarca', 'CAJ', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2437, 'Cuzco', 'CUS', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2438, 'Huancavelica', 'HUV', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2439, 'Huanuco', 'HUC', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2440, 'Ica', 'ICA', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2441, 'Junin', 'JUN', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2442, 'La Libertad', 'LAL', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2443, 'Lambayeque', 'LAM', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2444, 'Lima', 'LIM', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2445, 'Loreto', 'LOR', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2446, 'Madre de Dios', 'MDD', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2447, 'Moquegua', 'MOQ', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2448, 'Pasco', 'PAS', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2449, 'Piura', 'PIU', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2450, 'Puno', 'PUN', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2451, 'San Martin', 'SAM', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2452, 'Tacna', 'TAC', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2453, 'Tumbes', 'TUM', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2454, 'Ucayali', 'UCA', 172, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2455, 'National Capital District (Port Moresby)', 'NCD', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2456, 'Chimbu', 'CPK', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2457, 'Eastern Highlands', 'EHG', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2458, 'East New Britain', 'EBR', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2459, 'East Sepik', 'ESW', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2460, 'Enga', 'EPW', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2461, 'Gulf', 'GPK', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2462, 'Madang', 'MPM', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2463, 'Manus', 'MRL', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2464, 'Milne Bay', 'MBA', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2465, 'Morobe', 'MPL', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2466, 'New Ireland', 'NIK', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2467, 'North Solomons', 'NSA', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2468, 'Santaun', 'SAN', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2469, 'Southern Highlands', 'SHM', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2470, 'Western Highlands', 'WHM', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2471, 'West New Britain', 'WBK', 170, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2472, 'Abra', 'ABR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2473, 'Agusan del Norte', 'AGN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2474, 'Agusan del Sur', 'AGS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2475, 'Aklan', 'AKL', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2476, 'Albay', 'ALB', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2477, 'Antique', 'ANT', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2478, 'Apayao', 'APA', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2479, 'Aurora', 'AUR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2480, 'Basilan', 'BAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2481, 'Batasn', 'BAN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2482, 'Batanes', 'BTN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2483, 'Batangas', 'BTG', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2484, 'Benguet', 'BEN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2485, 'Biliran', 'BIL', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2486, 'Bohol', 'BOH', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2487, 'Bukidnon', 'BUK', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2488, 'Bulacan', 'BUL', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2489, 'Cagayan', 'CAG', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2490, 'Camarines Norte', 'CAN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2491, 'Camarines Sur', 'CAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2492, 'Camiguin', 'CAM', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2493, 'Capiz', 'CAP', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2494, 'Catanduanes', 'CAT', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2495, 'Cavite', 'CAV', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2496, 'Cebu', 'CEB', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2497, 'Compostela Valley', 'COM', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2498, 'Davao', 'DAV', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2499, 'Davao del Sur', 'DAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2500, 'Davao Oriental', 'DAO', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2501, 'Eastern Samar', 'EAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2502, 'Guimaras', 'GUI', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2503, 'Ifugao', 'IFU', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2504, 'Ilocos Norte', 'ILN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2505, 'Ilocos Sur', 'ILS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2506, 'Iloilo', 'ILI', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2507, 'Isabela', 'ISA', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2508, 'Kalinga-Apayso', 'KAL', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2509, 'Laguna', 'LAG', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2510, 'Lanao del Norte', 'LAN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2511, 'Lanao del Sur', 'LAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2512, 'La Union', 'LUN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2513, 'Leyte', 'LEY', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2514, 'Maguindanao', 'MAG', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2515, 'Marinduque', 'MAD', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2516, 'Masbate', 'MAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2517, 'Mindoro Occidental', 'MDC', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2518, 'Mindoro Oriental', 'MDR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2519, 'Misamis Occidental', 'MSC', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2520, 'Misamis Oriental', 'MSR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2521, 'Mountain Province', 'MOU', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2522, 'Negroe Occidental', 'NEC', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2523, 'Negros Oriental', 'NER', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2524, 'North Cotabato', 'NCO', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2525, 'Northern Samar', 'NSA', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2526, 'Nueva Ecija', 'NUE', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2527, 'Nueva Vizcaya', 'NUV', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2528, 'Palawan', 'PLW', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2529, 'Pampanga', 'PAM', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2530, 'Pangasinan', 'PAN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2531, 'Quezon', 'QUE', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2532, 'Quirino', 'QUI', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2533, 'Rizal', 'RIZ', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2534, 'Romblon', 'ROM', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2535, 'Sarangani', 'SAR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2536, 'Siquijor', 'SIG', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2537, 'Sorsogon', 'SOR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2538, 'South Cotabato', 'SCO', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2539, 'Southern Leyte', 'SLE', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2540, 'Sultan Kudarat', 'SUK', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2541, 'Sulu', 'SLU', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2542, 'Surigao del Norte', 'SUN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2543, 'Surigao del Sur', 'SUR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2544, 'Tarlac', 'TAR', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2545, 'Tawi-Tawi', 'TAW', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2546, 'Western Samar', 'WSA', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2547, 'Zambales', 'ZMB', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2548, 'Zamboanga del Norte', 'ZAN', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2549, 'Zamboanga del Sur', 'ZAS', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2550, 'Zamboanga Sibiguey', 'ZSI', 173, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2551, 'Islamabad', 'IS', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2552, 'Baluchistan (en)', 'BA', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2553, 'North-West Frontier', 'NW', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2554, 'Sind (en)', 'SD', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2555, 'Federally Administered Tribal Aresa', 'TA', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2556, 'Azad Rashmir', 'JK', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2557, 'Northern Areas', 'NA', 166, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2558, 'Aveiro', '1', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2559, 'Beja', '2', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2560, 'Braga', '3', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2561, 'Braganca', '4', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2562, 'Castelo Branco', '5', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2563, 'Colmbra', '6', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2564, 'Ovora', '7', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2565, 'Faro', '8', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2566, 'Guarda', '9', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2567, 'Leiria', '10', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2568, 'Lisboa', '11', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2569, 'Portalegre', '12', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2570, 'Porto', '13', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2571, 'Santarem', '14', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2572, 'Setubal', '15', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2573, 'Viana do Castelo', '16', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2574, 'Vila Real', '17', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2575, 'Viseu', '18', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2576, 'Regiao Autonoma dos Acores', '20', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2577, 'Regiao Autonoma da Madeira', '30', 176, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2578, 'Asuncion', 'ASU', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2579, 'Alto Paraguay', '16', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2580, 'Alto Parana', '10', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2581, 'Amambay', '13', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2582, 'Boqueron', '19', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2583, 'Caeguazu', '5', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2584, 'Caazapl', '6', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2585, 'Canindeyu', '14', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2586, 'Concepcion', '1', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2587, 'Cordillera', '3', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2588, 'Guaira', '4', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2589, 'Itapua', '7', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2590, 'Miaiones', '8', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2591, 'Neembucu', '12', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2592, 'Paraguari', '9', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2593, 'Presidente Hayes', '15', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2594, 'San Pedro', '2', 171, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2595, 'Ad Dawhah', 'DA', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2596, 'Al Ghuwayriyah', 'GH', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2597, 'Al Jumayliyah', 'JU', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2598, 'Al Khawr', 'KH', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2599, 'Al Wakrah', 'WA', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2600, 'Ar Rayyan', 'RA', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2601, 'Jariyan al Batnah', 'JB', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2602, 'Madinat ash Shamal', 'MS', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2603, 'Umm Salal', 'US', 178, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2604, 'Bucuresti', 'B', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2605, 'Alba', 'AB', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2606, 'Arad', 'AR', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2607, 'Arges', 'AG', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2608, 'Bacau', 'BC', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2609, 'Bihor', 'BH', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2610, 'Bistrita-Nasaud', 'BN', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2611, 'Boto\'ani', 'BT', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2612, 'Bra\'ov', 'BV', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2613, 'Braila', 'BR', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2614, 'Buzau', 'BZ', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2615, 'Caras-Severin', 'CS', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2616, 'Ca la ras\'i', 'CL', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2617, 'Cluj', 'CJ', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2618, 'Constant\'a', 'CT', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2619, 'Covasna', 'CV', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2620, 'Dambovit\'a', 'DB', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2621, 'Dolj', 'DJ', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2622, 'Galat\'i', 'GL', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2623, 'Giurgiu', 'GR', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2624, 'Gorj', 'GJ', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2625, 'Harghita', 'HR', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2626, 'Hunedoara', 'HD', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2627, 'Ialomit\'a', 'IL', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2628, 'Ias\'i', 'IS', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2629, 'Ilfov', 'IF', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2630, 'Maramures', 'MM', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2631, 'Mehedint\'i', 'MH', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2632, 'Mures', 'MS', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2633, 'Neamt', 'NT', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2634, 'Olt', 'OT', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2635, 'Prahova', 'PH', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2636, 'Satu Mare', 'SM', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2637, 'Sa laj', 'SJ', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2638, 'Sibiu', 'SB', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2639, 'Suceava', 'SV', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2640, 'Teleorman', 'TR', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2641, 'Timis', 'TM', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2642, 'Tulcea', 'TL', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2643, 'Vaslui', 'VS', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2644, 'Valcea', 'VL', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2645, 'Vrancea', 'VN', 180, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2646, 'Adygeya, Respublika', 'AD', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2647, 'Altay, Respublika', 'AL', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2648, 'Bashkortostan, Respublika', 'BA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2649, 'Buryatiya, Respublika', 'BU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2650, 'Chechenskaya Respublika', 'CE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2651, 'Chuvashskaya Respublika', 'CU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2652, 'Dagestan, Respublika', 'DA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2653, 'Ingushskaya Respublika', 'IN', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2654, 'Kabardino-Balkarskaya', 'KB', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2655, 'Kalmykiya, Respublika', 'KL', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2656, 'Karachayevo-Cherkesskaya Respublika', 'KC', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2657, 'Kareliya, Respublika', 'KR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2658, 'Khakasiya, Respublika', 'KK', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2659, 'Komi, Respublika', 'KO', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2660, 'Mariy El, Respublika', 'ME', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2661, 'Mordoviya, Respublika', 'MO', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2662, 'Sakha, Respublika [Yakutiya]', 'SA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2663, 'Severnaya Osetiya, Respublika', 'SE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2664, 'Tatarstan, Respublika', 'TA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2665, 'Tyva, Respublika [Tuva]', 'TY', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2666, 'Udmurtskaya Respublika', 'UD', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2667, 'Altayskiy kray', 'ALT', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2668, 'Khabarovskiy kray', 'KHA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2669, 'Krasnodarskiy kray', 'KDA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2670, 'Krasnoyarskiy kray', 'KYA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2671, 'Primorskiy kray', 'PRI', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2672, 'Stavropol\'skiy kray', 'STA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2673, 'Amurskaya oblast\'', 'AMU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2674, 'Arkhangel\'skaya oblast\'', 'ARK', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2675, 'Astrakhanskaya oblast\'', 'AST', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2676, 'Belgorodskaya oblast\'', 'BEL', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2677, 'Bryanskaya oblast\'', 'BRY', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2678, 'Chelyabinskaya oblast\'', 'CHE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2679, 'Chitinskaya oblast\'', 'CHI', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2680, 'Irkutskaya oblast\'', 'IRK', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2681, 'Ivanovskaya oblast\'', 'IVA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2682, 'Kaliningradskaya oblast\'', 'KGD', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2683, 'Kaluzhskaya oblast\'', 'KLU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2684, 'Kamchatskaya oblast\'', 'KAM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2685, 'Kemerovskaya oblast\'', 'KEM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2686, 'Kirovskaya oblast\'', 'KIR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2687, 'Kostromskaya oblast\'', 'KOS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2688, 'Kurganskaya oblast\'', 'KGN', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2689, 'Kurskaya oblast\'', 'KRS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2690, 'Leningradskaya oblast\'', 'LEN', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2691, 'Lipetskaya oblast\'', 'LIP', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2692, 'Magadanskaya oblast\'', 'MAG', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2693, 'Moskovskaya oblast\'', 'MOS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2694, 'Murmanskaya oblast\'', 'MUR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2695, 'Nizhegorodskaya oblast\'', 'NIZ', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2696, 'Novgorodskaya oblast\'', 'NGR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2697, 'Novosibirskaya oblast\'', 'NVS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2698, 'Omskaya oblast\'', 'OMS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2699, 'Orenburgskaya oblast\'', 'ORE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2700, 'Orlovskaya oblast\'', 'ORL', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2701, 'Penzenskaya oblast\'', 'PNZ', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2702, 'Permskaya oblast\'', 'PER', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2703, 'Pskovskaya oblast\'', 'PSK', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2704, 'Rostovskaya oblast\'', 'ROS', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2705, 'Ryazanskaya oblast\'', 'RYA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2706, 'Sakhalinskaya oblast\'', 'SAK', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2707, 'Samarskaya oblast\'', 'SAM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2708, 'Saratovskaya oblast\'', 'SAR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2709, 'Smolenskaya oblast\'', 'SMO', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2710, 'Sverdlovskaya oblast\'', 'SVE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2711, 'Tambovskaya oblast\'', 'TAM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2712, 'Tomskaya oblast\'', 'TOM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2713, 'Tul\'skaya oblast\'', 'TUL', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2714, 'Tverskaya oblast\'', 'TVE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2715, 'Tyumenskaya oblast\'', 'TYU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2716, 'Ul\'yanovskaya oblast\'', 'ULY', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2717, 'Vladimirskaya oblast\'', 'VLA', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2718, 'Volgogradskaya oblast\'', 'VGG', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2719, 'Vologodskaya oblast\'', 'VLG', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2720, 'Voronezhskaya oblast\'', 'VOR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2721, 'Yaroslavskaya oblast\'', 'YAR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2722, 'Moskva', 'MOW', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2723, 'Sankt-Peterburg', 'SPE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2724, 'Yevreyskaya avtonomnaya oblast\'', 'YEV', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2725, 'Aginskiy Buryatskiy avtonomnyy', 'AGB', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2726, 'Chukotskiy avtonomnyy okrug', 'CHU', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2727, 'Evenkiyskiy avtonomnyy okrug', 'EVE', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2728, 'Khanty-Mansiyskiy avtonomnyy okrug', 'KHM', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2729, 'Komi-Permyatskiy avtonomnyy okrug', 'KOP', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2730, 'Koryakskiy avtonomnyy okrug', 'KOR', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2731, 'Nenetskiy avtonomnyy okrug', 'NEN', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2732, 'Taymyrskiy (Dolgano-Nenetskiy)', 'TAY', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2733, 'Ust\'-Ordynskiy Buryatskiy', 'UOB', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2734, 'Yamalo-Nenetskiy avtonomnyy okrug', 'YAN', 181, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2735, 'Butare', 'C', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2736, 'Byumba', 'I', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2737, 'Cyangugu', 'E', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2738, 'Gikongoro', 'D', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2739, 'Gisenyi', 'G', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2740, 'Gitarama', 'B', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2741, 'Kibungo', 'J', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2742, 'Kibuye', 'F', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2743, 'Kigali-Rural Kigali y\' Icyaro', 'K', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2744, 'Kigali-Ville Kigali Ngari', 'L', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2745, 'Mutara', 'M', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2746, 'Ruhengeri', 'H', 182, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2747, 'Al Batah', '11', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2748, 'Al H,udd ash Shamallyah', '8', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2749, 'Al Jawf', '12', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2750, 'Al Madinah', '3', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2751, 'Al Qasim', '5', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2752, 'Ar Riyad', '1', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2753, 'Asir', '14', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2754, 'Ha\'il', '6', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2755, 'Jlzan', '9', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2756, 'Makkah', '2', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2757, 'Najran', '10', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2758, 'Tabuk', '7', 191, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2759, 'Capital Territory (Honiara)', 'CT', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2760, 'Guadalcanal', 'GU', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2761, 'Isabel', 'IS', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2762, 'Makira', 'MK', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2763, 'Malaita', 'ML', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2764, 'Temotu', 'TE', 200, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2765, 'Aali an Nil', 'AN', 207, b'1', 1, '2018-06-29 06:11:24', 297, '2018-11-16 05:59:59'),
(2766, 'Al Bah al Ahmar', '26', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2767, 'Al Buhayrat', '18', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2768, 'Al Jazirah', '7', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2769, 'Al Khartum', '3', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2770, 'Al Qadarif', '6', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2771, 'Al Wahdah', '22', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2772, 'An Nil', '4', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2773, 'An Nil al Abyaq', '8', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2774, 'An Nil al Azraq', '24', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2775, 'Ash Shamallyah', '1', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2776, 'Bahr al Jabal', '17', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2777, 'Gharb al Istiwa\'iyah', '16', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2778, 'Gharb Ba~r al Ghazal', '14', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2779, 'Gharb Darfur', '12', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2780, 'Gharb Kurdufan', '10', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2781, 'Janub Darfur', '11', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2782, 'Janub Rurdufan', '13', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2783, 'Jnqall', '20', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2784, 'Kassala', '5', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2785, 'Shamal Batr al Ghazal', '15', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2786, 'Shamal Darfur', '2', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2787, 'Shamal Kurdufan', '9', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2788, 'Sharq al Istiwa\'iyah', '19', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2789, 'Sinnar', '25', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2790, 'Warab', '21', 207, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2791, 'Blekinge lan', 'K', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2792, 'Dalarnas lan', 'W', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2793, 'Gotlands lan', 'I', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2794, 'Gavleborge lan', 'X', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2795, 'Hallands lan', 'N', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2796, 'Jamtlande lan', 'Z', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2797, 'Jonkopings lan', 'F', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2798, 'Kalmar lan', 'H', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2799, 'Kronoberge lan', 'G', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2800, 'Norrbottena lan', 'BD', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2801, 'Skane lan', 'M', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2802, 'Stockholms lan', 'AB', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2803, 'Sodermanlands lan', 'D', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2804, 'Uppsala lan', 'C', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2805, 'Varmlanda lan', 'S', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2806, 'Vasterbottens lan', 'AC', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2807, 'Vasternorrlands lan', 'Y', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2808, 'Vastmanlanda lan', 'U', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2809, 'Vastra Gotalands lan', 'Q', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2810, 'Orebro lan', 'T', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2811, 'Ostergotlands lan', 'E', 211, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2812, 'Saint Helena', 'SH', 183, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2813, 'Ascension', 'AC', 183, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2814, 'Tristan da Cunha', 'TA', 183, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2815, 'Ajdovscina', '1', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2816, 'Beltinci', '2', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2817, 'Benedikt', '148', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2818, 'Bistrica ob Sotli', '149', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2819, 'Bled', '3', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2820, 'Bloke', '150', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2821, 'Bohinj', '4', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2822, 'Borovnica', '5', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2823, 'Bovec', '6', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2824, 'Braslovce', '151', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2825, 'Brda', '7', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2826, 'Brezovica', '8', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2827, 'Brezica', '9', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2828, 'Cankova', '152', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2829, 'Celje', '11', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(2830, 'Cerklje na Gorenjskem', '12', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2831, 'Cerknica', '13', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2832, 'Cerkno', '14', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2833, 'Cerkvenjak', '153', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2834, 'Crensovci', '15', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2835, 'Crna na Koroskem', '16', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2836, 'Crnomelj', '17', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2837, 'Destrnik', '18', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2838, 'Divaca', '19', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2839, 'Dobje', '154', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2840, 'Dobrepolje', '20', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2841, 'Dobrna', '155', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2842, 'Dobrova-Polhov Gradec', '21', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2843, 'Dobrovnik', '156', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2844, 'Dol pri Ljubljani', '22', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2845, 'Dolenjske Toplice', '157', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2846, 'Domzale', '23', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2847, 'Dornava', '24', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2848, 'Dravograd', '25', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2849, 'Duplek', '26', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2850, 'Gorenja vas-Poljane', '27', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2851, 'Gorsnica', '28', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2852, 'Gornja Radgona', '29', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2853, 'Gornji Grad', '30', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2854, 'Gornji Petrovci', '31', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2855, 'Grad', '158', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2856, 'Grosuplje', '32', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2857, 'Hajdina', '159', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2858, 'Hoce-Slivnica', '160', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2859, 'Hodos', '161', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2860, 'Jorjul', '162', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2861, 'Hrastnik', '34', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2862, 'Hrpelje-Kozina', '35', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2863, 'Idrija', '36', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2864, 'Ig', '37', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2865, 'IIrska Bistrica', '38', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2866, 'Ivancna Gorica', '39', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2867, 'Izola', '40', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2868, 'Jesenice', '41', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2869, 'Jezersko', '163', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2870, 'Jursinci', '42', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2871, 'Kamnik', '43', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2872, 'Kanal', '44', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2873, 'Kidricevo', '45', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2874, 'Kobarid', '46', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2875, 'Kobilje', '47', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2876, 'Jovevje', '48', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2877, 'Komen', '49', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2878, 'Komenda', '164', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2879, 'Koper', '50', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2880, 'Kostel', '165', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2881, 'Kozje', '51', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2882, 'Kranj', '52', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2883, 'Kranjska Gora', '53', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2884, 'Krizevci', '166', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2885, 'Krsko', '54', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2886, 'Kungota', '55', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2887, 'Kuzma', '56', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2888, 'Lasko', '57', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2889, 'Lenart', '58', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2890, 'Lendava', '59', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2891, 'Litija', '60', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2892, 'Ljubljana', '61', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2893, 'Ljubno', '62', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2894, 'Ljutomer', '63', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2895, 'Logatec', '64', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2896, 'Loska dolina', '65', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2897, 'Loski Potok', '66', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2898, 'Lovrenc na Pohorju', '167', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2899, 'Luce', '67', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2900, 'Lukovica', '68', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2901, 'Majsperk', '69', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2902, 'Maribor', '70', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2903, 'Markovci', '168', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2904, 'Medvode', '71', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2905, 'Menges', '72', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2906, 'Metlika', '73', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2907, 'Mezica', '74', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2908, 'Miklavz na Dravskern polju', '169', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2909, 'Miren-Kostanjevica', '75', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2910, 'Mirna Pec', '170', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2911, 'Mislinja', '76', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2912, 'Moravce', '77', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2913, 'Moravske Toplice', '78', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2914, 'Mozirje', '79', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2915, 'Murska Sobota', '80', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2916, 'Muta', '81', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2917, 'Naklo', '82', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2918, 'Nazarje', '83', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2919, 'Nova Gorica', '84', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2920, 'Nova mesto', '85', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2921, 'Sveta Ana', '181', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2922, 'Sveti Andraz v Slovenskih goricah', '182', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2923, 'Sveti Jurij', '116', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2924, 'Salovci', '33', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2925, 'Sempeter-Vrtojba', '183', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2926, 'Sencur', '117', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2927, 'Sentilj', '118', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2928, 'Sentjernej', '119', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2929, 'Sentjur pri Celju', '120', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2930, 'Skocjan', '121', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2931, 'Skofja Loka', '122', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2932, 'Skoftjica', '123', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2933, 'Smarje pri Jelsah', '124', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2934, 'Smartno ob Paki', '125', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2935, 'Smartno pri Litiji', '194', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2936, 'Sostanj', '126', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2937, 'Store', '127', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2938, 'Tabor', '184', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2939, 'Tisina', '10', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2940, 'Tolmin', '128', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2941, 'Trbovje', '129', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2942, 'Trebnje', '130', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2943, 'Trnovska vas', '185', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2944, 'Trzic', '131', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2945, 'Trzin', '186', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2946, 'Turnisce', '132', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2947, 'Velenje', '133', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2948, 'Velika Polana', '187', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2949, 'Velika Lasce', '134', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2950, 'Verzej', '188', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2951, 'Videm', '135', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2952, 'Vipava', '136', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2953, 'Vitanje', '137', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2954, 'Vojnik', '138', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2955, 'Vransko', '189', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2956, 'Vrhnika', '140', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2957, 'Vuzenica', '141', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2958, 'Zagorje ob Savi', '142', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2959, 'Zavrc', '143', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2960, 'Zrece', '144', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2961, 'Zalec', '190', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2962, 'Zelezniki', '146', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2963, 'Zetale', '191', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2964, 'Ziri', '147', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2965, 'Zirovnica', '192', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2966, 'Zuzemberk', '193', 198, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2967, 'Banskobystrický kraj', 'BC', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2968, 'Bratislavský kraj', 'BL', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2969, 'Košický kraj', 'KI', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2970, 'Nitriansky kraj', 'NJ', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2971, 'Prešovský kraj', 'PV', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2972, 'Trenčiansky kraj', 'TC', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2973, 'Trnavský kraj', 'TA', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2974, 'Žilinský kraj', 'ZI', 197, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2975, 'Dakar', 'DK', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2976, 'Diourbel', 'DB', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2977, 'Fatick', 'FK', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2978, 'Kaolack', 'KL', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2979, 'Kolda', 'KD', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2980, 'Louga', 'LG', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2981, 'Matam', 'MT', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2982, 'Saint-Louis', 'SL', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2983, 'Tambacounda', 'TC', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2984, 'Thies', 'TH', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2985, 'Ziguinchor', 'ZG', 192, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2986, 'Awdal', 'AW', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2987, 'Bakool', 'BK', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2988, 'Banaadir', 'BN', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2989, 'Bay', 'BY', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2990, 'Galguduud', 'GA', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2991, 'Gedo', 'GE', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2992, 'Hiirsan', 'HI', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2993, 'Jubbada Dhexe', 'JD', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2994, 'Jubbada Hoose', 'JH', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2995, 'Mudug', 'MU', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2996, 'Nugaal', 'NU', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2997, 'Saneag', 'SA', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2998, 'Shabeellaha Dhexe', 'SD', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(2999, 'Shabeellaha Hoose', 'SH', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3000, 'Sool', 'SO', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3001, 'Togdheer', 'TO', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3002, 'Woqooyi Galbeed', 'WO', 201, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3003, 'Brokopondo', 'BR', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3004, 'Commewijne', 'CM', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3005, 'Coronie', 'CR', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3006, 'Marowijne', 'MA', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3007, 'Nickerie', 'NI', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3008, 'Paramaribo', 'PM', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3009, 'Saramacca', 'SA', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3010, 'Sipaliwini', 'SI', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3011, 'Wanica', 'WA', 208, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3012, 'Principe', 'P', 190, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3013, 'Sao Tome', 'S', 190, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3014, 'Ahuachapan', 'AH', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3015, 'Cabanas', 'CA', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3016, 'Cuscatlan', 'CU', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3017, 'Chalatenango', 'CH', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3018, 'Morazan', 'MO', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3019, 'San Miguel', 'SM', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3020, 'San Salvador', 'SS', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3021, 'Santa Ana', 'SA', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3022, 'San Vicente', 'SV', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3023, 'Sonsonate', 'SO', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3024, 'Usulutan', 'US', 65, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3025, 'Al Hasakah', 'HA', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3026, 'Al Ladhiqiyah', 'LA', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3027, 'Al Qunaytirah', 'QU', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3028, 'Ar Raqqah', 'RA', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3029, 'As Suwayda\'', 'SU', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3030, 'Dar\'a', 'DR', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3031, 'Dayr az Zawr', 'DY', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3032, 'Dimashq', 'DI', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3033, 'Halab', 'HL', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3034, 'Hamah', 'HM', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3035, 'Jim\'', 'HI', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3036, 'Idlib', 'ID', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3037, 'Rif Dimashq', 'RD', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3038, 'Tarts', 'TA', 213, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3039, 'Hhohho', 'HH', 210, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3040, 'Lubombo', 'LU', 210, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3041, 'Manzini', 'MA', 210, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3042, 'Shiselweni', 'SH', 210, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3043, 'Batha', 'BA', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3044, 'Biltine', 'BI', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3045, 'Borkou-Ennedi-Tibesti', 'BET', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3046, 'Chari-Baguirmi', 'CB', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3047, 'Guera', 'GR', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3048, 'Kanem', 'KA', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3049, 'Lac', 'LC', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3050, 'Logone-Occidental', 'LO', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3051, 'Logone-Oriental', 'LR', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3052, 'Mayo-Kebbi', 'MK', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3053, 'Moyen-Chari', 'MC', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3054, 'Ouaddai', 'OD', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3055, 'Salamat', 'SA', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3056, 'Tandjile', 'TA', 42, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3057, 'Kara', 'K', 218, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3058, 'Maritime (Region)', 'M', 218, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3059, 'Savannes', 'S', 218, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3060, 'Krung Thep Maha Nakhon Bangkok', '10', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3061, 'Phatthaya', 'S', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3062, 'Amnat Charoen', '37', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3063, 'Ang Thong', '15', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3064, 'Buri Ram', '31', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3065, 'Chachoengsao', '24', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3066, 'Chai Nat', '18', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3067, 'Chaiyaphum', '36', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3068, 'Chanthaburi', '22', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3069, 'Chiang Mai', '50', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3070, 'Chiang Rai', '57', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3071, 'Chon Buri', '20', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3072, 'Chumphon', '86', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3073, 'Kalasin', '46', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3074, 'Kamphasng Phet', '62', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3075, 'Kanchanaburi', '71', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3076, 'Khon Kaen', '40', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3077, 'Krabi', '81', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3078, 'Lampang', '52', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3079, 'Lamphun', '51', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3080, 'Loei', '42', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3081, 'Lop Buri', '16', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3082, 'Mae Hong Son', '58', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3083, 'Maha Sarakham', '44', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3084, 'Mukdahan', '50', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3085, 'Nakhon Nayok', '26', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3086, 'Nakhon Pathom', '73', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3087, 'Nakhon Phanom', '48', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3088, 'Nakhon Ratchasima', '30', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3089, 'Nakhon Sawan', '60', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3090, 'Nakhon Si Thammarat', '80', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3091, 'Nan', '55', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3092, 'Narathiwat', '96', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3093, 'Nong Bua Lam Phu', '39', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3094, 'Nong Khai', '43', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3095, 'Nonthaburi', '12', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3096, 'Pathum Thani', '13', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3097, 'Pattani', '94', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3098, 'Phangnga', '82', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3099, 'Phatthalung', '93', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3100, 'Phayao', '56', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3101, 'Phetchabun', '67', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3102, 'Phetchaburi', '76', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3103, 'Phichit', '66', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3104, 'Phitsanulok', '65', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3105, 'Phrae', '54', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3106, 'Phra Nakhon Si Ayutthaya', '14', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3107, 'Phaket', '83', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3108, 'Prachin Buri', '25', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3109, 'Prachuap Khiri Khan', '77', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3110, 'Ranong', '85', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3111, 'Ratchaburi', '70', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3112, 'Rayong', '21', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3113, 'Roi Et', '45', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3114, 'Sa Kaeo', '27', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3115, 'Sakon Nakhon', '47', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3116, 'Samut Prakan', '11', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3117, 'Samut Sakhon', '74', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3118, 'Samut Songkhram', '75', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3119, 'Saraburi', '19', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3120, 'Satun', '91', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3121, 'Sing Buri', '17', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3122, 'Si Sa Ket', '33', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3123, 'Songkhla', '90', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3124, 'Sukhothai', '64', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3125, 'Suphan Buri', '72', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3126, 'Surat Thani', '84', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3127, 'Surin', '32', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3128, 'Tak', '63', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3129, 'Trang', '92', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3130, 'Trat', '23', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3131, 'Ubon Ratchathani', '34', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3132, 'Udon Thani', '41', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3133, 'Uthai Thani', '61', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3134, 'Uttaradit', '53', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3135, 'Yala', '95', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3136, 'Yasothon', '35', 217, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3137, 'Sughd', 'SU', 215, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3138, 'Khatlon', 'KT', 215, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3139, 'Gorno-Badakhshan', 'GB', 215, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3140, 'Ahal', 'A', 224, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3141, 'Balkan', 'B', 224, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3142, 'Dasoguz', 'D', 224, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3143, 'Lebap', 'L', 224, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3144, 'Mary', 'M', 224, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3145, 'Béja', '31', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3146, 'Ben Arous', '13', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3147, 'Bizerte', '23', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3148, 'Gabès', '81', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3149, 'Gafsa', '71', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3150, 'Jendouba', '32', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3151, 'Kairouan', '41', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3152, 'Rasserine', '42', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3153, 'Kebili', '73', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3154, 'L\'Ariana', '12', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3155, 'Le Ref', '33', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3156, 'Mahdia', '53', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3157, 'La Manouba', '14', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3158, 'Medenine', '82', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3159, 'Moneatir', '52', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3160, 'Naboul', '21', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3161, 'Sfax', '61', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3162, 'Sidi Bouxid', '43', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3163, 'Siliana', '34', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3164, 'Sousse', '51', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3165, 'Tataouine', '83', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3166, 'Tozeur', '72', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3167, 'Tunis', '11', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3168, 'Zaghouan', '22', 222, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3169, 'Adana', '1', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3170, 'Ad yaman', '2', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3171, 'Afyon', '3', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3172, 'Ag r', '4', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3173, 'Aksaray', '68', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3174, 'Amasya', '5', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3175, 'Ankara', '6', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3176, 'Antalya', '7', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3177, 'Ardahan', '75', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3178, 'Artvin', '8', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3179, 'Aydin', '9', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3180, 'Bal kesir', '10', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3181, 'Bartin', '74', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3182, 'Batman', '72', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3183, 'Bayburt', '69', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3184, 'Bilecik', '11', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3185, 'Bingol', '12', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3186, 'Bitlis', '13', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3187, 'Bolu', '14', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3188, 'Burdur', '15', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3189, 'Bursa', '16', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3190, 'Canakkale', '17', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3191, 'Cankir', '18', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3192, 'Corum', '19', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3193, 'Denizli', '20', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3194, 'Diyarbakir', '21', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3195, 'Duzce', '81', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3196, 'Edirne', '22', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3197, 'Elazig', '23', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3198, 'Erzincan', '24', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3199, 'Erzurum', '25', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3200, 'Eskis\'ehir', '26', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3201, 'Gaziantep', '27', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3202, 'Giresun', '28', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3203, 'Gms\'hane', '29', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3204, 'Hakkari', '30', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3205, 'Hatay', '31', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3206, 'Igidir', '76', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3207, 'Isparta', '32', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3208, 'Icel', '33', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3209, 'Istanbul', '34', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3210, 'Izmir', '35', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3211, 'Kahramanmaras', '46', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3212, 'Karabk', '78', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3213, 'Karaman', '70', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3214, 'Kars', '36', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3215, 'Kastamonu', '37', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3216, 'Kayseri', '38', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3217, 'Kirikkale', '71', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3218, 'Kirklareli', '39', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3219, 'Kirs\'ehir', '40', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3220, 'Kilis', '79', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3221, 'Kocaeli', '41', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3222, 'Konya', '42', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3223, 'Ktahya', '43', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3224, 'Malatya', '44', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3225, 'Manisa', '45', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3226, 'Mardin', '47', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3227, 'Mugila', '48', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3228, 'Mus', '50', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3229, 'Nevs\'ehir', '50', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3230, 'Nigide', '51', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3231, 'Ordu', '52', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3232, 'Osmaniye', '80', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3233, 'Rize', '53', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3234, 'Sakarya', '54', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3235, 'Samsun', '55', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3236, 'Siirt', '56', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3237, 'Sinop', '57', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3238, 'Sivas', '58', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3239, 'S\'anliurfa', '63', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3240, 'S\'rnak', '73', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3241, 'Tekirdag', '59', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3242, 'Tokat', '60', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3243, 'Trabzon', '61', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3244, 'Tunceli', '62', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3245, 'Us\'ak', '64', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3246, 'Van', '65', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3247, 'Yalova', '77', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3248, 'Yozgat', '66', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3249, 'Zonguldak', '67', 223, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3250, 'Couva-Tabaquite-Talparo', 'CTT', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3251, 'Diego Martin', 'DMN', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3252, 'Eastern Tobago', 'ETO', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3253, 'Penal-Debe', 'PED', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3254, 'Princes Town', 'PRT', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3255, 'Rio Claro-Mayaro', 'RCM', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3256, 'Sangre Grande', 'SGE', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3257, 'San Juan-Laventille', 'SJL', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3258, 'Siparia', 'SIP', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3259, 'Tunapuna-Piarco', 'TUP', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3260, 'Western Tobago', 'WTO', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3261, 'Arima', 'ARI', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3262, 'Chaguanas', 'CHA', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3263, 'Point Fortin', 'PTF', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3264, 'Port of Spain', 'POS', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3265, 'San Fernando', 'SFO', 221, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3266, 'Aileu', 'AL', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3267, 'Ainaro', 'AN', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3268, 'Bacucau', 'BA', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3269, 'Bobonaro', 'BO', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3270, 'Cova Lima', 'CO', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3271, 'Dili', 'DI', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3272, 'Ermera', 'ER', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3273, 'Laulem', 'LA', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3274, 'Liquica', 'LI', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3275, 'Manatuto', 'MT', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3276, 'Manafahi', 'MF', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3277, 'Oecussi', 'OE', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3278, 'Viqueque', 'VI', 62, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3279, 'Changhua', 'CHA', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3280, 'Chiayi', 'CYQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3281, 'Hsinchu', 'HSQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3282, 'Hualien', 'HUA', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3283, 'Ilan', 'ILA', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3284, 'Kaohsiung', 'KHQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3285, 'Miaoli', 'MIA', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3286, 'Nantou', 'NAN', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3287, 'Penghu', 'PEN', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3288, 'Pingtung', 'PIF', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3289, 'Taichung', 'TXQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3290, 'Tainan', 'TNQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3291, 'Taipei', 'TPQ', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3292, 'Taitung', 'TTT', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3293, 'Taoyuan', 'TAO', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3294, 'Yunlin', 'YUN', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3295, 'Keelung', 'KEE', 214, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3296, 'Arusha', '1', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3297, 'Dar-es-Salaam', '2', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3298, 'Dodoma', '3', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3299, 'Iringa', '4', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3300, 'Kagera', '5', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3301, 'Kaskazini Pemba', '6', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3302, 'Kaskazini Unguja', '7', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3303, 'Xigoma', '8', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3304, 'Kilimanjaro', '9', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3305, 'Rusini Pemba', '10', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3306, 'Kusini Unguja', '11', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3307, 'Lindi', '12', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3308, 'M2018-06-15 05:11:06ara', '26', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3309, 'Mara', '13', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3310, 'Mbeya', '14', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3311, 'Mjini Magharibi', '15', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3312, 'Morogoro', '16', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3313, 'Mtwara', '17', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3314, 'Pwani', '19', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3315, 'Rukwa', '20', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3316, 'Ruvuma', '21', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3317, 'Shinyanga', '22', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3318, 'Singida', '23', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3319, 'Tabora', '24', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3320, 'Tanga', '25', 216, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3321, 'Cherkas\'ka Oblast\'', '71', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3322, 'Chernihivs\'ka Oblast\'', '74', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3323, 'Chernivets\'ka Oblast\'', '77', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3324, 'Dnipropetrovs\'ka Oblast\'', '12', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3325, 'Donets\'ka Oblast\'', '14', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3326, 'Ivano-Frankivs\'ka Oblast\'', '26', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3327, 'Kharkivs\'ka Oblast\'', '63', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3328, 'Khersons\'ka Oblast\'', '65', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3329, 'Khmel\'nyts\'ka Oblast\'', '68', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3330, 'Kirovohrads\'ka Oblast\'', '35', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3331, 'Kyivs\'ka Oblast\'', '32', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3332, 'Luhans\'ka Oblast\'', '9', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3333, 'L\'vivs\'ka Oblast\'', '46', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3334, 'Mykolaivs\'ka Oblast\'', '48', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3335, 'Odes \'ka Oblast\'', '51', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3336, 'Poltavs\'ka Oblast\'', '53', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3337, 'Rivnens\'ka Oblast\'', '56', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3338, 'Sums \'ka Oblast\'', '59', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3339, 'Ternopil\'s\'ka Oblast\'', '61', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3340, 'Vinnyts\'ka Oblast\'', '5', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3341, 'Volyos\'ka Oblast\'', '7', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3342, 'Zakarpats\'ka Oblast\'', '21', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3343, 'Zaporiz\'ka Oblast\'', '23', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3344, 'Zhytomyrs\'ka Oblast\'', '18', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3345, 'Respublika Krym', '43', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3346, 'Kyiv', '30', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3347, 'Sevastopol', '40', 228, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3348, 'Adjumani', '301', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3349, 'Apac', '302', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3350, 'Arua', '303', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3351, 'Bugiri', '201', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3352, 'Bundibugyo', '401', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3353, 'Bushenyi', '402', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3354, 'Busia', '202', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3355, 'Gulu', '304', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3356, 'Hoima', '403', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3357, 'Iganga', '203', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3358, 'Jinja', '204', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3359, 'Kabale', '404', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3360, 'Kabarole', '405', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3361, 'Kaberamaido', '213', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3362, 'Kalangala', '101', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3363, 'Kampala', '102', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3364, 'Kamuli', '205', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3365, 'Kamwenge', '413', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3366, 'Kanungu', '414', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3367, 'Kapchorwa', '206', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3368, 'Kasese', '406', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3369, 'Katakwi', '207', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3370, 'Kayunga', '112', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3371, 'Kibaale', '407', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3372, 'Kiboga', '103', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3373, 'Kisoro', '408', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3374, 'Kitgum', '305', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3375, 'Kotido', '306', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3376, 'Kumi', '208', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3377, 'Kyenjojo', '415', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3378, 'Lira', '307', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3379, 'Luwero', '104', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3380, 'Masaka', '105', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3381, 'Masindi', '409', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3382, 'Mayuge', '214', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3383, 'Mbale', '209', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3384, 'Mbarara', '410', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3385, 'Moroto', '308', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3386, 'Moyo', '309', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3387, 'Mpigi', '106', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3388, 'Mubende', '107', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3389, 'Mukono', '108', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3390, 'Nakapiripirit', '311', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3391, 'Nakasongola', '109', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3392, 'Nebbi', '310', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3393, 'Ntungamo', '411', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3394, 'Pader', '312', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');
INSERT INTO `tblmststate` (`StateId`, `StateName`, `StateAbbreviation`, `CountryId`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(3395, 'Pallisa', '210', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3396, 'Rakai', '110', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3397, 'Rukungiri', '412', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3398, 'Sembabule', '111', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3399, 'Sironko', '215', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3400, 'Soroti', '211', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3401, 'Tororo', '212', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3402, 'Wakiso', '113', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3403, 'Yumbe', '313', 227, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3404, 'Baker Island', '81', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3405, 'Howland Island', '84', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3406, 'Jarvis Island', '86', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3407, 'Johnston Atoll', '67', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3408, 'Kingman Reef', '89', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3409, 'Midway Islands', '71', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3410, 'Navassa Island', '76', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3411, 'Palmyra Atoll', '95', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3412, 'Wake Ialand', '79', 232, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3413, 'Artigsa', 'AR', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3414, 'Canelones', 'CA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3415, 'Cerro Largo', 'CL', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3416, 'Colonia', 'CO', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3417, 'Durazno', 'DU', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3418, 'Flores', 'FS', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3419, 'Lavalleja', 'LA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3420, 'Maldonado', 'MA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3421, 'Montevideo', 'MO', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3422, 'Paysandu', 'PA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3423, 'Rivera', 'RV', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3424, 'Rocha', 'RO', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3425, 'Salto', 'SA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3426, 'Soriano', 'SO', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3427, 'Tacuarembo', 'TA', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3428, 'Treinta y Tres', 'TT', 233, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3429, 'Toshkent (city)', 'TK', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3430, 'Qoraqalpogiston Respublikasi', 'QR', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3431, 'Andijon', 'AN', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3432, 'Buxoro', 'BU', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3433, 'Farg\'ona', 'FA', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3434, 'Jizzax', 'JI', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3435, 'Khorazm', 'KH', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3436, 'Namangan', 'NG', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3437, 'Navoiy', 'NW', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3438, 'Qashqadaryo', 'QA', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3439, 'Samarqand', 'SA', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3440, 'Sirdaryo', 'SI', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3441, 'Surxondaryo', 'SU', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3442, 'Toshkent', 'TO', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3443, 'Xorazm', 'XO', 234, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3444, 'Diatrito Federal', 'A', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3445, 'Anzoategui', 'B', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3446, 'Apure', 'C', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3447, 'Aragua', 'D', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3448, 'Barinas', 'E', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3449, 'Carabobo', 'G', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3450, 'Cojedes', 'H', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3451, 'Falcon', 'I', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3452, 'Guarico', 'J', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3453, 'Lara', 'K', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3454, 'Merida', 'L', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3455, 'Miranda', 'M', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3456, 'Monagas', 'N', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3457, 'Nueva Esparta', 'O', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3458, 'Portuguesa', 'P', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3459, 'Tachira', 'S', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3460, 'Trujillo', 'T', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3461, 'Vargas', 'X', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3462, 'Yaracuy', 'U', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3463, 'Zulia', 'V', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3464, 'Delta Amacuro', 'Y', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3465, 'Dependencias Federales', 'W', 237, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3466, 'An Giang', '44', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3467, 'Ba Ria - Vung Tau', '43', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3468, 'Bac Can', '53', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3469, 'Bac Giang', '54', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3470, 'Bac Lieu', '55', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3471, 'Bac Ninh', '56', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3472, 'Ben Tre', '50', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3473, 'Binh Dinh', '31', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3474, 'Binh Duong', '57', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3475, 'Binh Phuoc', '58', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3476, 'Binh Thuan', '40', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3477, 'Ca Mau', '59', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3478, 'Can Tho', '48', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3479, 'Cao Bang', '4', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3480, 'Da Nang, thanh pho', '60', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3481, 'Dong Nai', '39', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3482, 'Dong Thap', '45', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3483, 'Gia Lai', '30', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3484, 'Ha Giang', '3', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3485, 'Ha Nam', '63', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3486, 'Ha Noi, thu do', '64', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3487, 'Ha Tay', '15', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3488, 'Ha Tinh', '23', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3489, 'Hai Duong', '61', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3490, 'Hai Phong, thanh pho', '62', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3491, 'Hoa Binh', '14', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3492, 'Ho Chi Minh, thanh pho [Sai Gon]', '65', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3493, 'Hung Yen', '66', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3494, 'Khanh Hoa', '34', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3495, 'Kien Giang', '47', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3496, 'Kon Tum', '28', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3497, 'Lai Chau', '1', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3498, 'Lam Dong', '35', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3499, 'Lang Son', '9', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3500, 'Lao Cai', '2', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3501, 'Long An', '41', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3502, 'Nam Dinh', '67', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3503, 'Nghe An', '22', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3504, 'Ninh Binh', '18', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3505, 'Ninh Thuan', '36', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3506, 'Phu Tho', '68', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3507, 'Phu Yen', '32', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3508, 'Quang Binh', '24', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3509, 'Quang Nam', '27', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3510, 'Quang Ngai', '29', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3511, 'Quang Ninh', '13', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3512, 'Quang Tri', '25', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3513, 'Soc Trang', '52', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3514, 'Son La', '5', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3515, 'Tay Ninh', '37', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3516, 'Thai Binh', '20', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3517, 'Thai Nguyen', '69', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3518, 'Thanh Hoa', '21', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3519, 'Thua Thien-Hue', '26', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3520, 'Tien Giang', '46', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3521, 'Tra Vinh', '51', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3522, 'Tuyen Quang', '7', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3523, 'Vinh Long', '50', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3524, 'Vinh Phuc', '70', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3525, 'Yen Bai', '6', 238, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3526, 'Malampa', 'MAP', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3527, 'Penama', 'PAM', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3528, 'Sanma', 'SAM', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3529, 'Shefa', 'SEE', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3530, 'Tafea', 'TAE', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3531, 'Torba', 'TOB', 235, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3532, 'A\'ana', 'AA', 188, b'1', 1, '2018-06-29 06:11:24', 1, '2018-11-16 06:46:31'),
(3533, 'Aiga-i-le-Tai', 'AL', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3534, 'Atua', 'AT', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3535, 'Fa\'aaaleleaga', 'FA', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3536, 'Gaga\'emauga', 'GE', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3537, 'Gagaifomauga', 'GI', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3538, 'Palauli', 'PA', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3539, 'Satupa\'itea', 'SA', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3540, 'Tuamasaga', 'TU', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3541, 'Va\'a-o-Fonoti', 'VF', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3542, 'Vaisigano', 'VS', 188, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3543, 'Crna Gora', 'CG', 193, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3544, 'Srbija', 'SR', 193, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3545, 'Kosovo-Metohija', 'KM', 193, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3546, 'Vojvodina', 'VO', 193, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3547, 'Abyan', 'AB', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3548, 'Adan', 'AD', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3549, 'Ad Dali', 'DA', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3550, 'Al Bayda\'', 'BA', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3551, 'Al Hudaydah', 'MU', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3552, 'Al Mahrah', 'MR', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3553, 'Al Mahwit', 'MW', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3554, 'Amran', 'AM', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3555, 'Dhamar', 'DH', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3556, 'Hadramawt', 'HD', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3557, 'Hajjah', 'HJ', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3558, 'Ibb', 'IB', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3559, 'Lahij', 'LA', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3560, 'Ma\'rib', 'MA', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3561, 'Sa\'dah', 'SD', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3562, 'San\'a\'', 'SN', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3563, 'Shabwah', 'SH', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3564, 'Ta\'izz', 'TA', 243, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3565, 'Eastern Cape', 'EC', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3566, 'Free State', 'FS', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3567, 'Gauteng', 'GT', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3568, 'Kwazulu-Natal', 'NL', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3569, 'Mpumalanga', 'MP', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3570, 'Northern Cape', 'NC', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3571, 'Limpopo', 'NP', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3572, 'Western Cape', 'WC', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3573, 'Copperbelt', '8', 245, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3574, 'Luapula', '4', 245, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3575, 'Lusaka', '9', 245, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3576, 'North-Western', '6', 245, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3577, 'Bulawayo', 'BU', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3578, 'Harare', 'HA', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3579, 'Manicaland', 'MA', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3580, 'Mashonaland Central', 'MC', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3581, 'Mashonaland East', 'ME', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3582, 'Mashonaland West', 'MW', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3583, 'Masvingo', 'MV', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3584, 'Matabeleland North', 'MN', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3585, 'Matabeleland South', 'MS', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3586, 'Midlands', 'MI', 246, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3587, 'South Karelia', 'SK', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3588, 'South Ostrobothnia', 'SO', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3589, 'Etelä-Savo', 'ES', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3590, 'Häme', 'HH', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3591, 'Itä-Uusimaa', 'IU', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3592, 'Kainuu', 'KA', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3593, 'Central Ostrobothnia', 'CO', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3594, 'Central Finland', 'CF', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3595, 'Kymenlaakso', 'KY', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3596, 'Lapland', 'LA', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3597, 'Tampere Region', 'TR', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3598, 'Ostrobothnia', 'OB', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3599, 'North Karelia', 'NK', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3600, 'Nothern Ostrobothnia', 'NO', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3601, 'Northern Savo', 'NS', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3602, 'Päijät-Häme', 'PH', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3603, 'Satakunta', 'SK', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3604, 'Uusimaa', 'UM', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3605, 'South-West Finland', 'SW', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3606, 'Åland', 'AL', 74, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3607, 'Limburg', 'LI', 155, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3608, 'Central and Western', 'CW', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3609, 'Eastern', 'EA', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3610, 'Southern', 'SO', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3611, 'Wan Chai', 'WC', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3612, 'Kowloon City', 'KC', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3613, 'Kwun Tong', 'KU', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3614, 'Sham Shui Po', 'SS', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3615, 'Wong Tai Sin', 'WT', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3616, 'Yau Tsim Mong', 'YT', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3617, 'Islands', 'IS', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3618, 'Kwai Tsing', 'KI', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3619, 'North', 'NO', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3620, 'Sai Kung', 'SK', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3621, 'Sha Tin', 'ST', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3622, 'Tai Po', 'TP', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3623, 'Tsuen Wan', 'TW', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3624, 'Tuen Mun', 'TM', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3625, 'Yuen Long', 'YL', 98, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3626, 'Manchester', 'MR', 108, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3627, 'Al Manāmah (Al ‘Āşimah)', '13', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3628, 'Al Janūbīyah', '14', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3629, 'Al Wusţá', '16', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3630, 'Ash Shamālīyah', '17', 17, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3631, 'Jenin', '_A', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3632, 'Tubas', '_B', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3633, 'Tulkarm', '_C', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3634, 'Nablus', '_D', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3635, 'Qalqilya', '_E', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3636, 'Salfit', '_F', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3637, 'Ramallah and Al-Bireh', '_G', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3638, 'Jericho', '_H', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3639, 'Jerusalem', '_I', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3641, 'Hebron', '_K', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3642, 'North Gaza', '_L', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3643, 'Gaza', '_M', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3644, 'Deir el-Balah', '_N', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3645, 'Khan Yunis', '_O', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3646, 'Rafah', '_P', 168, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3647, 'Brussels', 'BRU', 21, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3648, 'Distrito Federal', 'DIF', 142, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3649, 'North West', 'NW', 202, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3650, 'Tyne and Wear', 'TWR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3651, 'Greater Manchester', 'GTM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3652, 'Co Tyrone', 'TYR', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3653, 'West Yorkshire', 'WYK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3654, 'South Yorkshire', 'SYK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3655, 'Merseyside', 'MSY', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3656, 'Berkshire', 'BRK', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3657, 'West Midlands', 'WMD', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3658, 'West Glamorgan', 'WGM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3659, 'Greater London', 'LON', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3660, 'Carbonia-Iglesias', 'CI', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3661, 'Olbia-Tempio', 'OT', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3662, 'Medio Campidano', 'VS', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3663, 'Ogliastra', 'OG', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3664, 'Bonaire', 'BON', 154, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3665, 'Curaçao', 'CUR', 154, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3666, 'Saba', 'SAB', 154, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3667, 'St. Eustatius', 'EUA', 154, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3668, 'St. Maarten', 'SXM', 154, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3669, 'Jura', '39', 75, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3670, 'Barletta-Andria-Trani', 'Bar', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3671, 'Fermo', 'Fer', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3672, 'Monza e Brianza', 'Mon', 107, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3673, 'Clwyd', 'CWD', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3674, 'Dyfed', 'DFD', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3675, 'South Glamorgan', 'SGM', 230, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3676, 'Artibonite', 'AR', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3677, 'Centre', 'CE', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3678, 'Nippes', 'NI', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24'),
(3679, 'Nord', 'ND', 95, b'1', 1, '2018-06-29 06:11:24', 0, '2018-06-29 06:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `tblmsttable`
--

CREATE TABLE `tblmsttable` (
  `TableId` int(11) NOT NULL,
  `TableName` varchar(100) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmsttable`
--

INSERT INTO `tblmsttable` (`TableId`, `TableName`, `DisplayName`, `IsActive`) VALUES
(1, 'tbluser', 'User', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmsttablecolumn`
--

CREATE TABLE `tblmsttablecolumn` (
  `ColumnId` int(11) NOT NULL,
  `ColumnName` varchar(100) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `TableId` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmsttablecolumn`
--

INSERT INTO `tblmsttablecolumn` (`ColumnId`, `ColumnName`, `DisplayName`, `TableId`, `IsActive`) VALUES
(1, 'FirstName', 'First Name', 1, b'1'),
(2, 'LastName', 'Last Name', 1, b'1'),
(3, 'Title', 'Title', 1, b'1'),
(4, 'EmailAddress', 'Email Address', 1, b'1'),
(5, 'Address1', 'Address1', 1, b'1'),
(6, 'Address2', 'Address2', 1, b'1'),
(7, 'CountryName', 'Country', 1, b'1'),
(8, 'StateName', 'State', 1, b'1'),
(9, 'City', 'City', 1, b'1'),
(10, 'ZipCode', 'Zip Code', 1, b'1'),
(11, 'PhoneNumber', 'Phone Number', 1, b'1'),
(12, 'RoleName', 'Role', 1, b'1'),
(13, 'Name', 'Company Name', 1, b'1'),
(14, 'Website', 'Company Website', 1, b'1'),
(15, 'PhoneNumber', 'Company PhoneNumber', 1, b'1'),
(16, 'IndustryName', 'Industry Name', 1, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmsttoken`
--

CREATE TABLE `tblmsttoken` (
  `TokenId` int(11) NOT NULL,
  `TokenName` text NOT NULL,
  `Description` varchar(300) NOT NULL,
  `DisplayText` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmsttoken`
--

INSERT INTO `tblmsttoken` (`TokenId`, `TokenName`, `Description`, `DisplayText`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'User Send Request', '', 'User Send Request', b'1', 1, '2018-11-28 06:44:27', 1, '2018-11-28 06:44:27'),
(2, 'User Invitation', '', 'User Invitation', b'1', 1, '2018-11-28 06:44:41', 1, '2018-11-28 06:44:41'),
(3, 'User Re-Invitation', '', 'User Re-Invitation', b'1', 1, '2018-11-28 06:45:01', 1, '2018-11-28 06:45:01'),
(4, 'Registration Complete', '', 'Registration Complete', b'1', 1, '2018-11-28 06:45:15', 1, '2018-11-28 06:45:15'),
(5, 'Reset Password', '', 'Reset Password', b'1', 1, '2018-11-28 06:45:29', 1, '2018-11-28 06:45:29'),
(6, 'Forgot Password', '', 'Forgot Password', b'1', 1, '2018-11-28 06:45:46', 1, '2018-11-28 06:45:46'),
(7, 'Change Password', '', 'Change Password', b'1', 1, '2018-11-28 06:45:59', 1, '2018-11-28 06:45:59'),
(8, 'User register to Admin', '', 'User register to Admin', b'1', 1, '2018-11-28 06:46:13', 1, '2018-11-28 06:46:13'),
(9, 'Admin register to SuperAdmin', '', 'Admin register to SuperAdmin', b'1', 1, '2018-11-28 06:46:25', 1, '2018-11-28 06:46:25'),
(10, 'User Activation', '', 'User Activation', b'1', 1, '2018-11-28 06:46:38', 1, '2018-11-28 06:46:38'),
(11, 'Open Invitation', '', 'Open Invitation', b'1', 1, '2018-12-28 05:24:34', 1, '2018-12-28 05:24:34'),
(12, 'User Revoked', '', 'User Revoked', b'1', 1, '2018-11-28 06:45:01', 1, '2018-11-28 06:45:01'),
(13, 'Course Start Reminder For Learner', '', 'Course Start Reminder For Learner', b'1', 1, '2019-04-12 06:54:55', 1, '2019-04-12 06:54:55'),
(14, 'Instructor should get an email before X days', '', 'Instructor should get an email before X days', b'1', 1, '2019-04-15 05:27:17', 1, '2019-04-15 05:27:17'),
(15, 'Instructor Followers Session Start ', '', 'Instructor Followers Session Start', b'1', 1, '2019-04-16 07:30:18', 1, '2019-04-16 07:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `tblmstuserrole`
--

CREATE TABLE `tblmstuserrole` (
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstuserrole`
--

INSERT INTO `tblmstuserrole` (`RoleId`, `RoleName`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 'SuperAdmin', b'1', 1, '2018-10-10 06:43:58', 1, '2018-10-10 06:43:58'),
(2, 'Admin', b'1', 1, '2018-10-10 06:43:58', 1, '2018-10-10 06:43:58'),
(3, 'Instructor', b'1', 1, '2018-10-10 06:44:55', 1, '2018-10-10 06:44:55'),
(4, 'Learner', b'1', 1, '2018-10-10 06:44:55', 1, '2018-10-10 06:44:55'),
(5, 'IT', b'1', 1, '2018-10-10 06:44:55', 1, '2018-10-10 06:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotification`
--

CREATE TABLE `tblnotification` (
  `NotificationId` int(11) NOT NULL,
  `SenderId` int(11) NOT NULL,
  `NotificationTitle` varchar(100) NOT NULL,
  `NotificationText` varchar(200) NOT NULL,
  `RecipientId` int(11) NOT NULL,
  `IsRead` bit(1) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblresources`
--

CREATE TABLE `tblresources` (
  `ResourcesId` int(11) NOT NULL,
  `InstructorId` int(11) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `Dataurl` text DEFAULT NULL,
  `Keyword` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblresources`
--

INSERT INTO `tblresources` (`ResourcesId`, `InstructorId`, `FilePath`, `Dataurl`, `Keyword`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 484, '1556280895097_1546868881860_l1.jpg', NULL, 'CourseImage', b'1', 484, '2019-04-26 21:44:49', NULL, NULL),
(2, 484, '1556280895097_1-Angular.mp4', NULL, 'CourseVideo', b'1', 484, '2019-04-26 21:44:49', NULL, NULL),
(3, 484, '1556281282809_ss.mp4', NULL, 'topicVideo', b'1', 484, '2019-04-26 21:51:17', NULL, NULL),
(4, 484, '1556281282810_Addendum1NYCDOCLearningManagementSystemRFSSI3118FINAL-1920x1080px-5s_444790.mp4', NULL, 'topicVideo', b'1', 484, '2019-04-26 21:51:17', NULL, NULL),
(5, 484, '1556281282813_Google Glass How-to1.mp4', NULL, 'topicVideo', b'1', 484, '2019-04-26 21:51:17', NULL, NULL),
(6, 484, 'certificatebadge1.png', NULL, 'CourseImage', b'1', 484, '2019-04-26 21:54:58', NULL, NULL),
(7, 484, 'certificatebadge1.png', NULL, 'CourseImage', b'1', 484, '2019-04-26 22:04:45', NULL, NULL),
(8, 484, '1556282559800_21.jpg', NULL, 'CourseImage', b'1', 484, '2019-04-26 22:12:34', NULL, NULL),
(9, 484, 'certificatebadge2.png', NULL, 'CourseImage', b'1', 484, '2019-04-26 22:16:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblrolespermission`
--

CREATE TABLE `tblrolespermission` (
  `PermissionId` int(11) NOT NULL,
  `ScreenId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `View` int(1) NOT NULL DEFAULT 1,
  `AddEdit` int(1) NOT NULL DEFAULT 1,
  `Delete` int(1) NOT NULL DEFAULT 1,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblrolespermission`
--

INSERT INTO `tblrolespermission` (`PermissionId`, `ScreenId`, `RoleId`, `View`, `AddEdit`, `Delete`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 1, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(2, 2, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:10'),
(4, 4, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(5, 5, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(6, 6, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(7, 7, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(8, 8, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(9, 9, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(10, 10, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(11, 11, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(12, 12, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(15, 15, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(16, 16, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(17, 17, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(18, 18, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(19, 19, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(20, 20, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(21, 21, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(22, 22, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(23, 23, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(24, 24, 5, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(25, 1, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(26, 2, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(28, 4, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(29, 5, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(30, 6, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(31, 7, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(32, 8, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(33, 9, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(34, 10, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(35, 11, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(36, 12, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(39, 15, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(40, 16, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:04:58'),
(41, 17, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:04:58'),
(42, 18, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(43, 19, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:04:58'),
(44, 20, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:04:58'),
(45, 21, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(46, 22, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:04:58'),
(47, 23, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:04:58'),
(48, 24, 1, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(49, 1, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(50, 2, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(52, 4, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(53, 5, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(54, 6, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(55, 7, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(56, 8, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(57, 9, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(58, 10, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(59, 11, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(60, 12, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(63, 15, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(64, 16, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:05:04'),
(65, 17, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:05:04'),
(66, 18, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(67, 19, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:05:04'),
(68, 20, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:05:04'),
(69, 21, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(70, 22, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:05:04'),
(71, 23, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:05:04'),
(72, 24, 2, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(73, 1, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(74, 2, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(76, 4, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(77, 5, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(78, 6, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(79, 7, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(80, 8, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(81, 9, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(82, 10, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(83, 11, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(84, 12, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(87, 15, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(88, 16, 3, 0, 0, 0, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:12:58'),
(89, 17, 3, 0, 0, 0, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:12:58'),
(90, 18, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(91, 19, 3, 0, 0, 0, b'1', 1, '2018-12-03 07:40:33', 1, '2019-04-30 08:12:58'),
(92, 20, 3, 0, 0, 0, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:12:58'),
(93, 21, 3, 1, 1, 1, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(95, 23, 3, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2019-04-30 08:12:58'),
(96, 24, 3, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(97, 1, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(98, 2, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(100, 4, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(101, 5, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(102, 6, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(103, 7, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(104, 8, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(105, 9, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(106, 10, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(107, 11, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(108, 12, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(111, 15, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(112, 16, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:33', 1, '2019-01-03 12:46:04'),
(113, 17, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:42', 1, '2019-01-03 12:46:04'),
(114, 18, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(115, 19, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:33', 1, '2019-01-03 12:46:04'),
(116, 20, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:42', 1, '2019-01-03 12:46:04'),
(117, 21, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:33', 1, '2018-12-03 07:40:33'),
(119, 23, 4, 0, 0, 0, b'1', 1, '2018-12-03 07:40:42', 1, '2019-01-03 12:46:04'),
(120, 24, 4, 1, 1, 1, b'1', 1, '2018-12-03 07:40:42', 1, '2018-12-03 07:40:42'),
(121, 25, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(122, 25, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(123, 25, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(124, 25, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(125, 25, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(126, 26, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(127, 26, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(128, 26, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(129, 26, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(130, 26, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(131, 28, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(132, 28, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(133, 28, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 10:56:12'),
(134, 28, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 11:03:43'),
(135, 28, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(136, 29, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(137, 29, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(138, 30, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(139, 30, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(140, 31, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(141, 31, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(142, 31, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(143, 31, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(144, 31, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(145, 32, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(146, 32, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(147, 32, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(148, 32, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(149, 32, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(150, 33, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(151, 33, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(152, 33, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(153, 33, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(154, 33, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(155, 34, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(156, 34, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(157, 34, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(158, 34, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(159, 34, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(160, 35, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(161, 35, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(162, 35, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(163, 35, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(164, 35, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(165, 36, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(166, 36, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(167, 36, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(168, 36, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(169, 36, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(170, 37, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(171, 37, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(172, 37, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(173, 37, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(174, 37, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(175, 38, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(176, 38, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(177, 38, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(178, 38, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(179, 38, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(180, 39, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(181, 39, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(182, 39, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(183, 39, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(184, 39, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(185, 40, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(186, 40, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(187, 40, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(188, 40, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(189, 30, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(190, 40, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 02:31:31'),
(191, 41, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(192, 41, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(193, 41, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(194, 41, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(195, 41, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(196, 42, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(197, 42, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(198, 42, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(199, 42, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(200, 42, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(201, 43, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(202, 43, 2, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(203, 43, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(204, 43, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(205, 43, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(206, 44, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(207, 44, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(208, 44, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(209, 44, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(210, 44, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(211, 45, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(212, 45, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(213, 45, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(214, 45, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(215, 45, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(216, 46, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(217, 46, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(218, 46, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(219, 46, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(220, 46, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(221, 47, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(222, 47, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(223, 47, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(224, 47, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(225, 47, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(226, 48, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(227, 48, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(228, 48, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(229, 48, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(230, 48, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(231, 49, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(232, 49, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(233, 49, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(234, 49, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(235, 49, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(236, 50, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(237, 50, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(238, 50, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(239, 50, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(240, 50, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(241, 51, 5, 1, 1, 1, b'1', 1, '2019-03-27 07:05:58', 1, '2019-03-27 07:05:58'),
(242, 52, 5, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:10'),
(243, 52, 1, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(244, 52, 2, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(245, 52, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(246, 52, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(247, 53, 5, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:10'),
(248, 53, 1, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(249, 53, 2, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(250, 53, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(251, 53, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(252, 54, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(253, 54, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(254, 54, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(255, 54, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(256, 54, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(257, 61, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(258, 61, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(259, 61, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(260, 61, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(261, 61, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(262, 59, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(263, 59, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(264, 59, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(265, 59, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(266, 59, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(267, 60, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(268, 60, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(269, 60, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(270, 60, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(271, 60, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(282, 29, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(283, 29, 2, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(284, 29, 1, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(285, 30, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(286, 30, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(287, 51, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(288, 51, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(289, 51, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(290, 51, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(291, 55, 5, 1, 1, 1, b'1', 1, '2019-03-27 07:05:58', 1, '2019-03-27 07:05:58'),
(292, 55, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(293, 55, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(294, 55, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(295, 55, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(296, 58, 5, 1, 1, 1, b'1', 1, '2019-03-27 07:05:58', 1, '2019-03-27 07:05:58'),
(297, 58, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(298, 58, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(299, 58, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(300, 58, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(301, 56, 5, 1, 1, 1, b'1', 1, '2019-03-27 07:05:58', 1, '2019-03-27 07:05:58'),
(302, 56, 1, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(303, 56, 2, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(304, 56, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(305, 56, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(306, 57, 5, 1, 1, 1, b'1', 1, '2019-03-27 07:05:58', 1, '2019-03-27 07:05:58'),
(307, 57, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(308, 57, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(309, 57, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(310, 57, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(311, 66, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(312, 66, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(313, 66, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(314, 66, 3, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(315, 66, 4, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(316, 67, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(317, 67, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(318, 67, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(319, 67, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(320, 67, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04'),
(321, 68, 5, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2018-11-16 05:34:11'),
(322, 68, 1, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:04:58'),
(323, 68, 2, 1, 1, 1, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:05:04'),
(324, 68, 3, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-04-30 08:12:58'),
(325, 68, 4, 0, 0, 0, b'1', 1, '2018-11-16 02:31:31', 1, '2019-01-03 12:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `UserId` int(11) NOT NULL,
  `InvitedByUserId` int(11) DEFAULT NULL,
  `RoleId` int(11) DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `EmailAddress` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `PhoneNumber2` varchar(15) DEFAULT NULL,
  `AddressesId` int(11) DEFAULT NULL,
  `UserDetailId` int(11) DEFAULT NULL,
  `ProfileImage` varchar(300) DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL,
  `Biography` text DEFAULT NULL,
  `AdminPrime` bit(1) NOT NULL DEFAULT b'0',
  `IsStatus` varchar(11) DEFAULT NULL,
  `RegistrationCode` varchar(100) DEFAULT NULL,
  `ResetPasswordCode` varchar(100) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`UserId`, `InvitedByUserId`, `RoleId`, `CompanyId`, `FirstName`, `LastName`, `Title`, `EmailAddress`, `Password`, `PhoneNumber`, `PhoneNumber2`, `AddressesId`, `UserDetailId`, `ProfileImage`, `Signature`, `Biography`, `AdminPrime`, `IsStatus`, `RegistrationCode`, `ResetPasswordCode`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 0, 5, NULL, 'it', 'It', 'Master', 'it@gmail.com', '25d55ad283aa400af464c76d713c07ad', '01234567890', '1234567890', 0, NULL, 'guy-9.jpg', NULL, 'masters developer', b'0', '0', NULL, NULL, b'1', 1, '2019-02-26 01:01:54', 1, '2019-04-25 07:37:13'),
(297, 1, 4, NULL, 'Nirav', 'patel', NULL, 'nirav.patel@theopeneyes.in', '25d55ad283aa400af464c76d713c07ad', '1234567890', '1234567890', 4, 1, '', NULL, 'ffdhfghfghf', b'0', '0', NULL, NULL, b'1', 1, '2019-02-26 07:34:53', 297, '2019-04-02 07:11:59'),
(484, 1, 3, 1, 'Anand', 'Yadav', 'Front End Developer', 'ayadav@theopeneyes.in', '25d55ad283aa400af464c76d713c07ad', '1234567890', '1234567890', 3, 3, '', '1554114323472_uttam_signature.png', 'I\'m Front-End Developer at OpenEyes Software Solutions.', b'0', '0', NULL, NULL, b'1', 1, '2019-02-26 05:27:11', 484, '2019-04-01 10:25:24'),
(504, 1, 2, 1, 'Jaxi', 'Chawda', NULL, 'jaxi.chawda@theopeneyes.in', '25d55ad283aa400af464c76d713c07ad', '1234567890', NULL, 4, NULL, 'guy-9.jpg', NULL, NULL, b'0', '0', NULL, NULL, b'1', 1, '2019-03-13 08:10:26', 1, '2019-04-25 12:06:46'),
(505, 1, 1, NULL, 'krupali', 'mystry', '', 'krupali.mystry@theopeneyes.in', '25d55ad283aa400af464c76d713c07ad', '7777777777', '1234567890', 0, NULL, '1554127313921_guy-9.jpg', NULL, 'ffdhfghfghf', b'0', '0', NULL, NULL, b'1', 1, '2019-02-26 07:34:53', 505, '2019-04-01 14:01:54'),
(506, 484, 3, 1, 'Mitesh', 'Patel', NULL, 'mitesh.patel@theopeneyes.in', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0', '1', 'C2B8CX', NULL, b'1', 484, '2019-03-15 11:12:20', 1, '2019-03-28 12:49:30'),
(512, 484, 4, NULL, 'Uttam', 'Bhut', NULL, 'uttam.bhut@theopeneyes.in', '25d55ad283aa400af464c76d713c07ad', '98989898989', NULL, 7, 6, NULL, NULL, NULL, b'0', '0', '', NULL, b'1', 484, '2019-04-03 10:06:25', 512, '2019-04-03 11:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserdetail`
--

CREATE TABLE `tbluserdetail` (
  `UserDetailId` int(11) NOT NULL,
  `EducationLevelId` int(11) NOT NULL,
  `Skills` text NOT NULL,
  `Field` varchar(250) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluserdetail`
--

INSERT INTO `tbluserdetail` (`UserDetailId`, `EducationLevelId`, `Skills`, `Field`, `IsActive`, `CreatedBy`, `CreatedOn`, `UpdatedBy`, `UpdatedOn`) VALUES
(1, 3, 'php,angular,sql,codigniter,laravel', 'php', b'1', 501, '2019-03-07 06:11:41', 297, '2019-04-03 11:22:28'),
(2, 2, 'php', 'yyyy', b'1', 502, '2019-03-07 09:42:19', 0, '2019-03-07 09:42:19'),
(3, 2, '', 'Angular', b'1', 503, '2019-03-07 13:05:04', 484, '2019-04-02 05:59:26'),
(4, 3, 'www,ggg,fff', 'php', b'1', 509, '2019-03-26 13:25:42', 0, '2019-03-26 13:25:42'),
(5, 3, '111,qqq', 'php', b'1', 511, '2019-04-01 11:41:25', 511, '2019-04-01 11:45:29'),
(6, 3, 'php,angular,sql', 'Computer Application', b'1', 512, '2019-04-03 11:59:46', 512, '2019-04-03 12:47:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`,`ip_address`,`user_agent`);

--
-- Indexes for table `tblactivitylog`
--
ALTER TABLE `tblactivitylog`
  ADD PRIMARY KEY (`ActivityLogId`);

--
-- Indexes for table `tblannouncement`
--
ALTER TABLE `tblannouncement`
  ADD PRIMARY KEY (`AnnouncementId`);

--
-- Indexes for table `tblannouncementaudience`
--
ALTER TABLE `tblannouncementaudience`
  ADD PRIMARY KEY (`AudienceId`);

--
-- Indexes for table `tblannouncementtype`
--
ALTER TABLE `tblannouncementtype`
  ADD PRIMARY KEY (`AnnouncementTypeId`);

--
-- Indexes for table `tblbadges`
--
ALTER TABLE `tblbadges`
  ADD PRIMARY KEY (`BadgesId`);

--
-- Indexes for table `tblcertificatetemplate`
--
ALTER TABLE `tblcertificatetemplate`
  ADD PRIMARY KEY (`CertificateId`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`CompanyId`),
  ADD KEY `InvitedByUserId` (`ParentId`),
  ADD KEY `AddressesId` (`AddressesId`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`CourseId`);
ALTER TABLE `tblcourse` ADD FULLTEXT KEY `Keyword` (`Keyword`);

--
-- Indexes for table `tblcoursecertificate`
--
ALTER TABLE `tblcoursecertificate`
  ADD PRIMARY KEY (`CourseCertificateId`);

--
-- Indexes for table `tblcoursediscussion`
--
ALTER TABLE `tblcoursediscussion`
  ADD PRIMARY KEY (`DiscussionId`);

--
-- Indexes for table `tblcourseinstructor`
--
ALTER TABLE `tblcourseinstructor`
  ADD PRIMARY KEY (`CourseInstructorId`);

--
-- Indexes for table `tblcoursereview`
--
ALTER TABLE `tblcoursereview`
  ADD PRIMARY KEY (`ReviewId`);

--
-- Indexes for table `tblcoursesession`
--
ALTER TABLE `tblcoursesession`
  ADD PRIMARY KEY (`CourseSessionId`);

--
-- Indexes for table `tblcoursetopic`
--
ALTER TABLE `tblcoursetopic`
  ADD PRIMARY KEY (`TopicId`);

--
-- Indexes for table `tblcourseuserregister`
--
ALTER TABLE `tblcourseuserregister`
  ADD PRIMARY KEY (`CourseUserregisterId`);

--
-- Indexes for table `tblemailattachment`
--
ALTER TABLE `tblemailattachment`
  ADD PRIMARY KEY (`AttachmentId`);

--
-- Indexes for table `tblemaillog`
--
ALTER TABLE `tblemaillog`
  ADD PRIMARY KEY (`EmailLogId`);

--
-- Indexes for table `tblemailnotification`
--
ALTER TABLE `tblemailnotification`
  ADD PRIMARY KEY (`EmailNotificationId`);

--
-- Indexes for table `tblemailtemplate`
--
ALTER TABLE `tblemailtemplate`
  ADD PRIMARY KEY (`EmailId`);

--
-- Indexes for table `tblinstructorcertificate`
--
ALTER TABLE `tblinstructorcertificate`
  ADD PRIMARY KEY (`CertificateId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `tblinstructorfollowers`
--
ALTER TABLE `tblinstructorfollowers`
  ADD PRIMARY KEY (`InstructorFollowerId`);

--
-- Indexes for table `tbllearnertest`
--
ALTER TABLE `tbllearnertest`
  ADD PRIMARY KEY (`LearnerTestID`);

--
-- Indexes for table `tblloginlog`
--
ALTER TABLE `tblloginlog`
  ADD PRIMARY KEY (`tblLoginLogId`);

--
-- Indexes for table `tblmstaddresses`
--
ALTER TABLE `tblmstaddresses`
  ADD PRIMARY KEY (`AddressesId`),
  ADD KEY `CountryId` (`CountryId`),
  ADD KEY `StateId` (`StateId`);

--
-- Indexes for table `tblmstcategory`
--
ALTER TABLE `tblmstcategory`
  ADD PRIMARY KEY (`CategoryId`);

--
-- Indexes for table `tblmstconfiguration`
--
ALTER TABLE `tblmstconfiguration`
  ADD PRIMARY KEY (`ConfigurationId`);

--
-- Indexes for table `tblmstcountry`
--
ALTER TABLE `tblmstcountry`
  ADD PRIMARY KEY (`CountryId`);

--
-- Indexes for table `tblmstdepartment`
--
ALTER TABLE `tblmstdepartment`
  ADD PRIMARY KEY (`DepartmentId`);

--
-- Indexes for table `tblmsteducationlevel`
--
ALTER TABLE `tblmsteducationlevel`
  ADD PRIMARY KEY (`EducationLevelId`);

--
-- Indexes for table `tblmstindustry`
--
ALTER TABLE `tblmstindustry`
  ADD PRIMARY KEY (`IndustryId`);

--
-- Indexes for table `tblmstquestion`
--
ALTER TABLE `tblmstquestion`
  ADD PRIMARY KEY (`QuestionId`);

--
-- Indexes for table `tblmstquestionoption`
--
ALTER TABLE `tblmstquestionoption`
  ADD PRIMARY KEY (`OptionId`);

--
-- Indexes for table `tblmstresult`
--
ALTER TABLE `tblmstresult`
  ADD PRIMARY KEY (`ResultId`);

--
-- Indexes for table `tblmstscreen`
--
ALTER TABLE `tblmstscreen`
  ADD PRIMARY KEY (`ScreenId`);

--
-- Indexes for table `tblmststate`
--
ALTER TABLE `tblmststate`
  ADD PRIMARY KEY (`StateId`),
  ADD KEY `CountryId` (`CountryId`);

--
-- Indexes for table `tblmsttoken`
--
ALTER TABLE `tblmsttoken`
  ADD PRIMARY KEY (`TokenId`);

--
-- Indexes for table `tblmstuserrole`
--
ALTER TABLE `tblmstuserrole`
  ADD PRIMARY KEY (`RoleId`);

--
-- Indexes for table `tblnotification`
--
ALTER TABLE `tblnotification`
  ADD PRIMARY KEY (`NotificationId`);

--
-- Indexes for table `tblresources`
--
ALTER TABLE `tblresources`
  ADD PRIMARY KEY (`ResourcesId`);

--
-- Indexes for table `tblrolespermission`
--
ALTER TABLE `tblrolespermission`
  ADD PRIMARY KEY (`PermissionId`),
  ADD KEY `RoleId` (`RoleId`),
  ADD KEY `ScreenId` (`ScreenId`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`UserId`),
  ADD KEY `InvitedByUserId` (`InvitedByUserId`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `tbluserdetail`
--
ALTER TABLE `tbluserdetail`
  ADD PRIMARY KEY (`UserDetailId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblactivitylog`
--
ALTER TABLE `tblactivitylog`
  MODIFY `ActivityLogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblannouncement`
--
ALTER TABLE `tblannouncement`
  MODIFY `AnnouncementId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblannouncementaudience`
--
ALTER TABLE `tblannouncementaudience`
  MODIFY `AudienceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblannouncementtype`
--
ALTER TABLE `tblannouncementtype`
  MODIFY `AnnouncementTypeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblbadges`
--
ALTER TABLE `tblbadges`
  MODIFY `BadgesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcertificatetemplate`
--
ALTER TABLE `tblcertificatetemplate`
  MODIFY `CertificateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `CompanyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcourse`
--
ALTER TABLE `tblcourse`
  MODIFY `CourseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcoursecertificate`
--
ALTER TABLE `tblcoursecertificate`
  MODIFY `CourseCertificateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcoursediscussion`
--
ALTER TABLE `tblcoursediscussion`
  MODIFY `DiscussionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcourseinstructor`
--
ALTER TABLE `tblcourseinstructor`
  MODIFY `CourseInstructorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblcoursereview`
--
ALTER TABLE `tblcoursereview`
  MODIFY `ReviewId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcoursesession`
--
ALTER TABLE `tblcoursesession`
  MODIFY `CourseSessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblcoursetopic`
--
ALTER TABLE `tblcoursetopic`
  MODIFY `TopicId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblcourseuserregister`
--
ALTER TABLE `tblcourseuserregister`
  MODIFY `CourseUserregisterId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblemailattachment`
--
ALTER TABLE `tblemailattachment`
  MODIFY `AttachmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblemaillog`
--
ALTER TABLE `tblemaillog`
  MODIFY `EmailLogId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblemailnotification`
--
ALTER TABLE `tblemailnotification`
  MODIFY `EmailNotificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tblemailtemplate`
--
ALTER TABLE `tblemailtemplate`
  MODIFY `EmailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblinstructorcertificate`
--
ALTER TABLE `tblinstructorcertificate`
  MODIFY `CertificateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblinstructorfollowers`
--
ALTER TABLE `tblinstructorfollowers`
  MODIFY `InstructorFollowerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbllearnertest`
--
ALTER TABLE `tbllearnertest`
  MODIFY `LearnerTestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblloginlog`
--
ALTER TABLE `tblloginlog`
  MODIFY `tblLoginLogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmstaddresses`
--
ALTER TABLE `tblmstaddresses`
  MODIFY `AddressesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmstcategory`
--
ALTER TABLE `tblmstcategory`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblmstconfiguration`
--
ALTER TABLE `tblmstconfiguration`
  MODIFY `ConfigurationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblmstcountry`
--
ALTER TABLE `tblmstcountry`
  MODIFY `CountryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `tblmstdepartment`
--
ALTER TABLE `tblmstdepartment`
  MODIFY `DepartmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmsteducationlevel`
--
ALTER TABLE `tblmsteducationlevel`
  MODIFY `EducationLevelId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblmstindustry`
--
ALTER TABLE `tblmstindustry`
  MODIFY `IndustryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmstquestion`
--
ALTER TABLE `tblmstquestion`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblmstquestionoption`
--
ALTER TABLE `tblmstquestionoption`
  MODIFY `OptionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tblmstresult`
--
ALTER TABLE `tblmstresult`
  MODIFY `ResultId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmstscreen`
--
ALTER TABLE `tblmstscreen`
  MODIFY `ScreenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tblmststate`
--
ALTER TABLE `tblmststate`
  MODIFY `StateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3680;

--
-- AUTO_INCREMENT for table `tblmsttoken`
--
ALTER TABLE `tblmsttoken`
  MODIFY `TokenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblmstuserrole`
--
ALTER TABLE `tblmstuserrole`
  MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblnotification`
--
ALTER TABLE `tblnotification`
  MODIFY `NotificationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblresources`
--
ALTER TABLE `tblresources`
  MODIFY `ResourcesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblrolespermission`
--
ALTER TABLE `tblrolespermission`
  MODIFY `PermissionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=513;

--
-- AUTO_INCREMENT for table `tbluserdetail`
--
ALTER TABLE `tbluserdetail`
  MODIFY `UserDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
