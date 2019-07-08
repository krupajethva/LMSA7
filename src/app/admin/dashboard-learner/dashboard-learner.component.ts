import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { DashboardService } from '../services/dashboard.service';
declare var $, swal: any;
declare function myInput(): any;
declare var AmCharts, PerfectScrollbar: any;

@Component({
	selector: 'app-dashboard-learner',
	templateUrl: './dashboard-learner.component.html',
	styleUrls: ['./dashboard-learner.component.css']
})
export class DashboardLearnerComponent implements OnInit {

	LearnerCourses;
	AnnouncementTypeList;
	LearnerActivities;
	totalinstructor;
	courseview;
	activecourse;
	recentactivity;
	completedcourse;
	yourcourse;
	testdata;


	constructor(public globals: Globals, private router: Router, private route: ActivatedRoute, private DashboardService: DashboardService, ) { }

	ngOnInit() {

		this.courseview = [];
		this.totalinstructor = [];
		this.activecourse = [];
		this.recentactivity = [];

		this.completedcourse = [];

		this.yourcourse = [];

		this.testdata = [];

		setTimeout(function () {
			if ($(".bg_white_block").hasClass("ps--active-y")) {
				$('footer').removeClass('footer_fixed');
			}
			else {
				$('footer').addClass('footer_fixed');
			}
		}, 1000);

		// this.DashboardService.getLearnerCourses(this.globals.authData.UserId)
		// 	.then((data) => {
		// 		this.LearnerCourses = data['learnerCourses'];
		// 		this.AnnouncementTypeList = data['announcementTypes'];
		// 	},
		// 	(error) => {
		// 		this.globals.isLoading = false;
		// 		this.router.navigate(['/pagenotfound']);
		// 	});
		// 	this.DashboardService.getLearnerActivities(this.globals.authData.UserId)
		// 	.then((data) => {
		// 		this.LearnerActivities = data;
		// 	},
		// 	(error) => {
		// 		this.globals.isLoading = false;
		// 		this.router.navigate(['/pagenotfound']);
		// 	});

		/*################ GET LEARNER DASHBOARD START ##############*/
		this.DashboardService.getLearnerDashboard(this.globals.authData.UserId)
			.then((data) => {
				debugger

				if (data['courseview']) {
					this.courseview = data['courseview'];
				}
				if (data['activecourse']) {
					this.activecourse = data['activecourse'];
				}
				if (data['totalinstructor']) {
					this.totalinstructor = data['totalinstructor'];
				}
				if (data['recentactivity']) {
					this.recentactivity = data['recentactivity'];
				}
				if (data['completedcourse']) {
					this.completedcourse = data['completedcourse'];
				}
				if (data['yourcourse']) {
					this.yourcourse = data['yourcourse'];
				}
				if (data['testdata']) {
					this.testdata = data['testdata'];
				}
			},
				(error) => {
					this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});
		/*################ GET LEARNER DASHBOARD END ##############*/

		this.DashboardService.getCalendarDetails(this.globals.authData.UserId)
			.then((data) => {
				$('#calendar').fullCalendar({

					eventRender: function (eventObj, $el) {
						$el.popover({
							title: eventObj.title,
							content: eventObj.description + '<br><b>Start:</b> ' + eventObj.start.format('D-MMM-YY h:mm a') + '<br><b>End:</b> ' + eventObj.end.format('D-MMM-YY h:mm a') + '<br><b>Location:</b> ' + eventObj.location + '<br><b>Organizer:</b> ' + eventObj.organizer,
							//content: '<p>' + eventObj.description + '<br>Start: ' + eventObj.start.format('h:mm a') + '</p><p>' + 'End: ' + eventObj.end.format('h:mm a') + '</p>',
							trigger: 'hover',
							placement: 'bottom',
							container: 'body',
							html: true
						});
					},
					defaultDate: new Date(),
					defaultView: 'month',
					yearColumns: 2,
					bootstrap: true,
					navLinks: true,
					editable: false,
					dragable: false,
					eventLimit: true,
					events: data
				});
			},
				(error) => {
					this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});

		var chart = AmCharts.makeChart("login_course_today", {
			"type": "serial",
			"theme": "none",
			"dataProvider": [
				{
					"Test": "Test1",
					"Scores": 2,
				},
				{
					"Test": "Test2",
					"Scores": 6,
				},
				{
					"Test": "Test3",
					"Scores": 1,
				},
				{
					"Test": "Test4",
					"Scores": 10,
				},
				{
					"Test": "Test5",
					"Scores": 0,
				},
			],
			"valueAxes": [{
				"integersOnly": true,
				"minimum": 0,
				"axisAlpha": 1,
				"dashLength": 5,
				"gridCount": 10,
				"position": "left",
				"title": "Score", "titleFontSize": 11
			}],
			"startDuration": 0,
			"graphs": [{
				"balloonText": "Scores : [[value]]",
				"title": "Scores",
				"valueField": "Scores",
				"fillAlphas": 0,
				"precision": 0,
				"lineColor": "var(--theme-color)", "lineThickness": 2, "lineAlpha": 1,
			}],
			"chartCursor": {
				"cursorAlpha": 0,
				"zoomable": false,
				"valueZoomable": false,
				"valueLineBalloonEnabled": false,
				"valueLineEnabled": false,
			},
			"categoryField": "Test",
			"categoryAxis": {
				"integersOnly": true,
				"minimum": 0,
				"precision": 2,
				"axisAlpha": 1,
				"gridPosition": "start",
				"position": "left",
				"type": "Test",
				"title": "Test", "titleFontSize": 11
			},
		});


		// PERFECT SCROLLBAR
		// new PerfectScrollbar('.scroll_yourscore');
		new PerfectScrollbar('.scroll_score');
		//new PerfectScrollbar('.scroll_calender');
		// END PERFECT SCROLLBAR


	}

}
