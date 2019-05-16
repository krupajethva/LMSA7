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
  selector: 'app-state',
  templateUrl: './state.component.html',
  styleUrls: ['./state.component.css']
})
export class StateComponent implements OnInit {
  	CountryEntity;
	CountryList;
	stateEntity;
	header;
	btn_disable;
	submitted;
	msgflag;
	message;
	type;
	buttonName;
  constructor( public globals: Globals, private router: Router, private StateService: StateService,private route:ActivatedRoute) { }

  ngOnInit() {
	
		this.StateService.getAllCountry()
		.then((data) => {
			this.CountryList = data;
		},
		(error) => {
			//alert('error');
		});

	let id = this.route.snapshot.paramMap.get('id');
	if (id) {

		this.buttonName='Update';
		 this.header = 'Edit';
		this.StateService.getById(id)
			.then((data) => {
				this.stateEntity = data;
				if(data['IsActive']==0){
					this.stateEntity.IsActive = 0;
				  } else {
					this.stateEntity.IsActive = '1';
				  }
        setTimeout(function(){
          myInput();
           },100);
				
			},
			(error) => {
				this.btn_disable = false;
				this.submitted = false;
			});
			}
			else {
				this.buttonName='Add';
				this.header = 'Add';
				this.stateEntity = {};
				this.stateEntity.StateId = 0;
				this.stateEntity.IsActive = '1';
				this.stateEntity.CountryId='';
				setTimeout(function(){
				myInput();
				},100);
			}
     
	}


	addState(stateForm) {
	debugger
		
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.stateEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {
			this.stateEntity.CreatedBy = this.globals.authData.UserId;
			this.stateEntity.UpdatedBy = this.globals.authData.UserId;
			this.stateEntity.StateId = 0;
			this.submitted = true;
		}
		if (stateForm.valid) {
			
			this.StateService.add(this.stateEntity)
				.then((data) => {
					
					this.btn_disable = false;
					this.submitted = false;
					this.stateEntity = {};
					stateForm.form.markAsPristine();
					if (id) {
							
							swal({
					
								type: 'success',
              					title: 'Updated!',
								text: 'State has been updated successfully!',
								showConfirmButton: false,
								timer: 3000
							})
						} else {
							
							swal({
		
								type: 'success',
              					title: 'Added!',
								text: 'State has been added successfully!',
								showConfirmButton: false,
								timer: 3000
							})
						}
					this.router.navigate(['/state-list']);
				},
				(error) => {
			
					this.btn_disable = false;
					this.submitted = false;
					
				});
		}
	}

	clearForm(stateForm) {
		debugger
		this.stateEntity = {};
		this.submitted = false;
		//this.ParentCategoryEntity.CategoryId = 0;
		this.stateEntity.IsActive = '1';
	
		stateForm.form.markAsPristine();
		this.stateEntity.StateId = 0;
	  }

}

 