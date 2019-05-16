import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class CoursetopicService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  add(addt){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Coursetopic/addCoursetopic/', addt)
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
  getAllCourse()
  {
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Coursetopic/getAllCourse')
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
  getById(id){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Coursetopic/getById/' + id)
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
