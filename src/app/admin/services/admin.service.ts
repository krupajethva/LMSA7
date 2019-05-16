import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class AdminService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
   // list all admin users //
   getAllUser(){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'User/getAdminUserList')
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

    // ** IsActive //
    isActiveChange(changeEntity){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'User/isActiveChange', changeEntity)
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

       // ** IsActive Admin Prime //
       isActiveChangePrime(changeEntity){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'User/isActiveChangePrime', changeEntity)
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

    
          // ** Delete admin //
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

           
          

}
