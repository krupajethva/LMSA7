import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable()
export class RegisterLearnerInvitedService {

  constructor( private http:HttpClient,private globals: Globals, private router: Router) { }

  add(userEntity)
 {    
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'User/addUser', userEntity)
      .toPromise()
      .then( 
        res => { // Success 
			let result = res;
			if(result && result['token']){
				localStorage.setItem('token',result['token']);				
				this.globals.authData = new JwtHelperService().decodeToken(result['token']);
			}
		  resolve(res);
        },
        msg => { // Error
      reject(msg);
     
     // this.router.navigate(['/pagenotfound']);
        }
      );
	});		
	return promise;
  }

  // add(userEntity){ 
  //   debugger
  //   let promise = new Promise((resolve, reject) => { 
  //     this.http.post(this.globals.baseAPIUrl + 'User/addUser', userEntity)
      
  //       .toPromise()
  //       .then(
  //         res => { // Success
  //           resolve(res); 
  //         },
  //         msg => { // Error
  //       reject(msg);
  //         }
  //       );
  //   });		
  //   return promise;
  //   }

  // invited learner register //
  invitedLearnerRegister(RegisterEntity)
  {    debugger
   let promise = new Promise((resolve, reject) => {
     this.http.post(this.globals.baseAPIUrl + 'User/invited_learner_Register', RegisterEntity)
       .toPromise()
       .then( 
         res => { // Success 
           resolve(res);
         },
         msg => { // Error
           reject(msg);
          // this.globals.isLoading = false;
          // this.router.navigate(['/pagenotfound']);
         }
       );
   });		
   return promise;
   }
 


  getResetlink(UserId){
	  
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/resetpasslink',UserId)
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


  // get all list  //
  getAllDefaultData(){
	  debugger
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


    getStateList(CountryId){ 
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'User/getStateList/' + CountryId)
          .toPromise()
          .then(
            res => { // Success
              resolve(res);
            },
            msg => { // Error
          reject(msg);
          //this.globals.isLoading = false;
          //this.router.navigate(['/pagenotfound']);
            }
          );
      });		
      return promise;
      }  

}
