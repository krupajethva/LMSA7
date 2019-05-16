import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class ForgotpasswordService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  // forgot password //
  add(fgpassEntity)
  {
   let promise = new Promise((resolve, reject) => {
     this.http.post(this.globals.baseAPIUrl + 'Forgotpass/userpass', fgpassEntity)
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

}
