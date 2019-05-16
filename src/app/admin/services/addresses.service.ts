import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';


@Injectable()
export class AddressesService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  // add new
  add(addressesEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Addresses/addAddresses/', addressesEntity)
     .toPromise()
     .then(
       res => { // Success
         resolve(res);
       },
       msg => { // Error
     reject(msg);
     this.globals.isLoading = false;
   
       }
     );
 });		
 return promise;
 }
  
  //list all address
 getAllAddresses(){
   
 let promise = new Promise((resolve, reject) => {
   this.http.get(this.globals.baseAPIUrl + 'Addresses/getAll')
     .toPromise()
     .then(
       res => { // Success
         resolve(res);
       },
       msg => { // Error
     reject(msg);
     this.globals.isLoading = false;
     
       }
     );
 });		
 return promise;
 }
  
  // delete
 delete(del){  
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Addresses/delete', del)
     .toPromise()
     .then(
       res => { // Success
         resolve(res);
       },
       msg => { // Error
     reject(msg);
     this.globals.isLoading = false;
       }
     );
 });		
 return promise;
 }
   
  // ** IsActive
  isActiveChange(changeEntity){ debugger
   let promise = new Promise((resolve, reject) => {
     this.http.post(this.globals.baseAPIUrl + 'Addresses/isActiveChange', changeEntity)
       .toPromise()
       .then(
         res => { // Success
           resolve(res);
         },
         msg => { // Error
           reject(msg);
        //   this.globals.isLoading = false;
           //this.router.navigate(['/pagenotfound']);      
         }
       );
   });		
   return promise;
   }

 //get data
  getById(AddressesId){
 let promise = new Promise((resolve, reject) => {
   this.http.get(this.globals.baseAPIUrl + 'Addresses/getById/' + AddressesId)
     .toPromise()
     .then(
       res => { // Success
         resolve(res);
       },
       msg => { // Error
     reject(msg);
   this.globals.isLoading = false;
       }
     );
 });		
 return promise;
 }





}
