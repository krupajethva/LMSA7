import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import { Globals } from '.././globals';
import { Router } from '@angular/router';

@Injectable()
export class ResetpassService {

   constructor( private http: HttpClient,private globals: Globals,private router: Router) { }
   
   
  add(UserId){debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Resetpass/resetuserpass', UserId)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
      //this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }
   
   getResetlink(UserId){
	  debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Resetpass/resetpasslink',UserId)
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
  
   getResetlink2(UserId){
	  debugger
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Resetpass/resetpasslink2',UserId)
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
