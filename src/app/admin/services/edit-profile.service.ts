import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Globals } from '.././globals';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';

@Injectable()
export class EditProfileService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  skillsData() {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/skillsData')
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

  // all default data //
  getDefaultData() {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/getDefaultData')
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

  // update user data //  
  editprofile(RegisterEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/editprofileadmin', RegisterEntity)
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
            reject(msg.json());
            this.globals.isLoading = false;
          }
        );
    });
    return promise;
  }

  // update education detail //
  updateEducationDetails(EducationEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/updateEducationDetails', EducationEntity)
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

  // update company detail //
  updateCompany(CompanyEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/updateCompany', CompanyEntity)
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

  // ** upload user image //
  uploadProfilePicture(file ,UserId) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/uploadProfilePicture/'+ UserId , file )
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

  // ** upload signature //
  uploadSignature(file ,UserId) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/uploadSignature/'+ UserId , file )
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

  //  // ** upload user image //
  //  uploadFileCertificate(file){
  // let promise = new Promise((resolve, reject) => {
  //   this.http.post(this.globals.baseAPIUrl + 'EditProfile/uploadFileCertificate', file)
  //     .toPromise()
  //     .then(
  //       res => { // Success
  //         resolve(res);
  //       },
  //       msg => { // Error
  //       reject(msg);
  //       this.globals.isLoading = false;
  //       }
  //     );
  // });		
  // return promise;
  // }


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


  // User for Company country //
  getStateList(cid) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/getStateList/' + cid)
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

  // use for user country //
  getStateListadd(CountryId) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/getStateListadd/' + CountryId)
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

  // get user id data //     
  getProfileById(userId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/getProfileById/' + userId)
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

  // get education detail data  //
  getEducationDetail(userId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'EditProfile/getEducationDetail/' + userId)
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

  // chnage pass user //
  changepassword(data) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/changePassword', data)
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

  //delete certificate
  deleteCertificate(del) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'EditProfile/deleteCertificate', del)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            //  this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }

}
