import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { SettingsService } from '../services/settings.service';
import { CommonService } from '../services/common.service';
import { Globals } from '.././globals';
import { debuglog } from 'util';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;

@Component({
	selector: 'app-settings',
	providers: [SettingsService, CommonService],
	templateUrl: './settings.component.html'
})
export class SettingsComponent implements OnInit {

	teamsizeEntity;
	submitted2;
	btn_disable2;
	submitted3;
	btn_disable3;
	submitted4;
	btn_disable4;
	submitted5;
	btn_disable5;
	submitted6;
	btn_disable6;
	submitted7;
	btn_disable7;
	instructoronoffEntity;
	configEntity;
	header;
	onoffEntity;
	InviEntity;
	ContactEntity;
	cmsgflag;
	cmessage;
	msgflag;
	message;
	type;
	courseKeyEntity;
	reminderEntity;
	submitted8;
	btn_disable8;
	courseList;
	beforeReminderEntity;
	beforeReminderEntity1;
	beforeReminderEntity2;
	beforeReminderEntity3;
	ReminderData;
	constructor(private el: ElementRef,  private router: Router,
		private route: ActivatedRoute, private SettingsService: SettingsService, public globals: Globals) {

	}
	ngOnInit() {
		this.globals.isLoading = true;
		let id = this.route.snapshot.paramMap.get('id');
		var item = { 'Day': '', 'CreatedBy': this.globals.authData.UserId, 'UpdatedBy': this.globals.authData.UserId };

		this.onoffEntity = {};
		this.configEntity = {};
		this.ContactEntity = {};
		this.InviEntity = {};
		this.courseKeyEntity = {};
		this.instructoronoffEntity = {};
		this.reminderEntity = {};
		this.beforeReminderEntity = [];
		this.beforeReminderEntity1 = {'day1': 0, 'instructor': false, 'candidate':false};
		this.beforeReminderEntity2 = {'day2': 0, 'instructor': false, 'candidate':false};
		this.beforeReminderEntity3 = {'day3': 0, 'instructor': false, 'candidate':false};
		myInput();


		this.SettingsService.getAll(this.globals.authData.UserId)
			.then((data) => {
				this.reminderEntity = data['reminder'];
				this.configEntity.emailpassword = data['emailpassword']['Value'];
				this.configEntity.emailfrom = data['emailfrom']['Value'];

				this.courseKeyEntity.CourseKeyword = data['CourseKey']['Description'];

				this.ContactEntity.ContactFrom = data['Contact']['Value'];
				this.InviEntity.Success = data['Invimsg']['Success'];
				this.InviEntity.Revoke = data['Invimsg']['Revoke'];
				this.InviEntity.Pending = data['Invimsg']['Pending'];

				if (data['configonoff']['Value'] == 1) {
					this.onoffEntity.IsActive = '1';
				} else {
					this.onoffEntity.IsActive = 0;
				}
				if (data['instructorConfigonoff']['Value'] == 1) {
					this.instructoronoffEntity.IsActive = '1';
				} else {
					this.instructoronoffEntity.IsActive = 0;
				}
				this.globals.isLoading = false;
				setTimeout(function () {
					myInput();
				}, 100);
			},
				(error) => {
					this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});

		$("body").tooltip({
			selector: "[data-toggle='tooltip']"
		});
	}

