import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class RolepermissionService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  getDefault(roleId){  
    let promise = new Promise((resolve, reject) => { 
      this.http.get(this.globals.baseAPIUrl + 'RolePermission/getDefault/' + roleId)
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

getRolePermission(roleId){  
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'RolePermission/getRolePermission/' + roleId)
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

update_permission(permission){  
  let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'RolePermission/update_permission', permission)
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

  getLeftMenu(roleId){    
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'RolePermission/getLeftMenu/' + roleId)
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
