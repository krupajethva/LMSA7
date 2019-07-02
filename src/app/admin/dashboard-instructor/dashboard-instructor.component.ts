import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { DashboardService } from '../services/dashboard.service';
declare var $, swal: any;
declare function myInput(): any;
declare var AmCharts, PerfectScrollbar: any;
@Component({
  selector: 'app-dashboard-instructor',
  templateUrl: './dashboard-instructor.component.html',
  styleUrls: ['./dashboard-instructor.component.css']
})
export class DashboardInstructorComponent implements OnInit {

  AnnouncementTypeList;
  LearnerActivities;

  /*27/3/2019 */
  totalCourses;
  recentActivity;

  /*29/3/2019 */
  instructorCourses;
  courseView;

  totalStudent;
  totalLesson;
  
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute, private DashboardService: DashboardService,) { }

  ngOnInit() {

    this.totalCourses = [];
    this.recentActivity = [];
    this.instructorCourses = [];
    this.courseView = [];
    this.totalStudent = [];
    this.totalLesson = [];


    /*################ GET INSTRUCTOR DASHBOARD START ##############*/
		this.DashboardService.getInstructorDashboard(this.globals.authData.UserId)
		.then((data) => {

      if (data['totalcourse']) {
        this.totalCourses = data['totalcourse'];
      }
      if (data['recentactivity']) {
        this.recentActivity = data['recentactivity'];
      }
      if (data['instructorcourses']) {
        this.instructorCourses = data['instructorcourses'];
      }
      if (data['courseview']) {
        this.courseView = data['courseview'];
      }
      if (data['student']) {
        this.totalStudent = data['student'];
      }
      if (data['lessons']) {
      this.totalLesson = data['lessons'];
      }
		},
		(error) => {
			this.globals.isLoading = false;
			this.router.navigate(['/pagenotfound']);
		});
    /*################ GET INSTRUCTO DASHBOARD END ##############*/

 

    
    
    this.DashboardService.getLearnerActivities(this.globals.authData.UserId)
			.then((data) => {
				this.LearnerActivities = data;
			},
			(error) => {
				this.globals.isLoading = false;
				this.router.navigate(['/pagenotfound']);
			});
    setTimeout(function () {
      $('#Select').on('change', function (e) {
        $('.tab-pane').hide();
        $('.tab-pane').eq($(this).val()).show();
      });
    }, 100);

      this.DashboardService.getCalendarDetails(this.globals.authData.UserId)
			.then((data) => 
			{ 
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
    (error) => 
    {
      this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
    });
  

      var chart = AmCharts.makeChart("instructorgraph", {
        "type": "serial",
        "theme": "none",
        "dataProvider": [{
          "month": "Jan",
          "earn": 52
        }, {
          "month": "Feb",
          "earn": 11
        }, {
          "month": "Mar",
          "earn": 24
        }, {
          "month": "Apr",
          "earn": 2
        }, {
          "month": "May",
          "earn": 18
        }, {
          "month": "Jun",
          "earn": 32
        }, {
          "month": "Jul",
          "earn": 45
        }, {
          "month": "Aug",
          "earn": 28
        }, {
          "month": "Sep",
          "earn": 14
        }, {
          "month": "Oct",
          "earn": 3
        }, {
          "month": "Nov",
          "earn": 38
        },
        {
          "month": "Dec",
          "earn": 54
        }],
        "valueAxes": [{
          "axisAlpha": 1,
          "position": "left",
          "gridAlpha": 0,
          "labelsEnabled": true,
          "title": "Total Earnings",
          "unit": "$",
          "unitPosition": "left"
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
          "balloonText": "[[category]]: <b>$[[value]]</b>",
          "fillAlphas": 0.8,
          "lineAlpha": 0.2,
          "type": "column",
          "valueField": "earn",
          "lineColor": "var(--theme-color)"
        }],
        "chartCursor": {
          "categoryBalloonEnabled": false,
          "cursorAlpha": 0,
          "zoomable": false
        },
        "categoryField": "month",
        "categoryAxis": {
          "gridPosition": "start",
          "gridAlpha": 0,
          "axisAlpha": 1,
          "position": "bottom",
          "title": "Months"
        }
      });

      var chart = AmCharts.makeChart("instructorgraph1", {
        "type": "serial",
        "theme": "none",
        "dataProvider": [{
          "month": "Jan",
          "earn": 52
        }, {
          "month": "Feb",
          "earn": 11
        }, {
          "month": "Mar",
          "earn": 24
        }, {
          "month": "Apr",
          "earn": 2
        }, {
          "month": "May",
          "earn": 18
        }, {
          "month": "Jun",
          "earn": 32
        }, {
          "month": "Jul",
          "earn": 45
        }, {
          "month": "Aug",
          "earn": 28
        }, {
          "month": "Sep",
          "earn": 14
        }, {
          "month": "Oct",
          "earn": 3
        }, {
          "month": "Nov",
          "earn": 38
        },
        {
          "month": "Dec",
          "earn": 54
        }],
        "valueAxes": [{
          "axisAlpha": 1,
          "position": "left",
          "gridAlpha": 0,
          "labelsEnabled": true,
          "title": "Total Earnings",
          "unit": "$",
          "unitPosition": "left"
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
          "balloonText": "[[category]]: <b>$[[value]]</b>",
          "fillAlphas": 0.8,
          "lineAlpha": 0.2,
          "type": "column",
          "valueField": "earn",
          "lineColor": "var(--theme-color)"
        }],
        "chartCursor": {
          "categoryBalloonEnabled": false,
          "cursorAlpha": 0,
          "zoomable": false
        },
        "categoryField": "month",
        "categoryAxis": {
          "gridPosition": "start",
          "gridAlpha": 0,
          "axisAlpha": 1,
          "position": "bottom",
          "title": "Months"
        }
      });

      var chart = AmCharts.makeChart("instructorgraph2", {
        "type": "serial",
        "theme": "none",
        "dataProvider": [{
          "month": "Jan",
          "earn": 52
        }, {
          "month": "Feb",
          "earn": 11
        }, {
          "month": "Mar",
          "earn": 24
        }, {
          "month": "Apr",
          "earn": 2
        }, {
          "month": "May",
          "earn": 18
        }, {
          "month": "Jun",
          "earn": 32
        }, {
          "month": "Jul",
          "earn": 45
        }, {
          "month": "Aug",
          "earn": 28
        }, {
          "month": "Sep",
          "earn": 14
        }, {
          "month": "Oct",
          "earn": 3
        }, {
          "month": "Nov",
          "earn": 38
        },
        {
          "month": "Dec",
          "earn": 54
        }],
        "valueAxes": [{
          "axisAlpha": 1,
          "position": "left",
          "gridAlpha": 0,
          "labelsEnabled": true,
          "title": "Total Earnings",
          "unit": "$",
          "unitPosition": "left"
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
          "balloonText": "[[category]]: <b>$[[value]]</b>",
          "fillAlphas": 0.8,
          "lineAlpha": 0.2,
          "type": "column",
          "valueField": "earn",
          "lineColor": "var(--theme-color)"
        }],
        "chartCursor": {
          "categoryBalloonEnabled": false,
          "cursorAlpha": 0,
          "zoomable": false
        },
        "categoryField": "month",
        "categoryAxis": {
          "gridPosition": "start",
          "gridAlpha": 0,
          "axisAlpha": 1,
          "position": "bottom",
          "title": "Months"
        }
      });

      var chart = AmCharts.makeChart("instructorgraph3", {
        "type": "serial",
        "theme": "none",
        "dataProvider": [{
          "month": "Jan",
          "earn": 52
        }, {
          "month": "Feb",
          "earn": 11
        }, {
          "month": "Mar",
          "earn": 24
        }, {
          "month": "Apr",
          "earn": 2
        }, {
          "month": "May",
          "earn": 18
        }, {
          "month": "Jun",
          "earn": 32
        }, {
          "month": "Jul",
          "earn": 45
        }, {
          "month": "Aug",
          "earn": 28
        }, {
          "month": "Sep",
          "earn": 14
        }, {
          "month": "Oct",
          "earn": 3
        }, {
          "month": "Nov",
          "earn": 38
        },
        {
          "month": "Dec",
          "earn": 54
        }],
        "valueAxes": [{
          "axisAlpha": 1,
          "position": "left",
          "gridAlpha": 0,
          "labelsEnabled": true,
          "title": "Total Earnings",
          "unit": "$",
          "unitPosition": "left"
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
          "balloonText": "[[category]]: <b>$[[value]]</b>",
          "fillAlphas": 0.8,
          "lineAlpha": 0.2,
          "type": "column",
          "valueField": "earn",
          "lineColor": "var(--theme-color)"
        }],
        "chartCursor": {
          "categoryBalloonEnabled": false,
          "cursorAlpha": 0,
          "zoomable": false
        },
        "categoryField": "month",
        "categoryAxis": {
          "gridPosition": "start",
          "gridAlpha": 0,
          "axisAlpha": 1,
          "position": "bottom",
          "title": "Months"
        }
      });

  

    // PERFECT SCROLLBAR
    new PerfectScrollbar('.scroll_score');
    //new PerfectScrollbar('.scroll_calender');
    // END PERFECT SCROLLBAR

  }

}
