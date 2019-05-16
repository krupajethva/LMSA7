import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { ActivityService } from '../services/activity.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;

@Component({
  selector: 'app-activity-list',
  templateUrl: './activity-list.component.html',
  styleUrls: ['./activity-list.component.css']
})
export class ActivityListComponent implements OnInit {
  UserActivity;
  msgflag;
  message;
  type;
  constructor(public globals: Globals, private router: Router, private ActivityService: ActivityService, private route: ActivatedRoute) { }

  ngOnInit() {

    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
    }, 2000);
    
    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();

    this.globals.isLoading = true;

    let id = this.globals.authData.UserId;

    this.ActivityService.getActivityByUser(id)
      .then((data) => {
        debugger

        let todaysdate = this.globals.todaysdate;
        setTimeout(function () {
          var table = $('#list_tables').DataTable({
            // scrollY: '55vh',
            responsive: {
              details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: ''
              }
            },
            scrollCollapse: true,
            "oLanguage": {
              "sLengthMenu": "_MENU_ Activities per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Activities",
              "sInfoFiltered": "(filtered from _MAX_ total Activity)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Activities"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Activity List – ' + todaysdate,
                filename: 'LearningManagementSystem–ActivityList–' + todaysdate,
                customize: function (xlsx) {
									var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
									source.setAttribute('name', 'LMS-ActivityList');
								},
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Activity List – ' + todaysdate,
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          });
		  
		     $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
              $('.buttons-print').attr('data-original-title', 'Print').tooltip();
			  
        }, 100);
        this.UserActivity = data;
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });
    this.msgflag = false;

  }


}
