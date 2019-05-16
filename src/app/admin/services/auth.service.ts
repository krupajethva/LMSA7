import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { JwtHelperService } from '@auth0/angular-jwt';


@Injectable()
export class AuthService {

  constructor( private http: HttpClient,private globals: Globals,private router: Router) { }
  
  login(loginEntity){ debugger
		let jwtHelper = new JwtHelperService(); 
		let promise = new Promise((resolve, reject) => {
			this.http.post(this.globals.baseAPIUrl + 'Login/check_login', loginEntity)
				.toPromise()
				.then( 
					res => { // Success 
				let result = res;
				if(result && result['token']){
					localStorage.setItem('token',result['token']);				
					this.globals.authData = new JwtHelperService().decodeToken(result['token']);
				}
				resolve(res);
					},
					msg => { // Error
				reject(msg);
				//this.globals.isLoading = false;
					}
				);
		});		
		return promise;
  }
   
  isLoggedIn() {   
	  let jwtHelper = new JwtHelperService();
	  let token = localStorage.getItem('token');
	  if(!token) {
		  return false;
		}  else {
			return true;
		}
	// 	let isExpired = jwtHelper.isTokenExpired(token) ? true : false;
	// 	if(isExpired){
	// 		this.globals.authData = '';	
	// 		localStorage.removeItem('token');
	// 	} 
	//   return !isExpired;
	}


	logout(UserId){ 
		let promise = new Promise((resolve, reject) => {
		this.http.get(this.globals.baseAPIUrl + 'Login/logout/'+ UserId)
			.toPromise()
			.then(
				res => { 
					this.globals.authData = '';				
					localStorage.removeItem('token');
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
