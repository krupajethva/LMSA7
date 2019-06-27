import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RegisterService } from '../services/register.service';
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

	constructor(private router: Router, private globals: Globals, private RegisterService: RegisterService) { }


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
		var skill = $('#tagsinput').val();
		this.RegisterEntity.Keyword = skill;
		if (this.RegisterEntity.Keyword == "" || this.RegisterEntity.Keyword == null || this.RegisterEntity.Keyword == undefined) {
			this.sameskill = true;
		} else {
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

	learner_Register(learnerRegisterForm) {
		debugger
		this.submitted = true;

		if (learnerRegisterForm.valid) {
			this.submitted = false;
			this.btn_disable = true;
			this.globals.isLoading = true;
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
						swal({
							type: 'success',
							title: 'Congratulations...!!!',
							text: 'Your details is submitted successfully. Please check your Email.',
							showConfirmButton: false,
							timer: 3000
						})
						//this.router.navigate(['/login']);	
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
