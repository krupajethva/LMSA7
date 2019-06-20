import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CoursebeforereminderService } from '../services/coursebeforereminder.service';
import { CommonService } from '../services/common.service';
import { Globals } from '.././globals';
import { debuglog } from 'util';
import { empty } from 'rxjs';
import { cloneDeep } from 'lodash';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;

@Component({
	selector: 'app-coursebeforereminder',
	templateUrl: './coursebeforereminder.component.html',
	styleUrls: ['./coursebeforereminder.component.css']
})
export class CoursebeforereminderComponent implements OnInit {
	beforeReminderEntity;
	ReminderData;
	courseList;
	detailList;


	constructor(private router: Router, private route: ActivatedRoute, private CoursebeforereminderService: CoursebeforereminderService, public globals: Globals) { }

	ngOnInit() {
		this.beforeReminderEntity = {};

		this.CoursebeforereminderService.getcourselist()
			.then((data) => {
				this.courseList = data;
				//	console.log(this.courseList);
			},
				(error) => {
					//alert('error');
				});

		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.CoursebeforereminderService.fetchReminder(id)
				.then((data) => {
					this.beforeReminderEntity = data['0'];
					console.log(this.beforeReminderEntity);
				},
					(error) => {
						//alert('error');


					});
		}
	}

	InsertOrUpdateBeforeReminder(reminderForm) {

		console.log("outside")
		if (reminderForm.valid) {
			console.log("called")
			this.CoursebeforereminderService.BeforeReminder(this.beforeReminderEntity)
				.then((data) => {
					this.ReminderData = data;
					console.log(this.ReminderData);
					this.router.navigate(['/coursebeforereminderlist']);
				},
					(error) => {
						//alert('error');
					});
		} else {
		}
	}





}