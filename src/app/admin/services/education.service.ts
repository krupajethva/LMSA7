import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class EducationService {

  constructor( private http: HttpClient,private globals: Globals, private router: Router) { }

  add(EducationEntity)
 {
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Education/add', EducationEntity)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
      //this.globals.isLoading = false;
      //this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
  

delete(del)
  {
	let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'Education/delete', del)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
      //this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
  
  getAllCou()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Education/getAll')
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
     // this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }


   // ** IsActive
   isActiveChange(changeEntity){ debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Education/isActiveChange', changeEntity)
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
  
  getById(EducationId)
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Education/getById/' + EducationId)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
      //this.globals.isLoading = false;
     // this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }  
    
 }


