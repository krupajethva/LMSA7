import { Injectable } from '@angular/core';
import { CanActivate,RouterStateSnapshot } from '@angular/router';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { Globals } from '.././globals';
declare var $: any;

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(private authService : AuthService, private router: Router, public globals: Globals) { }
	
  canActivate(route,state:RouterStateSnapshot) { 
	
		this.globals.isLoading = false;	
		if(state.url.split('/')[3] != undefined){
			this.globals.currentLink = '/'+state.url.split('/')[1]+'/'+state.url.split('/')[2]+'/'+state.url.split('/')[3];
		} else if(state.url.split('/')[2] != undefined) {
			this.globals.currentLink = '/'+state.url.split('/')[1]+'/'+state.url.split('/')[2];
		} else {
			this.globals.currentLink = '/'+state.url.split('/')[1];
		}
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1; //Months are zero based
		var curr_year = d.getFullYear();
		if (curr_month < 10) {
			var month = '0' + curr_month;
		} else {
			var month = '' + curr_month;
		}
		if (curr_date < 10) {
			var date = '0' + curr_date;
		}
		else {
			var date = '' + curr_date;
		}
		var today = month + '-' + date + '-' + curr_year;
		this.globals.todaysdate = today;
			if(this.authService.isLoggedIn()==true){	
		
				if(state.url=='/dashboard-learner'){
					if(this.globals.authData.RoleId==3){
						this.router.navigate(['/dashboard-instructor']);
					  return false;
					}
					else if(this.globals.authData.RoleId==1 || this.globals.authData.RoleId==2 || this.globals.authData.RoleId==5){
						this.router.navigate(['/dashboard']);
					  return false;
					}
				} else if(state.url=='/dashboard-instructor'){
					if(this.globals.authData.RoleId==4){
						this.router.navigate(['/dashboard-learner']);
					  return false;
					}
					else if(this.globals.authData.RoleId==1 || this.globals.authData.RoleId==2 || this.globals.authData.RoleId==5){
						this.router.navigate(['/dashboard']);
					  return false;
					}
				}
				else if(state.url=='/dashboard'){
					if(this.globals.authData.RoleId==4){
						this.router.navigate(['/dashboard-learner']);
					  return false;
					}
					if(this.globals.authData.RoleId==3){
						this.router.navigate(['/dashboard-instructor']);
					  return false;
					}
				}	
				if(state.url=='/register' || state.url=='/open-register-instructor' || (state.url.split('/')[1]=='register-admin-invited') || (state.url.split('/')[1]=='register-instructor-invited') || (state.url.split('/')[1]=='register-learner-invited') || (state.url.split('/')[1]=='user-activation') || state.url=='/welcome' || state.url=='/' || state.url=='/login' || state.url=='' || state.url=='/link-list' || state.url=='/forgot-password' || (state.url.split('/')[1]=='reset-password')  || state.url=='/register-admin'){			
					this.globals.IsLoggedIn = true;
					this.router.navigate(['/dashboard']);
					return false;
				} else {
					this.globals.IsLoggedIn = true;
					return true;		  
				}
					  
			} else { 
				if(state.url=='/register' || state.url=='/open-register-instructor' || (state.url.split('/')[1]=='register-admin-invited') ||  (state.url.split('/')[1]=='register-instructor-invited') || (state.url.split('/')[1]=='register-learner-invited') || (state.url.split('/')[1]=='user-activation')  || state.url=='/welcome' || state.url=='/login' || state.url=='' || state.url=='/link-list' || state.url=='/forgot-password' || (state.url.split('/')[1]=='reset-password') || state.url=='/register-admin'){			
					 this.globals.IsLoggedIn = false;
					 return true;
				 } else {
					 this.globals.IsLoggedIn = false;
					 this.router.navigate(['/login']);
					 return false;
				 }		  
			}
		}
		
	}
	