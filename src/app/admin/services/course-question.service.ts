
import { Injectable } from '@angular/core';

import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CourseQuestionService {

 
  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getAllCourse(userid){
    debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Question/getAllCourse/'+userid)
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
  getAllQuestion(CourseId){
    debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Question/getAllQuestion/'+CourseId)
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
  add(QuestionEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Question/addQuestion/', QuestionEntity)
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
 getById(id){debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Question/getById/' + id)
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
  getCourseById(id){debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Question/getCourseById/' + id)
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
 isActiveChange(changeEntity){ debugger
  let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Question/isActiveChange', changeEntity)
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
 

  delete(id,userid){
    debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Question/delete/'+id+'/'+userid)
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

}
