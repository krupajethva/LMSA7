import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class CourseSchedulerService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  addScheduler(CourseSesssionEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'CourseScheduler/addScheduler', CourseSesssionEntity)
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
 addSingleSession(CourseSesssionEntity){ 
  debugger
let promise = new Promise((resolve, reject) => {
 this.http.post(this.globals.baseAPIUrl + 'CourseScheduler/addSingleSession', CourseSesssionEntity)
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
updatePublish(CourseSesssionEntity){ 
  debugger
let promise = new Promise((resolve, reject) => {
 this.http.post(this.globals.baseAPIUrl + 'CourseScheduler/updatePublish', CourseSesssionEntity)
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
 getAllDefaultData(){
  debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'CourseScheduler/getAllDefaultData')
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
  getStateList(CountryId){ 
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'CourseScheduler/getStateList/' + CountryId )
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
    getById(id,userid){debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'CourseScheduler/getById/' + id+'/'+userid)
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
      deleteScheduler(del){  debugger
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'CourseScheduler/deleteScheduler', del)
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
        CloneCourse(coln){  debugger
          let promise = new Promise((resolve, reject) => {
            this.http.post(this.globals.baseAPIUrl + 'CourseScheduler/addClone', coln)
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
