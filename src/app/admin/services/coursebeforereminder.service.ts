import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class CoursebeforereminderService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) {}

    BeforeReminder(reminderEntity){
      debugger
      console.log('reminderEntity', reminderEntity);
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Coursebeforereminders/insert_data', reminderEntity)
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

    getcourselist() {
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Coursebeforereminders/course_list')
          .toPromise()
          .then(
            res => { // Success 
              resolve(res);
            },
            msg => { // Error
              reject(msg);
              this.router.navigate(['/pagenotfound']);
            }
          );
      });
      return promise;
    }

    getAllDetails() {
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Coursebeforereminders/getAllDetails')
          .toPromise()
          .then(
            res => { // Success 
              resolve(res);
            },
            msg => { // Error
              reject(msg);
              this.router.navigate(['/pagenotfound']);
            }
          );
      });
      return promise;
    }
   
}
