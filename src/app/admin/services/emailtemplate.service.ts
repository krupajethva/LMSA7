import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class EmailtemplateService {

constructor(private http: HttpClient,private globals: Globals, private router: Router) { }

add(emailEntity)
 { 
   debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Email_Template/add', emailEntity)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
     // this.globals.isLoading = false;
     // this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
  

delete(del)
  {
	let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'Email_Template/delete' ,del)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);

        }
      );
	});		
	return promise;
  }
  
  getAll()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Email_Template/getAll')
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

   // ** IsActive
   isActiveChange(changeEntity){ debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Email_Template/isActiveChange', changeEntity)
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
  
  getById(Email_TemplateId)
  { 
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Email_Template/getById/' + Email_TemplateId)
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
  
  getDefaultList(){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Email_Template/getDefaultList')
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
    
 }


