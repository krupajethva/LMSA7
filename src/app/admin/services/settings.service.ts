import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class SettingsService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  insaddONOFF(instructoronoffEntity){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/insAddOnOff', instructoronoffEntity)
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

  addONOFF(onoffEntity){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/addOnOff', onoffEntity)
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

// ** on/of List
getAllListONOFF(){ 
  debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Settings/getAllConfigInstructor')
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

// ** on/of List
  getAllList(){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Settings/getAllConfig')
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


    // ** on/of List
    getAllCourseKey(){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Settings/getAllCourseKey')
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


  update_config(configEntity){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/updateConfiguration', configEntity)
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

    update_email(configEntity){ 
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Settings/updateEmail', configEntity)
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
  
 
  
  getAll(UserId){ 
    
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Settings/getAll/' + UserId)
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


    addcontact(ContactEntity){ 
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Settings/addContact', ContactEntity)
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

  addCourseKeyword(courseKeyEntity){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/addCourseKeyword', courseKeyEntity)
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

  addinvimsg(InviEntity){ debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/addinvimsg', InviEntity)
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

secondSubmit(allEntity){ debugger
  let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Settings/secondSubmit', allEntity)
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

  UpdateReminder(reminderEntity){ 
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Settings/UpdateReminder', reminderEntity)
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

