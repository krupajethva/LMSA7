import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { InviteLearnerService } from '../services/invite-learner.service';
declare var $,swal: any;
declare function myInput() : any;
declare var Bloodhound: any;


@Component({
  selector: 'app-invite-learner',
  templateUrl: './invite-learner.component.html',
  styleUrls: ['./invite-learner.component.css']
})
export class InviteLearnerComponent implements OnInit {
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
  constructor( public globals: Globals, private router: Router, private InviteLearnerService: InviteLearnerService,private route:ActivatedRoute) { }

  ngOnInit() {
   
      this.inviteUserEntity = {};
      this.InviteLearnerService.getAllDefaultData()
      .then((data) => {
          this.IndustryList = data['industry'];
          this.roleList = data['role'];
          this.companyList = data['company'];
          this.departmentList = data['department'];
          this.parentCompanyList=data['parentcomp']; 
         
      },
      (error) => {
        this.btn_disable = false;
        this.submitted = false;  
      });

  let id = this.route.snapshot.paramMap.get('id');
  if (id) {
    
  }
  else
  {
      this.inviteUserEntity = {};
      this.inviteUserEntity.UserId = 0;
     this.inviteUserEntity.IsActive = '1';
     this.inviteUserEntity.RoleId ='';
     this.inviteUserEntity.DepartmentId ='';
     this.inviteUserEntity.CompanyId ='';
     this.inviteUserEntity.IndustryId ='';
     this.inviteUserEntity.InvitedByUserId ='';
     setTimeout(function(){
       myInput();
       },100);
  }



  }


  inviteUser(inviteForm) 
  { 
    myInput();
   
      let id = this.route.snapshot.paramMap.get('id');
      if (id) {
        this.inviteUserEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.inviteUserEntity.CreatedBy = this.globals.authData.UserId;
        this.inviteUserEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = true;
      }
			this.submitted = true;
			if (inviteForm.valid) {
				this.submitted = false;
				if(this.companyhide==true){
					this.inviteUserEntity.CompanyId = 0;
				} 
        this.globals.isLoading = true;
				this.InviteLearnerService.add(this.inviteUserEntity)
					.then((data) => {

						if(data=='Fail'){
              swal({
                type: 'warning',
                title: 'Oops...',
                text: 'Email address already Registered!!',
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
							text: 'Learner Invited Successfully!',
							showConfirmButton: false,
							timer: 3000
            })
            this.globals.isLoading = false;
						this.router.navigate(['/invited-learner-list']);
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


		com()
    {
      this.companyhide=true;
      this.submitted1 = false;
      this.btn_disable = false;
      this.isDisabled=true;
      setTimeout(function(){
        myInput();
        },100);
    }

    del(){
      this.companyhide=false;
      setTimeout(function(){
        myInput();
        },100);
    }
  

}
