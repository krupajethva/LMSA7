import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class InstructorCoursesService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getAllCourse(UserId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/getAllCourse/' + UserId)
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
  getbycourseclone(CourseId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/getAllCourseClone/' + CourseId)
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
  updatePublish(CourseId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/updatePublish/' + CourseId)
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
  StartSession(CourseSessionId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/StartSession/' + CourseSessionId)
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
  EndSession(CourseSessionId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/EndSession/' + CourseSessionId)
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
  //  updatePublish(CourseId){ debugger
  //   let promise = new Promise((resolve, reject) => {
  //     this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/updatePublish', CourseId )
  //       .toPromise()
  //       .then(
  //         res => { // Success
  //           resolve(res);
  //         },
  //         msg => { // Error
  //       reject(msg);
  //       //this.globals.isLoading = false;
  //       //this.router.navigate(['/pagenotfound']);
  //         }
  //       );
  //   });		
  //   return promise;
  //   }
  add(CategoryId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      debugger
      this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/getSearchCourseList', CategoryId)
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
  getAllParent() {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorCourses/getAllParent')
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
  getAllsessionDetail(id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      debugger
      this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/getAllSession', id)
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

  Revoke(id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/Revoke', id)
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
  addclone(clone) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/addclone', clone)
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
  isActiveChange(SessionEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'InstructorCourses/isActiveChange', SessionEntity)
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
}
