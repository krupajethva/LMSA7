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
	ableordisable;


	constructor(private router: Router, private route: ActivatedRoute, private CoursebeforereminderService: CoursebeforereminderService, public globals: Globals) { }

	ngOnInit() {
		this.beforeReminderEntity = {};
		this.ableordisable = false;
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
					//console.log('data', data);
					if (data) {
						let ReminderData1Arr = data['0'].Reminder1SendTo.split(',');
						let ReminderData2Arr = data['0'].Reminder2SendTo.split(',');
						let ReminderData3Arr = data['0'].Reminder3SendTo.split(',');
						data['0'].candidate1 = ReminderData1Arr[0] == '1' ? true : false;
						data['0'].instructor1 = ReminderData1Arr[1] == '1' ? true : false;
						data['0'].candidate2 = ReminderData2Arr[0] == '1' ? true : false;
						data['0'].instructor2 = ReminderData2Arr[1] == '1' ? true : false;
						data['0'].candidate3 = ReminderData3Arr[0] == '1' ? true : false;
						data['0'].instructor3 = ReminderData3Arr[1] == '1' ? true : false;
						this.beforeReminderEntity = data['0'];
						console.log(this.beforeReminderEntity);
						this.ableordisable = true;
						this.courseList.push({'CourseId':data['0'].CourseId, 'CourseFullName':data['0'].CourseFullName})
						console.log(this.courseList);

					}
				},
					(error) => {
						//alert('error');
					});
		} 
	}

	InsertOrUpdateBeforeReminder(beforereminderForm) {

		console.log("outside")
		if (beforereminderForm.valid) {
			console.log("called")
			this.CoursebeforereminderService.BeforeReminder(this.beforeReminderEntity)
				.then((data) => {
					// this.ReminderData = data;
					if(this.beforeReminderEntity.CourseBeforeReminderId){
						swal({
							type: 'success',
							title: 'Updated!',
							text: 'Reminder has been updated successfully',
							showConfirmButton: false,
							timer: 3000
						})
					} else {
						swal({
							type: 'success',
							title: 'Inserted!',
							text: 'Reminder has been added successfully',
							showConfirmButton: false,
							timer: 3000
						})
					}
					setTimeout(() => this.router.navigate(['/coursebeforereminderlist']), 3000);
				},
					(error) => {
						//alert('error');
					});
		} else {
			alert('Fill proper data');
		}
	}





}