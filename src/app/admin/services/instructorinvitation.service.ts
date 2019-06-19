import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class InstructorinvitationService {
  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getAllCourse()
  {
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Instructorinvi/getAllCourse')
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
  getAllInstructor()
  {debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Instructorinvi/getAllInstructor')
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
  add(InstructorEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Instructorinvi/addInstructor/', InstructorEntity)
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
 getAllInstructorInvi()
  {debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Instructorinvi/getAllInstructorInvi')
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
  ReInvite(InvitationId)
  {
  let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'Instructorinvi/ReInvite/',InvitationId)
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
 
}
