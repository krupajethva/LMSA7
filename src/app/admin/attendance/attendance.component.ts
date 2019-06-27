import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AttendanceService } from '../services/attendance.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-attendance',
  templateUrl: './attendance.component.html',
  styleUrls: ['./attendance.component.css']
})
export class AttendanceComponent implements OnInit {
  AttendanceEntity;
  SearchAttendanceEntity;
	submitted;
  btn_disable;
  SessionId;
  CourseList;
  SessionList;
  AttendanceList;
  listhide;
  DateList;
  checkvalue;
  datecolspan;
  ss;

  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,	
    private AttendanceService: AttendanceService) { }

  ngOnInit() {
    this.AttendanceEntity={};
   this.AttendanceList=[];
   this.DateList=[];
    this.SearchAttendanceEntity={};
    let id = this.route.snapshot.paramMap.get('id');
    this.SessionId=id;
    if (id) {
      this.SessionId=id;
      this.AttendanceService.getById(id)
        .then((data) => {debugger
          this.listhide=true;
          let todaysdate = this.globals.todaysdate;
          setTimeout(function () {
            var table = $('#list_tables').DataTable({
              responsive: {
                details: {
                  display: $.fn.dataTable.Responsive.display.childRowImmediate,
                  type: ''
                }
              },
              scrollCollapse: true,
              "oLanguage": {
                "sLengthMenu": "_MENU_ Learners per page",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ Learners",
                "sInfoFiltered": "(filtered from _MAX_ total Learners)",
                "sInfoEmpty": "Showing 0 to 0 of 0 Learners"
              },
              dom: 'lBfrtip',
              buttons: [
                {
                  extend: 'excel',
                  title: 'Learning Management System – Attendance List – ' + todaysdate,
                      filename: 'LearningManagementSystem–AttendanceList–' + todaysdate,
                      customize: function (xlsx) {
                        var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                        source.setAttribute('name', 'LMS-AttendanceList');
                      },
                  exportOptions: {
                    columns: [0, 1, 2, 3]
                  }
                },
                {
                  extend: 'print',
                  title: 'Learning Management System –  Attendance List – ' + todaysdate,
                  exportOptions: {
                    columns: [0, 1, 2, 3]
                  }
                },
              ]
            });
      
            var buttons = new $.fn.dataTable.Buttons(table, {
      
            }).container().appendTo($('#buttons'));
          
          $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
                $('.buttons-print').attr('data-original-title', 'Print').tooltip();
                myInput();
            
          }, 100);
          // setTimeout(function(){
            
          //    },100);
          this.AttendanceEntity = data['course'];
             this.AttendanceList = data['attendance'];
             this.DateList = data['dates'];
         this.SearchAttendanceEntity= data['courseid'];
         var  count=0;            
         for (var i = 0; i < this.DateList.length; i++)
          {
            count++;
         }
      setTimeout(function () {
        $('#aa').attr('colspan',count);
      }, 100);
     
         //this.SearchAttendanceEntity.CourseId=this.aa;
     //    alert( this.SearchAttendanceEntity.CourseId);
      //   this.SearchAttendanceEntity.CourseSessionId=id;
        
        },
        (error) => {
          //alert('error');
          this.btn_disable = false;
          this.submitted = false;
        
          //this.router.navigate(['/pagenotfound']);
        });
    }
    else {
      this.AttendanceEntity = {};
      myInput();
      this.listhide=false;
    }
    this.AttendanceService.getDefaultData(this.globals.authData.UserId)
			.then((data) => {debugger
	
				this.CourseList = data['course'];
				this.SessionList = data['session'];

			},
				(error) => {
					this.globals.isLoading = false;
				});
  

    setTimeout(function () {
      $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        pickTime: false,
        format: 'mm-dd-yyyy',
      });
    }, 100);

    setTimeout(function () {
      $('.form_time').datetimepicker({
        weekStart: 1,
        todayBtn: 0,
        autoclose: 1,
        startView: 1,
        maxView: 1,
        forceParse: 1,
        format: 'HH:ii p',
        pickDate: false,
        showMeridian: true,
      }).on('hide', function (ev) {
        $(".datetimepicker .prev").attr("style", "visibility:visible");
        $(".datetimepicker .next").attr("style", "visibility:visible");
        $(".switch").attr("style", "pointer-events: auto");
      });
      $(".form_time").click(function () {
        $(".datetimepicker .prev").attr("style", "visibility:hidden");
        $(".datetimepicker .next").attr("style", "visibility:hidden");
        $(".switch").attr("style", "pointer-events: none");
      });
    }, 100);

  }
  addattendance(AttendanceForm)
  {debugger 
    
    this.submitted = true;
    if (AttendanceForm.valid) {
      this.globals.isLoading = true;

   

      this.AttendanceService.add(this.SearchAttendanceEntity.CourseSessionId)
        .then((data) => {

          let todaysdate = this.globals.todaysdate;
          this.listhide=true;
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
        
          setTimeout(function () {
            $('#list_tables').DataTable().destroy();
            var table = $('#list_tables').DataTable({
              responsive: {
                details: {
                  display: $.fn.dataTable.Responsive.display.childRowImmediate,
                  type: ''
                }
              },
              scrollCollapse: true,
              "oLanguage": {
                "sLengthMenu": "_MENU_ Learners per page",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ Learners",
                "sInfoFiltered": "(filtered from _MAX_ total Learners)",
                "sInfoEmpty": "Showing 0 to 0 of 0 Learners"
              },
              dom: 'lBfrtip',
              buttons: [
                {
                  extend: 'excel',
                  title: 'Learning Management System – Attendance List – ' + todaysdate,
                      filename: 'LearningManagementSystem–AttendanceList–' + todaysdate,
                      customize: function (xlsx) {
                        var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                        source.setAttribute('name', 'LMS-AttendanceList');
                      },
                  exportOptions: {
                    columns: [0, 1, 2, 3]
                  }
                },
                {
                  extend: 'print',
                  title: 'Learning Management System –  Attendance List – ' + todaysdate,
                  exportOptions: {
                    columns: [0, 1, 2, 3]
                  }
                },
              ]
            });
      
            var buttons = new $.fn.dataTable.Buttons(table, {
      
            }).container().appendTo($('#buttons'));
          
          $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
                $('.buttons-print').attr('data-original-title', 'Print').tooltip();
                myInput();
            
          }, 100);
          // setTimeout(function(){
            
          //    },100);
          this.AttendanceEntity = data['course'];
             this.AttendanceList = data['attendance'];
             this.DateList = data['dates'];
            var  count=0;            
              for (var i = 0; i < this.DateList.length; i++)
               {
                 count++;
              }
           this.datecolspan=count;
           $('#aa').attr('colspan',this.datecolspan);
          
        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
     }

  }
	getSessionList(AttendanceForm) {
		debugger
		myInput();
		AttendanceForm.form.controls.CourseSessionId.markAsDirty();
		this.SearchAttendanceEntity.CourseSessionId = '';
		if (this.SearchAttendanceEntity.CourseId > 0) {
			this.AttendanceService.getStateList(this.SearchAttendanceEntity.CourseId)
				.then((data) => {
					this.SessionList = data;
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});
		} else {
			this.SessionList = [];
		}
  }
  AttendanceCheck(CourseUserregisterId,Check,i,j,Totalattendance)
  {//debugger
    //alert(Check.target.defaultValue)
    
    if(Check.target.defaultValue=="1")
    {
      this.checkvalue="0";
      this.AttendanceList[i].Totalattendance = Number(Totalattendance) - 1;
     //this.AttendanceList[i].Child[j]= "0";
    }else
    {
      this.checkvalue="1";
     this.AttendanceList[i].Totalattendance = Number(Totalattendance) + 1;
     //this.AttendanceList[i].Child[j]= "1";
    }
    var data = { 'CourseUserregisterId': CourseUserregisterId, 'Check':this.checkvalue,'j':j,'UserId':this.globals.authData.UserId };
			this.AttendanceService.UpdateAttendance(data)
				.then((data) => {
          
          $('#Check'+i+j).val(this.checkvalue);
          // let new_array = this.AttendanceList;
          // new_array[i].child = data;
          // this.AttendanceList = new_array;
    // this.AttendanceList[i].Child=data;
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});
	
  }
  clearForm(AttendanceForm) {
   

    this.SearchAttendanceEntity = {};
    AttendanceForm.form.markAsPristine();
   // this.btn_disable = false;
		this.submitted = false;


	}
}
