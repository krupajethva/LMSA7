import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import { Globals } from '.././globals';
import { Router } from '@angular/router';
@Injectable()
export class ResetpasswordService {

  constructor( private http: HttpClient,private globals: Globals,private router: Router) { }

  // add new password //
  add(UserId){
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Resetpass/resetuserpass', UserId)
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
     
    
    // check link used or not //
     getResetlink2(UserId){
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Resetpass/resetpasslink2',UserId)
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
  
