import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { UserActivationService } from '../services/user-activation.service';
import { Globals } from '.././globals';
import { JwtHelperService } from '@auth0/angular-jwt';
declare function myInput() : any;
declare var $,Bloodhound,swal: any;

@Component({
  selector: 'app-user-activation',
  templateUrl: './user-activation.component.html',
  styleUrls: ['./user-activation.component.css']
})
export class UserActivationComponent implements OnInit {
  activeEntity;
	submitted;
	btn_disable;
  constructor(public globals: Globals, private router: Router,private route:ActivatedRoute, private UserActivationService: UserActivationService) { }


  ngOnInit() { debugger
   
      this.activeEntity={};
    let id = this.route.snapshot.paramMap.get('id');
    id=new JwtHelperService().decodeToken(id);
    this.globals.isLoading = true;
    this.UserActivationService.getResetlink2(id)
    .then((data) => 
    { 
      if(data=='Success'){
      
        swal({
          type: 'success',
          title: 'Congratulations...!!!',
          text: 'Your registration is successfully. Now you can login.',
          showConfirmButton: false,
          timer: 3000
          })   
        this.router.navigate(['/login']);
      } 
      else if(data=='fail')
      {
        swal({
         
          type: 'warning',
          title:'Oops...',
          text: 'You are already used this link!',
          showConfirmButton: false,
          timer: 3000
        }) 
        
        this.router.navigate(['/login']);
      }
    	this.globals.isLoading = false;    
    }, 
    (error) => 
        {
         // alert('error');
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });	
      
    }
    
    

}
