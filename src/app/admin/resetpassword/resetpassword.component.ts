import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ResetpasswordService } from '../services/resetpassword.service';
import { JwtHelperService } from '@auth0/angular-jwt';
declare var $: any;
declare var $,swal: any;
declare function myInput() : any;
@Component({
  selector: 'app-resetpassword',
  providers: [ResetpasswordService],
  templateUrl: './resetpassword.component.html',
  styleUrls: ['./resetpassword.component.css']
})
export class ResetpasswordComponent implements OnInit {
	resetEntity;
	submitted;
	btn_disable;
	header;
	same;
   constructor( public globals: Globals, private router: Router,private route:ActivatedRoute,private ResetpasswordService:ResetpasswordService) { }


  ngOnInit() { 
	  this.resetEntity={};
	  myInput();
	let id = this.route.snapshot.paramMap.get('id');
	id=new JwtHelperService().decodeToken(id);
	this.ResetpasswordService.getResetlink2(id)
	.then((data) => 
	{ 
		if(data=='fail'){
				swal({
					type: 'danger',
					title:'Oops...',
					text: 'You are already used this link!',
					showConfirmButton: false,
					timer: 3000
				}) 
		 		this.router.navigate(['/login']);
		} 	
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
		this.submitted = true;
		if(resetForm.valid && !this.same)
		{
			this.submitted = false;
			this.btn_disable = true;
			this.globals.isLoading = true;
			this.ResetpasswordService.add(this.resetEntity)
			.then((data) => 
			{
				if(data='Code duplicate')
				{	
					swal({
						type: 'success',
						title:'Success',
						text: 'Your Password Changed Successfully!',
						showConfirmButton: false,
						timer: 3000
					}) 
				}else
				{
					this.btn_disable = false;
					this.submitted = false;
					this.globals.isLoading = false;
					this.resetEntity = {};
					resetForm.form.markAsPristine();			
				}
				this.router.navigate(['/login']);
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
	}
	
	 checkpassword(){ 
     debugger
		if(this.resetEntity.cPassword != this.resetEntity.Password){
			this.same = true;
		} else {
			this.same = false;
		}
		
	}
  
}
