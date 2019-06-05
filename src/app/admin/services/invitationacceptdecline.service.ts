import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class InvitationacceptdeclineService {
  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  Insinvitation(type,CourseSessionId,UserId)
  {debugger
	let promise = new Promise((resolve, reject) => {		
    this.http.get(this.globals.baseAPIUrl + 'Instructorinvi/InstRequest/'+ type +'/'+ CourseSessionId +'/'+ UserId)
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
