import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class AttendanceService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getById(id){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Attendance/getById/' + id)
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
    getDefaultData(id) {
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Attendance/getDefaultData/' + id)
          .toPromise()
          .then(
            res => {
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
    getStateList(CourseId) {
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Attendance/getStateList/' + CourseId)
          .toPromise()
          .then(
            res => {
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
  //   add(data){ 
  //     debugger
  //  let promise = new Promise((resolve, reject) => {
  //    this.http.post(this.globals.baseAPIUrl + 'Attendance/SearchAttendance/', data)
  //      .toPromise()
  //      .then(
  //        res => { // Success
  //          resolve(res);
  //        },
  //        msg => { // Error
  //      reject(msg);
  //      //this.globals.isLoading = false;
  //     // this.router.navigate(['/pagenotfound']);
  //        }
  //      );
  //  });		
  //  return promise;
  //  }
   add(Session_id) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Attendance/SearchAttendance/' + Session_id)
        .toPromise()
        .then(
          res => {
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
  UpdateAttendance(data){ 
      debugger
   let promise = new Promise((resolve, reject) => {
     this.http.post(this.globals.baseAPIUrl + 'Attendance/UpdateAttendance/', data)
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
