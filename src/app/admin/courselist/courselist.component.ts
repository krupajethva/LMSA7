
import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

import { CourseService } from '../services/course.service';
import { CourseQuestionService } from '../services/course-question.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
@Component({
  selector: 'app-courselist',
  templateUrl: './courselist.component.html',
  styleUrls: ['./courselist.component.css']
})
export class CourselistComponent implements OnInit {
  courseList;
  deleteEntity;
  CloneEntity;
  msgflag;
  message;
  type;
  permissionEntity;
  tempEntity;

  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private CourseQuestionService: CourseQuestionService) { }

  ngOnInit() {

    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();


    this.globals.isLoading = true;
    this.CourseQuestionService.getAllCourse(this.globals.authData.UserId)
      .then((data) => {
        debugger 
        this.globals.isLoading = false;
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
              "sLengthMenu": "_MENU_ Courses per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Courses",
              "sInfoFiltered": "(filtered from _MAX_ total Courses)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Courses"
            },
            dom: 'lBfrtip',
             buttons: [
                 {
                   extend: 'excel',
                   title: 'Learning Management System – Courses List – ' + todaysdate,
                filename: 'LearningManagementSystem–CoursesList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-CoursesList');
                },
                   exportOptions: {
                     columns: [0, 1, 2, 3, 4]
                   }
                 },
                 {
                   extend: 'print',
                   title: 'Learning Management System –  Courses List – ' + todaysdate,
                   exportOptions: {
                     columns: [0, 1, 2, 3, 4]
                   }
                 },
               ]
          });

          var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                extend: 'excel',
                title: 'Courses List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Courses List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));
		  
		   $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
              $('.buttons-print').attr('data-original-title', 'Print').tooltip();
			  
			  
        }, 100);
        this.courseList = data;
        //this.globals.isLoading = false;	
      },
        (error) => {
          // this.globals.isLoading = false;
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
      $(".courses").addClass("active");
      $(".courses > div").addClass("in");
      $(".courses > a").removeClass("collapsed");
      $(".courses > a").attr("aria-expanded", "true");
    }, 300);

  }

 
 
}


