import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable()
export class UserService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

   // list all learner users //
   getAllUser(){
	  debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'User/getAllUserList')
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



    // ** IsActive  learner user //
    isActiveChange(changeEntity){ debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'User/isActiveChange', changeEntity)
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

      // ** Delete user //
      deleteUser(del){
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'User/deleteUser', del)
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


       // revoke user //
       deleteInvitation(del)
       {
       let promise = new Promise((resolve, reject) => {		
         this.http.post(this.globals.baseAPIUrl + 'User/delete', del)
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


        // user re-invite //
        ReInvite(UserId)
        {
        let promise = new Promise((resolve, reject) => {		
          this.http.post(this.globals.baseAPIUrl + 'User/ReInvite', UserId)
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
