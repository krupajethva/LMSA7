import { Component, OnInit } from '@angular/core';
declare function myInput() : any;
declare var $: any;

@Component({
  selector: 'app-register-admin',
  templateUrl: './register-admin.component.html',
  styleUrls: ['./register-admin.component.css']
})
export class RegisterAdminComponent implements OnInit {

  constructor() { }

  ngOnInit() {
	    myInput();
	   $("#educationbtn").click(function(){
		   $(".register_tab li").removeClass("active");
		   $(".register_tab li#educationli").addClass("active");
	   });
	   $("#educationbtn1").click(function(){
		   $(".register_tab li").removeClass("active");
		   $(".register_tab li#educationli").addClass("active");
	   });
	   $("#personalbtn").click(function(){
		   $(".register_tab li").removeClass("active");
		   $(".register_tab li#personalli").addClass("active");
	   });
	   $("#loginbtn").click(function(){
		   $(".register_tab li").removeClass("active");
		   $(".register_tab li#loginli").addClass("active");
	   });
	   
  }

}
