  import { Component, OnInit } from '@angular/core';
  import { Globals } from '.././globals';
  import { Router } from '@angular/router';
  import { ActivatedRoute } from '@angular/router';
  import { InstructorinvitationService } from '../services/instructorinvitation.service';
  declare var $,swal: any;
  declare function myInput() : any;
  declare var $,Bloodhound: any;
  @Component({
    selector: 'app-instructorinvitationlist',
    templateUrl: './instructorinvitationlist.component.html',
    styleUrls: ['./instructorinvitationlist.component.css']
  })
  export class InstructorinvitationlistComponent implements OnInit {
    InstructorList;
    deleteEntity;
    msgflag;
    message;
    type;
    permissionEntity;
    
    constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
      private InstructorinvitationService: InstructorinvitationService) { }
  
    ngOnInit() {
         this.InstructorinvitationService.getAllInstructorInvi()
         .then((data) => 
         { 
          let todaysdate = this.globals.todaysdate;
           setTimeout(function(){
             var table = $('#list_tables').DataTable( {
              // scrollY: '55vh',
           responsive: {
                 details: {
                     display: $.fn.dataTable.Responsive.display.childRowImmediate,
                     type: ''
                 }
             },
                  scrollCollapse: true,           
                    "oLanguage": {
                      "sLengthMenu": "_MENU_ Instructor invitation per page",
                      "sInfo": "Showing _START_ to _END_ of _TOTAL_ Instructor invitation",
                      "sInfoFiltered": "(filtered from _MAX_ total Instructor invitation)",
                      "sInfoEmpty": "Showing 0 to 0 of 0 Instructor invitation"
                    },
                    dom: 'lBfrtip',
                     buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Instructor Invitation List – ' + todaysdate,
                filename: 'LearningManagementSystem–InstructorInvitationList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-InstructorInvitationList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System –  Instructor Invitation List – ' + todaysdate,
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
                              title: 'Instructor Invitation List',
                              exportOptions: {
                                columns: [ 0, 1, 2, 3 ]
                                }
                              },
                              {
                              extend: 'print',
                              title: 'Instructor Invitation List',
                              exportOptions: {
                                columns: [ 0, 1, 2, 3 ]
                                }
                              },
                          ]
                }).container().appendTo($('#buttons'));
				
				 $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
         $('.buttons-print').attr('data-original-title', 'Print').tooltip();
         
		 
		 
           },100); 
           this.InstructorList = data;	
           //this.globals.isLoading = false;	
         }, 
         (error) => 
         {
          // this.globals.isLoading = false;
           this.router.navigate(['/pagenotfound']);
         });
         this.msgflag = false;
  
         setTimeout(function(){
          if( $(".bg_white_block").hasClass( "ps--active-y" )){  
            $('footer').removeClass('footer_fixed');     
          }      
          else{  
            $('footer').addClass('footer_fixed');    
          }
        },1000);
    }
    ReInviteInstructor(Instructor)
	{ debugger
//	this.globals.isLoading = true;
		this.InstructorinvitationService.ReInvite(Instructor)
		.then((data) => 
		{
		//	this.globals.isLoading = false;
			let index = this.InstructorList.indexOf(Instructor);
			
			this.InstructorList[index].IsStatus =0;
			this.InstructorList[index].Code ='';
		
			swal({
		
        type: 'success',
        title: 'success!',
        text: 'Email Sent Successfully',
        showConfirmButton: false,
        timer: 1500
      })
			//this.globals.message = 'Email Sent Successfully';
			this.globals.type = 'success';
			this.globals.msgflag = true;
		}, 
		(error) => 
		{
			//this.globals.isLoading = false;

			if(error.text){
				this.globals.message = "You can't send this Email";
				this.globals.type = 'danger';
				this.globals.msgflag = true;
			}	
		});	
	}
    }
  
  
  