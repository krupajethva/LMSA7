import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';


@Injectable()
export class ActivityService {

  constructor( private http: HttpClient,private globals: Globals, private router: Router) { }
  	// activity list //
  getAllActivity()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'AuditLog/getActivityLog')
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

// Email log all //
getEmailLog()
{
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'AuditLog/getEmailLog')
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

  // login log list //
  getLoginLog()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'AuditLog/getLoginLog')
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

  getNotificationByUser(id)
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'AuditLog/getNotificationByUser/' + id)
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

  
  getActivityByUser(id)
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'AuditLog/getActivityByUser/' + id)
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
}
