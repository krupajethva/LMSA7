import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()
export class AssessmenttestService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getbyassessment(Id,userId){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Assessment/getbyassessment/' + Id+'/'+userId)
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
    finalsubmit(Id,userId,ttime,stime){ 
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Assessment/finalsubmit/' + Id+'/'+userId+'/'+ttime+'/'+stime)
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

      assessment_result(Id){ 
        debugger
        let promise = new Promise((resolve, reject) => {
          this.http.get(this.globals.baseAPIUrl + 'Assessment/assessment_result/' + Id)
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
    // assessmentans(ansEntity){ 
    //   debugger
    //   let promise = new Promise((resolve, reject) => {
    //     this.http.get(this.globals.baseAPIUrl + 'Assessment/assessment_ans/' + Id+'/'+userId)
    //       .toPromise()
    //       .then(
    //         res => { // Success
    //           resolve(res);
    //         },
    //         msg => { // Error
    //       reject(msg);
    //       //this.globals.isLoading = false;
    //       //this.router.navigate(['/pagenotfound']);
    //         }
    //       );
    //   });		
    //   return promise;
    //   }
      assessmentans(ansEntity){ 
        
     let promise = new Promise((resolve, reject) => {
       this.http.post(this.globals.baseAPIUrl + 'Assessment/assessment_ans', ansEntity)
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
     getbyassessmentcheck(assessmentEntity){ 
        
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Assessment/getbyassessment_check', assessmentEntity)
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
     MarkasReview(question){ debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Assessment/MarkasReview', question)
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
      timeoutsubmit(Id,userId){ 
        debugger
        let promise = new Promise((resolve, reject) => {
          this.http.get(this.globals.baseAPIUrl + 'Assessment/timeoutsubmit/' + Id+'/'+userId)
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
