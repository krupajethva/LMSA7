import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { StateService } from '../services/state.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;



@Component({
  selector: 'app-statelist',
  templateUrl: './statelist.component.html',
  styleUrls: ['./statelist.component.css']
})
export class StatelistComponent implements OnInit {
  stateList;
	deleteEntity;
	msgflag;
	message;
	type;
  constructor( public globals: Globals, private router: Router, private StateService: StateService,private route:ActivatedRoute) { }

ngOnInit() 
{
  $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
  $('.buttons-print').attr('data-original-title', 'Print').tooltip();
  
this.globals.isLoading = true;

  this.StateService.getAllState()
  .then((data) => 
  { debugger
    this.stateList = data;	
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
               "sLengthMenu": "_MENU_ States per page",
               "sInfo": "Showing _START_ to _END_ of _TOTAL_ States",
               "sInfoFiltered": "(filtered from _MAX_ total States)",
               "sInfoEmpty": "Showing 0 to 0 of 0 States"
             },
             dom: 'lBfrtip',
						 buttons: [
							 {
								 extend: 'excel',
                 title: 'Learning Management System – State List – ' + todaysdate,
                 filename: 'LearningManagementSystem–StateList–' + todaysdate,
                 customize: function (xlsx) {
                   var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                   source.setAttribute('name', 'LMS-StateList');
                 },
								 exportOptions: {
									 columns: [0, 1, 2, 3]
								 }
							 },
							 {
								 extend: 'print',
								 title: 'Learning Management System – State List – ' + todaysdate,
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
                       title: 'States List',
                       exportOptions: {
                         columns: [ 0, 1, 2, 3 ]
                         }
                       },
                       {
                       extend: 'print',
                       title: 'States List',
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
   if( $(".bg_white_block").hasClass( "ps--active-y" )){  
     $('footer').removeClass('footer_fixed');     
   }      
   else{  
     $('footer').addClass('footer_fixed');    
   }
 },1000);
             
}



isActiveChange(changeEntity, i)
{ debugger
  this.globals.isLoading = true;
  if(this.stateList[i].IsActive==1){
    this.stateList[i].IsActive = 0;
    changeEntity.IsActive = 0;
  } else {
    this.stateList[i].IsActive = 1;
    changeEntity.IsActive = 1;
  }
 this.globals.isLoading = true;
  changeEntity.UpdatedBy = 1;
  
  this.StateService.isActiveChange(changeEntity)
  .then((data) => 
  {	      
    this.globals.isLoading = false;	
      swal({
       
        type: 'success',
        title: 'Updated!',
        text: 'State has been updated successfully!',
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


deleteState(state)
{ debugger
  this.deleteEntity =  state;
  swal({
    title: 'Delete a State',
    text: "Are you sure you want to delete this state?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  })
  .then((result) => {
    if (result.value) {
  var del={'Userid':this.globals.authData.UserId,'id':state.StateId};
  this.StateService.deleteState(del)
  .then((data) => 
  {
    let index = this.stateList.indexOf(state);
    $('#Delete_Modal').modal('hide');
    if (index != -1) {
      this.stateList.splice(index, 1);
    }	
    swal({
     
      type: 'success',
      title: 'Deleted!',
      text: 'State has been deleted successfully',
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
