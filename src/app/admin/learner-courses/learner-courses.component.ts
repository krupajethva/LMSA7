import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

import { LearnerCoursesService } from '../services/learner-courses.service';
declare function myInput(): any;
declare var $: any;

@Component({
	selector: 'app-learner-courses',
	templateUrl: './learner-courses.component.html',
	styleUrls: ['./learner-courses.component.css']
})
export class LearnerCoursesComponent implements OnInit {
	SubCategoryList;
	LearnerCourseEntity;
	CourseList;
	datea;
	btn_disable;
	submitted;
	CourseSesssionList;
	constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,
		private LearnerCoursesService: LearnerCoursesService) { }

	ngOnInit() {
		debugger
		//this.LearnerCourseEntity.CategoryId=0;
		this.datea = new Date();

		this.LearnerCourseEntity = {};

		this.LearnerCoursesService.getAllParent()
			//.map(res => res.json())
			.then((data) => {
				this.SubCategoryList = data['sub'];
			},
				(error) => {
					//alert('error');
					//this.router.navigate(['/pagenotfound']);
				});
		this.LearnerCoursesService.getAllCourse(this.globals.authData.UserId)
			//.map(res => res.json())
			.then((data) => {
				this.CourseList = data['course'];
				this.LearnerCourseEntity.CourseId=this.CourseList.CourseId;
 
			},
				(error) => {
					//alert('error');

					//this.router.navigate(['/pagenotfound']);
				});
				setTimeout(function () {
					$('.modal').on('shown.bs.modal', function () {
					  $('.right_content_block').addClass('style_position');
					})
					$('.modal').on('hidden.bs.modal', function () {
						$('.right_content_block').removeClass('style_position');
						
					if ($(".bg_white_block").height() < $(window).height() - 100) {
						$('footer').addClass('footer_fixed');
					}
					else {
						$('footer').removeClass('footer_fixed');
					}
						myInput();
					});
				  },
				  500);
	}
	taketest(sessionId)
	{		
		if(sessionId)
		{
			var assessment = { 'sessionId': sessionId,'learner': this.globals.authData.UserId };
			this.LearnerCoursesService.assessmentadd(assessment)
				.then((data) => {
					this.globals.isLoading = false;
			
					this.btn_disable = false;
					this.submitted = false;
					window.location.href='/assessment-test/'+sessionId;

				},
					(error) => {
						//alert('error');
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					
					});
		}



	}
	Continue(sessionId)
	{	
		window.location.href='/assessment-test/'+sessionId;
	}
	addLearnerCourse(LearnerCourseForm) {
		debugger

		if((this.LearnerCourseEntity.CourseName == undefined || this.LearnerCourseEntity.CourseName =="" || this.LearnerCourseEntity.CourseName ==null) && (this.LearnerCourseEntity.CategoryId == undefined || this.LearnerCourseEntity.CategoryId =="" || this.LearnerCourseEntity.CategoryId ==0))
		{
		
		}else
		{
		if (LearnerCourseForm.valid ) {
			this.globals.isLoading = true;

			//   this.SalesDashboardEntity.CompanyId;
			// 	this.SalesDashboardEntity.UserId;
			// this.vardisabled=true;
			if (this.LearnerCourseEntity.CourseName == undefined) {
				this.LearnerCourseEntity.CourseName = null;
			}
			if (this.LearnerCourseEntity.CategoryId == undefined) {
				this.LearnerCourseEntity.CategoryId = 0;
			}
			var data = { 'Cat': this.LearnerCourseEntity.CategoryId, 'Name': this.LearnerCourseEntity.CourseName, 'user': this.globals.authData.UserId };
			this.LearnerCoursesService.add(data)
				.then((data) => {
					this.globals.isLoading = false;
					// this.hideowner=false;
					// this.header_var = 'List of all users';
					//alert('success');
					if (data == 'error') {
						this.CourseList = [];
					}
					else {
						this.CourseList = data['course'];
					}
					setTimeout(function () {
						$('.modal').on('shown.bs.modal', function () {
						  $('.right_content_block').addClass('style_position');
						})
						$('.modal').on('hidden.bs.modal', function () {
						  $('.right_content_block').removeClass('style_position');
						});
						myInput();
					  },
					  500);
					this.btn_disable = false;
					this.submitted = false;
					this.globals.isLoading = false;
				},
					(error) => {
						//alert('error');
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					
					});
		}
	}
	}
	clearForm(LearnerCourseForm) {
		this.LearnerCourseEntity = {};
		this.LearnerCourseEntity.CategoryId = '';
		this.LearnerCourseEntity.CourseName = '';
		this.LearnerCoursesService.getAllCourse(this.globals.authData.UserId)
			//.map(res => res.json())
			.then((data) => {
				this.CourseList = data['course'];

			},
				(error) => {
					//alert('error');

					//this.router.navigate(['/pagenotfound']);
					
				});
				setTimeout(function () {
					$('.modal').on('shown.bs.modal', function () {
					  $('.right_content_block').addClass('style_position');
					})
					$('.modal').on('hidden.bs.modal', function () {
					  $('.right_content_block').removeClass('style_position');
					});
				  },
				  500);
		this.submitted = false;
		//LearnerCourseForm.form.markAsPristine();
	}
	SessionClick(CourseId,i)
	{	debugger
		$('#modalsession'+i).modal('show'); 
this.LearnerCourseEntity.CourseId=CourseId;
			var id = { 'CourseId': CourseId, 'UserId': this.globals.authData.UserId };
		this.LearnerCoursesService.getAllsessionDetail(id)
		//.map(res => res.json())
		.then((data) => {
		  if (data) {
				this.CourseSesssionList = data;
				for (var i = 0; i < this.CourseSesssionList.length; i++) {
				
					if (this.CourseSesssionList[i].monday =="0") { this.CourseSesssionList[i].monday = ''; } else { this.CourseSesssionList[i].monday = 'Mon'; }
					if( this.CourseSesssionList[i].tuesday== "0") { this.CourseSesssionList[i].tuesday = ''; } else { this.CourseSesssionList[i].tuesday = 'Tue'; }
					if (this.CourseSesssionList[i].wednesday == "0") { this.CourseSesssionList[i].wednesday = ''; } else { this.CourseSesssionList[i].wednesday = 'Wed'; }
					if (this.CourseSesssionList[i].thursday == "0") { this.CourseSesssionList[i].thursday = ''; } else { this.CourseSesssionList[i].thursday = 'Thu'; }
					if (this.CourseSesssionList[i].friday =="0") { this.CourseSesssionList[i].friday = ''; } else { this.CourseSesssionList[i].friday = 'Fri'; }
					if (this.CourseSesssionList[i].saturday == "0") { this.CourseSesssionList[i].saturday = ''; } else { this.CourseSesssionList[i].saturday = 'Sat'; }
					if (this.CourseSesssionList[i].sunday == "0") { this.CourseSesssionList[i].sunday = ''; } else { this.CourseSesssionList[i].sunday = 'Sun'; }
				}
		  }  
		},
		  (error) => {
			//alert('error');
  
			//this.router.navigate(['/pagenotfound']);
		  });
		  setTimeout(function () {
			$('.modal').on('shown.bs.modal', function () {
			  $('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
			  $('.right_content_block').removeClass('style_position');
			});
		  },
		  500);
	}
	//view certificate and redirect learner certificate page
	viewcertificate(resultId,i)
	{
		$('#modalsession'+i).modal('hide'); 
		this.router.navigate(['/assessment-result/'+resultId]);
	}
	close(i)
	{debugger
		$('#modalsession'+i).modal('hide'); 
	}
	startsession(CourseSesssionList,i)
	{

		this.router.navigate(['/course-detail/'+this.LearnerCourseEntity.CourseId]);
		$('#modalsession'+i).modal('hide'); 

	}

}


