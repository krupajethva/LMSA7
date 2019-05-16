import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class ActivedeleteService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { 
  }
  delete(del){
    let promise = new Promise((resolve, reject) => {		
      this.http.post(this.globals.baseAPIUrl + 'ActiveDelete/deleteItem',del)
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
    isActiveChange(changeEntity){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'ActiveDelete/isActiveChange', changeEntity)
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
