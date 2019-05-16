import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';


@Injectable()
export class InviteLearnerService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) {  }

  //add users
  add(inviteUserEntity){ 
    debugger
    let promise = new Promise((resolve, reject) => { 
      this.http.post(this.globals.baseAPIUrl + 'Userinvite/addUser', inviteUserEntity)
      
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


  getAllDefaultData(){
	  
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Userinvite/getAllDefaultData')
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
        reject(msg);
        //this.globals.isLoading = false;
     //   this.router.navigate(['/pagenotfound']);
          }
        );
    });		
    return promise;
    }

}
