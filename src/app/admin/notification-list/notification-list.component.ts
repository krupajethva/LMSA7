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
  selector: 'app-notification-list',
  templateUrl: './notification-list.component.html',
  styleUrls: ['./notification-list.component.css']
})
export class NotificationListComponent implements OnInit {
  NotificationList;
  msgflag;
  message;
  type;
  constructor( public globals: Globals, private router: Router, private ActivityService: ActivityService, private route: ActivatedRoute) { }

  ngOnInit() {
    debugger
    
    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();

    let id = this.globals.authData.UserId;

    this.ActivityService.getNotificationByUser(id)
      .then((data) => {
        debugger
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
              "sLengthMenu": "_MENU_ Notifications per Page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Notifications",
              "sInfoFiltered": "(filtered from _MAX_ total Notifications)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Notifications"
            },
            dom: 'lBfrtip',
            buttons: [

            ]
          });
          var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                extend: 'excel',
                title: 'Notification List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Notification List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));
        }, 100);
        this.NotificationList = data;
      },
        (error) => {
          this.router.navigate(['/pagenotfound']);
        });
    this.msgflag = false;

    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
    }, 1000);
  }
}
