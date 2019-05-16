import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CountryService } from '../services/country.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-country',
  templateUrl: './country.component.html',
  styleUrls: ['./country.component.css']
})
export class CountryComponent implements OnInit {
  CountryEntity;
	submitted;
	btn_disable;
  header;
  buttonName;
  constructor( public globals: Globals, private router: Router, private CountryService: CountryService,private route:ActivatedRoute) { }

  ngOnInit() 
  {
    let id = this.route.snapshot.paramMap.get('id');
     if(id)
     {	
      this.header = 'Edit';
      this.buttonName="Update";
      this.CountryService.getById(id)
        .then((data) => 
        {
          this.CountryEntity=data;
          if(data['IsActive']==0){
            this.CountryEntity.IsActive = 0;
          } else {
            this.CountryEntity.IsActive = '1';
          }
          setTimeout(function(){
            myInput();
             },100);
        }, 
        (error) => 
        {
         
          this.btn_disable = false;
          this.submitted = false;
        
      
        });
      
     }
     else
     {
      this.header = 'Add';
      this.buttonName="Add";
         this.CountryEntity = {};
         this.CountryEntity.CountryId = 0;
        this.CountryEntity.IsActive = '1';
        setTimeout(function(){
          myInput();
          },100);
     }
  }


addCountry(CountryForm) 
{		 myInput();
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
    this.CountryEntity.UpdatedBy = this.globals.authData.UserId;
    this.submitted = false;
  } else {
    this.CountryEntity.CreatedBy = this.globals.authData.UserId;
    this.CountryEntity.UpdatedBy = this.globals.authData.UserId;
    this.CountryEntity.CompanyId = 0;
    this.submitted = true;
  }
    if(id){
      this.submitted = false;
    } else {
      this.CountryEntity.CountryId = 0;
      this.submitted = true;
    }
    if(CountryForm.valid){
      this.btn_disable = true;
      this.CountryService.add(this.CountryEntity)
      .then((data) => 
      {
      
        this.btn_disable = false;
        this.submitted = false;
        this.CountryEntity = {};
        CountryForm.form.markAsPristine();
        if (id) {
        
        swal({
          type: 'success',
          title: 'Updated!',
          text: 'Country has been Updated Successfully',
          showConfirmButton: false,
          timer: 3000
        }) 
        } else {
        
        swal({
         
          type: 'success',
          title: 'Added!',
          text: 'Country haas been Added Successfully',
          showConfirmButton: false,
          timer: 3000
        }) 
        }

        this.router.navigate(['/country-list']);
      }, 
      (error) => 
      {
       
        this.btn_disable = false;
        this.submitted = false;
      
      
      });	
    
    }
  }
  clearForm(CountryForm) {
    debugger
    this.CountryEntity = {};
    this.submitted = false;
    //this.ParentCategoryEntity.CategoryId = 0;
    this.CountryEntity.IsActive = '1';

    CountryForm.form.markAsPristine();
    this.CountryEntity.CountryId = 0;
  }

}
