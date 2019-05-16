import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { InviteInstructorService } from '../services/invite-instructor.service';
declare var $,swal: any;
declare function myInput() : any;
declare var Bloodhound: any;

@Component({
  selector: 'app-invite-instructor',
  templateUrl: './invite-instructor.component.html',
  styleUrls: ['./invite-instructor.component.css']
})
export class InviteInstructorComponent implements OnInit {
  inviteUserEntity;
	roleList;
	departmentList;
	companyList;
 	submitted;
	btn_disable;
	header;
	companyhide;
	ComL;
	isDisabled;
	submitted1;
	IndustryList;
  parentCompanyList;
  CountryList;
  StateList;
  constructor( public globals: Globals, private router: Router, private InviteInstructorService: InviteInstructorService,private route:ActivatedRoute) { }

  ngOnInit() {

    //multi selector
    setTimeout(function(){
    $('#example-enableFiltering').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true
    });
    },100);

    //multi selector

      this.inviteUserEntity = {};
      this.inviteUserEntity.IsActive =1;
        
      setTimeout(function(){
        myInput();
        },100);

}


inviteUser(inviteForm) 
{ 
  myInput();
    
      this.inviteUserEntity.CreatedBy = this.globals.authData.UserId;
      this.inviteUserEntity.UpdatedBy = this.globals.authData.UserId;
      this.submitted = true;
    
    if (inviteForm.valid) {
      this.submitted = false;
      this.globals.isLoading = true;
      this.InviteInstructorService.add(this.inviteUserEntity)
        .then((data) => {
          if(data=='Fail'){
            swal({
              type: 'warning',
              title: 'Oops...',
              text: 'Email address already Registered!',
              })
            this.globals.isLoading = false;
            this.btn_disable = false;
            this.submitted = false;
          } else {
          this.btn_disable = false;
          this.submitted = false;
          this.inviteUserEntity = {};
          inviteForm.form.markAsPristine();	
          swal({
            type: 'success',
            title:'Success!',
            text: 'Instructor Invited Successfully!',
            showConfirmButton: false,
           timer: 3000
          })
          this.globals.isLoading = false;
          }
        },
        (error) => {
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
          this.inviteUserEntity = {};
          inviteForm.form.markAsPristine();
        });
    }
  }
  clearForm(inviteForm) {debugger
    this.inviteUserEntity = {};
    inviteForm.form.markAsPristine();
    this.submitted = false;
    this.inviteUserEntity.IsActive = '1';
  }

}
