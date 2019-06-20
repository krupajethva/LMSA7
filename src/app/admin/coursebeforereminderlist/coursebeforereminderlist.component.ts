import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CoursebeforereminderlistService } from '../services/coursebeforereminderlist.service';
import { CommonService } from '../services/common.service';
import { Globals } from '.././globals';
import { debuglog } from 'util';
import { empty } from 'rxjs';

declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;

@Component({
	selector: 'app-coursebeforereminderlist',
	templateUrl: './coursebeforereminderlist.component.html',
	styleUrls: ['./coursebeforereminderlist.component.css']
})
export class CoursebeforereminderlistComponent implements OnInit {
	beforeReminderEntity;
	detailList;

	constructor(private router: Router, private route: ActivatedRoute, private CoursebeforereminderlistService: CoursebeforereminderlistService, public globals: Globals) { }

	ngOnInit() {
		debugger
		this.beforeReminderEntity = {};

		this.CoursebeforereminderlistService.getAllDetails()
			.then((data) => {
				this.detailList = data;
				//	console.log(this.courseList);
			},
				(error) => {
					//alert('error');
				});
	}

	deletereminder(data) {
		debugger
		this.CoursebeforereminderlistService.deletereminder(data)
			.then((responseData) => {
				if (responseData == true) {
					console.log('delete');
					let index = this.detailList.indexOf(data);
					if (index != -1) {
						this.detailList.splice(index, 1);
					}
					swal({
						type: 'success',
						title: 'Deleted!',
						text: 'Reminder has been deleted successfully',
						showConfirmButton: false,
						timer: 3000
					})
				} else {
					console.log('error');
				}
			})
	}

	
}
