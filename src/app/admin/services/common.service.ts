import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CommonService {

  constructor( private http: HttpClient,private globals: Globals, private router: Router) { }

  get_permissiondata(permission){ 
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Common/get_permissiondata', permission)
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

  get_whilelabling(Comapny_workspace){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Common/get_whilelabling', Comapny_workspace)
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

    getCompanyDetails(comapny){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Common/getCompanyDetails', comapny)
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

    getCompanyList(){ 
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Common/getCompanyList')
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

    check_workspace_url(data){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Common/check_workspace_url', data)
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

}