	UpdateReminder(reminderForm){
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.reminderEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted8 = false;
		} else {
			this.reminderEntity.CreatedBy = this.globals.authData.UserId;
			this.reminderEntity.UpdatedBy = this.globals.authData.UserId;
			this.reminderEntity.ConfigurationId = 0;
			this.submitted8 = true;
		}
		this.submitted7 = true;
		if (reminderForm.valid) {
			this.btn_disable8 = true;
			this.submitted8 = false;
			this.SettingsService.UpdateReminder(this.reminderEntity)
				.then((data) => {
					this.btn_disable8 = false;
					reminderForm.form.markAsPristine();
					swal({
						type: 'success',
             		    title: 'Updated!',
						text: 'Notifications Reminder updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						this.btn_disable8 = false;
						this.submitted8 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}


	insaddONOFF(insonoffForm) {
		
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.instructoronoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted7 = false;
		} else {
			this.instructoronoffEntity.CreatedBy = this.globals.authData.UserId;
			this.instructoronoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.instructoronoffEntity.ConfigurationId = 0;
			this.submitted7 = true;
		}

		this.submitted7 = true;
		if (insonoffForm.valid) {
			this.btn_disable7 = true;
			this.submitted7 = false;
			this.SettingsService.insaddONOFF(this.instructoronoffEntity)
				.then((data) => {
					this.btn_disable7 = false;
					insonoffForm.form.markAsPristine();
					swal({
						type: 'success',
              			title: 'Updated!',
						text: 'On/Off instructor settings updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						this.btn_disable7 = false;
						this.submitted7 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}


	addONOFF(onoffForm) {
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.onoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted3 = false;
			this.instructoronoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted7 = false;
		} else {
			this.onoffEntity.CreatedBy = this.globals.authData.UserId;
			this.onoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.onoffEntity.ConfigurationId = 0;
			this.submitted3 = true;
			this.instructoronoffEntity.CreatedBy = this.globals.authData.UserId;
			this.instructoronoffEntity.UpdatedBy = this.globals.authData.UserId;
			this.instructoronoffEntity.ConfigurationId = 0;
			this.submitted7 = true;
		}

		this.submitted3 = true;
		this.submitted7 = true;
		if (onoffForm.valid) {
			this.btn_disable3 = true;
			this.btn_disable7 = true;
			this.submitted3 = false;
			this.submitted7 = false;
			this.SettingsService.addONOFF({'learner':this.onoffEntity,'inst':this.instructoronoffEntity})
				.then((data) => {
					this.btn_disable3 = false;
					this.btn_disable7 = false;
					onoffForm.form.markAsPristine();
					swal({
						type: 'success',
						title:'Update!',
						text: 'On/Off settings updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						this.btn_disable3 = false;
						 this.submitted3 = false;
						 this.btn_disable7 = false;
						this.submitted7 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}

	// addONOFF(onoffForm) {
	// 	debugger
	// 	myInput();
	// 	let id = this.route.snapshot.paramMap.get('id');
	// 	if (id) {
	// 		this.onoffEntity.UpdatedBy = this.globals.authData.UserId;
	// 		this.submitted3 = false;
	// 	} else {
	// 		this.onoffEntity.CreatedBy = this.globals.authData.UserId;
	// 		this.onoffEntity.UpdatedBy = this.globals.authData.UserId;
	// 		this.onoffEntity.ConfigurationId = 0;
	// 		this.submitted3 = true;
	// 	}

	// 	this.submitted3 = true;
	// 	if (onoffForm.valid) {
	// 		this.btn_disable3 = true;
	// 		this.submitted3 = false;
	// 		this.SettingsService.addONOFF(this.onoffEntity)
	// 			.then((data) => {
	// 				this.btn_disable3 = false;
	// 				onoffForm.form.markAsPristine();
	// 				swal({
	// 					type: 'success',
	// 					title: 'On/Off Learner Settings Updated Successfully!',
	// 					showConfirmButton: false,
	// 					timer: 3000
	// 				})
	// 			},
	// 				(error) => {
	// 					// this.btn_disable3 = false;
	// 					//  this.submitted3 = false;
	// 					this.globals.isLoading = false;
	// 					this.router.navigate(['/pagenotfound']);
	// 				});
	// 	}
	// }



	addcontact(contForm) {
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.ContactEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted5 = false;
		} else {
			this.ContactEntity.CreatedBy = this.globals.authData.UserId;
			this.ContactEntity.UpdatedBy = this.globals.authData.UserId;
			this.ContactEntity.ConfigurationId = 0;
			this.submitted5 = true;
		}

		this.submitted5 = true;
		if (contForm.valid) {
			this.btn_disable5 = true;
			this.SettingsService.addcontact(this.ContactEntity)
				.then((data) => {
					this.btn_disable5 = false;
					this.submitted5 = false;
					// this.updateEntity = {};
					contForm.form.markAsPristine();
					swal({
						type: 'success',
             			 title: 'Updated!',
						text: 'Contact us email updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						//alert('error');
						this.btn_disable5 = false;
						this.submitted5 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}


	addCourseKeyword(courseKeywordForm) {
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.courseKeyEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted2 = false;
		} else {
			this.courseKeyEntity.CreatedBy = this.globals.authData.UserId;
			this.courseKeyEntity.UpdatedBy = this.globals.authData.UserId;
			this.courseKeyEntity.ConfigurationId = 0;
			this.submitted2 = true;
		}

		this.submitted2 = true;
		if (courseKeywordForm.valid) {
			this.btn_disable2 = true;
			this.SettingsService.addCourseKeyword(this.courseKeyEntity)
				.then((data) => {
					this.btn_disable2 = false;
					this.submitted2 = false;
					// this.updateEntity = {};
					courseKeywordForm.form.markAsPristine();
					swal({
		
						type: 'success',
             			 title: 'Updated!',
						text: 'Course keyword updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						//alert('error');
						this.btn_disable2 = false;
						this.submitted2 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}




	addEmailFrom(fromForm) {
		debugger
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.configEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted5 = false;
		} else {
			this.configEntity.CreatedBy = this.globals.authData.UserId;
			this.configEntity.UpdatedBy = this.globals.authData.UserId;
			this.configEntity.ConfigurationId = 0;
			this.submitted5 = true;
		}
		this.submitted4 = true;
		if (fromForm.valid) {
			this.btn_disable4 = true;
			this.SettingsService.update_email({ 'EmailFrom': this.configEntity.emailfrom, 'EmailPassword': this.configEntity.emailpassword, 'UpdatedBy': this.globals.authData.UserId })
				.then((data) => {
					this.btn_disable4 = false;
					this.submitted4 = false;
					// this.updateEntity = {};
					fromForm.form.markAsPristine();
					swal({
						type: 'success',
              			title: 'Updated!',
						text: 'SMTP details updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						//alert('error');
						this.btn_disable4 = false;
						this.submitted4 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}

	secondSubmit(InvitationForm){
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.ContactEntity.UpdatedBy = this.globals.authData.UserId;
			this.courseKeyEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted5 = false;
			this.submitted2 = false;
		} else {
			this.ContactEntity.CreatedBy = this.globals.authData.UserId;
			this.ContactEntity.UpdatedBy = this.globals.authData.UserId;
			this.ContactEntity.ConfigurationId = 0;
			this.courseKeyEntity.CreatedBy = this.globals.authData.UserId;
			this.courseKeyEntity.UpdatedBy = this.globals.authData.UserId;
			this.courseKeyEntity.ConfigurationId = 0;
			this.InviEntity.CreatedBy = this.globals.authData.UserId;
			this.InviEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted5 = true;
			this.submitted2 = true;
		}

		this.submitted5 = true;
		this.submitted2 = true;
		this.submitted6 = true;
		if (InvitationForm.valid) {
			this.btn_disable5 = true;
			this.btn_disable2 = true;
			this.btn_disable6 = true;
			this.SettingsService.secondSubmit({'contact':this.ContactEntity,'keyword':this.courseKeyEntity,'invitationmsg':this.InviEntity})
				.then((data) => {
					this.btn_disable5 = false;
					this.submitted5 = false;
					this.btn_disable2 = false;
					this.submitted2 = false;
					this.btn_disable6 = false;
					this.submitted6 = false;
					InvitationForm.form.markAsPristine();
					swal({
						type: 'success',
             			title: 'Updated!',
						text: 'Details updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						this.btn_disable5 = false;
						this.submitted5 = false;
						this.btn_disable2 = false;
						this.submitted2 = false;
						this.globals.isLoading = false;
						this.btn_disable6 = false;
						this.submitted6 = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}

	addInvitation(InvitationForm) {
		debugger
		myInput();
		this.submitted6 = true;
		if (InvitationForm.valid) {
			this.btn_disable6 = true;
			this.SettingsService.addinvimsg(this.InviEntity)
				.then((data) => {
					this.btn_disable6 = false;
					this.submitted6 = false;
					//this.updateEntity = {};
					InvitationForm.form.markAsPristine();
					swal({
						type: 'success',
						title: 'Updated!',
						text: 'Invitation message updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						//alert('error');
						this.btn_disable6 = false;
						this.submitted6 = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}

	BeforeReminder(reminderForm){
		this.beforeReminderEntity = Array(this.beforeReminderEntity1,this.beforeReminderEntity2,this.beforeReminderEntity3);
		console.log("outside")
		if (reminderForm.valid) {
			console.log("called")
		  this.SettingsService.BeforeReminder(this.beforeReminderEntity)
		  .then((data) => {
			this.ReminderData = data;
			console.log(this.ReminderData);
			//this.router.navigate(['/project/list']);
		  },
			(error) => {
			  //alert('error');
			});
		} else {
		}
	}


}
