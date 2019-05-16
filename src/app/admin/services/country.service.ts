import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CountryService {

   constructor( private http: HttpClient,private globals: Globals, private router: Router) { }
 // add country //  
add(CountryEntity)
 {
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Country/add', CountryEntity)
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
  
// delete country //  
delete(del)
  {
	let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'Country/delete', del)
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
  
  // list country //  
  getAllCou()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Country/getAll')
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


   // ** IsActive //
   isActiveChange(changeEntity){ debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Country/isActiveChange', changeEntity)
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
  
    // get country id //  
  getById(CountryId)
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Country/getById/' + CountryId)
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

