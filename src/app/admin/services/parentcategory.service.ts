import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class ParentcategoryService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  add(ParentCategoryEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'ParentCategory/addCategory/', ParentCategoryEntity)
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
 
 getAllCategory(){
	  debugger
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'ParentCategory/getAllCategory')
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
 //  this.globals.isLoading = false;
      //this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
   
  isActiveChange(changeEntity){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'ParentCategory/isActiveChange', changeEntity)
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
  deleteCategory(del){  debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'ParentCategory/delete', del)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
    //  this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
    

//   //update project list
   getById(id){
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'ParentCategory/getById/' + id)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
    //  this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }


 

}
