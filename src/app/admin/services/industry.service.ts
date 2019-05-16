import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class IndustryService {

  constructor( private http: HttpClient,private globals: Globals, private router: Router) { }


  add(IndustryEntity){ 
    debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Industry/add', IndustryEntity)
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
  

delete(del)
  {
	let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'Industry/delete',del)
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
  
  getAllInd()
  {
    debugger
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Industry/getAll')
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
      this.http.post(this.globals.baseAPIUrl + 'Industry/isActiveChange', changeEntity)
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
  
  getById(IndustryId)
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Industry/getById/' + IndustryId)
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

