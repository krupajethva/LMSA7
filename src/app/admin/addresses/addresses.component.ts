import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AddressesService } from '../services/addresses.service';
declare var swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;


@Component({
  selector: 'app-addresses',
  templateUrl: './addresses.component.html',
  styleUrls: ['./addresses.component.css']
})
export class AddressesComponent implements OnInit {
	addressesEntity;
	submitted;
	btn_disable;
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,private AddressesService: AddressesService) { }

  ngOnInit() {
    // this.addressesEntity = {};
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.AddressesService.getById(id)
        .then((data) => {
        this.addressesEntity = data;
        this.addressesEntity=data;
        if(data['IsActive']==0){
          this.addressesEntity.IsActive = 0;
        } else {
          this.addressesEntity.IsActive = '1';
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
      this.addressesEntity = {};
      this.addressesEntity.AddressesId = 0;
      this.addressesEntity.IsActive = '1';
      setTimeout(function(){
        myInput();
        },100);
    }
      
  }
  
  addAddress(addressForm) {
      myInput();
      let id = this.route.snapshot.paramMap.get('id');
      if (id) {
        this.addressesEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.addressesEntity.CreatedBy = this.globals.authData.UserId;
        this.addressesEntity.UpdatedBy = this.globals.authData.UserId;
        this.addressesEntity.AddressesId = 0;
        this.submitted = true;
      }
      if (addressForm.valid) {
        this.btn_disable = true;
        this.AddressesService.add(this.addressesEntity)
          .then((data) => {
            this.btn_disable = false;
            this.submitted = false;
            this.addressesEntity = {};
            addressForm.form.markAsPristine();
            if (id) {
  
              swal({
               
                type: 'success',
                title: 'Updated!',
								text: "Address Updated Successfully.",
                showConfirmButton: false,
                timer: 1500
              })	
            } else {
              swal({
               
                type: 'success',
                title: 'Added!',
                text: 'Address Added Successfully.',
                showConfirmButton: false,
                timer: 1500
              })
            }
            this.router.navigate(['/addresses-list']);
          },
          (error) => {
            alert('error');
            this.btn_disable = false;
            this.submitted = false;
          });
  
      }
    }
  
    clearForm(addressForm) {
      this.addressesEntity = {};
      this.addressesEntity.AddressesId = 0;
      this.addressesEntity.IsActive = '1';
      this.submitted = false;
      addressForm.form.markAsPristine();
    }
  
  }
  