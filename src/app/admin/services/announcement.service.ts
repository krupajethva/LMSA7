import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class AnnouncementService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { 
  }
  getAnnouncementTypes(){   
    debugger  
    let promise = new Promise((resolve, reject) => {     
      this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnouncementTypes')
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
    getAnnouncementAudience(){   
      debugger  
      let promise = new Promise((resolve, reject) => {     
        this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnouncementAudience')
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
      getAnnouncements(Id){   
        debugger  
        let promise = new Promise((resolve, reject) => {     
          this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnouncements/' + Id)
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
    addAnnouncement(announcementEntity){
      debugger
      let promise = new Promise((resolve, reject) => {
        this.http.post(this.globals.baseAPIUrl + 'Announcement/addAnnouncement', announcementEntity)
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
      addAnnouncementType(announcementtypeEntity){
        debugger
        let promise = new Promise((resolve, reject) => {
          this.http.post(this.globals.baseAPIUrl + 'Announcement/addAnnouncementType', announcementtypeEntity)
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
        getAnnounceTypeById(Id){ 
          debugger
          let promise = new Promise((resolve, reject) => {
            this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnounceTypeById/' + Id)
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
          getAnnouncementById(Id){ 
            debugger
            let promise = new Promise((resolve, reject) => {
              this.http.get(this.globals.baseAPIUrl + 'Announcement/getAnnouncementById/' + Id)
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
