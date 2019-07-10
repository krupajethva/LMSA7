import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable()
export class UserinstructorService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
   // list all instructor users //
   getAllUser(){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Instructor/getAllUserList')
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
    
    // get certificate by instuctor userid
    getCertificateById(userId){
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Instructor/getCertificateById/'+userId)
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
    // ** IsActive user instructor //
    isActiveChange(changeEntity){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Instructor/isActiveChange', changeEntity)
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

      // ** Delete instructor //
      deleteUser(del){  
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'Instructor/deleteUser', del)
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


}
