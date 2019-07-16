import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CompanyService } from '../services/company.service';
declare var swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;


@Component({
	selector: 'app-company',
	providers: [CompanyService],
	templateUrl: './company.component.html'

})

export class CompanyComponent implements OnInit {
	
	CompanyList;
	companyEntity;
	addressEntity
	submitted;
	btn_disable;
	IndustryList;
	CountryList;
	StateList;
	header;
	constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,private CompanyService: CompanyService) { }

	ngOnInit() {
	
	this.companyEntity = {};
	

	this.CompanyService.getAllDefaultdata()
		.then((data) => {
			this.IndustryList = data['industry'];
			this.CountryList = data['country'];
			this.StateList = data['state'];
		},
		(error) => {
			this.globals.isLoading = false;
		});

	let id = this.route.snapshot.paramMap.get('id');
	if (id) {
		this.header='Edit';
		this.CompanyService.getById(id)
			.then((data) => {
			this.companyEntity = data;
			if (this.companyEntity.CountryId > 0) {
				this.CompanyService.getStateList(this.companyEntity.CountryId)
					.then((data) => {
						this.StateList = data;
								this.globals.isLoading = false;
								this.btn_disable = false;
								this.submitted = false;
					},
					(error) => {
						this.globals.isLoading = false;
								this.btn_disable = false;
								this.submitted = false;
						
					});
			}
			if(data['IsActive']==0){
			  this.companyEntity.IsActive = 0;
			} else {
			  this.companyEntity.IsActive = '1';
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
		this.header='Add';
		this.companyEntity = {};
		this.companyEntity.CompanyId = 0;
		this.companyEntity.IsActive = '1';
		setTimeout(function(){
			myInput();
			},100);
	}
		
}


	addCompany(companyForm) {
		debugger
		myInput();
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.companyEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {
			this.companyEntity.CreatedBy = this.globals.authData.UserId;
			this.companyEntity.UpdatedBy = this.globals.authData.UserId;
			this.companyEntity.CompanyId = 0;
			this.submitted = true;
		}
		if (companyForm.valid) {
			this.btn_disable = true;
			this.globals.isLoading = true;
			this.CompanyService.add(this.companyEntity)
				.then((data) => {
					if (this.companyEntity.CountryId > 0) {
						this.CompanyService.getStateList(this.companyEntity.CountryId)
							.then((data) => {
								this.StateList = data;
								this.globals.isLoading = false;
								this.btn_disable = false;
								this.submitted = false;		
							},
							(error) => {
								this.globals.isLoading = false;
								this.btn_disable = false;
								this.submitted = false;
							});
					}
					
					this.btn_disable = false;
					this.submitted = false;
					this.companyEntity = {};
					companyForm.form.markAsPristine();
					if (id) {

						swal({
						
							type: 'success',
							title: 'Updated!',
							text: 'Company has been Updated Successfully',
							showConfirmButton: false,
							timer: 1500
						})	
					} else {
						swal({
			
							type: 'success',
							title: 'Added!',
							text: 'Company has been Added Successfully',
							showConfirmButton: false,
							timer: 1500
						})
					}
					this.router.navigate(['/company-list']);
				},
				(error) => {
					alert('error');
					this.btn_disable = false;
					this.submitted = false;
				});

		}
	}


	getStateList(companyForm) {
		debugger
		myInput();
		companyForm.form.controls.StateId.markAsDirty();
		this.companyEntity.StateId='';
		if (this.companyEntity.CountryId > 0) {
			this.CompanyService.getStateList(this.companyEntity.CountryId)
				.then((data) => {
					this.StateList = data;
				},
				(error) => {
					this.btn_disable = false;
					this.submitted = false;
				});
		} else {
			this.StateList = [];
		}
	}

	clearForm(companyForm) {
		debugger
		this.companyEntity = {};
		this.submitted = false;
		//this.ParentCategoryEntity.CategoryId = 0;
		this.companyEntity.IsActive = '1';
		companyForm.form.markAsPristine();
		this.companyEntity.CountryId = 0;
	  }
	
}
