import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';


@Injectable()
export class RegisterAdminInvitedService {

  constructor( private http:HttpClient,private globals: Globals, private router: Router) { }


 // ** admin register invited //
   invitedAdminRegister(RegisterEntity)
   {    
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/invited_admin_Register', RegisterEntity)
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
     
      // check link already used or not // 
      getResetlink2(UserId){
     let promise = new Promise((resolve, reject) => {
       this.http.post(this.globals.baseAPIUrl + 'User/resetpasslink2',UserId)
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
   
 
      // invited user get id for register //
     getById(UserId){
       let promise = new Promise((resolve, reject) => {
         this.http.get(this.globals.baseAPIUrl + 'User/getById/' + UserId)
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
 
 
   // ** list default data //
   getAllDefaultData(){
     let promise = new Promise((resolve, reject) => {
       this.http.get(this.globals.baseAPIUrl + 'User/getAllDefaultData')
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
 