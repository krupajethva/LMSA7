import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';
@Injectable()

@Injectable()
export class CourseCertificateService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }
  add(CertificateEntity){ 
    debugger
 let promise = new Promise((resolve, reject) => {
   this.http.post(this.globals.baseAPIUrl + 'Assessment/addCertificate', CertificateEntity)
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
 getByIdCourseCertificat(id)
  {debugger
	let promise = new Promise((resolve, reject) => {		
    this.http.get(this.globals.baseAPIUrl + 'Assessment/getByIdCourseCertificat/'+ id)
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
