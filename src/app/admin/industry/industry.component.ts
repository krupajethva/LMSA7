import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { IndustryService } from '../services/industry.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
	selector: 'app-industry',
	providers: [IndustryService],
	templateUrl: './industry.component.html'

})
export class IndustryComponent implements OnInit {

	IndustryEntity;
	submitted;
	btn_disable;
	header;
	msgflag;
	message;
	type;
	buttonName;
	constructor( public globals: Globals, private router: Router, private IndustryService: IndustryService,
		private route: ActivatedRoute) { }

		ngOnInit() 
		{
			let id = this.route.snapshot.paramMap.get('id');
		   if(id)
		   {	
			   this.header="Edit";
			   this.buttonName="Update";
			  this.IndustryService.getById(id)
				  .then((data) => 
				  {
					  this.IndustryEntity=data;
					  if(data['IsActive']==0){
						this.IndustryEntity.IsActive = 0;
					  } else {
						this.IndustryEntity.IsActive = '1';
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
			this.header="Add";
			this.buttonName="Add";
				   this.IndustryEntity = {};
				   this.IndustryEntity.IndustryId = 0;
					this.IndustryEntity.IsActive = '1';
				  
		   }
		}


	addIndustry(IndustryForm) 
	{	myInput();	
		  let id = this.route.snapshot.paramMap.get('id');
		  if (id) {
			this.IndustryEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {
			this.IndustryEntity.CreatedBy = this.globals.authData.UserId;
			this.IndustryEntity.UpdatedBy = this.globals.authData.UserId;
			this.IndustryEntity.IndustryId = 0;
			this.submitted = true;
		}
		  if(IndustryForm.valid){
			  this.btn_disable = true;
			  this.IndustryService.add(this.IndustryEntity)
			  .then((data) => 
			  {
				  this.btn_disable = false;
				  this.submitted = false;
				  this.IndustryEntity = {};
				  IndustryForm.form.markAsPristine();
				  if (id) {
					swal({
		
						type: 'success',
						title: 'Updated!',
						text: 'Industry has been updated successfully',
						showConfirmButton: false,
						timer: 1500
					})
				} else {
					swal({
				
						type: 'success',
						title: 'Added!',
						text: 'Industry has been added successfully',
						showConfirmButton: false,
						timer: 1500
					})
				} 
				  this.router.navigate(['/industry/list']);
			  }, 
			  (error) => 
			  {
				  //alert('error');
				  this.btn_disable = false;
				  this.submitted = false;
			  
			  //	this.router.navigate(['/pagenotfound']);
			  });	
		  
		  }
	  }
  
	clearForm(IndustryForm)
	  {
		  this.IndustryEntity = {};	
		  this.IndustryEntity.IndustryId = 0;
	 	  this.IndustryEntity.IsActive = '1';	
		  this.submitted = false;
		  IndustryForm.form.markAsPristine();
	  }	
  
}
