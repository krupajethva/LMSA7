import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { SettingsService } from '../services/settings.service';
declare function myInput() : any;
import { Globals } from '.././globals';
declare var $,swal,window: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginEntity;
  submitted;
  btn_disable;
  openRegisteration;
  openRegisterationInstructor;
  constructor(private router: Router,public globals: Globals,private route: ActivatedRoute,private SettingsService : SettingsService,private AuthService : AuthService) { }

  ngOnInit() {
    this.loginEntity = {};
     myInput();

     this.SettingsService.getAllListONOFF()
     .then((data) => 
     { 
       this.openRegisterationInstructor = data;
     }, 
     (error) => 
     {
      this.globals.isLoading = false;
     });	
     
     this.SettingsService.getAllList()
     .then((data) => 
     { 
       this.openRegisteration = data;
     }, 
     (error) => 
     {
      this.globals.isLoading = false;
     });	
  }

  login(loginForm)
	 {	debugger
		this.submitted = true;
		if(loginForm.valid){
			this.btn_disable = true;
      this.globals.isLoading = true;
			this.AuthService.login(this.loginEntity)
			.then((data) => 
			{
        this.globals.isLoading = false;
        this.btn_disable = false;
        this.submitted = false;
        this.loginEntity = {};

        loginForm.form.markAsPristine(); 
        if(data=='Deactive')
        {
            swal({
              type: 'warning',
              title:'Oops...',
              text: 'You are currently not Activated!',
              showConfirmButton: false,
              timer: 3000
            }) 
        }
        else if(data == 'Activation')
        {
          swal({
            type: 'warning',
            title:'Oops...',
            text: 'Please verify your email for activate your account',
            showConfirmButton: false,
            timer: 3000
          }) 
        }
        else
        {
            //window.location.href = '/dashboard';
            if(this.globals.authData.RoleId==1 || this.globals.authData.RoleId==2 || this.globals.authData.RoleId==5){
              window.location.href='/dashboard-admin';
            } else if(this.globals.authData.RoleId==3){
              window.location.href='/dashboard-instructor';
            } else if(this.globals.authData.RoleId==4){
              window.location.href='/dashboard-learner';
            }   
          }             
			}, 
			(error) => 
			{     
          swal({
            type: 'warning',
            title: 'Oops...',
            text: 'Either Email or Password is Incorrect',
            })
          this.globals.isLoading = false;
          this.btn_disable = false;
          this.submitted = false;
			});
		} 		
  }

}
