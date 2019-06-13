import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CoursebeforereminderService } from '../services/coursebeforereminder.service';
import { CommonService } from '../services/common.service';
import { Globals } from '.././globals';
import { debuglog } from 'util';
import { empty } from 'rxjs';

@Component({
	selector: 'app-coursebeforereminder',
	templateUrl: './coursebeforereminder.component.html',
	styleUrls: ['./coursebeforereminder.component.css']
})
export class CoursebeforereminderComponent implements OnInit {
	beforeReminderEntity;
	ReminderData;
	courseList;
	detatisList;

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

		this.CoursebeforereminderService.getAllDetails()
			.then((data) => {
				this.detatisList = data;
				//	console.log(this.courseList);
			},
				(error) => {
					//alert('error');
				});
	}

	BeforeReminder(reminderForm) {

		console.log("outside")
		if (reminderForm.valid) {
			console.log("called")
			this.CoursebeforereminderService.BeforeReminder(this.beforeReminderEntity)
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
