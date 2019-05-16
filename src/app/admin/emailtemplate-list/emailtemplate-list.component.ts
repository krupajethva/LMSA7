import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { forEach } from '@angular/router/src/utils/collection';
import { EmailtemplateService } from '../services/emailtemplate.service';
declare var $,unescape: any,swal: any;

import {HttpClient} from "@angular/common/http";


@Component({
  selector: 'app-emailtemplate-list',
  templateUrl: './emailtemplate-list.component.html'

})
export class EmailtemplateListComponent implements OnInit {
	
  EmailList;
	deleteEntity;
	msgflag;
	message;
	type;

	//globals;

 constructor( private http: HttpClient,public globals: Globals, private router: Router, 
	private EmailtemplateService: EmailtemplateService, private route:ActivatedRoute) { }
	ngOnInit() 
	{
	  $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
	  $('.buttons-print').attr('data-original-title', 'Print').tooltip();
	  
	this.globals.isLoading = true;
	
	  this.EmailtemplateService.getAll()
	  .then((data) => 
	  { debugger
		this.EmailList = data;	
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
				   "sLengthMenu": "_MENU_ Email Templates per page",
				   "sInfo": "Showing _START_ to _END_ of _TOTAL_ Email Templates",
				   "sInfoFiltered": "(filtered from _MAX_ total Email Templates)",
				   "sInfoEmpty": "Showing 0 to 0 of 0 Email Templates"
				 },
				 dom: 'lBfrtip',
				 buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Email Templates – ' + todaysdate,
                filename: 'LearningManagementSystem–EmailTemplates–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-EmailTemplates');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
								title: 'Learning Management System –  Email Templates – ' + todaysdate,
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
						   title: 'Email Templates List',
						   exportOptions: {
							 columns: [ 0, 1, 2, 3 ]
							 }
						   },
						   {
						   extend: 'print',
						   title: 'Email Templates List',
						   exportOptions: {
							 columns: [ 0, 1, 2, 3 ]
							 }
						   },
					   ]
			 }).container().appendTo($('#buttons'));
			 
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
	  this.msgflag = false;
	
	  setTimeout(function(){
	  //  if( $(".bg_white_block").hasClass( "ps--active-y" )){  
		//  $('footer').removeClass('footer_fixed');     
	  //  }      
	  //  else{  
		//  $('footer').addClass('footer_fixed');    
	  //  }
	 },1000);
				 
	}


	isActiveChange(changeEntity, i)
{ debugger
  this.globals.isLoading = true;
  if(this.EmailList[i].IsActive==1){
    this.EmailList[i].IsActive = 0;
    changeEntity.IsActive = 0;
  } else {
    this.EmailList[i].IsActive = 1;
    changeEntity.IsActive = 1;
  }
 this.globals.isLoading = true;
  changeEntity.UpdatedBy = 1;
  
  this.EmailtemplateService.isActiveChange(changeEntity)
  .then((data) => 
  {	      
    this.globals.isLoading = false;	
      swal({
       
        type: 'success',
				title: 'Updated!',
				text: "Email Template  has been updated successfully.",
        showConfirmButton: false,
        timer: 1500
      })
    
  }, 
  (error) => 
  {
    this.globals.isLoading = false;
    this.router.navigate(['/pagenotfound']);
  });		
}




	deleteEmail(Email)
	{ debugger
		this.deleteEntity =  Email;
		swal({
			title: 'Delete a Email Template',
			text: "Are you sure you want to delete this email template?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#60B8D1',
			cancelButtonColor: '#102749',
			confirmButtonText: 'Yes'
		})
		.then((result) => {
			if (result.value) {
		var del={'Userid':this.globals.authData.UserId,'id':Email.EmailId};
		this.EmailtemplateService.delete(del)
		.then((data) => 
		{
			let index = this.EmailList.indexOf(Email);
			$('#Delete_Modal').modal('hide');
			if (index != -1) {
			this.EmailList.splice(index, 1);
			}	
			swal({

			type: 'success',
			title: 'deleted!',
			text: "Email Template has been deleted successfully.",
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
				text: "You can't delete this record because of their dependency.",
				showConfirmButton: false,
				timer: 3000
			})
			}	
		});	
		}
		})
				
	}


}

