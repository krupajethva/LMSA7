import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class CourseListService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  getAllCourse(){
    debugger
  let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Courselist/getAllCourse')
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
  getCategoryWise(CategoryId){ 
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Courselist/getCategoryWise/' + CategoryId )
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
    getInstWise(UserId){ 
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.get(this.globals.baseAPIUrl + 'Courselist/getInstWise/' + UserId )
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
      getAllCourseDetail(Id){ 
        debugger
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'Courselist/getAllCourseDetail/', Id )
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
        getDiscussionById(obj){ 
          debugger
          let promise = new Promise((resolve, reject) => {
            this.http.post(this.globals.baseAPIUrl + 'Courselist/getDiscussionById' , obj)
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
          getAllDiscussions(Id){ 
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.get(this.globals.baseAPIUrl + 'Courselist/getAllDiscussions/' + Id )
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
          getAllReviews(obj){ 
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.post(this.globals.baseAPIUrl + 'Courselist/getAllReviews' , obj )
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
            getUserDetail(Id){ 
              debugger
              let promise = new Promise((resolve, reject) => {
                this.http.get(this.globals.baseAPIUrl + 'Courselist/getUserDetail/' + Id )
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
PurchaseCourse(pay)
  {    
   let promise = new Promise((resolve, reject) => {
     this.http.post(this.globals.baseAPIUrl + 'Courselist/PurchaseCourse', pay)
       .toPromise()
       .then( 
         res => { // Success 
          resolve(res);
         },
         msg => { // Error
          reject(msg.json());
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
         }
       );
   });		
   return promise;
   }
   addEnroll(Enrolla){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Courselist/addEnroll', Enrolla)
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
 
  delete(del){  debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Courselist/delete', del)
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
    checkUser(obj){  debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Courselist/checkUser', obj)
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
    addPost(postEntity){
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Courselist/addPost', postEntity)
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
      addCommentReply(postEntity){
        debugger
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'Courselist/addCommentReply', postEntity)
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
        addReview(reviewEntity){
          debugger
          let promise = new Promise((resolve, reject) => {
            this.http.post(this.globals.baseAPIUrl + 'Courselist/addReview', reviewEntity)
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
          deleteReview(obj) {
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.post(this.globals.baseAPIUrl + 'Courselist/deleteReview',obj)
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
          deleteDiscussion(DiscussionId) {
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.get(this.globals.baseAPIUrl + 'Courselist/deleteDiscussion/' + DiscussionId)
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
          shareCourse(shareEntity){
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.post(this.globals.baseAPIUrl + 'Courselist/shareCourse', shareEntity)
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
