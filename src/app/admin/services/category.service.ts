import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CategoryService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  add(CategoryEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Category/addCategory/', CategoryEntity)
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
 getAllParent()
 {
 let promise = new Promise((resolve, reject) => {
   this.http.get(this.globals.baseAPIUrl + 'Category/getAllParent')
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
 getAllCategory(){
	  debugger
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Category/getAllCategory')
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
      this.http.post(this.globals.baseAPIUrl + 'Category/isActiveChange', changeEntity)
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
    this.http.post(this.globals.baseAPIUrl + 'Category/delete', del)
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
    this.http.get(this.globals.baseAPIUrl + 'Category/getById/' + id)
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


 

//   getAllCo()
//   {
//     let promise = new Promise((resolve, reject) => {
//       this.http.get(this.globals.baseAPIUrl + 'Company/getAllComp')
//         .toPromise()
//         .then(
//           res => { // Success
//             resolve(res);
//           },
//           msg => { // Error
//         reject(msg);
//           }
//         );
//     });		
//     return promise;
//     }  
}
