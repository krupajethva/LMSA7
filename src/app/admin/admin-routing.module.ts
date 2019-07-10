import { BrowserModule } from '@angular/platform-browser';
import { Component, NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from "@angular/common";
import { AdminComponent } from './admin.component.module';
import { Globals } from './globals';
import { HttpClientModule } from '@angular/common/http';

import { DashboardComponent } from './dashboard/dashboard.component';
import { DashboardService } from './services/dashboard.service';

import { CompanyComponent } from './company/company.component';
import { CompanyListComponent } from './company-list/company-list.component';
import { CompanyService } from './services/company.service';

import { IndustryComponent } from './industry/industry.component';
import { IndustrylistComponent } from './industrylist/industrylist.component';
import { IndustryService } from './services/industry.service';

import { RegisterAdminInvitedComponent } from './register-admin-invited/register-admin-invited.component';
import { RegisterAdminInvitedService } from './services/register-admin-invited.service';


import { UserListComponent } from './user-list/user-list.component';
import { UserService } from './services/user.service';

import { InstructorfollowersComponent } from './instructorfollowers/instructorfollowers.component';
import { InstructorfollowersService } from './services/instructorfollowers.service';

import { CoursebeforereminderComponent } from './coursebeforereminder/coursebeforereminder.component';
import { CoursebeforereminderService } from './services/coursebeforereminder.service';

import { LoginlogComponent } from './loginlog/loginlog.component';
import { EmaillogComponent } from './emaillog/emaillog.component';

import { UserinstructorlistComponent } from './userinstructorlist/userinstructorlist.component';
import { UserinstructorService } from './services/userinstructor.service';

import { CountryComponent } from './country/country.component';
import { CountrylistComponent } from './countrylist/countrylist.component';
import { CountryService } from './services/country.service';

import { StateComponent } from './state/state.component';
import { StatelistComponent } from './statelist/statelist.component';
import { StateService } from './services/state.service';

import { EducationComponent } from './education/education.component';
import { EducationlistComponent } from './educationlist/educationlist.component';
import { EducationService } from './services/education.service';

import { EmailtemplateComponent } from './emailtemplate/emailtemplate.component';
import { EmailtemplateListComponent } from './emailtemplate-list/emailtemplate-list.component';
import { EmailtemplateService } from './services/emailtemplate.service';

import { SettingsComponent } from './settings/settings.component';
import { SettingsService } from './services/settings.service';

import { DashboardLearnerComponent } from './dashboard-learner/dashboard-learner.component';

import { ActivityListComponent } from './activity-list/activity-list.component';
import { ActivityService } from './services/activity.service';



import { InviteInstructorComponent } from './invite-instructor/invite-instructor.component';
import { InviteInstructorService } from './services/invite-instructor.service';




import { RegisterInstructorInvitedComponent } from './register-instructor-invited/register-instructor-invited.component';
import { RegisterInstructorInvitedService } from './services/register-instructor-invited.service';

import { OpeninstructorComponent } from './openinstructor/openinstructor.component';

import { AdminListComponent } from './admin-list/admin-list.component';
import { AdminService } from './services/admin.service';

import { ImportfiledataService } from './services/importfiledata.service';

import { CertificateComponent } from './certificate/certificate.component';
import { CourseDetailComponent } from './course-detail/course-detail.component';

import { RegisterLearnerComponent } from './register-learner/register-learner.component';
import { RegisterService } from './services/register.service';

import { UserActivationComponent } from './user-activation/user-activation.component';
import { UserActivationService } from './services/user-activation.service';

import { RegisterAdminComponent } from './register-admin/register-admin.component';
import { EditProfileAdminComponent } from './edit-profile-admin/edit-profile-admin.component';
import { EditProfileService } from './services/edit-profile.service';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { HeaderRegisterComponent } from './header-register/header-register.component';
import { FooterRegisterComponent } from './footer-register/footer-register.component';
import { LinkListComponent } from './link-list/link-list.component';
import { LoginComponent } from './login/login.component';
import { RolepermissionComponent } from './rolepermission/rolepermission.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ForgotpasswordService } from './services/forgotpassword.service';
import { ResetpasswordComponent } from './resetpassword/resetpassword.component';
import { ResetpasswordService } from './services/resetpassword.service';


import { CategoryService } from './services/category.service';
import { CategoryComponent } from './category/category.component';
import { CategorylistComponent } from './categorylist/categorylist.component';
import { CourseComponent } from './course/course.component';
import { CourselistComponent } from './courselist/courselist.component';

import { AuthService } from './services/auth.service';
import { AuthGuard } from './services/auth-guard.service';
import { CourseService } from './services/course.service';


import { CoursetopicService } from './services/coursetopic.service';
import { ParentcategoryComponent } from './parentcategory/parentcategory.component';
import { ParentcategorylistComponent } from './parentcategorylist/parentcategorylist.component';
import { ParentcategoryService } from './services/parentcategory.service';
import { RolepermissionService } from './services/rolepermission.service';
import { CommonService } from './services/common.service';
import { CourseListComponent } from './course-list/course-list.component';


import { ActivedeleteService } from './services/activedelete.service';
import { InstructorCoursesComponent } from './instructor-courses/instructor-courses.component';
import { LearnerCoursesComponent } from './learner-courses/learner-courses.component';
import { CourseListService } from './services/course-list.service';
import { LearnerCoursesService } from './services/learner-courses.service';
import { InstructorCoursesService } from './services/instructor-courses.service';


import { InboxComponent } from './inbox/inbox.component';
import { InboxService } from './services/inbox.service';

import { InboxPreviewComponent } from './inbox-preview/inbox-preview.component';

import { CourseDiscussionComponent } from './course-discussion/course-discussion.component';
import { CourseRatingComponent } from './course-rating/course-rating.component';
import { InstructorDetailComponent } from './instructor-detail/instructor-detail.component';
import { DashboardInstructorComponent } from './dashboard-instructor/dashboard-instructor.component';
import { AssessmenttestComponent } from './assessmenttest/assessmenttest.component';
import { AssessmentresultComponent } from './assessmentresult/assessmentresult.component';
import { CourseSchedulerService } from './services/course-scheduler.service';
import { PreviewComponent } from './preview/preview.component';
import { CourseQuestionComponent } from './course-question/course-question.component';
import { CourseQuestionlistComponent } from './course-questionlist/course-questionlist.component';
import { CourseQuestionService } from './services/course-question.service';
import { AttendanceComponent } from './attendance/attendance.component';
import { CourseCertificateComponent } from './course-certificate/course-certificate.component';
import { InstructorlistComponent } from './instructorlist/instructorlist.component';
import { CertificateBadgeComponent } from './certificate-badge/certificate-badge.component';
import { CertificateBadgeslistComponent } from './certificate-badgeslist/certificate-badgeslist.component';
import { AssessmenttestService } from './services/assessmenttest.service';
import { CourseCertificateService } from './services/course-certificate.service';
import { CertificateBadgeService } from './services/certificate-badge.service';
import { AttendanceService } from './services/attendance.service';
import { InvitationacceptdeclineComponent } from './invitationacceptdecline/invitationacceptdecline.component';
import { InvitationacceptdeclineService } from './services/invitationacceptdecline.service';
import { CoursebeforereminderlistComponent } from './coursebeforereminderlist/coursebeforereminderlist.component';
import { CoursebeforereminderlistService } from './services/coursebeforereminderlist.service';
const routes: Routes = [	
  {
    path: '',
        component: AdminComponent,
        children: [
		  
				{ path : '', component : LoginComponent,canActivate : [AuthGuard] },
				{ path : 'dashboard', component : DashboardComponent,canActivate : [AuthGuard] },
				{ path : 'rolepermission', component : RolepermissionComponent,canActivate : [AuthGuard] },
				{ path : 'user-list', component : UserListComponent,canActivate : [AuthGuard] },
				{ path : 'instructor-list', component : UserinstructorlistComponent,canActivate : [AuthGuard] },
				{ path : 'country', component : CountryComponent,canActivate : [AuthGuard] },
				{ path : 'country-list', component : CountrylistComponent,canActivate : [AuthGuard] },
				{ path : 'country/edit/:id', component : CountryComponent,canActivate : [AuthGuard] },
				{ path : 'state', component : StateComponent,canActivate : [AuthGuard] },
				{ path : 'state-list', component : StatelistComponent,canActivate : [AuthGuard] },
				{ path : 'state/edit/:id', component : StateComponent,canActivate : [AuthGuard] },
				{ path : 'emailtemplate', component : EmailtemplateComponent ,canActivate : [AuthGuard]},
				{ path : 'emailtemplate-list', component : EmailtemplateListComponent ,canActivate : [AuthGuard]},
				{ path : 'emailtemplate/edit/:id', component : EmailtemplateComponent ,canActivate : [AuthGuard]},
				{ path : 'settings', component : SettingsComponent ,canActivate : [AuthGuard]},
				{ path : 'dashboard-learner', component : DashboardLearnerComponent ,canActivate : [AuthGuard]},
				{ path : 'company', component : CompanyComponent ,canActivate : [AuthGuard]},
				{ path : 'company/edit/:id', component : CompanyComponent ,canActivate : [AuthGuard]},
				{ path : 'company-list', component : CompanyListComponent ,canActivate : [AuthGuard]},
				{ path : 'industry/add', component : IndustryComponent ,canActivate : [AuthGuard]},
				{ path : 'industry/list', component : IndustrylistComponent ,canActivate : [AuthGuard]},
				{ path : 'industry/edit/:id', component : IndustryComponent ,canActivate : [AuthGuard]},
			//	{ path : 'register-admin-invited/edit/:id', component : RegisterAdminInvitedComponent ,canActivate : [AuthGuard]},
				{ path : 'user-activation/:id', component : UserActivationComponent,canActivate : [AuthGuard] },
				{ path : 'open-register-instructor', component : OpeninstructorComponent ,canActivate : [AuthGuard]},
				{ path : 'activity-list', component : ActivityListComponent ,canActivate : [AuthGuard]},
				{ path : 'loginlog', component : LoginlogComponent ,canActivate : [AuthGuard]},
				{ path : 'emaillog', component : EmaillogComponent ,canActivate : [AuthGuard]},
				{ path : 'invite-user', component : InviteInstructorComponent ,canActivate : [AuthGuard]},
				{ path : 'instructor-courses', component : InstructorCoursesComponent ,canActivate : [AuthGuard]},
				{ path : 'register-instructor-invited/edit/:id', component :  RegisterInstructorInvitedComponent ,canActivate : [AuthGuard]},
				{ path : 'admin-list', component : AdminListComponent ,canActivate : [AuthGuard]},
				{ path : 'certificate', component : CertificateComponent,canActivate : [AuthGuard] },
				{ path : 'Parentcategory', component : ParentcategoryComponent,canActivate : [AuthGuard] },
				{ path : 'Parentcategorylist', component : ParentcategorylistComponent,canActivate : [AuthGuard] },
				{ path : 'Parentcategory/edit/:id', component : ParentcategoryComponent,canActivate : [AuthGuard] },
				{ path : 'category', component : CategoryComponent,canActivate : [AuthGuard] },
				{ path : 'categorylist', component : CategorylistComponent,canActivate : [AuthGuard] },
				{ path : 'category/edit/:id', component : CategoryComponent,canActivate : [AuthGuard] },
				{ path : 'course', component : CourseComponent,canActivate : [AuthGuard] },
				{ path : 'courselist-question', component : CourselistComponent,canActivate : [AuthGuard] },
				{ path : 'course-list', component : CourseListComponent,canActivate : [AuthGuard] },
				{ path : 'course-certificate', component : CourseCertificateComponent,canActivate : [AuthGuard] },
				{ path : 'course/edit/:id', component : CourseComponent,canActivate : [AuthGuard] },
				{ path : 'course/edit/:id/:name', component : CourseComponent,canActivate : [AuthGuard] },
				{ path : 'course-detail', component : CourseDetailComponent,canActivate : [AuthGuard] },
				{ path : 'course-detail/:id', component : CourseDetailComponent,canActivate : [AuthGuard] },
				{ path : 'preview/:id', component : PreviewComponent,canActivate : [AuthGuard] },
				{ path : 'learner-courses', component : LearnerCoursesComponent,canActivate : [AuthGuard] },
				{ path : 'default-badge', component : CertificateBadgeComponent,canActivate : [AuthGuard] },
				{ path : 'default-badgelist', component : CertificateBadgeslistComponent,canActivate : [AuthGuard] },
				{ path : 'default-badge/edit/:id', component : CertificateBadgeComponent,canActivate : [AuthGuard] },
				{ path : 'education', component : EducationComponent,canActivate : [AuthGuard] },
				{ path : 'education-list', component : EducationlistComponent,canActivate : [AuthGuard] },
				{ path : 'education/edit/:id', component : EducationComponent,canActivate : [AuthGuard] },
				{ path : 'instructorfollowers', component : InstructorfollowersComponent,canActivate : [AuthGuard] },
				{ path : 'register-admin', component : RegisterAdminComponent,canActivate : [AuthGuard] },
				{ path : 'register', component : RegisterLearnerComponent,canActivate : [AuthGuard] },
				{ path : 'login', component : LoginComponent,canActivate : [AuthGuard] },
				{ path : 'link-list', component : LinkListComponent,canActivate : [AuthGuard] },
				{ path : 'forgot-password', component : ForgotPasswordComponent,canActivate : [AuthGuard] },
				{ path : 'reset-password/:id', component : ResetpasswordComponent,canActivate : [AuthGuard] },
				{ path : 'edit-profile-admin', component : EditProfileAdminComponent,canActivate : [AuthGuard] },
				{ path : 'inbox', component : InboxComponent,canActivate : [AuthGuard] },
				{ path : 'inbox/:id', component : InboxComponent,canActivate : [AuthGuard] },
				{ path : 'inbox-preview/:id', component : InboxPreviewComponent,canActivate : [AuthGuard] },
				{ path : 'course-discussion/:id', component : CourseDiscussionComponent,canActivate : [AuthGuard] },
				{ path : 'course-rating/:id', component : CourseRatingComponent,canActivate : [AuthGuard] },
				{ path : 'instructor-detail/:id', component : InstructorDetailComponent,canActivate : [AuthGuard] },
				{ path : 'instructor-detail', component : InstructorDetailComponent,canActivate : [AuthGuard] },
				{ path : 'dashboard-instructor', component : DashboardInstructorComponent,canActivate : [AuthGuard] },
				{ path : 'course-question/edit/:id', component : CourseQuestionComponent,canActivate : [AuthGuard] },
				{ path : 'course-question/:id', component : CourseQuestionComponent,canActivate : [AuthGuard] },
				{ path : 'course-question/:id/:QuestionId', component : CourseQuestionComponent,canActivate : [AuthGuard] },
				{ path : 'course-questionlist/:id', component : CourseQuestionlistComponent,canActivate : [AuthGuard] },
				{ path : 'assessment-test/:id', component : AssessmenttestComponent,canActivate : [AuthGuard] },
				{ path : 'assessment-result/:id/:name', component : AssessmentresultComponent,canActivate : [AuthGuard] },
				{ path : 'assessment-result/:id', component : AssessmentresultComponent,canActivate : [AuthGuard] },
				{ path : 'attendance', component : AttendanceComponent,canActivate : [AuthGuard] },
				{ path : 'attendance/:id', component : AttendanceComponent,canActivate : [AuthGuard] },
				{ path : 'instructorlist', component : InstructorlistComponent,canActivate : [AuthGuard] },
				{ path : 'coursebeforereminder', component : CoursebeforereminderComponent,canActivate : [AuthGuard] },
				{ path : 'coursebeforereminder/:id', component : CoursebeforereminderComponent,canActivate : [AuthGuard] },
				{ path : 'coursebeforereminderlist', component : CoursebeforereminderlistComponent,canActivate : [AuthGuard] },
				{ path : 'instructor-invitation/:id', component : InvitationacceptdeclineComponent,canActivate : [AuthGuard] },
 			    { path: '', redirectTo: 'link-list', pathMatch:'full'},
				{ path: '**', redirectTo : 'link-list' }
        
        ]
  }
];

@NgModule({
imports: [RouterModule.forChild(routes)],
exports: [RouterModule],

 
providers: [AdminService,ImportfiledataService,InboxService,Globals,AuthGuard,RegisterAdminInvitedService,
	IndustryService,RegisterService,CompanyService,RegisterInstructorInvitedService,InviteInstructorService,
	ActivityService,UserActivationService,EditProfileService,EducationService,EmailtemplateService,SettingsService,
    CountryService,StateService,RolepermissionService,AuthService,UserService,UserinstructorService,ForgotpasswordService,
	ResetpasswordService,CategoryService,CourseService,CoursetopicService,ParentcategoryService,
    CourseListService,RolepermissionService,CommonService,CoursebeforereminderlistService,
	CertificateBadgeService,AttendanceService,CourseSchedulerService,CourseCertificateService,CourseQuestionService,
	DashboardService,AssessmenttestService,LearnerCoursesService,InstructorCoursesService,ActivedeleteService,InstructorfollowersService,CoursebeforereminderService,InvitationacceptdeclineService],


  bootstrap: [AdminComponent],
})
export class AdminRoutingModule { }
