import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class DashboardService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  getDashboard(Id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getDashboard/' + Id)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  getLearnerCourses(LearnerId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getLearnerCourses/' + LearnerId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  getCalendarDetails(Id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getCalendarDetails/' + Id)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  getLearnerActivities(Id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getLearnerActivities/' + Id)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
/*################ RECENT INVITATION  START ##############*/
  getRecentInvitation() {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getRecentInvitation/')
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  /*################ RECENT INVITATION  END ##############*/

  /*################ RECENT ACTIVITIES  START ##############*/
  getRecentActivity(UserId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getRecentActivity/'+UserId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
 /*################ RECENT ACTIVITIES  START ##############*/

 /*################ TOP INSTRUCTORS  START ##############*/
 getTopInstructors() {
  debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Dashboard/getTopInstructors/')
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
          reject(msg);
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        }
      );
  });
  return promise;
}
/*################ TOP INSTRUCTORS  END ##############*/

    /*################################ INSTRUCTOR DASHBOARD #########################################*/

  /*################ GET INSTRUCTOR DASHBOARD START ##############*/
   getInstructorDashboard(UserId) {
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Dashboard/getInstructorDashboard/'+UserId)
          .toPromise()
          .then(
            res => { // Success
              resolve(res);
            },
            msg => { // Error
              reject(msg);
              this.globals.isLoading = false;
              this.router.navigate(['/pagenotfound']);
            }
          );
      });
      return promise;
    }
    /*################ GET INSTRUCTOR DASHBOARD START ##############*/

     /*################ GET LEARNER DASHBOARD START ##############*/
   getLearnerDashboard(UserId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Dashboard/getLearnerDashboard/'+UserId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  /*################ GET INSTRUCTO DASHBOARD START ##############*/

}
