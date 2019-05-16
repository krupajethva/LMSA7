import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { EmailtemplateService } from '../services/emailtemplate.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare function myInput(): any;
declare var $, Bloodhound: any;
declare var CKEDITOR: any, swal: any;
//import { CommonService } from '../services/common.service';

@Component({
	selector: 'app-emailtemplate',
	providers: [EmailtemplateService],
	templateUrl: './emailtemplate.component.html'

})
export class EmailtemplateComponent implements OnInit {
	emailEntity;
	submitted;
	btn_disable;
	header;
	des_valid;
	roleList;
	placeholderList;
	abcform;
	tockenList;
	buttonName;
	constructor( public globals: Globals, private router: Router, private EmailtemplateService: EmailtemplateService,
		private route: ActivatedRoute) { }

	ngOnInit() {
		debugger
		myInput();
		this.globals.msgflag = false;
		this.des_valid = false;
		this.emailEntity = {};
		//CKEDITOR.replace('EmailBody');
		CKEDITOR.replace('EmailBody', {
			height: '300',
			resize_enabled: 'false',
			resize_maxHeight: '300',
			resize_maxWidth: '948',
			resize_minHeight: '300',
			resize_minWidth: '948',
			extraAllowedContent: 'span;ul;li;table;td;style;*[id];img[*];*(*);*{*}',
			disallowedContent: 'img{width,height};',
			enterMode: Number(2)
		});
		let id = this.route.snapshot.paramMap.get('id');
		this.EmailtemplateService.getDefaultList()
			.then((data) => {
				this.roleList = data['role'];
				this.placeholderList = data['placeholder'];
				this.tockenList = data['tocken'];
				//this.globals.isLoading = false;
			},
				(error) => {
					//alert('error');
					//this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});
		if (id) {
			this.header = 'Edit';
			this.buttonName = 'Update';
			this.EmailtemplateService.getById(id)
				.then((data) => {

					if (data != "") {
						this.emailEntity = data;
						if (data['IsActive'] == 0) {
							this.emailEntity.IsActive = 0;
						} else {
							this.emailEntity.IsActive = '1';
						}

						if (this.emailEntity.Cc == 0) {
							this.emailEntity.Cc = "";
						}
						if (this.emailEntity.Bcc == 0) {
							this.emailEntity.Bcc = "";
						}
						CKEDITOR.instances.EmailBody.setData(this.emailEntity.EmailBody);
						//	this.globals.isLoading = false;
					} else {
						this.router.navigate(['/dashboard']);
					}


				},
					(error) => {
						//alert('error');
						//this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
					setTimeout(function () {
						myInput();
					}, 100);
		} else {
			this.header = 'Add';
			this.buttonName = 'Add';
			this.emailEntity = {};
			this.emailEntity.TokenId = 0;
			this.emailEntity.EmailId = 0;
			this.emailEntity.Token = '';
			this.emailEntity.To = '';
			this.emailEntity.Cc = '';
			this.emailEntity.Bcc = '';
			this.emailEntity.IsActive = '1';
			this.globals.isLoading = false;
			setTimeout(function () {
				myInput();
			}, 100);
		}

		CKEDITOR.on('instanceReady', function () {
			CKEDITOR.document.getById('contactList').on('dragstart', function (evt) {
				var target = evt.data.getTarget().getAscendant('div', true);
				CKEDITOR.plugins.clipboard.initDragDataTransfer(evt);
				var dataTransfer = evt.data.dataTransfer;
				dataTransfer.setData('text/html', '{' + target.getText() + '}');
			});
		});
		setTimeout(function () {
			$(".emailtemplate").addClass("selected");
			$(".email").addClass("active");
			$(".emailtemplate").parent().removeClass("display_block");
		}, 500);
	}


	addEmailTemplate(EmailForm) {
		debugger
		myInput();
		this.emailEntity.check = 1;
		this.emailEntity.EmailBody = CKEDITOR.instances.EmailBody.getData();
		if (this.emailEntity.EmailBody != "") {
			this.des_valid = false;
		} else {
			this.des_valid = true;
		}
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.emailEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {
			this.emailEntity.CreatedBy = this.globals.authData.UserId;
			this.emailEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = true;
		}
		if (EmailForm.valid && this.des_valid == false) {
			this.btn_disable = true;
			this.emailEntity.check = 0;
			this.EmailtemplateService.add(this.emailEntity)
				.then((data) => {
					// if (data == 'sure') {
					// 	this.btn_disable = false;
					// 	this.submitted = false;
					// 	this.abcform = EmailForm;
					// 	$('#Sure_Modal').modal('show');

					// } else {
						this.btn_disable = false;
						this.submitted = false;
						this.emailEntity = {};
						EmailForm.form.markAsPristine();
						if (id) {
							swal({

								type: 'success',
								title: 'Updated!',
								text: "Email template has been updated successfully.",
								showConfirmButton: false,
								timer: 3000
							})
						} else {
							swal({

								type: 'success',
								title: 'Added!',
								text: "Email template has been added successfully.",
								showConfirmButton: false,
								timer: 3000
							})
						}
						this.router.navigate(['/emailtemplate-list']);
					//}
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;

					});
		}
	}

	clearForm(EmailForm) {
		this.emailEntity = {};
		this.emailEntity.EmailId = 0;
		this.emailEntity.IsActive = '1';
		this.submitted = false;
		this.des_valid = false;
		this.emailEntity.Token = '';
		this.emailEntity.To = '';
		this.emailEntity.Cc = '';
		this.emailEntity.Bcc = '';
		CKEDITOR.instances.EmailBody.setData('');
		EmailForm.form.markAsPristine();
	}

	addConfirm(abcform) {

		this.emailEntity.check = 1;
		let id = this.route.snapshot.paramMap.get('id');
		this.EmailtemplateService.add(this.emailEntity)
			.then((data) => {
				$('#Sure_Modal').modal('hide');
				//	this.btn_disable = false;
				//	this.submitted = false;
				this.emailEntity = {};
				abcform.form.markAsPristine();
				if (id) {
					this.globals.message = 'Email Template Updated Successfully.';
					this.globals.type = 'success';
					this.globals.msgflag = true;
				} else {
					this.globals.message = 'Email Template Added Successfully.';
					this.globals.type = 'success';
					this.globals.msgflag = true;
				}
				this.router.navigate(['/emailtemplate/list']);

			},
				(error) => {
					this.btn_disable = false;
					this.submitted = false;
					this.globals.isLoading = false;

				});
	}
	
}

