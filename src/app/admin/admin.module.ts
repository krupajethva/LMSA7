//import { BrowserModule } from '@angular/platform-browser';
import { Component, NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from "@angular/common";
import { JwSocialButtonsModule } from 'jw-angular-social-buttons';

//import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { AdminRoutingModule } from './admin-routing.module';
import { AdminComponent } from './admin.component.module';

import { DashboardComponent } from './dashboard/dashboard.component';

import { CompanyComponent } from './company/company.component';
import { CompanyListComponent } from './company-list/company-list.component';

import { RegisterAdminInvitedComponent } from './register-admin-invited/register-admin-invited.component';

import { IndustryComponent } from './industry/industry.component';
import { IndustrylistComponent } from './industrylist/industrylist.component';

import { AddressesComponent } from './addresses/addresses.component';
import { AddresseslistComponent } from './addresseslist/addresseslist.component';

import { PipePipe } from './pipe/pipe.pipe';

import { DatePipePipe } from './datepipe/date-pipe.pipe';

import { LoginlogComponent } from './loginlog/loginlog.component';
import { EmaillogComponent } from './emaillog/emaillog.component';


import { UserListComponent } from './user-list/user-list.component';
import { UserService } from './services/user.service';


import { UserinstructorlistComponent } from './userinstructorlist/userinstructorlist.component';

import { OpeninstructorComponent } from './openinstructor/openinstructor.component';

import { CountryComponent } from './country/country.component';
import { CountrylistComponent } from './countrylist/countrylist.component';

import { StateComponent } from './state/state.component';
import { StatelistComponent } from './statelist/statelist.component';

import { EducationComponent } from './education/education.component';
import { EducationlistComponent } from './educationlist/educationlist.component';

import { EmailtemplateComponent } from './emailtemplate/emailtemplate.component';
import { EmailtemplateListComponent } from './emailtemplate-list/emailtemplate-list.component';
import { EmailtemplateService } from './services/emailtemplate.service';

import { SettingsComponent } from './settings/settings.component';

import { DashboardLearnerComponent } from './dashboard-learner/dashboard-learner.component';

import { NotificationListComponent } from './notification-list/notification-list.component';

import { ActivityListComponent } from './activity-list/activity-list.component';

import { InviteLearnerComponent } from './invite-learner/invite-learner.component';


import { InviteInstructorComponent } from './invite-instructor/invite-instructor.component';


import { RegisterLearnerInvitedComponent } from './register-learner-invited/register-learner-invited.component';
import { RegisterInstructorInvitedComponent } from './register-instructor-invited/register-instructor-invited.component';


import { AdminListComponent } from './admin-list/admin-list.component';

import { ImportfileDataComponent } from './importfile-data/importfile-data.component';

import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { CalendarComponent } from './calendar/calendar.component';
import { CertificateComponent } from './certificate/certificate.component';
import { CourseDetailComponent } from './course-detail/course-detail.component';


import { RegisterLearnerComponent } from './register-learner/register-learner.component';
import { UserActivationComponent } from './user-activation/user-activation.component';

import { RegisterAdminComponent } from './register-admin/register-admin.component';
import { EditProfileLearnerComponent } from './edit-profile-learner/edit-profile-learner.component';

import { EditProfileAdminComponent } from './edit-profile-admin/edit-profile-admin.component';
import { EditProfileService } from './services/edit-profile.service';

import { EditProfileInstructorComponent } from './edit-profile-instructor/edit-profile-instructor.component';

import { LinkListComponent } from './link-list/link-list.component';
import { LoginComponent } from './login/login.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';

import { ResetpasswordComponent } from './resetpassword/resetpassword.component';

import { ResetpassComponent } from './resetpass/resetpass.component';
import { ResetpassService } from './services/resetpass.service';

import { HeaderRegisterComponent } from './header-register/header-register.component';
import { FooterRegisterComponent } from './footer-register/footer-register.component';

import { CategoryComponent } from './category/category.component';
import { CategorylistComponent } from './categorylist/categorylist.component';
import { CourseComponent } from './course/course.component';
import { CourselistComponent } from './courselist/courselist.component';
import { InstructorinvitationComponent } from './instructorinvitation/instructorinvitation.component';
import { InstructorinvitationlistComponent } from './instructorinvitationlist/instructorinvitationlist.component';

import { ParentcategoryComponent } from './parentcategory/parentcategory.component';
import { ParentcategorylistComponent } from './parentcategorylist/parentcategorylist.component';
import { RolepermissionComponent } from './rolepermission/rolepermission.component';
import { SelectModule } from 'ng-select';
import { AnnouncementComponent } from './announcement/announcement.component';
import { AnnouncementTypeComponent } from './announcement-type/announcement-type.component';
import { AnnouncementtypelistComponent } from './announcementtypelist/announcementtypelist.component';
import { AnnouncementlistComponent } from './announcementlist/announcementlist.component';
import { CourseListComponent } from './course-list/course-list.component';

import { CertificatetemplateComponent } from './certificatetemplate/certificatetemplate.component';
import { CertificatetemplatelistComponent } from './certificatetemplatelist/certificatetemplatelist.component';
import { LearnerCoursesComponent } from './learner-courses/learner-courses.component';
import { InstructorfollowersComponent } from './instructorfollowers/instructorfollowers.component';
import { NgxPaginationModule } from 'ngx-pagination';

import { TagInputModule } from 'ngx-chips';


import { InstructorCoursesComponent } from './instructor-courses/instructor-courses.component';
import { InboxComponent } from './inbox/inbox.component';
import { AssessmenttestComponent } from './assessmenttest/assessmenttest.component';
import { AssessmentresultComponent } from './assessmentresult/assessmentresult.component';
import { InboxPreviewComponent } from './inbox-preview/inbox-preview.component';
import { CourseDiscussionComponent } from './course-discussion/course-discussion.component';
import { CourseRatingComponent } from './course-rating/course-rating.component';
import { InstructorDetailComponent } from './instructor-detail/instructor-detail.component';
import { DashboardInstructorComponent } from './dashboard-instructor/dashboard-instructor.component';
import { PreviewComponent } from './preview/preview.component';
import { CourseQuestionComponent } from './course-question/course-question.component';
import { CourseQuestionlistComponent } from './course-questionlist/course-questionlist.component';
import { AttendanceComponent } from './attendance/attendance.component';
import { CourseCertificateComponent } from './course-certificate/course-certificate.component';
import { InstructorlistComponent } from './instructorlist/instructorlist.component';
import { CertificateBadgeComponent } from './certificate-badge/certificate-badge.component';
import { CertificateBadgeslistComponent } from './certificate-badgeslist/certificate-badgeslist.component';
@NgModule({
	
	declarations: [
		AdminComponent,
		AssessmenttestComponent,
		AssessmentresultComponent,
		PreviewComponent,
		HeaderComponent,
		CourseQuestionComponent,
		CourseQuestionlistComponent,
		FooterComponent,
		SidebarComponent,
		CategoryComponent,
		CourseCertificateComponent,
		CategorylistComponent,
		ParentcategoryComponent,
		ParentcategorylistComponent,
		CourseComponent,
		CourselistComponent,
		CourseListComponent,
		CertificateBadgeComponent,
		CertificateBadgeslistComponent,
		DashboardComponent,
		UserListComponent,
		CalendarComponent,
		CertificateComponent,
		CourseDetailComponent,
		RegisterLearnerComponent,
		RegisterAdminComponent,
		HeaderRegisterComponent,
		FooterRegisterComponent,
		InstructorCoursesComponent,
		LinkListComponent,
		LoginComponent,
		LearnerCoursesComponent,
		ForgotPasswordComponent,
		EditProfileLearnerComponent,
		EditProfileAdminComponent,
		EditProfileInstructorComponent,
		InstructorinvitationComponent,
		InstructorinvitationlistComponent,
		ResetpasswordComponent,
		ResetpassComponent,
		UserinstructorlistComponent,
		AnnouncementComponent,
		CertificatetemplateComponent,
		CertificatetemplatelistComponent,
		RolepermissionComponent,
		CountryComponent,
		CountrylistComponent,
		StateComponent,
		StatelistComponent,
		EducationComponent,
		EducationlistComponent,
		EmailtemplateComponent,
		EmailtemplateListComponent,
		SettingsComponent,
		UserActivationComponent,
		DashboardLearnerComponent, NotificationListComponent, ActivityListComponent,
		AnnouncementTypeComponent,
		AnnouncementtypelistComponent, InviteLearnerComponent,
		InviteInstructorComponent,
		RegisterLearnerInvitedComponent,
		RegisterInstructorInvitedComponent,
		InstructorfollowersComponent,
		AnnouncementlistComponent,
		AdminListComponent,
		ImportfileDataComponent,
		InboxComponent,
		InboxPreviewComponent,
		CourseDiscussionComponent,
		CourseRatingComponent,
		InstructorDetailComponent,
		DashboardInstructorComponent,
		PipePipe,
		DatePipePipe,
		LoginlogComponent,
		EmaillogComponent,
		CompanyComponent,
		CompanyListComponent,
		AddressesComponent,
		AttendanceComponent,
		AddresseslistComponent, IndustryComponent, IndustrylistComponent,
		RegisterAdminInvitedComponent, OpeninstructorComponent,		
		InstructorlistComponent,
	],
	imports: [
		//BrowserModule,
		//BrowserAnimationsModule,
		CommonModule,
		SelectModule,
		FormsModule,
		JwSocialButtonsModule,
		NgxPaginationModule,

		TagInputModule,
		ReactiveFormsModule,


		AdminRoutingModule
	],
})
export class AdminModule { }
