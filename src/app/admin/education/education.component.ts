import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { EducationService } from '../services/education.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;


@Component({
  selector: 'app-education',
  templateUrl: './education.component.html',
  styleUrls: ['./education.component.css']
})
export class EducationComponent implements OnInit {
  EducationEntity;
	submitted;
	btn_disable;
  header;
  buttonName;
  constructor( public globals: Globals, private router: Router, private EducationService: EducationService,private route:ActivatedRoute) { }

  ngOnInit() 
  {
    let id = this.route.snapshot.paramMap.get('id');
     if(id)
     {	
      this.header = 'Edit';
      this.buttonName='Update';
      this.EducationService.getById(id)
        .then((data) => 
        {
          this.EducationEntity=data;
          if(data['IsActive']==0){
            this.EducationEntity.IsActive = 0;
          } else {
            this.EducationEntity.IsActive = '1';
          }
          setTimeout(function(){
            myInput();
             },100);
        }, 
        (error) => 
        {
          //alert('error');
          this.btn_disable = false;
          this.submitted = false;
        
        //	this.router.navigate(['/pagenotfound']);
        });
      
     }
     else
     {
      this.header = 'Add';
      this.buttonName='Add';
         this.EducationEntity = {};
         this.EducationEntity.EducationLevelId = 0;
        this.EducationEntity.IsActive = '1';
        setTimeout(function(){
          myInput();
           },100);
     }
  }


addEducation(EducationForm) 
{		 myInput();
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
    this.EducationEntity.UpdatedBy = this.globals.authData.UserId;
    this.submitted = false;
  } else {
    this.EducationEntity.CreatedBy = this.globals.authData.UserId;
    this.EducationEntity.UpdatedBy = this.globals.authData.UserId;
    this.EducationEntity.CompanyId = 0;
    this.submitted = true;
  }
    if(id){
      this.submitted = false;
    } else {
      this.EducationEntity.EducationLevelId = 0;
      this.submitted = true;
    }
    if(EducationForm.valid){
      this.btn_disable = true;
      this.EducationService.add(this.EducationEntity)
      .then((data) => 
      {
        this.btn_disable = false;
        this.submitted = false;
        this.EducationEntity = {};
        EducationForm.form.markAsPristine();
        if (id) {
        
        swal({
         
          type: 'success',
          title: 'Updated!',
          text: 'Education has been updated successfully',
          showConfirmButton: false,
          timer: 3000
        }) 
        } else {
        
        swal({
         
          type: 'success',
          title: 'Added!',
          text: 'Education has been added successfully',
          showConfirmButton: false,
          timer: 3000
        }) 
        }

        this.router.navigate(['/education-list']);
      }, 
      (error) => 
      {
        this.btn_disable = false;
        this.submitted = false;
      });	
    
    }
  }

clearForm(EducationForm)
  {
    this.EducationEntity = {};	
    this.EducationEntity.EducationLevelId = 0;
    this.EducationEntity.IsActive = '1';	
    this.submitted = false;
    EducationForm.form.markAsPristine();
  }	

}
