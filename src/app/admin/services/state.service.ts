import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class StateService {

 constructor(private http: HttpClient, private globals: Globals, private router: Router) {  }
 
 // add state //
 add(stateEntity){ 
  
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'State/addState', stateEntity)
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
 
  // list state //
  getAllState(){ 
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'State/getAll')
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

  // ** IsActive //
  isActiveChange(changeEntity){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'State/isActiveChange', changeEntity)
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
  
  
  deleteState(del){
	let promise = new Promise((resolve, reject) => {		
    this.http.post(this.globals.baseAPIUrl + 'State/delete', del)
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
  
  
  getById(stateId){
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'State/getById/' + stateId)
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
  
  
   getAllCountry()
  {
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'State/getAllCountry')
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
