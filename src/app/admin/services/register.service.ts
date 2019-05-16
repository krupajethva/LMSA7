import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import { Globals } from '.././globals';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';
@Injectable()
export class RegisterService {

 constructor( private http:HttpClient,private globals: Globals,private router: Router) { }


  // ** open learner register //
  learner_Register(RegisterEntity)
 {   
   debugger 
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Register/learner_Register', RegisterEntity)
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


  // ** check alrady register user or not //
  alradylearner_Register(RegisterEntity)
 {   
   debugger 
	let promise = new Promise((resolve, reject) => {
    this.http.post(this.globals.baseAPIUrl + 'Register/alrady_learner_Register', RegisterEntity)
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

  skillsData()
  {    
   let promise = new Promise((resolve, reject) => {
     this.http.get(this.globals.baseAPIUrl + 'Register/skillsData')
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

  // list education //
  getlist_EducationLevel()
  {    
   let promise = new Promise((resolve, reject) => {
     this.http.get(this.globals.baseAPIUrl + 'Register/getlist_EducationLevel')
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
