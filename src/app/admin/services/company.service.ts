import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CompanyService {

   constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
   
   //  add company //
   add(companyEntity){ 
     debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Company/addCompany/', companyEntity)
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
   
   // list all company //
  getAllCompany(){
	  
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Company/getAll')
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
   
  // delete company // 
  delete(del){  
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Company/delete', del)
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
      this.http.post(this.globals.baseAPIUrl + 'Company/isActiveChange', changeEntity)
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

  // get id company //
   getById(CompanyId){
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Company/getById/' + CompanyId)
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


  // state dependencie //
getStateList(CountryId){ 
	let promise = new Promise((resolve, reject) => {
	  this.http.get(this.globals.baseAPIUrl + 'Company/getStateList/' + CountryId)
		.toPromise()
		.then(
		  res => {
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



  // get default list //
  getAllDefaultdata()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Company/getAllDefaultdata')
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

 

}
