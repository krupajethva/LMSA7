import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import { Globals } from '.././globals';
import { Router } from '@angular/router';


@Injectable()
export class UserActivationService {

  constructor( private http: HttpClient,private globals: Globals,private router: Router) { }

  getResetlink2(UserId){
	  debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Register/userActive',UserId)
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
