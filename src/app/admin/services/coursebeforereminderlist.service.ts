import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';


@Injectable({
  providedIn: 'root'
})
export class CoursebeforereminderlistService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  getAllDetails() {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Coursebeforereminderlist/getAllDetails')
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

  deletereminder(data){
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Coursebeforereminderlist/deletereminder',data)
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
