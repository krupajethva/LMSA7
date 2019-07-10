import { Component, OnInit,ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { RegisterService } from '../services/register.service';
import { SettingsService } from '../services/settings.service';
import { EditProfileService } from '../services/edit-profile.service';
import { Globals } from '.././globals';
declare function myInput(): any;
declare var CKEDITOR, Bloodhound, swal, Dropzone, $: any;
@Component({
	selector: 'app-register-learner',
	templateUrl: './register-learner.component.html',
	styleUrls: ['./register-learner.component.css']
})
export class RegisterLearnerComponent implements OnInit {

	RegisterEntity;
	same;
	submitted;
	submitted1;
	submitted2;
	btn_disable;
	EducationLeveList;
	sameskill;

	constructor(private router: Router, private globals: Globals, private RegisterService: RegisterService,private SettingsService : SettingsService, private elem: ElementRef, private EditProfileService: EditProfileService) { }


	ngOnInit() {

		$('.file_upload input[type="file"]').change(function (e) {
			var fileName = e.target.files[0].name;
			$('.file_upload input[type="text"]').val(fileName);
		});


		myInput();
		this.RegisterEntity = {};
		var Keyword = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: this.globals.baseAPIUrl + 'Course/skillsData',
				filter: function (list) {
					return $.map(list, function (cityname) {
						return { name: cityname };
					});
				}
			}
		});
		Keyword.initialize();
		$('#tagsinput').tagsinput({
			typeaheadjs: {
				name: 'Keyword',
				displayKey: 'name',
				valueKey: 'name',
				source: Keyword.ttAdapter()
			}
		});

		this.globals.isLoading = true;
		this.RegisterService.getlist_EducationLevel()
			.then((data) => {
				this.EducationLeveList = data;
				this.globals.isLoading = false;
			},
				(error) => {
					this.globals.isLoading = false;
					this.router.navigate(['/']);
				});
		this.SettingsService.getAllListONOFF()
			.then((data) => 
			{ 
				if(data == 1)
					this.RegisterEntity.registerRole = 2;
				else
					this.RegisterEntity.registerRole = 1;
			}, 
			(error) => 
			{
				this.globals.isLoading = false;
			});	

	}

	next1(RegisterForm1) {
		debugger
		this.submitted1 = true;
		if (RegisterForm1.valid) {

			this.submitted1 = false;
			this.btn_disable = true;
			this.globals.isLoading = true;
			this.RegisterService.alradylearner_Register(this.RegisterEntity)
				.then((data) => {
					this.globals.isLoading = false;
					this.btn_disable = false;
					this.submitted1 = false;
					if (data == 'email duplicate') {
						swal({
							type: 'warning',
							title: 'Oops...',
							text: 'This email is already exists.',
						})
					}
					else {
						this.submitted1 = false;
						$(".register_tab li").removeClass("active");
						$(".register_tab li#educationli").addClass("active");
						$("#personaldetail").removeClass("active in");
						$("#educationdetail").addClass("active in");
					}
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
			setTimeout(function () {
				myInput();
			}, 100);


		}
	}

	previous1() {
		$(".register_tab li").removeClass("active");
		$(".register_tab li#personalli").addClass("active");
		$("#educationdetail").removeClass("active in");
		$("#personaldetail").addClass("active in");
	}

	next2(RegisterForm2) {
		debugger
		this.submitted2 = true;
		if(this.RegisterEntity.registerRole == 1)
		{
			var skill = $('#tagsinput').val();
			this.RegisterEntity.Keyword = skill;
			if (this.RegisterEntity.Keyword == "" || this.RegisterEntity.Keyword == null || this.RegisterEntity.Keyword == undefined) {
				this.sameskill = true;
			} else {
				this.sameskill = false;
			}
		}
		else{
			this.sameskill = false;		
		}
		
		if (RegisterForm2.valid && !this.sameskill) {
			this.submitted2 = false;
			$(".register_tab li").removeClass("active");
			$(".register_tab li#loginli").addClass("active");
			$("#educationdetail").removeClass("active in");
			$("#logindetail").addClass("active in");
		}
	}

	previous2() {
		this.sameskill = false;
		$(".register_tab li").removeClass("active");
		$(".register_tab li#educationli").addClass("active");
		$("#logindetail").removeClass("active in");
		$("#educationdetail").addClass("active in");
	}

	certificateSelect(input)
	{
		if(input.files.length > 0)
			$("#certificate").val(input.files.length + "files selected");
		else
			$("#certificate").val(" ");
	}
	learner_Register(learnerRegisterForm) {
		debugger
		this.submitted = true;
		let file1 = '';
		if (learnerRegisterForm.valid) {
			this.submitted = false;
			this.btn_disable = true;
			this.globals.isLoading = true;
			if(this.RegisterEntity.registerRole == 2)
			{
				 file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
				var fd = new FormData();
				this.RegisterEntity.Certificate = [];					
				if (file1 && file1.length != 0)
				{
					/*if(this.RegisterEntity.CertificateId != '' && this.RegisterEntity.CertificateId != undefined)
					{
						this.RegisterEntity.Certificate.push(this.RegisterEntity.CertificateId);
					}*/
					for (var i = 0; i < file1.length; i++) {
					  var Images = Date.now() + '_' + file1[i]['name'];
					  fd.append('Certificate' + i, file1[i], Images);
					  this.RegisterEntity.Certificate.push(Images);
					}
					//this.RegisterEntity.Certificate = this.RegisterEntity.Certificate.join(",");
				} 
				else 
				{
					fd.append('Certificate', null); 
					this.RegisterEntity.Certificate = null;
				}
			}
			else{
				this.RegisterEntity.Certificate = null;
			}
			this.RegisterService.learner_Register(this.RegisterEntity)
				.then((data) => {
					this.globals.isLoading = false;
					this.btn_disable = false;
					this.submitted = false;
					
					if (data == 'email duplicate') {
						swal({
							type: 'warning',
							title: 'Oops...',
							text: 'This email is already exists.',
						})
					} else {
						this.RegisterEntity = {};
						learnerRegisterForm.form.markAsPristine();
						if (file1) {
							this.EditProfileService.uploadFileCertificate(fd, data)
								.then((data) => {
									$("#CertificateId").val(null);
									
									swal({
										type: 'success',
										title: 'Congratulations...!!!',
										text: 'Your details is submitted successfully. Please check your Email.',
										showConfirmButton: false,
										timer: 3000
									})
									this.router.navigate(['/login']);	
								},
									(error) => {
										this.btn_disable = false;
										this.submitted = false;
										this.globals.isLoading = false;
									});
						}
						else {
							swal({
								type: 'success',
								title: 'Congratulations...!!!',
								text: 'Your details is submitted successfully. Please check your Email.',
								showConfirmButton: false,
								timer: 3000
							})
						}
						this.router.navigate(['/login']);	
					}
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}





	checkpassword() {
		if (this.RegisterEntity.cPassword != this.RegisterEntity.Password) {
			this.same = true;
		} else {
			this.same = false;
		}

	}





}
