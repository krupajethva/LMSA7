import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Globals } from '.././globals';
import { ActivatedRoute } from '@angular/router';
import { ActivityService } from '../services/activity.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-loginlog',
  templateUrl: './loginlog.component.html',
  styleUrls: ['./loginlog.component.css']
})
export class LoginlogComponent implements OnInit {
  LoginlogList;
  constructor( private router: Router, private route: ActivatedRoute,
    public globals: Globals,private ActivityService: ActivityService)  {  }

    ngOnInit() 
    {      
    this.globals.isLoading = true;
      this.ActivityService.getLoginLog()
      .then((data) => 
      { debugger
        this.LoginlogList = data;	
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
                   "sLengthMenu": "_MENU_ Loginlogs per page",
                   "sInfo": "Showing _START_ to _END_ of _TOTAL_ Loginlogs",
                   "sInfoFiltered": "(filtered from _MAX_ total Loginlogs)",
                   "sInfoEmpty": "Showing 0 to 0 of 0 Loginlogs"
                 },
                 dom: 'lBfrtip',
                 buttons: [
                   {
                     extend: 'excel',
                     title: 'Learning Management System – LoginLogs – ' + todaysdate,
                     filename: 'LearningManagementSystem–LoginLogs–' + todaysdate,
                     customize: function (xlsx) {
                       var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                       source.setAttribute('name', 'LMS-LoginLogs');
                     },
                     exportOptions: {
                       columns: [0, 1, 2, 3, 4]
                     }
                   },
                   {
                     extend: 'print',
                     title: 'Learning Management System – LoginLogs – ' + todaysdate,
                     exportOptions: {
                       columns: [0, 1, 2, 3, 4]
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
