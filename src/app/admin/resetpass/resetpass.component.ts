import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ResetpassService } from '../services/resetpass.service';
import { JwtHelperService } from '@auth0/angular-jwt';
declare var $,swal: any;

@Component({
  selector: 'app-resetpass',
	 providers: [ResetpassService],
	   templateUrl: './resetpass.component.html'

})
export class ResetpassComponent implements OnInit {
	resetEntity;
	submitted;
	btn_disable;
	header;
	same;
	//globals;
   constructor( public globals: Globals, private router: Router,private route:ActivatedRoute,private ResetpassService:ResetpassService) { }


  ngOnInit() { debugger
	//this.globals = this.global;
	//this.globals.isLoading = true;
	

    
	   
	  this.resetEntity={};
	let id = this.route.snapshot.paramMap.get('id');
	id=new JwtHelperService().decodeToken(id);
	//this.ResetpassService.getResetlink(id)
	this.ResetpassService.getResetlink2(id)
	.then((data) => 
	{ 
		if(data=='fail'){
			swal({
        	   
							type: 'danger',
							title:'Oops',
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
				this.btn_disable = false;
				this.submitted = false;
				this.globals.isLoading = false;
				this.router.navigate(['/pagenotfound']);
			});	
		
  }
  
  

  addPassword(resetForm)
  {	debugger
	let id = this.route.snapshot.paramMap.get('id');
		
	var id1=new JwtHelperService().decodeToken(id);
	this.resetEntity.UserId = id1.UserId;
		if(id1){
			this.submitted = false;
		} else {
			this.resetEntity.UserId = 0;
			this.submitted = true;
		}
		if(resetForm.valid && !this.same)
		{
			this.btn_disable = true;
			this.ResetpassService.add(this.resetEntity)
			.then((data) => 
			{
				if(data='Code duplicate')
				{
					swal({
				
									type: 'success',
									title:'Success!',
									text: 'Your Password has been changed successfully!',
									showConfirmButton: false,
									timer: 3000
					}) 
				
				}else
					{
				
				this.btn_disable = false;
				this.submitted = false;
				this.resetEntity = {};
				resetForm.form.markAsPristine();
				}
				this.router.navigate(['/login']);
			}, 
			(error) => 
			{
				//alert('error');
				this.btn_disable = false;
				this.submitted = false;
				this.globals.isLoading = false;
				this.router.navigate(['/pagenotfound']);
			});	
		
		}
	}
	
	 checkpassword(){ 
		if(this.resetEntity.cPassword != this.resetEntity.Password){
			this.same = true;
		} else {
			this.same = false;
		}
		
	}
  
}
