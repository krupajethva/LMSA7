import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { UserinstructorService } from '../services/userinstructor.service';
import { UserService } from '../services/user.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-userinstructorlist',
  templateUrl: './userinstructorlist.component.html',
  styleUrls: ['./userinstructorlist.component.css']
})
export class UserinstructorlistComponent implements OnInit {

  userList;
  msgflag;
	message;
	type;
  deleteEntity;
  ReInviteEntity;
  CertificateEntity;
  constructor( public globals: Globals, private router: Router,private UserService: UserService, private UserinstructorService: UserinstructorService,private route:ActivatedRoute) { }
 
  ngOnInit() {
	
		  $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
  $('.buttons-print').attr('data-original-title', 'Print').tooltip();
  setTimeout(function () {
    $('.modal').on('shown.bs.modal', function () {
      $('.right_content_block').addClass('style_position');
    })
    $('.modal').on('hidden.bs.modal', function () {
      $('.right_content_block').removeClass('style_position');
      
    if ($(".bg_white_block").height() < $(window).height() - 100) {
      $('footer').addClass('footer_fixed');
    }
    else {
      $('footer').removeClass('footer_fixed');
    }
      myInput();
    });
    },
    500);
    
    this.globals.isLoading = true;	
    this.UserinstructorService.getAllUser()
    .then((data) => 
    { 
      this.userList = data;	
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
                 "sLengthMenu": "_MENU_ Instructors per page",
                 "sInfo": "Showing _START_ to _END_ of _TOTAL_ Instructors",
                 "sInfoFiltered": "(filtered from _MAX_ total Instructors)",
                 "sInfoEmpty": "Showing 0 to 0 of 0 Instructors"
               },
               dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Instructor List – ' + todaysdate,
                filename: 'LearningManagementSystem–InstructorList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-InstructorList');
                },
                exportOptions: {
                columns: [0, 1, 2, 3, 4]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Instructor List – ' + todaysdate,
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
  { 
    if(this.userList[i].IsActive==1){
      this.userList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.userList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
   this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;
    
    this.UserinstructorService.isActiveChange(changeEntity)
    .then((data) => 
    {	      
      this.globals.isLoading = false;	
        swal({
         
          type: 'success',
          title: 'Updated!',
          text: 'Instructor has been updated successfully!',
          showConfirmButton: false,
          timer: 3000
        })
      
    }, 
    (error) => 
    {
     this.globals.isLoading = false;
    });		
  }


  revokeUser(user)
  { 
    this.deleteEntity =  user;
    swal({
      title: 'Revoke an Instructor',
      text: "Are you sure you want to revoke this instructor?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
    .then((result) => {
      if (result.value) {
    var del={'Userid':this.globals,'UserId':user.UserId};
    this.globals.isLoading = true;
    this.UserService.deleteInvitation(del)
    .then((data) => 
    {
      let index = this.userList.indexOf(user);
      swal({
       
        type: 'success',
        title: 'Revoked!',
				text: 'Instructor has been revoked successfully',
        showConfirmButton: false,
        timer: 3000
      })
      this.UserinstructorService.getAllUser()
      .then((data) => 
      { 
        this.userList = data;	
      },
      (error) => {
        this.globals.isLoading = false;
      });
      this.globals.isLoading = false;
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

  // display certificate particular instructor
  viewCertificate(userId)
  {    
    this.globals.isLoading = true;
    this.UserinstructorService.getCertificateById(userId)
      .then((data) => 
      { 
        this.CertificateEntity = data;	
        this.globals.isLoading = false;
        if(this.CertificateEntity.length > 0)
        {
          $('#certificatedisplay').modal('show'); 
        }
        else{
          swal({
         
            type: 'error',
            title:'Oops...',
            text: "You have no any certificate uploaded",
            showConfirmButton: false,
            timer: 3000
          })
        }
      },
      (error) => {
        this.globals.isLoading = false;
      });
  }
  //close certificate modal
  close()
  {
    $('#certificatedisplay').modal('hide'); 
  }

  reinviteUser(user)
  { debugger
    this.ReInviteEntity =  user;
    swal({
      title: 'Re-Invite an Instructor',
      text: "Are you sure you want to re-invite this instructor?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
    .then((result) => {
      if (result.value) {
        this.globals.isLoading = true;
       this.UserService.ReInvite(user)
    .then((data) => 
    {
			let index = this.userList.indexOf(user);	
			this.userList[index].IsStatus =0;
    this.globals.isLoading = false;
			$('#ReInvite_Modal').modal('hide');
			swal({
	
        type: 'success',
        title: 'Re-Invited!',
				text: 'Instructor has been re-invited successfully',
				showConfirmButton: false,
				timer: 3000
      })
      this.globals.isLoading = false;
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

  deleteUser(user)
  { 
    this.deleteEntity =  user;
    swal({
      title: 'Delete an Instructor',
      text: "Are you sure you want to delete this instructor?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
    .then((result) => {
      if (result.value) {
    var del = { 'Userid': this.globals, 'UserId': user.UserId,'AddressesId': user.AddressesId};
    this.UserinstructorService.deleteUser(del)
    .then((data) => 
    {
      let index = this.userList.indexOf(user);
      $('#Delete_Modal').modal('hide');
      if (index != -1) {
        this.userList.splice(index, 1);
      }	
      swal({
       
        type: 'success',
        title: 'Deleted!',
				text: 'Instructor has been deleted successfully',
        showConfirmButton: false,
        timer: 1500
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
          timer: 1500
        })
      }	
    });	
  }
  })
            
  }

}

