import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class CalendarService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { 
  }
  getAnnouncementTypes(){   
    debugger  
    let promise = new Promise((resolve, reject) => {     
      this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnouncementTypes')
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
    getCalendarDetails(Id)
    {
      debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Calendar/getCalendarDetails/' + Id)
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
}
