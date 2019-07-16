import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ForgotpasswordService } from '../services/forgotpassword.service';
declare var $;
declare function myInput() : any;
declare var $,swal: any;

@Component({
  selector: 'app-forgot-password',
  providers: [ForgotpasswordService],
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.css']
})
export class ForgotPasswordComponent implements OnInit {
  fgpassEntity;
	submitted;
	type;
	btn_disable;
  constructor( public globals: Globals, private router: Router,private route:ActivatedRoute,private ForgotpasswordService:ForgotpasswordService) { }
  ngOnInit() {
    this.fgpassEntity={};
    myInput();
    }
    
   
    addFgpass(fgpassForm)
    {		  
      this.submitted = true;
      
      if(fgpassForm.valid){
        this.fgpassEntity.EmailAddress;
        this.submitted = false;
        this.btn_disable = true;
        this.globals.isLoading = true;
        this.ForgotpasswordService.add(this.fgpassEntity)
        .then((data) => 
        {
          this.submitted = false;
          this.globals.isLoading = false;
          this.fgpassEntity = {};
          fgpassForm.form.markAsPristine();
          
          if(data=='Code duplicate')
          {
            swal({
              type: 'warning',
              title: 'Oops...',
              text: 'Could not find your email address!',
              })
            //this.router.navigate(['/forgot-password']);
          }
          else
          {
            this.btn_disable = false;
            this.submitted = false;
            localStorage.setItem('EmailAddress',this.fgpassEntity.EmailAddress);
            this.fgpassEntity = {};
            fgpassForm.form.markAsPristine();
               
            swal({
        	   
							type: 'warning',
							text: 'Please check your Email.',
							showConfirmButton: false,
							timer: 3000
            }) 
          }
          this.globals.isLoading = false;
          //this.router.navigate(['/login']);
        }, 
        (error) => 
        {
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
        });
      } 		
    }
    
    
    
    
  
  
    
  }
  