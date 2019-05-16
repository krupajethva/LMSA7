import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class LearnerCoursesService {


  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  
  add(CategoryId){ debugger
    let promise = new Promise((resolve, reject) => { debugger
      this.http.post(this.globals.baseAPIUrl + 'LearnerCourses/getSearchCourseList', CategoryId)
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
  getAllParent()
  {debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'LearnerCourses/getAllParent')
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
  assessmentadd(assessment){ debugger
    let promise = new Promise((resolve, reject) => { debugger
      this.http.post(this.globals.baseAPIUrl + 'LearnerCourses/Assessmentadd', assessment)
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
  getAllCourse(UserId){ debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'LearnerCourses/getAllCourse/' + UserId )
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
    
    // getAllsessionDetail(id){ debugger
    //   let promise = new Promise((resolve, reject) => {
    //     this.http.get(this.globals.baseAPIUrl + 'LearnerCourses/getAllSession/' + id )
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
      getAllsessionDetail(id){ debugger
        let promise = new Promise((resolve, reject) => { debugger
          this.http.post(this.globals.baseAPIUrl + 'LearnerCourses/getAllSession', id)
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
