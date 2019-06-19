import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CompanyService } from '../services/company.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-company-list',
  templateUrl: './company-list.component.html',
  styleUrls: ['./company-list.component.css']
})
export class CompanyListComponent implements OnInit {

  CompanyList;
	deleteEntity;
	msgflag;
	message;
	type;
	permissionEntity;
  constructor( public globals: Globals, private router: Router, private CompanyService: CompanyService,private route:ActivatedRoute) { }

  ngOnInit() 
{
  $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
  $('.buttons-print').attr('data-original-title', 'Print').tooltip();
  
this.globals.isLoading = true;

  this.CompanyService.getAllCompany()
  .then((data) => 
  { debugger
    this.CompanyList = data;	
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
               "sLengthMenu": "_MENU_ Companies per page",
               "sInfo": "Showing _START_ to _END_ of _TOTAL_ Companies",
               "sInfoFiltered": "(filtered from _MAX_ total Companies)",
               "sInfoEmpty": "Showing 0 to 0 of 0 Companies"
             },
             dom: 'lBfrtip',
              buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Company List – ' + todaysdate,
                filename: 'LearningManagementSystem–CompanyList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-CompanyList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3, 4]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Company List – ' + todaysdate,
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
  if(this.CompanyList[i].IsActive==1){
    this.CompanyList[i].IsActive = 0;
    changeEntity.IsActive = 0;
  } else {
    this.CompanyList[i].IsActive = 1;
    changeEntity.IsActive = 1;
  }
 this.globals.isLoading = true;
  changeEntity.UpdatedBy = 1;
  
  this.CompanyService.isActiveChange(changeEntity)
  .then((data) => 
  {	      
    this.globals.isLoading = false;	
      swal({
       
        type: 'success',
        title: 'Updated!',
        text: 'Company has been Updated Successfully!',
        showConfirmButton: false,
        timer: 3000
      })
  }, 
  (error) => 
  {
    this.globals.isLoading = false;
  });		
}



deleteCompany(Company)
{ debugger
  this.deleteEntity =  Company;
  swal({
    title: 'Delete a Company',
    text: "Are you sure you want to delete this company?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  })
  .then((result) => {
    if (result.value) {
  var del={'Userid':this.globals.authData.UserId,'CompanyId':Company.CompanyId,'AddressesId':Company.AddressesId};
  this.CompanyService.delete(del)
  .then((data) => 
  {
    let index = this.CompanyList.indexOf(Company);
    $('#Delete_Modal').modal('hide');
    if (index != -1) {
      this.CompanyList.splice(index, 1);
    }	
    swal({
     
      type: 'success',
      title: 'Deleted!',
      text: 'Company has been deleted successfully',
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
