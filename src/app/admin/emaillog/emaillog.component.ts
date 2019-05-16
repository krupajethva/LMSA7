import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Globals } from '.././globals';
import { ActivatedRoute } from '@angular/router';
import { ActivityService } from '../services/activity.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-emaillog',
  templateUrl: './emaillog.component.html',
  styleUrls: ['./emaillog.component.css']
})
export class EmaillogComponent implements OnInit {
  EmaillogList;
  constructor( private router: Router, private route: ActivatedRoute,
    public globals: Globals,private ActivityService: ActivityService)  {  }

    ngOnInit() 
    {
      $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
      $('.buttons-print').attr('data-original-title', 'Print').tooltip();
      
    this.globals.isLoading = true;
      this.ActivityService.getEmailLog()
      .then((data) => 
      { debugger
        this.EmaillogList = data;	
        this.globals.isLoading = false;
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
                   "sLengthMenu": "_MENU_ Emaillogs per page",
                   "sInfo": "Showing _START_ to _END_ of _TOTAL_ Emaillogs",
                   "sInfoFiltered": "(filtered from _MAX_ total Emaillogs)",
                   "sInfoEmpty": "Showing 0 to 0 of 0 Emaillogs"
                 },
                 dom: 'lBfrtip',
                 buttons: [
                   {
                     extend: 'excel',
                     title: 'Learning Management System – Email Logs – ' + todaysdate,
                filename: 'LearningManagementSystem–EmailLogs–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-EmailLogs');
                },
                     exportOptions: {
                       columns: [0, 1, 2, 3, 4, 5, 6]
                     }
                   },
                   {
                     extend: 'print',
                     title: 'Learning Management System –  Email Logs – ' + todaysdate,
                     exportOptions: {
                       columns: [0, 1, 2, 3, 4, 5, 6]
                     }
                   },
                 ]
               });
               
			 $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
      $('.buttons-print').attr('data-original-title', 'Print').tooltip();
		  
		  
        },100); 
       
        this.globals.isLoading = false;	
      }, 
      (error) => 
      {
        this.globals.isLoading = false;
        this.router.navigate(['/pagenotfound']);
      });
     
    
      setTimeout(function(){
       if( $(".bg_white_block").hasClass( "ps--active-y" )){  
         $('footer').removeClass('footer_fixed');     
       }      
       else{  
         $('footer').addClass('footer_fixed');    
       }
     },1000);
                 
    }
    

}
