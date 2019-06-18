import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CoursebeforereminderService } from '../services/coursebeforereminder.service';
import { CommonService } from '../services/common.service';
import { Globals } from '.././globals';
import { debuglog } from 'util';
import { empty } from 'rxjs';
import { cloneDeep } from 'lodash';

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

		this.CoursebeforereminderService.getAllDetails()
			.then((data) => {
				this.detailList = data;
				//	console.log(this.courseList);
			},
				(error) => {
					//alert('error');
				});
		console.log("beforeReminderEntity", this.beforeReminderEntity);
	}

	InsertOrUpdateBeforeReminder(reminderForm) {

		console.log("outside")
		if (reminderForm.valid) {
			console.log("called")
			this.CoursebeforereminderService.BeforeReminder(this.beforeReminderEntity)
				.then((data) => {
					//this.ReminderData = data;
					let beforeReminderEntity = cloneDeep(this.beforeReminderEntity)
					this.courseList.forEach(course => {
						if (beforeReminderEntity['CourseId'] == course.CourseId) {
							beforeReminderEntity.CourseFullName = course.CourseFullName;
						}

					});
					this.detailList.push(beforeReminderEntity);
					

					console.log('this.detailList', this.detailList);
					//this.router.navigate(['/project/list']);
				},
					(error) => {
						//alert('error');
					});
		} else {
		}
	}

	getdetails(data) {
		let ReminderData1Arr = data.Reminder1SendTo.split(',');
		let ReminderData2Arr = data.Reminder2SendTo.split(',');
		let ReminderData3Arr = data.Reminder3SendTo.split(',');
		data.candidate1 = ReminderData1Arr[0];
		data.instructor1 = ReminderData1Arr[1];
		data.candidate2 = ReminderData2Arr[0];
		data.instructor2 = ReminderData2Arr[1];
		data.candidate3 = ReminderData3Arr[0];
		data.instructor3 = ReminderData3Arr[1];
		console.log(data);
		this.beforeReminderEntity = data;
	}

	deletereminder(data) {
		debugger
		this.CoursebeforereminderService.deletereminder(data)
			.then((responseData) => {
				if (responseData == true) {
					console.log('delete');
					let index = this.detailList.indexOf(data);
					if (index != -1) {
						this.detailList.splice(index, 1);
					}
				} else {
					console.log('error');
				}
			})


	}

}