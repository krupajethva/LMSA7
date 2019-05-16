import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class InviteInstructorService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) {  }

  // invite user //
  add(inviteUserEntity){ 
    debugger
    let promise = new Promise((resolve, reject) => { 
      this.http.post(this.globals.baseAPIUrl + 'Userinvite/inviteInstructor', inviteUserEntity)
      
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

    // open register Instructor //
    openInstructorAdd(inviteUserEntity){ 
      debugger
      let promise = new Promise((resolve, reject) => { 
        this.http.post(this.globals.baseAPIUrl + 'Userinvite/openinviteInstructor', inviteUserEntity)
        
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
  

// List All Default Data user register //
  getAllDefaultData(){ 
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Userinvite/getAllDefaultData')
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

    // state dependencie //
    getStateList(CountryId){ 
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Userinvite/getStateList/' + CountryId)
        .toPromise()
        .then(
          res => {
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
