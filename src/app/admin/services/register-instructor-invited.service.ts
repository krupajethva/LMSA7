import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';


@Injectable()
export class RegisterInstructorInvitedService {

  constructor( private http: HttpClient, private globals: Globals, private router: Router) { }


  add(userEntity) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/addUser', userEntity)
        .toPromise()
        .then(
          res => { // Success 
            let result = res;
            if (result && result['token']) {
              localStorage.setItem('token', result['token']);
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

  // ** file upload
  importFileUserData(file) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/importFileUserData', file)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            //this.globals.isLoading = false;
          }
        );
    });
    return promise;
  }


  // ** import file
  importFileData(RegisterEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/importFile', RegisterEntity)
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


  // ** instructor register invited //
  openInstructorRegister(RegisterEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/openInstructorRegister', RegisterEntity)
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

  // ** instructor register invited //
  invitedInstructorRegister(RegisterEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/invitedInstructorRegister', RegisterEntity)
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

  // ** certificate upload instructor //
  uploadFile(file) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/uploadFile', file)
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
  // ** upload user image //
  uploadFileCertificate(file, UserId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/uploadFileCertificate/' + UserId, file)
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
  getResetlink(UserId) {

    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/resetpasslink', UserId)
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

  // check link already used or not // 
  getResetlink2(UserId) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/resetpasslink2', UserId)
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


  // invited user get id  //
  getById(UserId) {
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


  // list all default data //
  getAllDefaultData() {
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

  checkEmail(obj) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'User/checkEmail', obj)
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
