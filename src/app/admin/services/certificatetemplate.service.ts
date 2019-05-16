import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class CertificatetemplateService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  add(CertificateEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'CertificateTemplate/addCertificate/', CertificateEntity)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            //this.globals.isLoading = false;
            // this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  }
  getAllCertificate() {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'CertificateTemplate/getAllCertificate')
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            //  this.globals.isLoading = false;
            //this.router.navigate(['/pagenotfound']);
          }
        );
    });
    return promise;
  } 
  isActiveChange(changeEntity) {
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'CertificateTemplate/isActiveChange', changeEntity)
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
  deleteCertificate(del) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'CertificateTemplate/delete', del)
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


  //   //update project list
  getById(id) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'CertificateTemplate/getById/' + id)
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

  getDefaultList(){
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'CertificateTemplate/getDefaultList')
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            //this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          }
        );
    });		
    return promise;
    }
}
