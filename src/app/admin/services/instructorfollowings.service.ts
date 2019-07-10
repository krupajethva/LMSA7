import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class InstructorfollowingsService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  getAllFollowings(id) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'InstructorFollowings/getAllFollowings/' + id)
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
}
