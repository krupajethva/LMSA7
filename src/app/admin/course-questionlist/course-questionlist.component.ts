
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
  selector: 'app-course-questionlist',
  templateUrl: './course-questionlist.component.html',
  styleUrls: ['./course-questionlist.component.css']
})
export class CourseQuestionlistComponent implements OnInit {
  questionlist;
  deleteEntity;
  CloneEntity;
  msgflag;
  message;
  type;
  permissionEntity;
  tempEntity;
  CID;
  Coursename;
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private CourseQuestionService: CourseQuestionService) { }

  ngOnInit() {

    


    this.globals.isLoading = true;
    let id = this.route.snapshot.paramMap.get('id');
     this.CID=id;

    this.CourseQuestionService.getAllQuestion(id)
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
              "sLengthMenu": "_MENU_ Questions per Page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Questions",
              "sInfoFiltered": "(filtered from _MAX_ total Questions)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Questions"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Questions List – ' + todaysdate,
                filename: 'LearningManagementSystem–QuestionsList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-QuestionsList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System –  Questions List – ' + todaysdate,
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          });

          var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                extend: 'excel',
                title: 'Questions List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Questions List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));
		  
		  $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();
	
	
        }, 100);
        this.questionlist = data['question'];
        this.Coursename = data['course'];
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
  isActiveChange(changeEntity, i)
{ debugger

  if(this.questionlist[i].IsActive==1){
    this.questionlist[i].IsActive = 0;
    changeEntity.IsActive = 0;
  } else {
    this.questionlist[i].IsActive = 1;
    changeEntity.IsActive = 1;
  }

  changeEntity.UpdatedBy = 1;
  
  this.CourseQuestionService.isActiveChange(changeEntity)
  .then((data) => 
  {	      
    this.globals.isLoading = false;	
      swal({
        type: 'success',
        title: 'Updated!',
        text: 'Updated successfully!',
        showConfirmButton: false,
        timer: 3000
      })
    
  }, 
  (error) => 
  {
    this.globals.isLoading = false;
    this.router.navigate(['/pagenotfound']);
  });		
}

 
  deleteQuestion(question)
    { debugger
      this.deleteEntity =question.QuestionId;
      swal({
        title: 'Delete a question',
        text: "Are you sure you want to delete this question?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
      })
      .then((result) => {
        if (result.value) {
  
      this.CourseQuestionService.delete(question.QuestionId,this.globals.authData.UserId)
      .then((data) => 
      {
        let index = this.questionlist.indexOf(question);
        $('#Delete_Modal').modal('hide');
        if (index != -1) {
          this.questionlist.splice(index, 1);
        }	
        swal({
    
          type: 'success',
          title: 'Deleted!',
          text: 'Question has been deleted successfully',
          showConfirmButton: false,
          timer: 3000
        })
      }, 
      (error) => 
      {
        $('#Delete_Modal').modal('hide');
        if(error.text){
          swal({
           
            type: 'error',
            title:'Oops...',
            text: "You can't delete this record because of their dependency!",
            showConfirmButton: false,
            timer: 3000
          })
        }	
      });	
    }
    })
              
    }
}


